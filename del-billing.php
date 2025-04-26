<?php
include("config.php");
if(!empty($_POST["invo_no"]))
{
    $invo_no=$_POST['invo_no'];
    
    $sel=$obj->arr("SELECT * FROM billing WHERE invo_no='$invo_no'");
    if(!empty($sel))
    {
        $del=$obj->query("DELETE FROM `billing` WHERE invo_no='$invo_no'");
        if($del)
        {
            $sel_bill=$obj->fetch("SELECT * FROM billing_details WHERE bill_id='$invo_no'");
            if(!empty($sel_bill))
            {
                $del_bill=$obj->query("DELETE FROM `billing_details` WHERE bill_id='$invo_no'");
                if($del_bill)
                {
                    echo '<p class="alert alert-success"><i class="fa fa-check-square-o"></i> Successfully Deleted.</p>';
                }
                else
                {
                    echo '<p class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> Something went wrong'; 
                }
            }
            else
            {
                echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Unable to select the data';
            }
        } 
        else
        {
            echo '<p class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> Something went wrong';
        }   
    }
    else
    {
        echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Unable to select the data';
    }
}
else
{
    echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>Error Occured';
}
?>