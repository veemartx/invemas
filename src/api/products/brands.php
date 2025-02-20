<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$brands=[];

$sql="SELECT * FROM brands WHERE deleted_at IS NULL ORDER BY name ASC";

$query=mysqli_query($con,$sql);

while ($p=mysqli_fetch_assoc($query)){

    $br=new stdClass();

    $br->id=$p['id'];

    $br->brand_id=$p['brand_id'];

    $br->name=$p['name'];

    $br->slug=$p['slug'];

    array_push($brands,$br);

}

$res->message="brands";

$res->detail=$brands;

$res->success=true;

echo json_encode($res);