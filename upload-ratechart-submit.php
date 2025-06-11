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

			$folder = "/var/www/mlmApp/api/assets/" . $newfile;


			if (move_uploaded_file($tmp, $folder)) {
    echo 'ok';
} else {
    echo '<p class="alert alert-danger">Image upload failed</p>';

    // Debugging
    echo "<pre>";
    echo "Temp file: " . $tmp . "\n";
    echo "Target file: " . $folder . "\n";
    echo "File exists in temp? " . (file_exists($tmp) ? 'Yes' : 'No') . "\n";
    echo "Is folder writable? " . (is_writable(dirname($folder)) ? 'Yes' : 'No') . "\n";
    print_r(error_get_last());
    echo "</pre>";
}
 else {
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
