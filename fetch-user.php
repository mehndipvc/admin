<option value="">Select User</option>
<option value="All">All</option>
<?php
include("config.php");
if(!empty($_POST['user_type']))
{
    $user_type=$_POST['user_type'];
    $fetch=$obj->fetch("SELECT * FROM users WHERE user_type='$user_type' ORDER BY name ASC");
    foreach($fetch as $val){
        ?>
        <option value="<?= $val['user_id'] ?>"><?= $val['name'] ?></option>
        <?php
    }
}
?>