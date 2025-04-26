<?php 
include("config.php");
//print_r($_FILES);
error_reporting(0);
if(!empty($_POST['location']) && !empty($_POST['sub_location']) && !empty($_POST['bhk']) && !empty($_POST['pro_type']) 
&& !empty($_POST['status']) && !empty($_POST['pro_name']) && !empty($_POST['pro_full_ads']) && !empty($_POST['description'])
&& !empty($_POST['details']) && !empty($_POST['amenities']) && !empty($_POST['payment_plan']) 
&& !empty($_POST['loc_map'])  && !empty($_POST['total_img'] && !empty($_POST['doctor_id']))
)
{
    $location=$_POST['location'];
    $sub_location=$_POST['sub_location'];
    $bhk=$_POST['bhk'];
    $pro_type=$_POST['pro_type'];
    $status=$_POST['status'];
    $pro_name=$_POST['pro_name'];
    $pro_full_ads=$_POST['pro_full_ads'];
    $description=base64_encode($_POST['description']);
    $details=base64_encode($_POST['details']);
    $amenities=base64_encode($_POST['amenities']);
    $loc_map=base64_encode($_POST['loc_map']);
    $payment_plan=base64_encode($_POST['payment_plan']);


    $floor_plan_old=$_POST['floor_plan_old'];
    $brochure_old=$_POST['brochure_old'];
    $id=$_POST['doctor_id'];
    $cr_date=date('Y-m-d');
    

    if(!empty($_FILES['floor_plan']['name']))
    {
        unlink($floor_plan_old);
        $floor_plan=$_FILES['floor_plan']['name'];
        $allowed_floor = array('gif', 'png', 'jpg','jpeg','webp');
        $ext_floor = pathinfo($floor_plan, PATHINFO_EXTENSION);
        if (in_array($ext_floor, $allowed_floor)) 
        {
            $tmp_floor=$_FILES['floor_plan']['tmp_name'];
            $temp_floor=explode(".", $floor_plan);
            $newfile_floor=rand(00000000,99999999).'.'.end($temp_floor);
            $folder_floor="images/Products/".$newfile_floor;
            $upload_floor=move_uploaded_file($tmp_floor, $folder_floor);
        }
    }
    else
    {
        $folder_floor=$floor_plan_old;
    }
    
    if(!empty($_FILES['brochure']['name']))
    {
        unlink($brochure_old);
        $brochure=$_FILES['brochure']['name'];
        $allowed_bro = array('gif', 'png', 'jpg','jpeg','webp');
        $ext_bro = pathinfo($brochure, PATHINFO_EXTENSION);
        if (in_array($ext_bro, $allowed_bro)) 
        {
            $tmp_bro=$_FILES['brochure']['tmp_name'];
            $temp_bro=explode(".", $brochure);
            $newfile_bro=rand(00000000,99999999).'.'.end($temp_bro);
            $folder_bro="images/Products/".$newfile_bro;
            $upload_bro=move_uploaded_file($tmp_bro, $folder_bro);
        }
    }
    else
    {
        $folder_bro=$brochure_old;
    }



    if(!empty($_FILES['img']['name']))
		{
			$da=$obj->arr("SELECT * FROM property WHERE id='$id'");
			$tem=unserialize($da['image']);
			$t_item=$_POST['total_img'];
            // echo $t_item;
            // echo "okkkk";  
 			for($cnt=0;$cnt<$t_item;$cnt++)
 			{
 			     $old=$_POST['old_image'][$cnt];
 			     $tim=$tem[$cnt];
 			    if($old==$tim)
 			    {
 			    // echo "djkgdjf";
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
                                $folder="images/Products/".$newfile;
                                $new[]=$folder;
                                $upload=move_uploaded_file($tmp_image, $folder);
                            }
                    }
                    else
                    {
                        $new[]=$old;
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
                                    $folder="images/Products/".$newfile;
                                    $new[]=$folder;
                                    $upload=move_uploaded_file($tmp_image, $folder);
                                }
                              //  echo"not ok";
             		    }
 			    }
 			}
	        $file=serialize($new);

            $update=$obj->query("UPDATE property SET location='$location', sub_location='$sub_location', bhk='$bhk', 
            pro_type='$pro_type', status='$status',pro_name='$pro_name', pro_full_ads='$pro_full_ads', description='$description',
            details='$details', amenities='$amenities', payment_plan='$payment_plan', floor_plan='$folder_floor',loc_map='$loc_map',
            brochure='$folder_bro', cr_date='$cr_date', image='$file' WHERE id='$id'"); 
            if($update)
            {
                echo '<p class="alert alert-success mt-3"><i class="fa fa-check-square-o" aria-hidden="true"></i> Property Updated Successfully</p>';
            }
            else
            {
                echo '<p class="alert alert-danger mt-3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Something Wrong</p>';
            }
           
        }
        else
        {
            $update=$obj->query("UPDATE property SET location='$location', sub_location='$sub_location', bhk='$bhk', 
            pro_type='$pro_type', status='$status',pro_name='$pro_name', pro_full_ads='$pro_full_ads', description='$description',
            details='$details', amenities='$amenities', payment_plan='$payment_plan', floor_plan='$folder_floor',loc_map='$loc_map',
            brochure='$folder_bro', cr_date='$cr_date' WHERE id='$id'"); 
            if($update)
            {
                echo '<p class="alert alert-success mt-3"><i class="fa fa-check-square-o" aria-hidden="true"></i> Property Updated Successfully</p>';
            }
            else
            {
                echo '<p class="alert alert-danger mt-3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Something Wrong</p>';
            }
        }




}
else
{
    echo '<p class="alert alert-danger mt-3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please fill all mandatory field</p>';    
}
