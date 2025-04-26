<?php 
//print_r($_POST);
include("config.php");

if(!empty($_FILES['image']['name']))
{
	$image=$_FILES['image']['name'];
	$temp=explode(".", $_FILES['image']['name']);
	$newfile=rand(00000000,99999999).'.'.end($temp);
	$folder = "../api/assets/" . $newfile;
	if(move_uploaded_file($_FILES['image']['tmp_name'], $folder))
	{
			$query=$obj->query("INSERT INTO banners(filename) VALUES('$newfile')");

	

		if($query)
		{
			echo '<a href="#" class="badge badge-success">Success</a>';
		}
		else
		{
			echo '<a href="#" class="badge badge-success">Failed</a>';
			
		}
	}
	else
	{
		echo '<a href="#" class="badge badge-warning">Image Uploade Failed</a>';
	}
		
}
else
{
	echo '<a href="#" class="badge badge-warning">Empty Field</a>';
}
// Return response 
//print json_encode($data);

?>