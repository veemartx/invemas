<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    $category_id=$_POST['category_id'];

    $name=$_POST['category'];

    $description=$_POST['description'];

    $slug=slugify($name);

    //
    $sql="SELECT * FROM categories WHERE category_id='$category_id'";

    $query=mysqli_query($con,$sql);

    if($c=mysqli_fetch_assoc($query)){

        //update
        $update="UPDATE categories SET name='$name',description='$description',slug='$slug' WHERE category_id='$category_id'";

        if(mysqli_query($con,$update)){

            $res->success=true;

            $res->message=$name." Updated successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }else{

        
        // create 
        $insert="INSERT INTO categories (category_id,name,description,slug) VALUES('$category_id','$name','$description','$slug')";

        if(mysqli_query($con,$insert)){

            $res->success=true;

            $res->message=$name." Created successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }

    echo json_encode($res);