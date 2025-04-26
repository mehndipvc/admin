<?php
include("config.php");
if(!empty($_POST['product_id']) && !empty($_POST['offer_type']) && !empty($_POST['offer']))
{
    $product_id=$_POST['product_id'];
    $offer_type=$_POST['offer_type'];
    $offer=$_POST['offer'];
    
    $check=$obj->num("SELECT item_id FROM discounts WHERE item_id='$product_id'");
    if($check==0)
    {
        $insert=$obj->query("INSERT INTO discounts(user_id,item_id,discount_type,amount) VALUES('','$product_id','$offer_type','$offer')");
        if($insert)
        {
            echo 'ok';
        }
        else
        {
            echo '<p class="alert alert-danger">Error Faild Submission</p>';
        }
    }
    else
    {
        $update=$obj->query("UPDATE discounts SET discount_type='$offer_type',amount='$offer' WHERE item_id='$product_id'");
        if($update)
        {
            echo 'ok';
        }
        else
        {
            echo '<p class="alert alert-danger">Error Faild Updation</p>';
        }
    }
}
else
{
    echo '<p class="alert alert-danger">Error Please Fill All The Field</p>';
}
?>