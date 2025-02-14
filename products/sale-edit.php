<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    // data 
    $sale_id=$_POST['sale_id'];

    $product_id=$_POST['product_id'];

    $name=$_POST['name'];

    $code=$_POST['code'];
    
    $retail_price=$_POST['retail_price'];

    $sale_price=$_POST['sale_price'];

    $discount=$_POST['discount'];

    $sale_qty=$_POST['sale_qty'];

    $remaining_qty=$_POST['remaining_qty'];

    $init=$_POST['init'];


    $sale_total=$retail_price*$sale_qty;

    $sale_value=$sale_price*$sale_qty;

    // create sale
    $sql="INSERT INTO sales (sale_id,product_id,product_name,product_code,sale_qty,retail_price,sale_price,discount,sale_total,sale_value,sale_by)
          VALUE('$sale_id','$product_id','$name','$code','$sale_qty','$retail_price','$sale_price','$discount','$sale_total','$sale_value','$init')";


    if(mysqli_query($con,$sql)){

        //update qty
        if(updateProductQty($con,$product_id,$remaining_qty)){

            $res->success=true;

            $res->message=$name." Sale Edit Successful";

        }else{
            //rollback
            rollBackSale($con,$sale_id);

            $res->success=false;

            $res->message="An error occurred handling the request";
        }

    }else{

        $res->success=false;

        $res->message=mysqli_error($con);

    }


    echo json_encode($res);


    function updateProductQty($con,$product_id,$qty){

        $sql="UPDATE products_hd SET qty='$qty' WHERE product_id='$product_id'";

        if(mysqli_query($con,$sql)){

            return true;
        }else{
            return false;
        }
    }

    
    function rollBackSale($con,$sale_id){

        $sql="DELETE FROM sales WHERE sale_id='$sale_id'";

        if(mysqli_query($con,$sql)){
            return true;
        }else{
            return false;
        }
    }