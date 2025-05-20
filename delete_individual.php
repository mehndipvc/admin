<?php
// print_r($_POST);
include("config.php");
if (!empty($_POST['dlt_btn'])) {
	$dlt_btn = $_POST['dlt_btn'];
	$row = $obj->num("SELECT * FROM individual_price WHERE id='$dlt_btn'");
	if ($row == 1) {
		$query = $obj->query("DELETE FROM individual_price  WHERE id='$dlt_btn'");
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