<?php
include("config.php");
include('addl_functions.php');

// print_r(count($_POST['parent_ids']));
// exit;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $user_id = $_POST['user_id'];
    $confirmation = $_POST['confirmation'];
    $total_price = 0; // Assuming you calculate the total price separately
   $order_id=rand(0000000000000,9999999999999); // Generate a unique order ID
    $date = date("Y-m-d");
    $current_time = date("h:i:s A");

    // Initialize arrays to store product details
    $pro_names = [];
    $pro_ids = [];
    $pro_qty = [];

    // Loop through the products and quantities
    if (isset($_POST['item']) && isset($_POST['qty'])) {
        foreach ($_POST['item'] as $index => $product_id) {
            $quantity = $_POST['qty'][$index];

            // Fetch the product details from the database based on product_id
            $product = $obj->arr("SELECT * FROM `items` WHERE id = $product_id");
            $product_name = $product['name'];
            $product_price = $product['price']; // Assuming there's a 'price' column
            $product_code = $product['code']; // Assuming there's a 'code' column
            $product_image_url = $product['image_url']; // Assuming there's an 'image_url' column

            // Calculate total price (simple addition)
            $total_price += $product_price * $quantity;

            // Store product details for orders table
            $pro_names[] = $product_name;
            $pro_ids[] = $product_id;
            $pro_qty[] = $quantity;

            // Insert into order_item table
            $ins_item = $obj->query("INSERT INTO order_item(item_id, name, code, image_url, parent, price, quantity, about, features, user_id, actual_price, total_price, order_id) 
            VALUES ('$product_id', '$product_name', '$product_code', '$product_image_url', '', '$product_price', '$quantity', '', '', '$user_id', '$product_price', '".($product_price * $quantity)."', '$order_id')");
        }
    }

    // Convert arrays to comma-separated strings
    $pro_names = implode(',', $pro_names);
    $pro_ids = implode(',', $pro_ids);
    $pro_qty = implode(',', $pro_qty);

    // Insert into orders table
    $query_ins = $obj->query("INSERT INTO orders(price, user_id, order_id, date, status, title, name, product_id, order_quantity, time, type) 
    VALUES ('$total_price', '$user_id', '$order_id', '$date', '$confirmation', '$pro_names', '', '$pro_ids', '$pro_qty', '$current_time','Automatic')");
    
    // $parent_ids=$_POST['parent_ids'];
    // $par_com=$_POST['par-com'];
    // for($i=0;$i<count($parent_ids);$i++){
    //     $parent_id=$parent_ids[$i];
    //     $amt=$par_com[$i];
    //     if($amt){
    //         $tran_id='TR'.rand(0000000,9999999);
    //         $ins_tran=$obj->query("INSERT INTO `transaction`(`from_id`, `user_id`, `amount`, `order_id`, `transaction_id`, `status`, `payment_mode`) VALUES ('$user_id',
    //         '$parent_id','$amt','$order_id','$tran_id','Pending','Cr.')");
            
    //         $sel_prev=$obj->arr("SELECT wallet FROM users WHERE user_id='$parent_id'");
    //         $upd_amount=($sel_prev['wallet']+$amt);
    //         $update_wallet=$obj->query("UPDATE users SET wallet='$upd_amount' WHERE user_id='$parent_id'");
    //     }
    // }

    // Check if insertion was successful
    if ($query_ins && $ins_item) {
        echo "ok";
    } else {
        echo "Error: Could not place order.";
    }
}
?>
