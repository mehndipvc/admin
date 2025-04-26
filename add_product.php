<?php 
//print_r($_POST);
include("config.php");
//print_r($_POST);

if(!empty($_FILES['image']['name']) && !empty($_POST['cat_id']) && !empty($_POST['code']) && !empty($_POST['name'])
 && !empty($_POST['qty']) && !empty($_POST['total_item']))
{
	
                $cat_id=$_POST['cat_id'];
                $code=$_POST['code'];
                $name=$_POST['name'];
                $price=$_POST['price'];
                $qty=$_POST['qty'];
                $about=base64_encode($_POST['about']);
                $features=base64_encode($_POST['features']);
                $stock=$_POST['stock'];

                $t_item=$_POST['total_item'];
                //echo $t_item;
                $new=array();
                for($cnt=0;$cnt<$t_item;$cnt++)
                {
        
                    $image=$_FILES['image']['name'][$cnt];
                    $allowed = array('gif', 'png', 'jpg','jpeg','webp');
                    $ext = pathinfo($image, PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) 
                    {
                        $tmp_image=$_FILES['image']['tmp_name'][$cnt];
                        $temp=explode(".", $image);
                        $newfile=rand(00000000,99999999).'.'.end($temp);
                        $folder="../api/assets/".$newfile;
                        if(move_uploaded_file($_FILES['image']['tmp_name'][$cnt], $folder))
                        {
                             $new[]['image']=$folder;
                        }
                       
                    }
                    else{
                        echo '<p class="alert alert-danger mt-3">Image Format not Supported</p>';
                    }
                }
                  $file=json_encode($new);
                
                $query=$obj->query("INSERT INTO `items` (`cat_id`, `code`, `name`, `price`, `quantity`, `about`, `features`,
                    `image_url`,`status`,`item_id`) VALUES ('$cat_id', '$code', '$name', '$price', '$qty', '$about', '$features', '$file','$stock','')");
                // echo "INSERT INTO `items` (`item_id`, `parent`, `code`, `name`, `price`, `quantity`, `about`, `features`,
                //     `image_url`) VALUES ('$timestamp','$cat_id', '$code', '$name', '$price', '$qty', '$about', '$features', '$firstImage')";
                // exit();
            
                if($query)
                {
                    echo 'ok';
                }
                else
                {
                    echo '<p class="alert alert-success">Failed something wrong</p>';
                }
}
else
{
	echo '<p class="alert alert-warning">Please fillup all the mandotory field</p>';
}

?>