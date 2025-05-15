ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
<?php
include("config.php");
include("add-watermark.php");
// print_r($_FILES);
// exit();

if (!empty($_POST['cat_id']) && !empty($_FILES['image']['name'])) {
	    $cat_id = $_POST['cat_id'];
	    
	    if (isset($_FILES["image"])) {
        $files = $_FILES["image"];
        $allowed = array('png', 'jpg', 'jpeg', 'webp');
        $validImageNames = array();


        $invalidFileFound = false;

        for ($i = 0; $i < count($files['name']); $i++) {
            $doc = $files['name'][$i];
            $ext = pathinfo($doc, PATHINFO_EXTENSION);

            if (!in_array($ext, $allowed)) {
                $invalidFileFound = true;
                break;
            }
        }

        if ($invalidFileFound) {
            echo "Invalid file format. Allowed formats: " . implode(', ', $allowed) . "<br>";
            exit;
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            $doc = $files['name'][$i];
            $tmp = $files['tmp_name'][$i];
            $temp = explode(".", $doc);
            $newfile = rand(0000000000000, 9999999999999) . '.' . end($temp);
            $folder = "../api/assets/" . $newfile;
            
            // Move the uploaded file to the desired directory
            move_uploaded_file($tmp, $folder);
            addWatermark($folder);

            // Additional processing if needed
            
            $validImageNames[] = $newfile;
        }
        $validImageNamesString = implode(', ', $validImageNames);

    }

    	foreach ($validImageNames as $filename) {
    	    $item_id = rand(0000000000000, 9999999999999);
    	    $gallery_code = rand(00000, 99999);
            $query = $obj->query("INSERT INTO items_images(gallery_code,filename,item_id,user_id,cat_id,status) VALUES ('$gallery_code','$filename','$item_id','1686380538723','$cat_id','Approve')");
        }
			
		if ($query) {
			echo '200';
		} else {
			echo '<p class="alert alert-danger">Error something wrong!</p>';
		}


} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
