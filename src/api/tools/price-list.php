<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

//get the file
// $file_path="../assets/docs/price-list-docs/entries.txt";

getListPrices($con,$file_path);


function getListPrices($con,$path){

    $prices=[];

    //open the file
    $file=fopen($path,'r') or die('Unable to open file');

    $brand="";

    $manufacturer="";

    //read the file line by line
    while(!feof($file)){
        //line
        $line=fgets($file);

        //if line line empty
        if(!str_contains($line,"--")){
            //if it does not have price its a brand
            if(!str_contains($line,"@")){
                // echo $line."</br>";
                $brand=capitalize($line);

                $manufacturer=capitalize($line);

                createBrand($con,$brand);
                createManufacturer($con,$manufacturer);
            }else{

                // get the price 
                $p_array=explode("@",$line);

                $name=$brand." ".$p_array[0];

                $price_str=str_replace(',',"",$p_array[1]);

                $price=floatval($price_str);
                // $price=$p_array[1];

                // echo "Brand ".$brand." Manufacturer ".$manufaturer." Product ".$name." Price ".$price."</br>";
                createListProduct($con,$name,$brand,$manufacturer,$price);

            }
        }
    }

    //close the file
    fclose($file);
}

//takes in connection brand/manufacturer
function createBrand($con,$name){
    //check if exists
    $sel="SELECT * FROM brands WHERE name='$name'";

    $query=mysqli_query($con,$sel);

    if($b=mysqli_fetch_assoc($query)){
        // do nothing
        return;
    }else{

        $id=uniqid();

        $slug=slugify($name);
        //insert
        $insert="INSERT INTO brands (brand_id,name,slug) VALUES ('$id','$name','$slug')";

        if(mysqli_query($con,$insert)){
            return true;
        }else{
            return false;
        }
    }
}


function createManufacturer($con,$name){

    //check if exists
    $sel="SELECT * FROM manufacturers WHERE name='$name'";

    $query=mysqli_query($con,$sel);

    if($b=mysqli_fetch_assoc($query)){
        // do nothing
        return;
    }else{

        $id=uniqid();

        $slug=slugify($name);
        //insert
        $insert="INSERT INTO manufacturers (manufacturer_id,name,slug) VALUES ('$id','$name','$slug')";

        if(mysqli_query($con,$insert)){
            return true;
        }else{
            return false;
        }
    }
}

function createListProduct($con,$name,$brand,$manufacturer,$price){
    $code=generateProductCode($name);

    $cost_price=$price;

    $retail_price=$price*1.4;

    $trade_price=$price;

    $vat=16;

    $pack_size=1;

    $category="Phones And Tablets";

    if($price<2000){
        $subcategory="Feature phones";
    }else{
        $subcategory="Smartphones";
    }

    $short_description=$name;

    $description=$name." ".$brand;

    $pl_id=uniqid();

    $sold_as="";

    $tags=$name." ".$category."".$subcategory;

    $discount=0;

    $slug=slugify($name);

    $images_url="";

    $insert="INSERT INTO products_list (pl_id,name,code,trade_price,cost_price,retail_price,vat,pack_size,category,subcategory,brand,
    manufacturer,short_description,description,sold_as,discount,tags,slug,images_url) VALUES('$pl_id','$name','$code','$trade_price','$cost_price','$retail_price','$vat',
    '$pack_size','$category','$subcategory','$brand','$manufacturer','$short_description','$description','$sold_as','$discount','$tags','$slug','$images_url')";


    if(mysqli_query($con,$insert)){
        echo $name." added </br>";
    }else{
        echo mysqli_error($con)."</br>";
    }

}