<?php
header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

if(isset($_GET['type'])){
    $type=$_GET['type'];

}else{
    $type="all";
}

$res=new stdClass();

$detail=[];

// echo ('{"success":true,"message":"Product Stats","detail":[{"name":"Products List","value":2200,"type":"number","change":0,"url":"/products/products-list"},{"name":"In Stock","value":1300,"type":"number","change":0,"url":"/products"},{"name":"brands","value":130,"type":"number","change":0,"url":"/products/brands"},{"name":"manufacturers","value":240,"type":"number","change":0,"url":"/products/manufacturers"},{"name":"Dead Stock","value":22,"type":"number","change":0,"url":"/products/dead-stock"},{"name":"categories","value":7,"type":"number","change":0,"url":"/products/categories"},{"name":"New Stock","value":145,"type":"number","change":0,"url":"/products/new"},{"name":"Low Stock","value":18,"type":"number","change":0,"url":"/products/low-stock"}]}');

$res->success=true;

$res->message="Product Stats";

//product list
$pl=new stdClass();

$pl->name="products list";

$pl->type="number";

$pl->change=0;

$pl->url="/dash/products/products-list";

$pl->value=stats($con,'products_list');

array_push($detail,$pl);

//products
$p=new stdClass();

$p->name="products";
$p->type="number";
$p->change=0;
$p->url="/dash/products";
$p->value=stats($con,"products_hd");
array_push($detail,$p);

// categories
$c=new stdClass();
$c->name="categories";
$c->url="/dash/products/categories";
$c->type="number";
$c->change=0;
$c->value=stats($con,"categories");

array_push($detail,$c);


// subcategories
// $sc=new stdClass();

// $sc->name="subcategories";
// $sc->type="number";
// $sc->change=0;
// $sc->url="/dash/products/subcategories";
// $sc->value=stats($con,"subcategories");

// array_push($detail,$sc);

// suppliers
$s=new stdClass();
$s->name="suppliers";
$s->type="number";
$s->change=0;
$s->url="/dash/products/suppliers";
$s->value=stats($con,"suppliers");

array_push($detail,$s);

// new stock
$s=new stdClass();
$s->name="New Products";
$s->type="number";
$s->change=0;
$s->url="/dash/products/new";
$s->value=stats($con,"products_dt");

array_push($detail,$s);


// dead stock 
$s=new stdClass();
$s->name="Dead Stock";
$s->type="number";
$s->change=0;
$s->url="/dash/products/dead-stock";
$s->value=stats($con,"products_dt");

array_push($detail,$s);

// suppliers 

$s=new stdClass();
$s->name="Low Stock";
$s->type="number";
$s->change=0;
$s->url="/dash/products/low-stock";
$s->value=0;

array_push($detail,$s);

// brands
$b=new stdClass();
$b->name="brands";
$b->type="number";
$b->change=0;
$b->url="/dash/products/brands";
$b->value=stats($con,"brands");

array_push($detail,$b);

// manufacturers
$m=new stdClass();
$m->name="manufacturers";
$m->type="number";
$m->change=0;
$m->url="/dash/products/manufacturers";
$m->value=stats($con,"manufacturers");
$m->color="red";

array_push($detail,$m);

$res->detail=$detail;

echo json_encode($res);


function stats($con,$table){

    $sql="SELECT * FROM $table";

    $query=mysqli_query($con,$sql);

    return mysqli_num_rows($query);

}