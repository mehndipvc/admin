<?php
session_start();
include("config.php");

if(!empty($_POST['username']) && !empty($_POST['password']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];

	$sel=$obj->num("SELECT * FROM users WHERE email='$username' AND password='$password'");

	if($sel)
	{
	    $sel_user=$obj->arr("SELECT user_id FROM users WHERE email='$username' AND password='$password'");
	    
	    $user_id=$sel_user['user_id'];
	    
		$insert=$obj->query("INSERT INTO `account_del_req` (`user_id`, `user_name`, `password`) VALUES ('$user_id', '$username', '$password')");

		if($insert)
		{
		    echo 200;
		}
	}
	else
	{
		echo '<p class="alert alert-danger">Incorrect username & password</p>';
	}

}
else
{
	echo '<p class="alert alert-warning">Empty field</p>';
}
?>