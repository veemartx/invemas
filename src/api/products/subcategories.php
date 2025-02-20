<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$subcategories=[];

$sql="SELECT * FROM subcategories WHERE deleted_at IS NULL ORDER BY name ASC";

$query=mysqli_query($con,$sql);

while ($p=mysqli_fetch_assoc($query)){

    $ctg=new stdClass();

    $ctg->id=$p['id'];

    $ctg->subcategory_id=$p['subcategory_id'];

    $ctg->name=$p['name'];

    $ctg->category_id=$p['category_id'];
    
    $ctg->category=$p['category'];

    $ctg->slug=$p['slug'];

    array_push($subcategories,$ctg);

}

$res->message="subcategories";

$res->detail=$subcategories;

$res->success=true;

echo json_encode($res);

