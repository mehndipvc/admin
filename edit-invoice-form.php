<?php
require_once("config.php");
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['date']) && 
!empty($_POST['bill_adrs']) && !empty($_POST['total_count']))
{ 
    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $date=$_POST['date'];
    $bill_adrs=$_POST['bill_adrs'];
    $gstin=$_POST['gstin'];
    $del_note=$_POST['del_note'];
    $ref_no=$_POST['ref_no'];
    $other_ref=$_POST['other_ref'];
    $buy_ref=$_POST['buy_ref'];
    $dated=$_POST['dated'];
    $disp_no=$_POST['disp_no'];
    $del_note_no=$_POST['del_note_no'];
    $dis_through=$_POST['dis_through'];
    $destination=$_POST['destination'];
    $flight_no=$_POST['flight_no'];
    $rec_shipper=$_POST['rec_shipper'];
    $port_land=$_POST['port_land'];
    $port_disch=$_POST['port_disch'];
    $terms_del=$_POST['terms_del'];
    $total_count=$_POST['total_count'];
    $invo_no = $_POST['invo_no'];

    $update_bill = $obj->query("UPDATE billing SET `name`='$name', `email`='$email', `mobile`='$mobile', `date`='$date',
     `bill_adrs`='$bill_adrs', `gstin`='$gstin',`del_note`='$del_note',`ref_no`='$ref_no',`other_ref`='$other_ref',
     `buy_ref`='$buy_ref',`dated`='$dated',`disp_no`='$disp_no',`del_note_no`='$del_note_no',`dis_through`='$dis_through',
     `destination`='$destination',`flight_no`='$flight_no',`rec_shipper`='$rec_shipper',`port_land`='$port_land',
     `port_disch`='$port_disch',`terms_del`='$terms_del' WHERE invo_no='$invo_no'");
    $row=0;
    $total_amt=0;
    for($i=0; $i<$total_count; $i++)
    {
        $service=$_POST['service'][$i];
        $item=$_POST['item'][$i];
        $price=$_POST['price'][$i];
        $dis_rate=$_POST['dis_rate'][$i];
        $dis_amt=$_POST['dis_amt'][$i];
        $cgst_rate=$_POST['cgst_rate'][$i];
        $cgst_amt=$_POST['cgst_amt'][$i];
        $sgst_rate=$_POST['sgst_rate'][$i];
        $sgst_amt=$_POST['sgst_amt'][$i];
        $total=$_POST['total'][$i];
        $bill_dtl_id=$_POST['bill_dtl_id'][$i];
        $total_amt+=(int)$total;
        if(!empty($bill_dtl_id))
        {
            $update_dtls = $obj->query("UPDATE billing_details SET `service`='$service', `item`='$item', `price`='$price',
             `dis_rate`='$dis_rate', `dis_amt`='$dis_amt',`cgst_rate`='$cgst_rate', `cgst_amt`='$cgst_amt', 
             `sgst_rate`='$sgst_rate', `sgst_amt`='$sgst_amt', `total`='$total', `bill_id`='$invo_no' WHERE id='$bill_dtl_id'");
            if(!$update_dtls)
            {
            echo '<p class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>'.$i.' row updation failed</p>';
            }
            else
            {
            $row++;
            }
        }
        else
        {
            $insert_details=$obj->query("INSERT INTO `billing_details` (`service`, `item`, `price`, `dis_rate`, `dis_amt`, 
            `cgst_rate`, `cgst_amt`, `sgst_rate`, `sgst_amt`, `total`, `bill_id`)
             VALUES ('$service', '$item', '$price', '$dis_rate', '$dis_amt', '$cgst_rate', '$cgst_amt', '$sgst_rate',
              '$sgst_amt', '$total', '$invo_no');");
            if(!$insert_details)
            {
            echo '<p class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>'.$i.' row submission failed</p>';
            }
            else
            {
            $row++;
            }
        }
    }
    if($row>0)
    {
        $update_amount=$obj->query("UPDATE billing SET final_amt='$total_amt' WHERE invo_no='$invo_no'");
        echo '<p class="alert alert-success"><i class="fa fa-check-square-o"></i> Successfully Updated</p>';
    }
    else
    {
        echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Failed something wrong!!';
    }
}
else
{
    echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Please fill up all the mandotory field';
}
?>