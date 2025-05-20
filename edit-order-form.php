<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
?>
<?php include("config.php"); ?>
<!DOCTYPE html>
<html>

<?php //header link
include("header_link.php"); ?>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <?php
        include("header.php");
        ?>
        <?php
        include('addl_functions.php');
        $order_id = $_GET['order_id'];
        $val = $obj->arr("SELECT * FROM orders WHERE order_id='$order_id'");
        $user_id = $val['user_id'];
        $user_type = $obj->arr("SELECT user_type,parent_id FROM users WHERE user_id='$user_id'");
        $par_id = $user_type['parent_id'];
        $sel_parent = $obj->arr("SELECT user_id FROM users WHERE id='$par_id'");
        ?>
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Edit Order</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Order</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    <div class="col-sm-12 text-right mb-3">
                        <input type="text" placeholder="Search..." id="search">
                    </div>
                    <div class="col-md-12">
                        <form id="edit_order_form">
                            <div class="form-header">
                                <div class="row">
                                    <?php
                                    $sel_order = explode(",", $val['product_id']);
                                    $pro_qry = explode(',', $val['order_quantity']);
                                    $pro_data = $obj->fetch("SELECT id, name,price,cat_id FROM `items`");
                                    $pro_count = count($sel_order);

                                    $total_amount = 0;

                                    $price = null;


                                    $procount = 0;
                                    $order_data_item = $obj->fetch("SELECT name,quantity,item_id,price FROM order_item WHERE order_id='$order_id'");
                                    foreach ($order_data_item as $val_item) {
                                        $item_id = $val_item['item_id'];

                                        // Output product details
                                        $price = $val_item['price'];

                                        $total_product = $price * $val_item['quantity'];
                                        $total_amount += $total_product;
                                        $procount++;
                                        ?>
                                        <div class="form-group text-left col-sm-6">
                                            <label>Product <?= $procount ?><span class="text-danger">*</span></label><br>
                                            <select class="form-control product-select" name="pro_id[]" required>
                                                <?php
                                                foreach ($pro_data as $val_pro) {
                                                    $pro_id = $val_pro['id'];
                                                    $price_new = checkPrice($obj, $user_id, $pro_id, $val_pro['cat_id'], $user_type['user_type']);
                                                    ?>
                                                    <option value="<?= $val_pro['id'] ?>" data-price="<?= $price_new ?>"
                                                        <?= ($item_id == $val_pro['id']) ? 'selected' : '' ?>>
                                                        <?= $val_pro['name'] ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group text-left col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Qty</label>
                                                    <input type="text" class="form-control quantity"
                                                        value="<?= $val_item['quantity'] ?>" name="quantity[]">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Price</label>
                                                    <input type="text" class="form-control price" id="price<?= $procount ?>"
                                                        value="<?= $price ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="row" id="prodBody"></div>
                            </div>

                            <input type="hidden" id="procount" value="<?= $procount ?>">
                            <a href="javascript:void(0)" class="btn btn-primary mx-auto  addProduct"
                                id="<?php echo $val['order_id'] ?>">Add Product</a>

                            <div class="form-group text-right" style="font-size:18px">
                                <label style="font-weight: bold;">Total Amount:</label>
                                <span style="font-family:cambria">&#8377;</span> <span id="totalAmount"
                                    style="color: blue;"><?= $total_amount ?></span>
                            </div>

                            <div class="form-group text-left">
                                <div class="mb-3">
                                    <label for="example-textarea" class="form-label">Remarks</label>
                                    <textarea class="form-control" name="remarks"
                                        id="example-textarea"><?= $val['remarks'] ?></textarea>
                                </div>
                            </div>

                            <div class="form-group text-left">
                                <label for="example-textarea" class="form-label">Status</label>
                                <select class="form-control" name="confirmation"
                                    id="staTus<?php echo $val['order_id']; ?>">
                                    <option value="Pending Confirmation" <?= ($val['status'] == 'Pending Confirmation') ? 'selected' : '' ?>>Pending Confirmation</option>
                                    <option value="Cancelled" <?= ($val['status'] == 'Cancelled') ? 'selected' : '' ?>>
                                        Cancelled</option>
                                    <option value="Confirmed" <?= ($val['status'] == 'Confirmed') ? 'selected' : '' ?>>
                                        Confirmed</option>
                                </select>
                            </div>

                            <div class="form-group text-left">
                                <label>Upload Invoice (doc, docx, pdf, xls, xlsx)</label>
                                <input type="file" class="form-control" name="invoice">
                            </div>

                            <div class="form-group">

                                <input type="hidden" name="order_id" value="<?php echo $val['order_id'] ?>" />
                                <input type="hidden" name="user_id" value="<?php echo $val['user_id'] ?>" />
                                <input type="hidden" name="user_type" value="<?php echo $user_type['user_type'] ?>" />
                                <input type="hidden" name="parent_id" value="<?php echo $sel_parent['user_id'] ?>" />

                                <button type="submit" class="btn btn-primary mx-auto continue-btn editSubmit"
                                    id="<?php echo $val['order_id']; ?>">Submit</button>
                            </div>

                            <div class="form-group errorMsg">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    //footer link
    include("footer_link.php");

    //footer
    include("footer.php");

    ?>


    <script>
        $(".product-select").select2();
    </script>
    <script>
        $('.addProduct').on("click", function () {
            let totalCount = $('#procount').val();
            totalCount++;
            let id = $(this).attr('id');

            let html_data = '';
            html_data += '<div class="form-group text-left col-sm-6">';
            html_data += '<label>Product ' + totalCount + '</label><br>';
            html_data += '<select class="form-control product-select" name="pro_id[]" required>';
            html_data += '<option>Select Product</option>';
            <?php
            $order_id = $_GET['order_id'];
            $val = $obj->arr("SELECT * FROM orders WHERE order_id='$order_id'");
            $user_id = $val['user_id'];
            $user_type = $obj->arr("SELECT user_type FROM users WHERE user_id='$user_id'");

            $pro_data2 = $obj->fetch("SELECT id, name,price,cat_id FROM items");
            foreach ($pro_data2 as $val_pro2) {
                $pro_id = $val_pro2["id"];
                $price = checkPrice($obj, $user_id, $pro_id, $val_pro2['cat_id'], $user_type['user_type']);
                ?>
                html_data += '<option value="<?= $val_pro2["id"] ?>" data-price="<?= $price ?>"><?= $val_pro2["name"] ?></option>';
                <?php
            }
            ?>
            html_data += '</select>';
            html_data += '</div>';
            html_data += '<div class="form-group text-left col-sm-6">';
            html_data += '<div class="row"><div class="col-sm-6"><label>Qty</label>';
            html_data += '<input type="text" class="form-control quantity" onkeyup="updateTotalAmount2()" name="quantity[]"></div>';
            html_data += '<div class="col-sm-6"><label>Price</label><input type="text" class="form-control price" value="" readonly>';

            html_data += '</div></div></div>';
            $('#prodBody').append(html_data);
            $('#procount').val(totalCount);
        });
        $(document).on("change", ".product-select", function () {
            let selectedOption = $(this).find(":selected");
            let price = selectedOption.data("price");

            $(this).closest(".form-group").next().find(".price").val(price);
        });
    </script>
    <script type="text/javascript">
        $('#edit_order_form').on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "edit-order.php",
                type: "post",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.editSubmit').html('Processing...');
                },
                success: function (data) {
                    $('.editSubmit').html('Submit');

                    if (data == 200) {
                        $('.errorMsg').html('<p class="alert alert-success">Successfully Updated</p>');
                        setTimeout(location.reload.bind(location), 1500);
                    } else {
                        $('.errorMsg').html(data);
                    }

                }
            });
        });

    </script>

    <script>
        function updateTotalAmount2() {

            var totalAmount = 0;
            $(".quantity").each(function (index) {
                var quantity = parseInt($(this).val());

                console.log("Quantity:", quantity);

                var priceStr = $(this).closest(".form-group").find(".price").val();
                console.log("Price string:", priceStr);

                var price = parseFloat(priceStr);
                console.log("Parsed price:", price);

                if (!isNaN(quantity) && !isNaN(price)) {
                    totalAmount += quantity * price;
                }
            });

            $("#totalAmount").text(totalAmount.toFixed(2));
        }

        $(document).ready(function () {
            function updateTotalAmount() {

                var totalAmount = 0;
                $(".form-header .quantity").each(function (index) {
                    var quantity = parseInt($(this).val());
                    console.log("Quantity:", quantity);

                    var priceStr = $(this).closest(".form-group").find(".price").val();
                    console.log("Price string:", priceStr);

                    var price = parseFloat(priceStr);
                    console.log("Parsed price:", price);

                    if (!isNaN(quantity) && !isNaN(price)) {
                        totalAmount += quantity * price;
                    }
                });

                $("#totalAmount").text(totalAmount.toFixed(2));
            }

            $(".quantity").on("keyup", function () {
                updateTotalAmount();
            });
            updateTotalAmount();
        });
    </script>




</body>

</html>