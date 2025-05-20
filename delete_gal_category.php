<?php
//print_r($_POST);
include("config.php");
if (!empty($_POST['dlt_btn'])) {
	$dlt_btn = $_POST['dlt_btn'];
	// 	$old_image1=$_POST['old_image1'];

	// 	unlink($old_image1);

	$row = $obj->num("SELECT * FROM gal_category WHERE id='$dlt_btn'");
	if ($row == 1) {
		$query = $obj->query("DELETE FROM gal_category  WHERE id='$dlt_btn'");
		//echo $query;


		if ($query) {
			echo '<a href="#" class="badge badge-success">Success</a>';
		} else {
			echo '<a href="#" class="badge badge-danger">Faild</a>';
		}
	} else {
		echo '<a href="#" class="badge badge-warning">Not Found</a>';
	}
} else {
	echo '<a href="#" class="badge badge-warning">Empty Field</a>';
}

?>