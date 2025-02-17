<?php
header("Access-Control-Allow-Origin: *");
    
// require connection
require './includes/connect.php';

require './includes/functions.php';

$res=new stdClass();

$stats=[];

// product stats
$sel="SELECT * FROM products_hd";

$sel_query=mysqli_query($con,$sel);

$products_no=number_format(mysqli_num_rows($sel_query));


$sql="SELECT SUM(qty) AS total_units,SUM(qty*retail_price) AS retail_value FROM products_hd";

$query=mysqli_query($con,$sql);

if($p=mysqli_fetch_assoc($query)){
 

    $products=new stdClass();

    $products->name="Products";

    $products->value=number_format($p['total_units'])."(".$products_no.")";

    $products->icon='<i class="ri-wallet-3-line"></i>';

    $products->change=2;

    $products->link="/dash/products";

    $products->color="red";

    array_push($stats,$products);


    //value
    $value=new stdClass();

    $value->name="Stock Value";

    $value->value=number_format($p['retail_value'],2);

    $value->icon='<i class="ri-file-list-3-line"></i>';

    $value->change=-1.2;

    $value->link="/dash/products";

    $value->color="purple";

    array_push($stats,$value);

}


// sales
$value=new stdClass();

$value->name="Sales";

$sql="SELECT * FROM sales";

$value->value=getRecordEntriesNo($con,$sql);

$value->icon='<i class="ri-user-smile-line"></i>';

$value->change=0;

$value->link="/dash/sales";

$value->color="green";

array_push($stats,$value);


// low stock
$value=new stdClass();

$value->name="Low Stock";

$value->value=0;

$value->icon='<i class="ri-file-list-3-line"></i>';

$value->change=0;

$value->link="/dash/products/low-stock";

$value->color="blue";

array_push($stats,$value);


$res->success=true;

$res->message="Stats";

$res->detail=$stats;


echo json_encode($res);