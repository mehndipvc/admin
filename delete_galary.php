<?php 
//print_r($_POST);
include("config.php");

if(!empty($_POST['dlt_btn']))
{
	$dlt_btn=$_POST['dlt_btn'];
    $oldImageNamesString = $_POST['old_image1'];
 
    $imageFilePath = "../api/assets/" . $oldImageNamesString;
    unlink($imageFilePath);


	
	$row=$obj->num("SELECT * FROM items_images WHERE item_id='$dlt_btn'");
	
// 	print_r($_POST);
// 	print_r($row);
//     exit();
	
	if($row)
	{
	    $query=$obj->query("DELETE FROM items_images WHERE item_id='$dlt_btn'");

		if($query)
		{
			echo '<a href="#" class="badge badge-success">Gallery is deleted Successfully</a>';
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