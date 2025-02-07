<?php

ini_set('error_reporting', E_ALL);
ini_set('memory_limit', '128M');
ini_set('display_errors', true);

require 'connect.php';

require_once 'phpClasses/phpSpreadsheet/vendor/autoload.php';

// echo "maria";

$region = [];
// get the sent data

$formData = $_POST['region'];



// parse the string
parse_str($formData, $region);


// dear future dev , kindly keep branch before region as region is reinitialized;

$branch = $region['branch'];

$region = $region['targetR'];




// echo $region;




$test_doc = $_FILES['doc']['name'];

$uploadOk = 1;



//target dir
$target_dir = "../assets/docs/order-checks/" . $test_doc;
$dir = "assets/docs/order-checks/" . $test_doc;

$absolute_dir = "../assets/docs/order-checks/" . $test_doc;
//check file type
$docType = pathinfo($absolute_dir, PATHINFO_EXTENSION);

//
if ($docType != 'xls') {
    echo 'Only Xls Files Can Be Uploaded';
    $uploadOk = 0;
}

// 
// check if the file exists 
if (file_exists($absolute_dir)) {

    // the name 
    $nameArray = explode('.', $test_doc);

    $newName = $nameArray[0] . uniqid() . "." . $nameArray[1];

    // $test_doc = $test_doc . uniqid();
    $absolute_dir = "../assets/docs/order-checks/" . $newName;
}


//upload
if ($uploadOk == 0) {
    //there was an error
    echo "unkown error occured";
} else {

    if (move_uploaded_file($_FILES['doc']['tmp_name'], $absolute_dir)) {

        // echo "Upload Success";

        // now read the excel sheet 

        echo json_encode(readExcel($con, $absolute_dir, $dir, $region));

        $checkId = uniqid();

        // insert check 
        $insertCheck = "INSERT INTO branchOrderChecks(checkId,branch,contentSearch,targetRegion) VALUES('$checkId','$branch','$test_doc','$region')";

        mysqli_query($con, $insertCheck);
    } else {

        echo "error uploading file";
    }
}



function readExcel($con, $absolute_dir, $dir, $region)
{

    $resArray = [];

    $productsArray = [];


    $link = "<a href='../../server/p-o-c-l.php?d=" . $dir . "&&r=" . $region . "'><button class='ui green basic button'><i class='print icon'></i>Print</button></a>";

    array_push($resArray, $link);

    // echo "malay";
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($absolute_dir);
    $reader->setReadDataOnly(true);
    $pread = $reader->load($absolute_dir);

    $xls_data = $pread->getActiveSheet()->toArray(null, true, true, true);

    $cleanArray = [];

    $lowerLimit = 17;

    $upperLimit = sizeof($xls_data) - 5;
    // print_r($xls_data);
    for ($x = $lowerLimit; $x < $upperLimit; $x += 2) {

        array_push($cleanArray, $xls_data[$x]);
    }


    // loop through the clean array 
    foreach ($cleanArray as $product) {

        $productName = $product['A'];

        // echo $productName."</br>";

        $productPieces = $product['B'];


        $productQty = $product['C'];

        $productPrice = $product['E'];

        $productTotal = $product['H'];


        // check whether the product is in our database 

        if ($region == 'All') {

            $sel = "SELECT productId,productName,inStock,inStockPieces,branch,packsize FROM products WHERE productName='$productName'";
        } else {

            $sel = "SELECT productId, productName,inStock,inStockPieces,branch,packsize FROM products WHERE productName='$productName' AND region='$region'";
        }


        $selQuery = mysqli_query($con, $sel);

        while ($q = mysqli_fetch_assoc($selQuery)) {

            $resObj = new stdClass();

            $resObj->name = $q['productName'];


            $pId = $q['productId'];

            $ch = "SELECT productId FROM transfers WHERE productId='$pId'";

            $chQuery = mysqli_query($con, $ch);

            if ($p = mysqli_fetch_assoc($chQuery)) {

                $resObj->status = "<span style='color:green;'>Pushed</span>";
            } else {

                $resObj->status = "<span style='color:red;'>Not Pushed</span>";
            }


            $resObj->branch = $q['branch'];

            $resObj->whole = $q['inStock'];

            $resObj->pieces = $q['inStockPieces'];



            array_push($productsArray, $resObj);
        }


        // echo $productName;
    }

    array_push($resArray, $productsArray);


    // print_r($resArray);
    return ($resArray);
}
