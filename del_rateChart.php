<?php 

include("config.php");

if(!empty($_POST['dlt_btn']))
{
	$dlt_btn=$_POST['dlt_btn'];

	$row=$obj->num("SELECT * FROM rate_chart WHERE id='$dlt_btn'");
	if($row==1)
	{
	        $old_data=$obj->arr("SELECT file_path FROM rate_chart  WHERE id='$dlt_btn'");
	        
			$query=$obj->query("DELETE FROM rate_chart  WHERE id='$dlt_btn'");

		if($query)
		{
		      $old_image=$old_data['file_path'];
		      $imageFilePath = "../api/assets/" . $old_image;
              unlink($imageFilePath);
			  echo '<a href="#" class="badge badge-success">Success</a>';
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