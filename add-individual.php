<?php
include("config.php");

// print_r($_POST);
// exit();

if(!empty($_POST['user_type'])  && !empty($_POST['user_id']) && !empty($_POST['commission']) && !empty($_POST['product_id']) && !empty($_POST['category']))
{
    $user_type=$_POST['user_type'];
    $user_id=$_POST['user_id'];
    $commission=$_POST['commission'];
    $product_id=$_POST['product_id'];
    $price=$_POST['price'];
    $percentage=$_POST['percentage'];
    $set_price=$_POST['set_price'];
    $category=$_POST['category'];
    
    $check_dup=$obj->num("SELECT id FROM individual_price WHERE user_type='$user_type' AND product_id='$product_id' AND user_id='$user_id' AND category='$category'");
    
    if($check_dup>0){
        $del_dup=$obj->query("DELETE FROM individual_price WHERE user_type='$user_type' AND product_id='$product_id' AND user_id='$user_id' AND category='$category'");
    }

    $insert=$obj->query("INSERT INTO `individual_price` (`user_type`, `product_id`, `price`, `commission`, `user_id`, `percentage`,`category`,`set_price`) 
    VALUES ('$user_type', '$product_id', '$price','$commission', '$user_id','$percentage','$category','$set_price')");
    
    echo 'ok';

}
else
{
    echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
?>