<?php 
include("config.php");

function check($data,$val){
    foreach($data as $dataVal){
        if($dataVal['image']==$val){
            return true;
        }
    }
    return false;
}


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
	
	$new=[];

	$sel = $obj->num("SELECT * FROM items WHERE id='$id'");
	if($sel != '0') {
	    
	    $allowed = array('gif', 'png', 'jpg','jpeg','webp');
        
		$t_item=$_POST['total_img'];
 			
 		for($cnt=0;$cnt<$t_item;$cnt++)
 		{
 		    if($_FILES['img']['name'][$cnt]!=""){
     		    
     		    $image=$_FILES['img']['name'][$cnt];
     		    
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
 		    }else{
 		        if($_POST['old_image'][$cnt]){
 		            $new[]['image']=$_POST['old_image'][$cnt];
 		        }
 		    }
            
            //print_r($_FILES['img']['name'][$cnt]);
    		//exit;
 		}
 		
 		
 		$sel_image = $obj->arr("SELECT image_url FROM items WHERE id='$id'");
 		
 		$old_images=json_decode($sel_image['image_url']);
 		
 		$file = json_encode($new);
 		
//  		echo 'Newww   ';
//  		print_r($new);
 		
//  		echo '  Old   ';
//  		print_r($old_images);
//  		exit;
 		
 		foreach($old_images as $imgVal){
 		    if(!check($new,$imgVal->image)){
 		        unlink($imgVal->image);
 		        //print_r($imgVal->image);
 		    }
 		}
//  		echo '/////////////';

//         foreach($new as $imVal){
//  		      print_r($imVal['image']);
//  		}
        
	        
		$query = $obj->query("UPDATE items SET cat_id='$cat_id',code='$code',image_url='$file',
			    name='$name',price='$price',quantity='$qty',about='$about',features='$features',status='$stock' WHERE id='$id'");
 		
 		
 		
 		echo 'ok';
		
		
    } else {
        echo '<p class="alert alert-danger">Record not found</p>';
    }
} else {
	echo '<p class="alert alert-danger">Please fillup all the mandotory field</p>';
}
