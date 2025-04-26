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

    $allProduct=null;
   
    if($product_id==='allProduct'){
        $allProductf = $obj->fetch("SELECT id FROM items WHERE cat_id='$category'");
        $idArray = array_column($allProductf, 'id');
        $allProduct = implode(',', $idArray);
    }else{
        $allProduct=$product_id;
    }
    
    // print_r($product_id);
    // exit;
    
    if($user_id=='All')
    {
        $cnt=0;
        $fet_user=$obj->fetch("SELECT * FROM users WHERE user_type='$user_type'");
        foreach($fet_user as $val)
        {
            $new_user=$val['user_id'];
            if($product_id=='allProduct'){
                $del_old_all=$obj->query("DELETE FROM individual_price WHERE category='$category' AND user_id='$new_user'");
            }
            
            $cnt++;
            
            $check=$obj->num("SELECT * FROM individual_price WHERE user_type='$user_type' AND user_id='$new_user' AND product_id='$product_id'");
            if($check==0)
            {
                
                $insert=$obj->query("INSERT INTO `individual_price` (`user_type`, `product_id`, `price`, `commission`, `user_id`, `percentage`,`category`,`set_price`) 
                VALUES ('$user_type', '$allProduct', '$price','$commission', '$new_user','$percentage','$category','$set_price')");
                if(!$insert)
                {
                    echo '<p class="alert alert-danger">'.$cnt.' Error something wrong!</p>';
                }
                
                
            }
            else
            {
                $del_old=$obj->query("DELETE FROM individual_price WHERE product_id='$allProduct' AND user_id='$new_user'");
                
                $insert=$obj->query("INSERT INTO `individual_price` (`user_type`, `product_id`, `price`, `commission`, `user_id`, `percentage`,`category`,`set_price`) 
                VALUES ('$user_type', '$allProduct', '$price','$commission', '$new_user','$percentage','$category','$set_price')");
                if(!$insert)
                {
                    echo '<p class="alert alert-danger">'.$cnt.' Error something wrong!</p>';
                }
            }
        }
        if($cnt>1)
        {
            echo "ok";
        }
    }
    else
    {
        $check=$obj->num("SELECT * FROM individual_price WHERE user_type='$user_type' AND user_id='$user_id' AND product_id='$product_id'");
        if($check==0)
        {
            $insert=$obj->query("INSERT INTO `individual_price` (`user_type`, `product_id`, `price`, `commission`, `user_id`,`percentage`,`category`,`set_price`) 
            VALUES ('$user_type', '$allProduct', '$price','$commission', '$user_id','$percentage','$category','$set_price')");
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
            $del_old=$obj->query("DELETE FROM individual_price WHERE product_id='$allProduct' AND user_id='$user_id'");
            
            $insert=$obj->query("INSERT INTO `individual_price` (`user_type`, `product_id`, `price`, `commission`, `user_id`,`percentage`,`category`,`set_price`) 
            VALUES ('$user_type', '$allProduct', '$price','$commission', '$user_id','$percentage','$category','$set_price')");
            
            echo 'ok'; 
        }
    }
}
else
{
    echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
?>