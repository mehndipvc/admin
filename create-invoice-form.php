<?php
include("config.php");
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
    
   
    
    $fet_dt=$obj->arr("SELECT * FROM billing ORDER BY id DESC");
    if(!empty($fet_dt['invo_lbl']))
    {
        $invo_lbl=(int)$fet_dt['invo_lbl']+1;
        $invo_no='MPI/22-23/'.$invo_lbl;
    }
    else
    {
        $invo_lbl=101;
        $invo_no='MPI/22-23/'.$invo_lbl;
    }
    
     

    $insert=$obj->query("INSERT INTO `billing` (`name`, `email`, `mobile`, `date`, `bill_adrs`, `gstin`, `del_note`, 
    `ref_no`, `other_ref`, `buy_ref`, `dated`, `disp_no`, `del_note_no`, `dis_through`, `destination`, `flight_no`, `rec_shipper`,
     `port_land`, `port_disch`, `terms_del`, `invo_no`,`invo_lbl`) VALUES ('$name', '$email', '$mobile', '$date', '$bill_adrs', '$gstin', 
     '$del_note', '$ref_no', '$other_ref', '$buy_ref', '$dated', '$disp_no', '$del_note_no', '$dis_through', '$destination', 
     '$flight_no', '$rec_shipper', '$port_land', '$port_disch', '$terms_del','$invo_no','$invo_lbl')");
    if($insert)
    {
       
        $row=0;
        $total_amt_before_tax=0;
        $total_tax=0;
        $total_amt_after_tax=0;
        $total_amt=0;
        for($i=0;$i<$total_count;$i++)
        {         
            
            $service=$_POST['service'][$i];
            $item=$_POST['item'][$i];
            $price=(int)$_POST['price'][$i];
            $dis_rate=(int)$_POST['dis_rate'][$i];
            $dis_amt=(int)$_POST['dis_amt'][$i];
            $cgst_rate=(int)$_POST['cgst_rate'][$i];
            $cgst_amt=(int)$_POST['cgst_amt'][$i];
            $sgst_rate=(int)$_POST['sgst_rate'][$i];
            $sgst_amt=(int)$_POST['sgst_amt'][$i];
            $total=(int)$_POST['total'][$i];
            $total_amt+=(int)$total;
            
            $total_amt_before_tax=($total_amt_before_tax+$price)*$item;
            $total_tax=($total_tax+$cgst_amt)+$sgst_amt;
            $total_amt_after_tax=($total_amt_after_tax+$total);
            
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
        if($row>0)
        {
            $update_amount=$obj->query("UPDATE billing SET final_amt='$total_amt',total_amt_before_tax='$total_amt_before_tax',total_tax='$total_tax',
            total_amt_after_tax='$total_amt_after_tax' WHERE invo_no='$invo_no'");
           
            header("location:pdf.php?invo_no=$invo_no");
        }
        else
        {
            echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Failed something wrong!!';
        }
    }
    else
    {
        echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Failed something wrong!!';
    }
}
else{
    echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Please fill up all the mandotory field';
}
?>