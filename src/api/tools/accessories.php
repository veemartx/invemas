<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$list=[];

$cat="Phone Accessories";

// $sql="SELECT * FROM products_list_back WHERE category='$cat'";

$query=mysqli_query($con,$sql);

while ($p=mysqli_fetch_assoc($query)){

    $pl=new stdClass();

    $pl->id=$p['id'];

    $pl->pl_id=$p['pl_id'];

    $pl->name=$p['name'];

    $pl->code=$p['code'];

    $pl->category=$p['category'];

    $pl->brand=$p['brand'];

    $pl->manufacturer=$p['manufacturer'];

    $pl->short_description=$p['short_description'];

    $pl->description=$p['description'];

    $pl->sold_as=$p['sold_as'];

    $pl->pack_size=$p['pack_size'];

    $pl->subcategory=$p['subcategory'];

    $pl->trade_price=$p['trade_price'];

    $pl->cost_price=$p['cost_price'];

    $pl->retail_price=$p['retail_price'];

    $pl->discount=$p['discount'];

    $pl->image_url=$p['images_url'];

    $pl->slug=$p['slug'];

    $pl->tags=$p['tags'];

    $vat=16;


    //insert
    $insert="INSERT INTO products_list (pl_id,name,code,trade_price,cost_price,retail_price,vat,pack_size,category,subcategory,brand,
    manufacturer,short_description,description,sold_as,discount,tags,slug,images_url) VALUES('$pl->pl_id','$pl->name','$pl->code','$pl->trade_price','$pl->cost_price','$pl->retail_price','$vat',
    '$pl->pack_size','$pl->category','$pl->subcategory','$pl->brand','$pl->manufacturer','$pl->short_description','$pl->description','$pl->sold_as','$pl->discount','$pl->tags','$pl->slug','$pl->image_url')";


    if(mysqli_query($con,$insert)){
        echo $pl->name." added </br>";
    }else{
        echo mysqli_error($con)."</br>";
    }

    // array_push($list,$pl);

}

// $res->message="List";

// $res->detail=$list;

// $res->success=true;

// echo json_encode($res);