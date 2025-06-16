<?php
include("config.php");
include("add-watermark.php");

if (!empty($_POST['status']) && !empty($_POST['id'])) {
    $status = $_POST['status'];
    $id = $_POST['id'];
    $old_image = $_POST['old_image'];

    $filenameToUpdate = $old_image; // Default to old image
    $hasNewImage = false;

    // Check if a new image is uploaded
    if (!empty($_FILES["image_new"]['name'][0])) {
        $files = $_FILES["image_new"];
        $allowed = array('png', 'jpg', 'jpeg', 'webp');
        $validImageNames = array();

        for ($i = 0; $i < count($files['name']); $i++) {
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                echo "Invalid file format. Allowed formats: " . implode(', ', $allowed);
                exit;
            }
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            $tmp = $files['tmp_name'][$i];
            $temp = explode(".", $files['name'][$i]);
            $newfile = rand(1000000000, 9999999999) . '.' . end($temp);
            $folder = "../api/assets/" . $newfile;

            move_uploaded_file($tmp, $folder);
            addWatermark($folder);
            $validImageNames[] = $newfile;
        }

        // Delete old image(s)
        foreach (explode(', ', $old_image) as $img) {
            $imgPath = "../api/assets/" . $img;
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        $filenameToUpdate = implode(', ', $validImageNames);
        $hasNewImage = true;
    }

    $gallery_code = rand(10000, 99999);
    $sql = "UPDATE items_images SET 
                gallery_code = '$gallery_code',
                status = '$status',
                filename = '$filenameToUpdate' 
            WHERE id = '$id'";

    $update = $obj->query($sql);

    if ($update) {
        echo '<p class="alert alert-success">Successfully Updated</p>';
    } else {
        echo '<p class="alert alert-danger">Failed to update record.</p>';
    }
} else {
    echo '<p class="alert alert-danger">Empty Field</p>';
}
