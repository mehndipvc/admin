<?php
header('Content-type: text/html; charset=UTF-8') ;
require_once 'dompdf/autoload.inc.php';
//error_reporting(0);
use Dompdf\Dompdf;
use Dompdf\Options;

// if(empty($_GET['invo_no']))
// {
//     echo '<script>window.location.href="create-invoice"</script>';
// }

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

if(isset($_GET["invo_no"])) 
{
require_once("config.php");
$invo_no=$_GET['invo_no'];
$fetch_data=$obj->arr("SELECT * FROM billing WHERE invo_no='$invo_no'");
$invo_lbl=$fetch_data['invo_lbl'];
$fetch_item=$obj->fetch("SELECT * FROM billing_details WHERE bill_id='$invo_no'");

$output=
'
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap");
*{
    font-family: "Poppins", sans-serif;
}
</style>
 <table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr>
   <td colspan="2" align="center" style="font-size:18px;"><b>Invoice</b></td>
  </tr>
  <tr>
    <td colspan="2">
    <table><tr>
     
       
    <td style="text-align:left;">
      <b>Seller Information</b>,<br>
      Mehndi PVC Profile,<br>
  
      Unit No. 506 , DN-10 ,Sector V, Salt Lake, Kolkata - 700151 <br>
       PH. No. - +91 - 9432205976<br>
       GSTIN/UIN: 19AAOCA0560G1ZO<br>
       CIN: 	U72300WB2015PTC208377<br>
       </td>
       <td style="text-align:right;padding-left:150px;text-colour:#0517f2">
       <img src="https://project.adretsoftware.in/Mehedi/images/logo/logo.png" style="text-align:right;width:200px;"><br><br>
       AN ISO CERTIFIED COMPANY
       </td>
       </tr>
       </table>
       
    </td>
   
  </tr>
  <tr>
   <td colspan="2">
    <table>
     <tr>
      <td width="65%">
       To,<br />
       <b>RECEIVER (BILL TO)</b><br />
       Name : '.$fetch_data["name"].'<br /> 
       Billing Address : '.$fetch_data["bill_adrs"].'<br />
       Mobile Number : '.$fetch_data["mobile"].'<br />
       GSTIN/UIN : '.$fetch_data["gstin"].'<br />
       Email : '.$fetch_data["email"].'<br />
      </td>
      <td width="35%">
       Reverse Charge<br />
       Invoice No. : #'.$fetch_data["invo_no"].'<br />
       Invoice Date : '.$fetch_data["date"].'<br />
      </td>
     </tr>
    </table>
    <br />
    <table  border="1" width="100%">
     <tr>
        <th>Description of Goods</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Discount</th>
        <th>CGST(%)</th>
        <th>SGST(%)</th>
        <th align="right">Total</th>
     </tr>
';

foreach ($fetch_item as $val) {
    $output .= '
    <tr>
        <td>' . $val["service"] . '</td>
        <td>' . $val["item"] . '</td>
        <td>' . $val["price"] . '</td>
        <td>' . $val["dis_rate"] . '</td>
        <td>' . $val["cgst_rate"] . '</td>
        <td>' . $val["sgst_rate"] . '</td>
        <td colspan="2" align="right">' . $val["total"] . '</td>
    </tr>
    ';
}
$output .= '
  <tr>
   <td colspan="6"><b>Total Amt. Before Tax :</b></td>
   <td align="right">'.$fetch_data["total_amt_before_tax"].'</td>
  </tr>
  <tr>
   <td colspan="6"><b>Total Tax Amt.  :</b></td>
   <td align="right">'.$fetch_data["total_tax"].'</td>
  </tr>
  <tr>
   <td colspan="6"><b>Total Amt. After Tax :</b></td>
   <td align="right">'.$fetch_data["total_amt_after_tax"].'</td>
  </tr>';
  $output .= '
      </table>
      <br>
     </td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td align="left" >
                      
                        Company Name : Mehedi PVC<br>
                        Account Number : 10114905054<br>
                        Bank Name : IDFC FIRST BANK<br>
                        IFSC : IDFB0060102<br>
                        Branch : Saltlake sector 5, Kolkata, India<br>
                    </td>
                    
                </tr>
            </table>
        </td>
    </tr>
   </table>
   <hr>
   <footer style="text-align:center;">This is computer generated invoice no signature required</footer>
  ';
  
    $dompdf->loadHtml($output);
    $dompdf->setPaper('A4', 'Portrait');
    $dompdf->render();
    $data = $dompdf->Output();
    file_put_contents("pdf/".$invo_lbl.".pdf", $data);
    
    $email = $fetch_data["email"];
    
    
        // Recipient 
        $to = $email;
    
        // Sender 
        $from = 'admin@adretsoftware.com';
        $fromName = 'Mehedi';
    
        // Email subject 
        $subject = 'Invoice ' . $fetch_data["name"];
    
        // Attachment file 
        $file = "pdf/".$invo_lbl.".pdf";
    
        // Email body content 
        $htmlContent = ' 
                        Dear Client,
                        <br><br>
                        Greetings of the day!
                        <br><br>
                        Hope you are doing good. Please check the attached invoice and kindly process the payment.
                        <br><br>
                        Bank Account Details : <br>
                        Company Name : Mehedi<br>
                        Account Number : 10114905054<br>
                        Bank Name : IDFC FIRST BANK<br>
                        IFSC : IDFB0060102<br>
                        Branch : Saltlake sector 5, Kolkata, India<br>
                        <br><br><br>
                        
                        Thank You
                        Stay safe . 
    ';

    // Header for sender info 
    $headers = "From: $fromName" . " <" . $from . ">";

    // Boundary  
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // Headers for attachment  
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // Multipart boundary  
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    // Preparing attachment 

    $message .= "--{$mime_boundary}\n";

    if (!empty($file) > 0) 
    {
        if (is_file($file)) 
        {
            $message .= "--{$mime_boundary}\n";
            $fp =    @fopen($file, "rb");
            $data =  @fread($fp, filesize($file));

            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                "Content-Description: " . basename($file) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }

    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;

    // Send email 
    $mail = @mail($to, $subject, $message, $headers, $returnpath);
    if($mail)
    {
         echo '<script>window.location.href="invoice"</script>';
    }
    else
    {
        //echo '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Failed something wrong!!</p>';
        header("location:https://project.adretsoftware.in/Mehedi/invoice");
    }
}
?>