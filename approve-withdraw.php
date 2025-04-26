<?php
include("config.php");
include("add-watermark.php");
// print_r($_FILES);
// exit();
// print_r($_POST);
// exit;
if (!empty($_POST['id']) && !empty($_POST['status']) && !empty($_POST['user_id'])) {
	    $id = $_POST['id'];
	    $status = $_POST['status'];
	    $amount = $_POST['amount'];
	   $user_id = $_POST['user_id'];
	    $query=$obj->query("UPDATE withdraw SET status='$status' WHERE user_id='$user_id'");
	    
	    if($status=='Approved'){
	        
	        $sel_balance=$obj->arr("SELECT wallet FROM users WHERE user_id='$user_id'");
	        $rem_amount=$sel_balance['wallet']-$amount;
	        $upd_balance=$obj->query("UPDATE users SET wallet='$rem_amount' WHERE user_id='$user_id'");
	    }
	   	
		if ($query) {
			echo 200;
		} else {
			echo '<p class="alert alert-danger">Error something wrong!</p>';
		}


} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
