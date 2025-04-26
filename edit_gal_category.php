<?php 
//print_r($_POST);
include("config.php");
if(!empty($_POST['category']) && !empty($_POST['cat_id']))
{
	$cat_id=$_POST['cat_id'];
	$category=$_POST['category'];
	$row=$obj->num("SELECT * FROM gal_category WHERE id='$cat_id'");
	if($row==1)
	{
	    if(!empty($_FILES['image']['name']))
	    {
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
                    if(!empty($_POST['old_image']))
                    {
                        unlink($_POST['old_image']);
                    }
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
            $query=$obj->query("UPDATE gal_category SET category='$category',image='$new',image_path='$newfile' WHERE id='$cat_id'");
	    }
	    else  
	    {
	        $query=$obj->query("UPDATE gal_category SET category='$category' WHERE id='$cat_id'");
	    }
	    
        
		if($query)
		{
			echo 'ok';
		}
		else
		{
			echo '<p class="alert alert-danger">Faild something wrong</p>';
		}
	}
	else
	{
		echo '<p class="alert alert-danger">Record not found</p>';
	}
}
else
{
	echo '<p class="alert alert-danger">Please fillup all the field</p>';
}
