<?php
//print_r($_POST);
include("config.php");
if (!empty($_POST['menu'])) {
	$menu_id = $_POST['menu_id'];
	$menu = $_POST['menu'];
	$row = $obj->num("SELECT * FROM category WHERE id='$menu_id'");
	if ($row == 1) {
		if (!empty($_FILES['file']['name'])) {
			$photo = $_FILES['file']['name'];
			$allowed = array('gif', 'png', 'jpg', 'jpeg', 'webp');
			$ext = pathinfo($photo, PATHINFO_EXTENSION);
			if (in_array($ext, $allowed)) {
				$tmp = $_FILES['file']['tmp_name'];
				$temp = explode(".", $photo);
				$newfile = rand(00000000, 99999999) . '.' . end($temp);
				$folder = "../api/assets/" . $newfile;
				$upload = move_uploaded_file($tmp, $folder);
				if ($upload) {
					unlink($_POST['old_img']);
				} else {
					echo '<p class="alert alert-danger">Image upload faild</p>';
					exit();
				}
			} else {
				echo '<p class="alert alert-danger">Image format does not supported</p>';
				exit();
			}
		} else {
			$folder = $_POST['old_img'];
		}

		if (isset($folder)) {
			$query = $obj->query("UPDATE category SET name='$menu',image='$folder' WHERE id='$menu_id'");
		} else {
			$query = $obj->query("UPDATE category SET name='$menu' WHERE id='$menu_id'");
		}
		if ($query) {
			echo 'ok';
		} else {
			echo '<p class="alert alert-danger">Faild something wrong</p>';
		}
	} else {
		echo '<p class="alert alert-danger">Record not found</p>';
	}
} else {
	echo '<p class="alert alert-danger">Please fillup all the field</p>';
}
