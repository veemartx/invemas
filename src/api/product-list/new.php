<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    // data 
    $pl_id=$_POST['product_id'];

    $name=addslashes($_POST['name']);

    $code=generateProductCode($name);

    $category=$_POST['category'];

    $subcategory=$_POST['subcategory'];

    $brand=$_POST['brand'];

    $manufacturer=$_POST['manufacturer'];

    $pack_size=$_POST['pack_size'];

    $trade_price=$_POST['trade_price'];

    $cost_price=$_POST['cost_price'];

    $retail_price=$_POST['retail_price'];

    $discount=$_POST['discount'];

    if(isset($_POST['short_description'])){
        $short_description=addslashes($_POST['short_description']);

    }else{
        $short_description="";
    }

    $description=addslashes($_POST['description']);

    $vat=$_POST['vat'];

    $init=$_POST['init'];

    $slug=$_POST['slug'].substr(str_shuffle('qwetyuiksoldhfgnzmxnchjaklpq'),0,5);

    $sold_as=$_POST['sold_as'];

    $tags="";

    $images_url="/assets/products/images";



    // check if product exists 
    
    $sql="SELECT name FROM products_list WHERE name='$name'";

    $query=mysqli_query($con,$sql);

    if($p=mysqli_fetch_assoc($query)){
        $res->success=false;

        $res->message="Product Already Exists";


    }else{

        // insert
        $insert="INSERT INTO products_list (pl_id,name,code,trade_price,cost_price,retail_price,vat,pack_size,category,subcategory,brand,
        manufacturer,short_description,description,sold_as,discount,tags,slug,images_url) VALUES('$pl_id','$name','$code','$trade_price','$cost_price','$retail_price','$vat',
        '$pack_size','$category','$subcategory','$brand','$manufacturer','$short_description','$description','$sold_as','$discount','$tags','$slug','$images_url')";

        if(mysqli_query($con,$insert)){
            $res->success="true";

            $res->message="list product created successfully";

            //create transaction
            createTransaction($con,'List Product','List product addition',$init);

        }else{
            $res->success="false";

            $res->message=mysqli_error($con);
        }
    }



    echo json_encode($res);