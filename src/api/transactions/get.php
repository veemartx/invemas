<?php

header("Access-Control-Allow-Origin: *");
    
// require connection
require '../includes/connect.php';

require '../includes/functions.php';

$res=new stdClass();

$transactions=[];

$sql="SELECT * FROM transactions ORDER BY created_at DESC LIMIT 10";

$query=mysqli_query($con,$sql);

while ($t=mysqli_fetch_assoc($query)){

    $transaction=new stdClass();

    $transaction->id=$t['id'];

    $transaction->name=$t['name'];

    $transaction->description=$t['description'];

    $transaction->created=$t['created_at'];
    
    $transaction->init=$t['created_by'];


    array_push($transactions,$transaction);

}

$res->message="transactions";

$res->detail=$transactions;

$res->success=true;

echo json_encode($res);


