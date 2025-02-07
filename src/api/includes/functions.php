<?php

    function createTransaction($con,$name,$description,$init){

        //create transaction

        $transaction_id=uniqid();

        $sql="INSERT INTO transactions (transaction_id,name,description,created_by,status) 
                VALUES('$transaction_id','$name','$description','$init','complete')";

        if(mysqli_query($con,$sql)){
            return true;
        }else{
            return mysqli_error($con);
        }
    }


    function slugify($name){

        $str="qwertyuiopasdfghjklzxcvbnnm";

        return str_replace(' ','-',$name).'-'.substr(str_shuffle($str),0,5);
    }