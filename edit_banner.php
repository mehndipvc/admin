<?php 
include("config.php");
$assetImgUrl = "https://mehndipvc.shop/api/assets/";

if(!empty($_POST['banner_id']))
{
	$id=$_POST['banner_id'];
	$selec=$obj->num("SELECT * FROM banners WHERE id='$id'");
	if($selec=='1')
	{
	$image=$_FILES['image']['name'];
	
	if(!empty($_FILES['image']['name']))
	{
		$un=unlink($_POST['old_image']);
		$temp=explode(".", $_FILES['image']['name']);
		$newfile=rand(00000000,99999999).'.'.end($temp);
		$folder="../api/assets/".$newfile;
		if(move_uploaded_file($_FILES['image']['tmp_name'], $folder))
		{
			
			
		$query=$obj->query("UPDATE banners SET filename='$newfile' WHERE id='$id'");

        		if($query)
        		{
        			echo '<a href="#" class="badge badge-success">Success</a>';
        		}
        		else
        		{
        			echo '<a href="#" class="badge badge-success">Faild</a>';
        			
        		}
		}
	}
	else
	{
		echo '<a href="#" class="badge badge-warning">Already Exist</a>';
	}
  }
		
}
else
{
	echo '<a href="#" class="badge badge-warning">Empty Field</a>';
}
// Return response 
//print json_encode($data);

?>