<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require '../includes/connect.php';

    require '../includes/functions.php';

    $res=new stdClass();

    $subcategory_id=$_POST['subcategory_id'];

    $name=$_POST['subcategory_name'];

    $category_id=$_POST['category_id'];

    $category_name=$_POST['category_name'];

    $slug=$_POST['slug'];

    $init=$_POST['init'];

    $description="";

    //
    $sql="SELECT * FROM subcategories WHERE subcategory_id='$subcategory_id'";

    $query=mysqli_query($con,$sql);

    if($c=mysqli_fetch_assoc($query)){

        //update
        $update="UPDATE subcategories SET name='$name',slug='$slug' WHERE subcategory_id='$subcategory_id'";

        if(mysqli_query($con,$update)){

            $res->success=true;

            $res->message=$name." Updated successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }else{

        
        // create 
        $insert="INSERT INTO subcategories (subcategory_id,name,category_id,category,description,slug)
         VALUES('$subcategory_id','$name','$category_id','$category_name','$description','$slug')";

        if(mysqli_query($con,$insert)){

            $res->success=true;

            $res->message=$name." Created successfully";
        }else{
            $res->success=false;

            $res->message=mysqli_error($con);
        }
    }

    echo json_encode($res);