<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$suppliers=[];

$sql="SELECT * FROM suppliers";

$query=mysqli_query($con,$sql);

while ($p=mysqli_fetch_assoc($query)){

    $pl=new stdClass();

    $pl->id=$p['id'];

    $pl->name=$p['name'];

    $pl->phone=$p['phone'];

    $pl->email=$p['email'];

    $pl->postal_code=$p['postal_code'];

    $pl->website=$p['website'];

    $pl->limit=$p['supplier_limit'];

    $pl->pay_cycle=$p['when_to_pay'];

    $pl->slug=$p['slug'];

    array_push($suppliers,$pl);

}

$res->message="suppliers";

$res->detail=$suppliers;

$res->success=true;

echo json_encode($res);