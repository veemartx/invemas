<?php
header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$result=new stdClass();

$stats=[];

$date=date('Y-m-d',time());


//all sales
$all=new stdClass();

$sql="SELECT * FROM sales";

$all->name="All Sales";

$all->value=getRecordEntriesNo($con,$sql);


//today sales

$today=new stdClass();

$sql="SELECT * FROM sales WHERE sale_time LIKE '%$date%'";

$today->name="Sales Today";

$today->value=getRecordEntriesNo($con,$sql);


// top products 
$top_products=new stdClass();

$top_products->name="Top Products";

$top_products->value=0;

// top categories 
$top_categories=new stdClass();

$top_categories->name="Top Categories";

$top_categories->value=0;


// top brands 
$top_brands=new stdClass();

$top_brands->name="Top Brands";

$top_brands->value=0;


// top manufacturers
$top_manufacturers=new stdClass();

$top_manufacturers->name="Top Manufacturers";

$top_manufacturers->value=0;

array_push($stats,$all);
array_push($stats,$today);
array_push($stats,$top_products);
array_push($stats,$top_categories);
array_push($stats,$top_brands);
array_push($stats,$top_manufacturers);


$result->success=true;
$result->message="Sales Reports";
$result->detail=$stats;


echo json_encode($result);


