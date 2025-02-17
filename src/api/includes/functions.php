<?php

    function createTransaction($con,$name,$description,$resource,$resource_id,$payload,$init){

        //create transaction

        $transaction_id=uniqid();

        $sql="INSERT INTO transactions (transaction_id,name,description,resource,resource_id,payload,created_by,status) 
                VALUES('$transaction_id','$name','$description','$resource','$resource_id','$payload','$init','complete')";

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

    function generateProductCode($name){

        //split the name 
        $name_arr=explode(" ",$name,3);

        $code_arr=[];

        foreach ($name_arr as $key => $value) {
            # code...
            array_push($code_arr,substr($value,0,1));
        }

        //implode the code
        $code_letters=implode("",$code_arr);

        $str="12345678900987654321";

        return strtoupper($code_letters.substr(str_shuffle($str),0,3));
    }


    function getRecordEntriesNo($con,$query){

        $sql_query=mysqli_query($con,$query);

        return mysqli_num_rows($sql_query);

    }