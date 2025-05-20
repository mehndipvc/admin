<?php
include("config.php");
include('addl_functions.php');

// print_r(count($_POST['parent_ids']));
// exit;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $user_id = $_POST['user_id'];
    $confirmation = $_POST['confirmation'];

    $order_id = $_POST['order_id']; // Generate a unique order ID
    $date = date("Y-m-d");
    $current_time = date("h:i:s A");

    $sum = array_sum($_POST['par-com']);
    $total_amount = $_POST['total_amount'];

    if ($total_amount == "") {
        echo "Please Enter Amount....!!";
        exit;
    }

    if ($sum >= $total_amount) {
        echo "Invalid Commission Amount....!!";
        exit;
    }
    $folder = $_POST['old_invoice'];
    $temp_path = $_POST['old_invoice_temp'];
    if (!empty($_FILES['invoice']['name'])) {
        $invoice = $_FILES['invoice']['name'];
        $allowed = array('doc', 'docx', 'pdf', 'xls', 'xlsx');
        $ext = pathinfo($invoice, PATHINFO_EXTENSION);

        if (in_array($ext, $allowed)) {
            $temp = explode(".", $invoice);
            $newfile = rand(00000000, 99999999) . '.' . end($temp);
            $folder = "../api/assets/invoice/" . $newfile;
            $temp_path = "api/assets/invoice/" . $newfile;
            move_uploaded_file($_FILES['invoice']['tmp_name'], $folder);
            unlink($_POST['old_invoice']);
        } else {
            echo '<p class="alert alert-danger">Invalid file format for invoice. Allowed formats are: doc, pdf, xls, xlsx</p>';
            exit(); // Exit the script if the file format is invalid.
        }
    }


    // Insert into orders table
    $query_ins = $obj->query("INSERT INTO orders(price, user_id, order_id, date, status, title, name, product_id, order_quantity, time, type,invoice_path,temp_path) 
    VALUES ('$total_amount', '$user_id', '$order_id', '$date', '$confirmation', '', '', '', '', '$current_time','Custom','$folder','$temp_path')");

    $parent_ids = $_POST['parent_ids'];
    $par_com = $_POST['par-com'];
    for ($i = 0; $i < count($parent_ids); $i++) {
        $parent_id = $parent_ids[$i];
        $amt = $par_com[$i];
        if ($amt) {
            $tran_id = 'TR' . rand(0000000, 9999999);
            $ins_tran = $obj->query("INSERT INTO `transaction`(`from_id`, `user_id`, `amount`, `order_id`, `transaction_id`, `status`, `payment_mode`) VALUES ('$user_id',
            '$parent_id','$amt','$order_id','$tran_id','Pending','Cr.')");

            $sel_prev = $obj->arr("SELECT wallet FROM users WHERE user_id='$parent_id'");
            $upd_amount = ($sel_prev['wallet'] + $amt);
            $update_wallet = $obj->query("UPDATE users SET wallet='$upd_amount' WHERE user_id='$parent_id'");
        }
    }

    // Check if insertion was successful
    if ($update_wallet) {
        echo "ok";
    } else {
        echo "Error: Could not place order.";
    }
}
?>