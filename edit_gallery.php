<?php
include("config.php");
include("add-watermark.php");
// print_r($_POST);
// exit;
if (!empty($_POST['status']) && !empty($_POST['id']) && !empty($_POST['cat_id'])) {
    $status = $_POST['status'];
    $id = $_POST['id'];
    $cat_id = $_POST['cat_id'];
    $old_image = $_POST['old_image'];


    if (!empty($_FILES["image_new"]['name'][0])) {
        $files = $_FILES["image_new"];
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

            move_uploaded_file($tmp, $folder);
            addWatermark($folder);
            $validImageNames[] = $newfile;
        }
        $validImageNamesString = implode(', ', $validImageNames);

        $oldImageNamesArray = explode(', ', $old_image);
        foreach ($oldImageNamesArray as $oldImageName) {
            $imageFilePath = "../api/assets/" . $oldImageName;
            unlink($imageFilePath);
        }
    }
    $check = $obj->num("SELECT id FROM items_images WHERE id='$id'");
    if ($check != 0) {
        $gallery_code = rand(00000, 99999);
        if (!empty($_FILES["image_new"]['name'][0])) {
            $update = $obj->query("UPDATE items_images SET gallery_code='$gallery_code',status='$status',cat_id='$cat_id',filename='$validImageNamesString' WHERE id='$id'");
            if ($update) {
                echo '<p class="alert alert-success">Successfully Updated</p>';
            }
        } else {

            $update = $obj->query("UPDATE items_images SET gallery_code='$gallery_code',status='$status',cat_id='$cat_id',filename='$old_image' WHERE id='$id'");
            if ($update) {
                echo '<p class="alert alert-success">Successfully Updated</p>';
            }
        }
    } else {
        echo '<p class="alert alert-danger">Error Faild Submission</p>';
    }
} else {
    echo '<p class="alert alert-danger">Empty Field</p>';
}
?>