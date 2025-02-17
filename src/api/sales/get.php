<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$sales=[];

$sql="SELECT * FROM sales ORDER BY sale_time DESC LIMIT 100";

$query=mysqli_query($con,$sql);

while ($t=mysqli_fetch_assoc($query)){

    $sale=new stdClass();

    $sale->id=$t['id'];

    $sale->name=$t['product_name'];

    $sale->code=$t['product_code'];

    $sale->qty=$t['sale_qty'];

    $sale->retail_price=$t['retail_price'];

    $sale->sale_price=$t['sale_price'];

    $sale->discount=$t['discount'];

    $sale->total=$t['sale_total'];

    $sale->value=$t['sale_value'];

    $sale->date=$t['sale_time'];
    
    $sale->init=$t['sale_by'];


    array_push($sales,$sale);

}

$res->message="sales";

$res->detail=$sales;

$res->success=true;

echo json_encode($res);


