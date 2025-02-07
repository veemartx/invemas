<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    $manufacturer_id=$_POST['manufacturer_id'];

    $name=$_POST['manufacturer'];

    $slug=slugify($name);

    //
    $sql="SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";

    $query=mysqli_query($con,$sql);

    if($c=mysqli_fetch_assoc($query)){

        //update
        $update="UPDATE manufacturers SET name='$name',slug='$slug' WHERE manufacturer_id='$manufacturer_id'";

        if(mysqli_query($con,$update)){

            $res->success=true;

            $res->message=$name." Updated successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }else{

        
        // create 
        $insert="INSERT INTO manufacturers (manufacturer_id,name,slug) VALUES('$manufacturer_id','$name','$slug')";

        if(mysqli_query($con,$insert)){

            $res->success=true;

            $res->message=$name." Created successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }

    echo json_encode($res);