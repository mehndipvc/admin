<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
?>
<!DOCTYPE html>
<html>

<?php //header link
include("header_link.php"); ?>

<style>
    .order-list {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        min-width: 160px;
        background-color: #f9f9f9;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 3px 0;
        border-bottom: 1px dashed #ccc;
        font-family: Arial, sans-serif;
        width:160px;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-name {
        font-weight: bold;
        color: #333;
    }

    .item-quantity {
        background-color: #4CAF50;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
    }
</style>


<body>
    <?php
    //database file link
    include("config.php");
    ?>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Order History</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Order History</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="add-custom-order.php" class="btn add-btn"><i class="fa fa-plus"></i> Manual</a>
                             <a href="add-order.php" class="btn add-btn ml-1"><i class="fa fa-plus"></i> Automatic</a>
                         </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0" id="order-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width:200px">Date</th>
                                        <th>Order ID</th>
                                        <th>User Name</th>
                                        <th>Product Details</th>
                       
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Invoice</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    $selct = $obj->fetch("SELECT * FROM orders ORDER BY id DESC");
                                    foreach ($selct as $val) {
                                        $cnt++;
                                        $pro_id = $val['product_id'];
                                        $order_id = $val['order_id'];
                                        
                                        $order_data = $obj->arr("SELECT SUM(total_price) AS total_sum FROM order_item WHERE order_id='$order_id'");
                                        $order_data_item = $obj->fetch("SELECT name,quantity FROM order_item WHERE order_id='$order_id'");
                                        
                                        $user_name = $val['user_id'];
                                        $pro_data = $obj->arr("SELECT * FROM items WHERE id='$pro_id'");
                                        $user_data = $obj->arr("SELECT * FROM users WHERE user_id='$user_name'");
                                    ?>
                                        <tr class="holiday-upcoming">
                                            <td><?php echo $cnt; ?></td>
                                            <td><?=$val['date'] ?> [<?=$val['time'] ?>]</td>
                                            <td><?php echo $val['order_id'] ?></td>
                                            <td><?php echo $user_data['name'] ?> <br>
                                            <span style="color:red;"><?= $user_data['mobile'] ?></span>
                                            </td>

                                            <td>
                                                <div class="order-list">
                                                    <?php 
                                                    $cnt1=0;
                                                    foreach ($order_data_item as $items){
                                                        $cnt1++;
                                                    ?>
                                                        <div class="order-item">
                                                            <span class="item-name"><?=$cnt1 ?>)</span>
                                                            <span class="item-name"><?php echo $items['name']; ?></span>
                                                            <span class="item-quantity"><?php echo $items['quantity']; ?></span>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                           
                                            <td> <span style="font-family:cambria">&#8377;</span> <?= number_format($val['price'], 2); ?>
                                            <br>
                                            <span style="color:red;"><?= $val['type'] ?></span>
                                            </td>
                                            <td><?php echo $val['status'] ?></td>
                                            <td>
                                                <?php
                                                if (!empty($val['invoice_path'])) {
                                                ?>
                                                    <a href="<?= $val['invoice_path'] ?>" download>Download</a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php
                                                        if($val['type']=='Custom'){
                                                        ?>
                                                        <a class="dropdown-item" href="edit-custom-order?order_id=<?= $val['order_id']?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <?php }else{ ?>
                                                        <a class="dropdown-item" href="edit-order-form?order_id=<?= $val['order_id']?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <?php } ?>
                                                        
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_holiday<?php echo $cnt; ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Delete Menu Modal -->
                                        <div class="modal custom-modal fade" id="delete_holiday<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Delete Order</h3>
                                                            <p>Are you sure want to delete?</p>
                                                        </div>
                                                        <div class="modal-btn delete-action">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button class="btn btn-primary continue-btn" value="<?php echo $val['order_id']; ?>" id="dlt_btn<?php echo $val['order_id']; ?>" style="width: 100%;">Delete</button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12" align="center" style="padding-top: 15px;"><span id="preview<?php echo $cnt; ?>"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Delete Menu Modal -->

                                        <!-- Edit Modal -->
                                        <div class="modal custom-modal fade" id="edit_modal<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form id="edit_order_form<?php echo $cnt; ?>">
                                                            <div class="form-header">
                                                                <div class="row">
                                                                    <?php
                                                                    $sel_order = explode(",", $val['product_id']);
                                                                    $pro_qry = explode(',', $val['order_quantity']);
                                                                    $pro_data = $obj->fetch("SELECT id, name FROM `items`");
                                                                    $pro_count = count($sel_order);

                                                                    for ($p = 0; $p < $pro_count; $p++) {
                                                                    ?>
                                                                        <div class="form-group text-left col-sm-6">
                                                                            <label>Product<span class="text-danger">*</span></label><br>
                                                                            <select class="form-control" name="pro_id[]" required>
                                                                                <?php
                                                                                foreach ($pro_data as $val_pro) {
                                                                                ?>
                                                                                    <option value="<?= $val_pro['id'] ?>" <?= ($sel_order[$p] == $val_pro['id']) ? 'selected' : '' ?>>
                                                                                        <?= $val_pro['name'] ?>
                                                                                    </option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group text-left w-50">
                                                                            <label>Qty</label>
                                                                            <input type="text" class="form-control" value="<?= $pro_qry[$p] ?>" name="quantity[]">
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="row" id="prodBody<?php echo $val['order_id'] ?>"></div>
                                                            </div>

                                                            <div class="form-group text-left">
                                                                <div class="mb-3">
                                                                    <label for="example-textarea" class="form-label">Remarks</label>
                                                                    <textarea class="form-control" name="remarks" id="example-textarea"><?= $val['remarks'] ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group text-left">
                                                                <label for="example-textarea" class="form-label">Status</label>
                                                                <select class="form-control" name="confirmation" id="staTus<?php echo $val['order_id']; ?>">
                                                                    <option value="Pending Confirmation" <?= ($val['status'] == 'Pending Confirmation') ? 'selected' : '' ?>>Pending Confirmation</option>
                                                                    <option value="Cancelled" <?= ($val['status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                                                    <option value="Confirmed" <?= ($val['status'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group text-left">
                                                                <label>Upload Invoice</label>
                                                                <input type="file" class="form-control" name="invoice">
                                                            </div>

                                                            <div class="form-group">
                                                                <a href="javascript:void(0)" class="btn btn-primary mx-auto  addProduct" id="<?php echo $val['order_id'] ?>">Add Product</a>
                                                                <input type="hidden" name="order_id" value="<?php echo $val['order_id'] ?>" />
                                                                <input type="submit" class="btn btn-primary mx-auto continue-btn editSubmit" id="<?php echo $val['order_id']; ?>" value="Submit">
                                                            </div>
                                                            <div class="form-group errorMsg">

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Edit Modal -->

                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('#edit_order_form<?php echo $cnt; ?>').on("submit", function (e) {
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
                                                            $('.errorMsg').html(data);
                                                            //setTimeout(location.reload.bind(location), 1500);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                        <!-- Delete Script Modal -->
                                        <script>
                                            $("#dlt_btn<?php echo $val['order_id']; ?>").click("submit", function () {
                                                var dlt_btn = $(this).val();
                                                var flag = true;

                                                /********validate all our form fields***********/
                                                if (dlt_btn == "") {
                                                    $("#dlt_btn").css("border-color", "red");
                                                    $(".dlt_btn").html("Empty Field");
                                                    flag = false;
                                                }

                                                if (flag) {
                                                    $.ajax({
                                                        url: "del_order.php",
                                                        method: "POST",
                                                        data: {
                                                            dlt_btn: dlt_btn
                                                        },
                                                        beforeSend: function () {
                                                            $('#dlt_btn<?php echo $val['order_id']; ?>').html('Processing...');
                                                        },
                                                        success: function (data) {
                                                            $('#dlt_btn<?php echo $val['order_id']; ?>').html('Delete');
                                                            $("#preview<?php echo $cnt; ?>").html(data);
                                                            setTimeout(location.reload.bind(location), 1500);
                                                        },
                                                    });
                                                }
                                            });
                                        </script>
                                        <!-- End Delete Script Modal -->
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->

            <?php
            include("header.php");
            ?>

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
            let id = $(this).attr('id');
            let html_data = '';
            html_data += '<div class="form-group text-left col-sm-6">';
            html_data += '<label>Product</label><br>';
            html_data += '<select class="form-control" name="pro_id[]">';
            html_data += '<option>Select Product</option>';
            <?php
            $pro_data2 = $obj->fetch("SELECT id, name FROM items");
            foreach ($pro_data2 as $val_pro2) {
            ?>
                html_data += '<option value="<?= $val_pro2["id"] ?>"><?= $val_pro2["name"] ?></option>';
            <?php
            }
            ?>
            html_data += '</select>';
            html_data += '</div>';
            html_data += '<div class="form-group text-left w-50">';
            html_data += '<label>Qty</label>';
            html_data += '<input type="text" class="form-control" name="quantity[]">';
            html_data += '</div>';
            $('#prodBody' + id).append(html_data);
        });
        
        $(document).ready(function(){
          var table = $('#order-table').DataTable({
            "searching": true
        });
     });
    </script>

</body>

</html>
