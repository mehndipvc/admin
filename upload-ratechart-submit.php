<?php
include("config.php");

// print_r($_POST);
// exit();

if (!empty($_POST['name']) && !empty($_FILES['file']['name'])) {
	$name = $_POST['name'];

	if ($_POST['user_id'] == 'All User') {
		$user_id = 'All User';
	} else {
		$user_id = $_POST['user_id'];
	}
	$row = $obj->num("SELECT id FROM rate_chart WHERE name='$name'");

	if ($row == 0) {

		$doc = $_FILES['file']['name'];
		$allowed = array('pdf', 'doc', 'xls', 'xlsx');
		$ext = pathinfo($doc, PATHINFO_EXTENSION);

		if (in_array($ext, $allowed)) {
			$tmp = $_FILES['file']['tmp_name'];
			$temp = explode(".", $doc);

			$newfile = $name . '.' . end($temp);

			$folder = "../api/assets/" . $newfile;


			if (move_uploaded_file($tmp, $folder)) {
				$query = $obj->query("INSERT INTO rate_chart(file,file_path,name,user_id) VALUES ('$folder','$newfile','$name','$user_id')");

				if ($query) {
					echo 'ok';
				} else {
					echo '<p class="alert alert-danger">Error something wrong!</p>';
				}
			} else {
				echo '<p class="alert alert-danger">Image upload failed</p>';
			}

		} else {
			echo '<p class="alert alert-danger">File format is not supported</p>';
		}
	} else {
		echo '<p class="alert alert-danger">This category already in record</p>';
	}
} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
