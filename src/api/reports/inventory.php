<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$res->success=true;


$res->message="product(s)";

$res->success=true;


//check if single product
if(isset($_GET['p'])){

    $slug=$_GET['p'];

    $res->detail=get_product($con,$_GET['p']);
}else{

    $res->detail=get_products($con);
}




// $res->detail=$products;


echo json_encode($res);


function get_product($con,$slug){
   
    $pl=new stdClass();

    $sql="SELECT * FROM products_hd WHERE slug='$slug'";

    $query=mysqli_query($con,$sql);

    if ($p=mysqli_fetch_assoc($query)){

        $extra_details=product_extra_details($con,$slug);

        $pl->exists=true;

        $pl->id=$p['id'];

        $pl->product_id=$p['product_id'];

        $pl->name=$p['name'];

        $pl->code=$p['code'];

        $pl->cost_price=$p['cost_price'];

        $pl->retail_price=$p['retail_price'];

        $pl->category=$p['category'];

        $pl->subcategory=$p['subcategory'];

        $pl->brand=$p['brand'];

        $pl->manufacturer=$p['manufacturer'];

        $pl->description=$extra_details->description;

        $pl->pack_size=$extra_details->pack_size;

        $pl->sold_as=$extra_details->sold_as;

        
        $pl->discount=$p['discount'];

        $pl->qty=$p['qty'];

        $pl->created_at=$p['created_at'];

        $pl->image_url=$p['images_url'];

        $pl->slug=$p['slug'];

        $pl->value=$p['qty']*$p['retail_price'];

        $pl->history=productHistory($con,$pl->product_id);


    }else{

        $pl->exists=false;
    }

    return $pl;
}

function get_products($con){

    $products=[];

    $sql="SELECT * FROM products_hd";

    $query=mysqli_query($con,$sql);

    while ($p=mysqli_fetch_assoc($query)){

        $pl=new stdClass();

        $pl->id=$p['id'];

        $pl->name=$p['name'];

        $pl->code=$p['code'];

        $pl->cost_price=$p['cost_price'];

        $pl->retail_price=$p['retail_price'];

        $pl->category=$p['category'];

        $pl->subcategory=$p['subcategory'];
        
        $pl->discount=$p['discount'];

        $pl->qty=$p['qty'];


        $pl->created_at=$p['created_at'];

        $pl->image_url=$p['images_url'];

        $pl->slug=$p['slug'];

        $pl->value=$p['qty']*$p['retail_price'];

        array_push($products,$pl);

    }

    return $products;

}


function product_extra_details($con,$slug){

    $res=new stdClass();

    $sql="SELECT * FROM products_list WHERE slug='$slug'";

    $query=mysqli_query($con,$sql);

    if($p=mysqli_fetch_assoc($query)){

        $res->pack_size=$p['pack_size'];
        
        $res->sold_as=$p['sold_as'];

        $res->description=$p['description'];
    }else{

        $res->pack_size=0;

        $res->sold_as="";

        $res->description="";
    }

    return $res;
}

function productHistory($con,$product_id){

    $transactions=[];

    $sel="SELECT name,description,payload,created_at,created_by FROM transactions WHERE resource_id='$product_id'";

    $query=mysqli_query($con,$sel);

    while ($t = mysqli_fetch_assoc($query)) {
        
        $tr=new stdClass();

        $tr->name=$t['name'];

        $tr->description=$t['description'];

        $tr->created_at=$t['created_at'];
        
        $tr->init=$t['created_by'];

        $payload=json_decode($t['payload']);

        $tr->qty=$payload->qty;

        array_push($transactions,$tr);
    }

    return $transactions;
}