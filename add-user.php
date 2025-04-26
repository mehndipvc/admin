<?php
include("config.php");
if(!empty($_POST['user_type']) && !empty($_POST['parent']) && !empty($_POST['username']) && !empty($_POST['mobile']) && !empty($_POST['password']) && !empty($_POST['status']) && !empty($_POST['email']))
{
    $user_type=$_POST['user_type'];
    $parent=$_POST['parent'];
    $username=$_POST['username'];
    $mobile=$_POST['mobile'];
    $password=$_POST['password'];
    $status=$_POST['status'];
    $email=$_POST['email'];
    
    $check=$obj->num("SELECT id FROM users WHERE mobile='$mobile' || email='$email'");
    if($check==0)
    {
        $sel_last=$obj->arr("SELECT user_id FROM users ORDER BY id DESC");
        $user_id=$sel_last['user_id']+1;
        
        $insert=$obj->query("INSERT INTO `users`(`user_type`, `is_admin`, `password`, `name`, `mobile`, `user_id`, `parent_id`, `status`,`email`) VALUES ('$user_type',
        '0','$password','$username','$mobile','$user_id','$parent','$status','$email')");
        
        if($insert)
        {
            echo 200;
        }
        else
        {
            echo '<p class="alert alert-danger">Error Faild Submission</p>';
        }
    }
    else
    {
        echo '<p class="alert alert-danger">This mobile number is already used</p>';
    }
}
else
{
    echo '<p class="alert alert-danger">Error Please Fill All The Field</p>';
}
?>