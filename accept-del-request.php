<?php 
include("config.php");

if(!empty($_POST['id']))
{
    $id=$_POST['id'];
    
    $update=$obj->query("UPDATE account_del_req SET is_approve='Yes' WHERE id='$id'");
    
    if($update)
    {
        echo '<p class="alert alert-success">Successfully Accept Delete Request</p>';
    }
    else
    {
        echo '<p class="alert alert-danger">Error something wrong</p>';
    }
}
else
{
    echo '<p class="alert alert-danger">Error empty field</p>';
}
?>