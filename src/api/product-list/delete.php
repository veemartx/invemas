<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    $pl_id=$_POST['pl_id'];

    $name=$_POST['name'];

    $init=$_POST['init'];

    // c
    $now=date('Y-m-d h:i:s',time());

    $sql="UPDATE products_list SET deleted_at='$now',deleted_by='$init' WHERE pl_id='$pl_id'";

    if(mysqli_query($con,$sql)){

        $res->success=true;

        $res->message=$name." Deleted Successfully";
    }else{
        $res->success=false;

        $res->message=mysqli_error($con);
    }


    echo json_encode($res);
