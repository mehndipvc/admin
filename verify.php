<?php
session_start();
include("config.php");
if (!empty($_POST['username']) && !empty($_POST['password'])) {
	$username = $_POST['username'];
	$password = md5($_POST['password']);

	$sel = $obj->num("SELECT * FROM admin WHERE username='$username' && password='$password'");
	if ($sel) {
		$_SESSION['username'] = 'Admin';
		echo '<script>window.location.href="dashboard.php"</script>';
	} else {
		echo '<a href="#" class="badge badge-danger">Incorrect username & password</a>';
	}

} else {
	echo '<a href="#" class="badge badge-warning">Empty field</a>';
}
?>