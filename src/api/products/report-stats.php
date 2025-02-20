<?php
header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$result=new stdClass();

$stats=[];

$date=date('Y-m-d',time());


//all products
$all=new stdClass();

$sql="SELECT * FROM products_hd";

$all->name="All products";

$all->value=getRecordEntriesNo($con,$sql);


//low stock

$low=new stdClass();

$sql="SELECT * FROM products_hd WHERE qty < 10";

$low->name="Low Stock";

$low->value=getRecordEntriesNo($con,$sql);


// top products 
$new_products=new stdClass();

$new_products->name="New Products";

$new_products->value=0;

// dead stock 
$dead_stock=new stdClass();

$dead_stock->name="Dead Stock";

$dead_stock->value=0;


// recently added
$recently_added=new stdClass();

$recently_added->name="Recently Added";

$recently_added->value=0;



array_push($stats,$all);
array_push($stats,$low);
array_push($stats,$new_products);
array_push($stats,$dead_stock);
array_push($stats,$recently_added);



$result->success=true;
$result->message="Products Reports";
$result->detail=$stats;


echo json_encode($result);


