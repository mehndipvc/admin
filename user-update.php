<?php
include("config.php");


if (!empty($_POST['id']) && !empty($_POST['username']) && !empty($_POST['status']) && !empty($_POST['mobile']) && !empty($_POST['email'])) {



    $id = $_POST['id'];
    $pass = $_POST['pass'];
    $user_type = $_POST['user_type'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $parent = $_POST['parent'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $user_id = $_POST['user_id'];

    if (!empty($_POST['pass'])) {
        $update = $obj->query("UPDATE users SET name='$username',user_type='$user_type',password='$pass',status='$status',parent_id='$parent',mobile='$mobile',email='$email' WHERE id='$id'");
    } else {
        $update = $obj->query("UPDATE users SET name='$username',user_type='$user_type',status='$status',parent_id='$parent',mobile='$mobile',email='$email' WHERE id='$id'");
    }

    if ($update) {
        //Update in Individual Price
        $upd_indv = $obj->query("UPDATE `individual_price` SET `user_type`='$user_type' WHERE `user_id`='$user_id'");

        echo '<p class="alert alert-success">Successfully Updated</p>';
    } else {
        echo '<p class="alert alert-danger">Error something wrong</p>';
    }
} else {
    echo '<p class="alert alert-danger">Error empty field</p>';
}
?>