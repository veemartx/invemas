<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require './includes/connect.php';

require './includes/functions.php';

$res=new stdClass();

$users=[];

$sql="SELECT * FROM users WHERE deleted_at IS NULL";

$query=mysqli_query($con,$sql);

while ($u=mysqli_fetch_assoc($query)){

    $usr=new stdClass();

    $usr->user_id=$u['user_id'];

    $usr->name=$u['fullname'];

    $usr->username=$u['username'];

    $usr->email=$u['email'];

    $usr->phone=$u['phone'];

    $usr->avator=$u['avator_url'];

    $usr->position=$u['position'];

    array_push($users,$usr);

}

$res->message="Users";

$res->detail=$users;

$res->success=true;

echo json_encode($res);