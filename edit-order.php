<?php
include("config.php");
include('addl_functions.php');
// print_r($_POST);
// exit();
if (!empty($_POST['order_id']) && !empty($_POST['confirmation'])) {
    $proIds = isset($_POST['pro_id']) ? $_POST['pro_id'] : [];
    $proIdsString = implode(',', $proIds);

    $product_name_arr = array();
    $count = count((array) $_POST['pro_id']);
    for ($i = 0; $i < $count; $i++) {
        $product_id = $_POST['pro_id'][$i];
        $pro_name_fet = $obj->arr("SELECT name FROM items WHERE id='$product_id'");
        $product_name_arr[] = $pro_name_fet['name'];
    }

    $product_namear = implode(',', $product_name_arr);
    $product_qty = implode(',', $_POST['quantity']);
    $product_qty = str_replace(' ', '', $product_qty);

    $id = $_POST['order_id'];
    $status = $_POST['confirmation'];
    $remarks = $_POST['remarks'];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $parent_id = $_POST['parent_id'];
    $folder = '';

    $numbers = explode(",", $proIdsString);
    $total_item = count($numbers);

    //   print_r($total_item);
//   exit;

    // $sel_prev=$obj->num("SELECT id FROM order_item WHERE order_id='$id'");

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

        } else {
            echo '<p class="alert alert-danger">Invalid file format for invoice. Allowed formats are: doc, pdf, xls, xlsx</p>';
            exit(); // Exit the script if the file format is invalid.
        }
    }

    // echo $total_item;
    // exit();

    $total = 0;



    for ($j = 0; $j < $total_item; $j++) {

        $pro_id = $numbers[$j];
        $qty = $_POST['quantity'][$j];

        $sel_prev = $obj->num("SELECT id FROM order_item WHERE order_id='$id' AND item_id='$pro_id'");
        $sel_item = $obj->arr("SELECT name,code,image_url,price,cat_id FROM items WHERE id='$pro_id'");

        $pro_price = checkPrice($obj, $user_id, $pro_id, $sel_item['cat_id'], $user_type);

        if ($sel_prev == 0) {
            $pro_name = $sel_item['name'];
            $pro_code = $sel_item['code'];
            //$pro_price=$sel_item['price'];
            $img_arr = json_decode($sel_item['image_url'], true);
            $first_img = $img_arr[0]['image'];
            $url = $first_img;
            $cleaned_url = preg_replace('/^\.\.\//', '', $url);
            $total_price = $pro_price * $qty;
            $total = $total + $total_price;
            $ins_ord = $obj->query("INSERT INTO order_item (`item_id`, `name`, `code`, `image_url`, `parent`, `price`, `quantity`, `about`, `features`, `user_id`, `actual_price`, `order_id`, `total_price`) 
VALUES ('$pro_id', '$pro_name', '$pro_code', '$cleaned_url','','$pro_price','$qty', '', '', '$user_id', '$pro_price', '$id', '$total_price')");

        } else {
            $pro_name = $sel_item['name'];
            $pro_code = $sel_item['code'];
            //$pro_price=$sel_item['price'];
            $img_arr = json_decode($sel_item['image_url'], true);
            $first_img = $img_arr[0]['image'];
            $url = $first_img;
            $cleaned_url = preg_replace('/^\.\.\//', '', $url);
            $total_price = $pro_price * $qty;
            $total = $total + $total_price;
            $update_ord = $obj->query("UPDATE order_item SET  `name` = '$pro_name',`code` = '$pro_code',`image_url` = '$cleaned_url',`price` = '$pro_price',`quantity` = '$qty',`user_id` = '$user_id',`actual_price` = '$pro_price',`order_id` = '$id',`total_price` = '$total_price' WHERE `item_id` = '$pro_id' AND order_id='$id'");
        }


    }

    if ($status == 'Confirmed') {

        $ascendants = getAscendants($parent_id, $obj);

        foreach ($ascendants as $val) {
            $total_commission = 0;
            $parents = $val['user_id'];
            $user_type = $val['user_type'];
            for ($j = 0; $j < $total_item; $j++) {
                $pro_id = $numbers[$j];
                $qty = $_POST['quantity'][$j];
                $sel_item = $obj->arr("SELECT cat_id FROM items WHERE id='$pro_id'");
                $pro_commission = checkCommsission($obj, $parents, $pro_id, $sel_item['cat_id'], $user_type);
                $amount = (int) $qty * (int) $pro_commission;
                $total_commission += (int) $amount;
            }

            // Check For Previous
            $sel_prev = $obj->arr("SELECT amount FROM transaction WHERE order_id='$id' AND user_id='$parents'");
            $prev_tran_amount = $sel_prev['amount'];
            $del_prev = $obj->query("DELETE FROM transaction WHERE order_id='$id' AND user_id='$parents'");

            // For New
            $tran_id = 'TR' . rand(0000000, 9999999);
            $ins_tran = $obj->query("INSERT INTO `transaction`(`from_id`, `user_id`, `amount`, `order_id`, `transaction_id`, `status`, `payment_mode`) VALUES ('$user_id',
            '$parents','$total_commission','$id','$tran_id','Pending','Cr.')");

            $sel_prev = $obj->arr("SELECT wallet FROM users WHERE user_id='$parents'");
            $upd_amount = ($sel_prev['wallet'] + $total_commission) - $prev_tran_amount;
            $update_wallet = $obj->query("UPDATE users SET wallet='$upd_amount' WHERE user_id='$parents'");

        }


    }

    if (empty($folder) && empty($temp_path)) {

        $update = $obj->query("UPDATE orders SET status='$status', title='$product_namear', product_id='$proIdsString', remarks='$remarks',order_quantity='$product_qty',price='$total' WHERE order_id='$id'");
    } else {
        $update = $obj->query("UPDATE orders SET status='$status', title='$product_namear', product_id='$proIdsString', remarks='$remarks',
        invoice_path='$folder',temp_path='$temp_path',order_quantity='$product_qty',price='$total' WHERE order_id='$id'");
    }

    if ($update) {
        echo 200;
    } else {
        echo '<p class="alert alert-danger">Error something wrong</p>';
    }
} else {
    echo '<p class="alert alert-danger">Error empty field</p>';
}
?>