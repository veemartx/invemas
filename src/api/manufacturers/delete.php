<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    $manufacturer_id=$_POST['manufacturer_id'];

    $name=$_POST['name'];

    // c
    $now=date('Y-m-d h:i:s',time());

    $sql="UPDATE manufacturers SET deleted_at='$now' WHERE manufacturer_id='$manufacturer_id'";

    if(mysqli_query($con,$sql)){

        $res->success=true;

        $res->message=$name." Deleted Successfully";
    }else{
        $res->success=false;

        $res->message=mysqli_error($con);
    }


    echo json_encode($res);
