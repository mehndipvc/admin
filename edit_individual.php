<?php
include("config.php");

// print_r($_POST);
// exit();

if(!empty($_POST['user_typeEdit']) && !empty($_POST['product_idEdit']) && !empty($_POST['priceEdit']) && !empty($_POST['individual_id']))
{
    $user_type=$_POST['user_typeEdit'];
    $product_id=$_POST['product_idEdit'];
    $price=$_POST['priceEdit'];
    $set_price=$_POST['set_priceEdit'];
    $id=$_POST['individual_id'];
    
    $user_id=$_POST['user_typeEdit'];

    $check=$obj->num("SELECT * FROM individual_price WHERE id='$id'");
    
    if($check==1)
    {
        $check_dup=$obj->num("SELECT id FROM individual_price WHERE user_type='$user_type' AND product_id='$product_id' AND user_id='$user_id'");
        if($check_dup>0){
            $del_dup=$obj->query("DELETE FROM individual_price WHERE user_type='$user_type' AND product_id='$product_id' AND user_id='$user_id'");
        }
        
        $insert=$obj->query("UPDATE `individual_price` SET `user_type`='$user_type', `product_id`='$product_id',`set_price`='$set_price', `price`='$price' WHERE id='$id'");
        if($insert)
        {
            echo 'ok'; 
        }
        else
        {
            echo '<p class="alert alert-danger">Error something wrong!</p>';
        }
    }
    else
    {
        echo '<p class="alert alert-danger">Record not found</p>';
    }
}
else
{
    echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
?>