<?php 
include("config.php");
if(!empty($_POST['doctor_id']) && !empty($_POST['cat_id']) && !empty($_POST['code']) && !empty($_POST['name'])
    && !empty($_POST['price']) && !empty($_POST['qty']) && !empty($_POST['total_img'])) {
	$id=$_POST['doctor_id'];
	$cat_id=$_POST['cat_id'];
	$code=$_POST['code'];
	$name=$_POST['name'];
	$price=$_POST['price'];
	$qty=$_POST['qty'];
	$about=base64_encode($_POST['about']);
	$features=base64_encode($_POST['features']);
	$stock=$_POST['stock'];

	$sel = $obj->num("SELECT * FROM items WHERE id='$id'");
	if($sel != '0') {
		if(array_filter($_FILES['img']['name'])) 
		{
		    $da=$obj->arr("SELECT * FROM items WHERE id='$id'");
			$jsonimg=json_decode($da['image_url']);
			foreach($jsonimg as $jsonvl)
			{
			    $tem[]=$jsonvl->image;
			}
			$t_item=$_POST['total_img'];
 			
 			for($cnt=0;$cnt<$t_item;$cnt++)
 			{
 			    
 			   
 			      $old=$_POST['old_image'][$cnt];
 			      $tim=$tem[$cnt];
 			    if($old==$tim)
 			    {
 			    //  echo "djkgdjf";
 			    
             		    $image=$_FILES['img']['name'][$cnt];
             		    if(!empty($_FILES['img']['name'][$cnt]))
             		    {
             		             
             		             unlink($old);
                     		    $allowed = array('gif', 'png', 'jpg','jpeg','webp');
                                $ext = pathinfo($image, PATHINFO_EXTENSION);
                                if (in_array($ext, $allowed)) 
                                {
                         		    $tmp_image=$_FILES['img']['tmp_name'][$cnt];
                                    $temp=explode(".", $image);
                                    $newfile=rand(00000000,99999999).'.'.end($temp);
                                    $folder="../api/assets/".$newfile;
                                    $new[]['image']=$folder;
                                    $upload=move_uploaded_file($tmp_image, $folder);
                                }
             		    }
             		    else
             		    {
             		        $new[]['image']=$old;
             		    }
 			    }
 			    else
 			    {
 			        // echo"ok";
 			         if(!empty($_FILES['img']['name'][$cnt]))
             		    {
             		             
                     		    $allowed = array('gif', 'png', 'jpg','jpeg','webp');
                                $ext = pathinfo($image, PATHINFO_EXTENSION);
                                if (in_array($ext, $allowed)) 
                                {
                         		    $tmp_image=$_FILES['img']['tmp_name'][$cnt];
                                    $temp=explode(".", $image);
                                    $newfile=rand(00000000,99999999).'.'.end($temp);
                                    $folder="../api/assets/".$newfile;
                                    $new[]['image']=$folder;
                                    $upload=move_uploaded_file($tmp_image, $folder);
                                }
                                // echo"not ok";
             		    }
 			    }
 			}
 			
	
	         $file = json_encode($new);
	        
			$query = $obj->query("UPDATE items SET cat_id='$cat_id',code='$code',image_url='$file',
			    name='$name',price='$price',quantity='$qty',about='$about',features='$features',status='$stock' WHERE id='$id'");
			if($query) {
				echo 'ok';
			} else {
				echo '<p class="alert alert-danger">Failed something wrong</p>';
			}
		} else {
			$query = $obj->query("UPDATE items SET cat_id='$cat_id',code='$code', name='$name',price='$price',quantity='$qty',about='$about',features='$features',status='$stock' WHERE id='$id'");
			if($query) {
				echo 'ok';
			} else {
				echo '<p class="alert alert-danger">Failed something wrong</p>';
			}
		}
    } else {
        echo '<p class="alert alert-danger">Record not found</p>';
    }
} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
