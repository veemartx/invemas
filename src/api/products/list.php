<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$list=[];

$sql="SELECT * FROM products_list WHERE deleted_at IS NULL";

$query=mysqli_query($con,$sql);

while ($p=mysqli_fetch_assoc($query)){

    $pl=new stdClass();

    $pl->id=$p['id'];

    $pl->pl_id=$p['pl_id'];

    $pl->name=$p['name'];

    $pl->code=$p['code'];

    $pl->category=$p['category'];

    $pl->subcategory=$p['subcategory'];

    $pl->cost_price=$p['cost_price'];

    $pl->retail_price=$p['retail_price'];

    $pl->discount=$p['discount'];

    $pl->brand=$p['brand'];

    $pl->manufacturer=$p['manufacturer'];

    $pl->image_url=$p['images_url'];

    $pl->slug=$p['slug'];

    array_push($list,$pl);

}

$res->message="List";

$res->detail=$list;

$res->success=true;

echo json_encode($res);