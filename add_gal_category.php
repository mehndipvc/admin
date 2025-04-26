<?php
include("config.php");

if (!empty($_POST['category']) && !empty($_FILES['image']['name'])) {
	$category = $_POST['category'];
	$image=$_FILES['image']['name'];
	$allowed = array('png', 'jpg', 'jpeg', 'webp');
	$ext = pathinfo($image, PATHINFO_EXTENSION);
	 if (in_array($ext, $allowed)) 
    {
        $temp=explode(".", $image);
        $newfile=rand(00000000,99999999).'.'.end($temp);
        $folder="../api/assets/".$newfile;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $folder))
        {
             $new=$folder;
        }
        else
        {
            echo '<p class="alert alert-danger mt-3">Image Upload Failed</p>';
            exit;
        }
       
    }
    else{
        echo '<p class="alert alert-danger mt-3">Image Format not Supported</p>';
        exit;
    }
	$row = $obj->num("SELECT * FROM gal_category WHERE category='$category'");
	if ($row == 0) 
	{
        $query = $obj->query("INSERT INTO gal_category(category,image,image_path) VALUES ('$category','$new','$newfile')");
    	if ($query) {
    		echo 'ok';
    	} else {
    		echo '<p class="alert alert-danger">Error something wrong!</p>';
    	}
	} else {
		echo '<p class="alert alert-danger">This category already in record</p>';
	}
} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
