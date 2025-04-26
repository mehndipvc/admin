<?php
include("config.php");

// print_r($_POST);
// exit();

if(!empty($_POST['dlt_btn']))
{
	$dlt_btn=$_POST['dlt_btn'];
	$row=$obj->num("SELECT * FROM orders WHERE order_id='$dlt_btn'");
	if($row==1)
	{
			$query=$obj->query("DELETE FROM orders WHERE order_id='$dlt_btn'");

		if($query)
		{
			echo '<a href="#" class="badge badge-success">Successfully Deleted</a>';
		}
		else
		{
			echo '<a href="#" class="badge badge-danger">Faild</a>';
		}
	}
	else
	{
		echo '<a href="#" class="badge badge-warning">Not Found</a>';
	}
}
else
{
	echo '<a href="#" class="badge badge-warning">Empty Field</a>';
}

?>