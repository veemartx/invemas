<?php
header("Access-Control-Allow-Origin: *");

require './includes/connect.php';

$results=[];

$q = $_POST['q'];

$sel = "SELECT * FROM products_list WHERE code LIKE '%$q%' OR NAME LIKE '%$q%' LIMIT 5";
// query
$sel_query = mysqli_query($con, $sel);

while ($row = mysqli_fetch_assoc($sel_query)) {

    $p = new stdClass();

    $p->id = $row['id'];

    $p->name = $row['name'];

    $p->code = $row['code'];

    $p->cost_price = $row['cost_price'];

    $p->trade_price = $row['trade_price'];

    $p->retail_price = $row['retail_price'];

    $p->pack_size=$row['pack_size'];

    $p->vat=$row['vat'];

    $p->discount=$row['discount'];

    $p->category=$row['category'];

    $p->subcategory=$row['subcategory'];

    $p->brand=$row['brand'];

    $p->manufacturer=$row['manufacturer'];

    $p->description=$row['description'];

    $p->sold_as=$row['sold_as'];

    $p->slug=$row['slug'];

    $p->images_url=$row['images_url'];


    array_push($results, $p);
    
}

    
echo json_encode($results);



