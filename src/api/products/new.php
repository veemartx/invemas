<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    // data 
    $product_id=$_POST['product_id'];

    $name=$_POST['name'];

    $code=$_POST['code'];

    $category=$_POST['category'];

    $subcategory=$_POST['subcategory'];

    $brand=$_POST['brand'];

    $manufacturer=$_POST['manufacturer'];

    $pack_size=$_POST['pack_size'];

    $trade_price=$_POST['trade_price'];

    $cost_price=$_POST['cost_price'];

    $retail_price=$_POST['retail_price'];

    $discount=$_POST['discount'];

    $description=$_POST['description'];

    $vat=$_POST['vat'];

    $qty=$_POST['qty'];

    $init=$_POST['init'];

    $slug=$_POST['slug'];


    $supplier='';

    $images_url="images_url";

    $status="active";


    // add to products dt
    $sql="INSERT INTO products_dt (name,code,qty,price,created_by,supplier) VALUES('$name','$code','$qty','$retail_price','$init','$supplier')";

    $query=mysqli_query($con,$sql);


    //check if in hd
    $sql="SELECT code,qty FROM products_hd WHERE code='$code'";

    $query=mysqli_query($con,$sql);

    if($p=mysqli_fetch_assoc($query)){

        $qty_instock=$p['qty'];

        $new_qty=$qty_instock+$qty;

        //update
        $update="UPDATE products_hd SET qty='$new_qty' WHERE code='$code'";

        if(mysqli_query($con,$update)){

            $res->success="true";

            $res->message="product updated";

        }else{
            $res->success=false;

            $res->message="An error occurred";
        }


    }else{

          // insert
          $insert="INSERT INTO products_hd (product_id,name,code,category,subcategory,manufacturer,brand,qty,cost_price,retail_price,
          discount,images_url,slug,status) VALUES('$product_id','$name','$code','$category','$subcategory','$manufacturer','$brand','$qty',
          '$cost_price','$retail_price','$discount','$images_url','$slug','active')";

          if(mysqli_query($con,$insert)){
            $res->success="true";

            $res->message="product updated";

          }else{
            $res->success="false";

            $res->message="product created successfully";
          }
    }



    echo json_encode($res);