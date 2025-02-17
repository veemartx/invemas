<?php
header("Access-Control-Allow-Origin: *");

require '../includes/connect.php';

$results=[];

$q = $_POST['q'];


$sel = "SELECT * FROM products_hd WHERE code LIKE '%$q%' OR NAME LIKE '%$q%' LIMIT 5";
// query
$sel_query = mysqli_query($con, $sel);

while ($row = mysqli_fetch_assoc($sel_query)) {

    $p = new stdClass();

    $p->id = $row['id'];

    $p->name = $row['name'];

    $p->code = $row['code'];

    $p->price = $row['retail_price'];

    $p->qty=$row['qty'];

    $p->slug=$row['slug'];

    array_push($results, $p);
    
}

    
echo json_encode($results);



