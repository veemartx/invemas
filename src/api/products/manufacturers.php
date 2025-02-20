<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$manufacturers=[];

$sql="SELECT * FROM manufacturers WHERE deleted_at IS NULL ORDER BY name ASC";

$query=mysqli_query($con,$sql);

while ($u=mysqli_fetch_assoc($query)){

    $man=new stdClass();

    $man->manufacturer_id=$u['manufacturer_id'];

    $man->name=$u['name'];

    $man->slug=$u['slug'];

    array_push($manufacturers,$man);

}

$res->message="manufacturers";

$res->detail=$manufacturers;

$res->success=true;

echo json_encode($res);