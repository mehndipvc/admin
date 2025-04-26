<?php
include("config.php");

if(!empty($_POST['offer_type']) && !empty($_POST['product_id']) && !empty($_POST['offer']))
{
    $offer_type=$_POST['offer_type'];
    $product_id=$_POST['product_id'];
    $offer=$_POST['offer'];
    $id=$_POST['id'];

    $check=$obj->num("SELECT * FROM discounts WHERE id='$id'");
    
    if($check==1)
    {
        
        $insert=$obj->query("UPDATE `discounts` SET `discount_type`='$offer_type', `item_id`='$product_id', `amount`='$offer' WHERE id='$id'");
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