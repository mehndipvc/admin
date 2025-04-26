<option value="All">All Product</option>
<?php
require_once("config.php");

if(!empty($_POST['category']))
{
    $category=$_POST['category'];
    
    $fet_data=$obj->fetch("SELECT * FROM items WHERE cat_id='$category'");
    foreach($fet_data as $fet_val)
    {
        ?>
        <option value="<?= $fet_val['id']?>" data-price="<?=$fet_val['price']?>"><?= $fet_val['name']?></option>
        <?php
    }
}
?>