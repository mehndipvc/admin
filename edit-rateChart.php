<?php
include("config.php");

if (!empty($_POST['menu_id']) && !empty($_POST['menu'])) {

	$id = $_POST['menu_id'];
	$menu = $_POST['menu'];
	$user_id = $_POST['user_id'];

	$row = $obj->num("SELECT id FROM rate_chart WHERE id='$id'");

	if (!empty($_FILES['file']['name'])) {
		$old_image = $_POST['old_file'];

		$doc = $_FILES['file']['name'];
		$allowed = array('pdf', 'doc', 'xls', 'xlsx');
		$ext = pathinfo($doc, PATHINFO_EXTENSION);
		if (in_array($ext, $allowed)) {
			$tmp = $_FILES['file']['tmp_name'];
			$temp = explode(".", $doc);
			$newfile = $temp[0] . '.' . end($temp);
			$folder = "../api/assets/" . $newfile;
			if (move_uploaded_file($tmp, $folder)) {
				$query = $obj->query("UPDATE rate_chart SET name='$menu',file='$folder',file_path='$newfile',user_id='$user_id' WHERE id='$id'");

				if ($query) {
					$imageFilePath = "../api/assets/" . $old_image;
					unlink($imageFilePath);
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
		$query = $obj->query("UPDATE rate_chart SET name='$menu',user_id='$user_id' WHERE id='$id'");

		if ($query) {
			echo 'ok';
		} else {
			echo '<p class="alert alert-danger">Error something wrong!</p>';
		}
	}

} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
