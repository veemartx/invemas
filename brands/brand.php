<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    $brand_id=$_POST['brand_id'];

    $name=$_POST['brand'];

    $slug=slugify($name);

    //
    $sql="SELECT * FROM brands WHERE brand_id='$brand_id'";

    $query=mysqli_query($con,$sql);

    if($c=mysqli_fetch_assoc($query)){

        //update
        $update="UPDATE brands SET name='$name',slug='$slug' WHERE brand_id='$brand_id'";

        if(mysqli_query($con,$update)){

            $res->success=true;

            $res->message=$name." Updated successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }else{

        
        // create 
        $insert="INSERT INTO brands (brand_id,name,slug) VALUES('$brand_id','$name','$slug')";

        if(mysqli_query($con,$insert)){

            $res->success=true;

            $res->message=$name." Created successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }

    echo json_encode($res);