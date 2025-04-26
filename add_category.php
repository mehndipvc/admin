<?php
include("config.php");
if (!empty($_POST['menu']) && !empty($_FILES['file']['name'])) {
	$menu = $_POST['menu'];
	$row = $obj->num("SELECT * FROM category WHERE name='$menu'");
	if ($row == 0) {
		$doc = $_FILES['file']['name'];
		$allowed = array('png','jpg','jpeg','webp');
		$ext = pathinfo($doc, PATHINFO_EXTENSION);
		if (in_array($ext, $allowed)) {
			$tmp = $_FILES['file']['tmp_name'];
			$temp = explode(".", $doc);
			$newfile = rand(00000000, 99999999) . '.' . end($temp);
			$folder = "../api/assets/" . $newfile;
			if(move_uploaded_file($tmp, $folder))
			{
			    $query = $obj->query("INSERT INTO category(name,image) VALUES ('$menu','$folder')");
    			if ($query) {
    				echo 'ok';
    			} else {
    				echo '<p class="alert alert-danger">Error something wrong!</p>';
    			}
			}
			else
			{
			    	echo '<p class="alert alert-danger">Image upload failed</p>';
			}
            
		}
	} else {
		echo '<p class="alert alert-danger">This category already in record</p>';
	}
} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
