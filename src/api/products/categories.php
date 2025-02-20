<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$categories=[];

$sql="SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY name ASC";

$query=mysqli_query($con,$sql);

while ($p=mysqli_fetch_assoc($query)){

    $ctg=new stdClass();

    $ctg->id=$p['id'];

    $ctg->category_id=$p['category_id'];


    $ctg->name=$p['name'];

    $ctg->description=$p['description'];

    $ctg->subcategories=subcategories($con,$ctg->category_id);

    $ctg->slug=$p['slug'];

    array_push($categories,$ctg);

}

$res->message="categories";

$res->detail=$categories;

$res->success=true;

echo json_encode($res);


function subcategories($con,$category_id){

    $scats=[];

    $sql="SELECT * FROM subcategories WHERE category_id='$category_id'";

    $query=mysqli_query($con,$sql);

    while($s=mysqli_fetch_assoc($query)){

        $sc=new stdClass();

        $sc->name=$s['name'];

        $sc->description=$s['description'];

        $sc->slug=$s['slug'];

        array_push($scats,$sc);

    }


    return $scats;
}