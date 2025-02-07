<?php
    header("Access-Control-Allow-Origin: *");
    
    // require connection
    require './includes/connect.php';

    require './includes/functions.php';
    
    //result object
    $resObj=new stdClass();

    // echo 'success';
    $username=$_POST['username'];
    $password=$_POST['password'];

    //check userExist
    $checkExists="SELECT * FROM users WHERE username='$username'";

    // query
    $checkExistsQuery=mysqli_query($con,$checkExists);

    // fetch
    if($row=mysqli_fetch_assoc($checkExistsQuery)){
        
        $user=new stdClass();
        
        //exists
        $resObj->exists=true;
        // userid
        $user->name=$row['fullname'];
        
        $user->position=$row['position'];

        $user->username=$row['username'];
        
        $user->id=$row['user_id'];

        // stored password
        $hashedPass=$row['password'];
        //verify pass
        if(password_verify($password,$hashedPass)){
            // they match
            $resObj->login=true;
            
            $resObj->user=$user;

            //create transaction
            createTransaction($con,'Login','Normal user login',$user->name);
        }else{
            // they dont match
            $resObj->login=false;
        
        }
    }else{
        //no such user
        $resObj->exists=false;

    }

    //encode to json and echo the json
    echo json_encode($resObj);