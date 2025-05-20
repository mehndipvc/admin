<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login.php"</script>';
}
$assetImgUrl = "https://mehndipvc.shop/api/assets/";
?>
<?php include("config.php"); ?>
<!DOCTYPE html>
<html>
<?php //header link
include("header_link.php"); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<body>
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px !important;
        }

        .select2-container--default .select2-selection--single {
            display: flex;
            height: 43px;
            align-items: center;
        }

        .custom-field-parent {
            display: flex;
            gap: 5px;
        }

        .custom-input {
            width: 45% !important;
        }
    </style>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <?php
        include("header.php");
        include('addl_functions.php');

        $order_id = $_GET['order_id'];
        $val_order = $obj->arr("SELECT * FROM orders WHERE order_id='$order_id'");

        $par_id = $val_order['user_id'];
        $sel_parents = getAscendants($par_id, $obj);
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
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit order</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="order" class="btn add-btn"><i class="fa fa-plus"></i> View Order</a>
                        </div>
                    </div>
                </div>

                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <form id="edit_doctor" enctype="multipart/form-data">
                                <div class="preview2 mt-1" style="text-align: center;"></div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User <span class="text-danger">*</span></label>
                                            <select class="form-control" name="user_id" id="user-select" required><br>
                                                <option value="">--Select--</option>
                                                <?php
                                                $cat_fetch = $obj->fetch("SELECT * FROM users");
                                                foreach ($cat_fetch as $cval) {
                                                    ?>
                                                    <option value="<?= $cval['user_id'] ?>"
                                                        <?= $val_order['user_id'] == $cval['user_id'] ? 'selected' : '' ?>>
                                                        <?= $cval['name'] ?> [<?= $cval['user_type'] ?>]
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Amount <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?= $val_order['price'] ?>"
                                                name="total_amount" id="total_amount" type="number" required>
                                        </div>
                                    </div>

                                </div>


                                <div id="user-inputs">
                                    <div class="row border p-2 mt-2 mb-2">
                                        <?php
                                        foreach ($sel_parents as $parent_val) {
                                            if ($parent_val['user_id'] != $val_order['user_id']) {
                                                $com_user_id = $parent_val['user_id'];
                                                $sel_commission = $obj->arr("SELECT amount FROM transaction WHERE user_id='$com_user_id' AND order_id='$order_id'");
                                                ?>
                                                <div class="form-group col-sm-6">
                                                    <label><?= $parent_val['name'] ?> (<?= $parent_val['user_type'] ?>)</label>
                                                    <div class="custom-field-parent">
                                                        <input type="number"
                                                            value="<?= ($sel_commission['amount'] / $val_order['price']) * 100 ?>"
                                                            class="form-control custom-input"
                                                            oninput="calculate(this,<?= $parent_val['user_id'] ?>)"
                                                            name="percentage[]" placeholder="Enter Percentage">
                                                        <input readonly type="number" value="<?= $sel_commission['amount'] ?>"
                                                            class="form-control custom-input"
                                                            id="par-com<?= $parent_val['user_id'] ?>" name="par-com[]"
                                                            placeholder="Commission Amount">
                                                    </div>
                                                    <input type="hidden" class="form-control" name="parent_ids[]"
                                                        value="<?= $parent_val['user_id'] ?>">
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="example-textarea" class="form-label">Status</label>
                                        <select class="form-control" name="confirmation" id="staTus">
                                            <option value="Pending Confirmation" <?= ($val_order['status'] == 'Pending Confirmation') ? 'selected' : '' ?>>Pending Confirmation</option>
                                            <option value="Cancelled" <?= ($val_order['status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                            <option value="Confirmed" <?= ($val_order['status'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Upload Invoice (doc, docx, pdf, xls, xlsx)</label><br>
                                        <a href="<?= $val_order['invoice_path'] ?>" download>Download</a>
                                        <input type="file" class="form-control" name="invoice">
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <input type="hidden" class="form-control" name="order_id" value="<?= $order_id ?>">
                                    <input type="hidden" class="form-control" name="old_invoice"
                                        value="<?= $val_order['invoice_path'] ?>">
                                    <input type="hidden" class="form-control" name="old_invoice_temp"
                                        value="<?= $val_order['temp_path'] ?>">
                                    <button name="submit" id="edit_banner_btn"
                                        class="btn btn-primary edit_banner_btn">Submit</button>
                                </div>
                                <div class="preview1 mt-1" style="text-align: center;"></div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Content -->
        </div>
    </div>
    <?php
    //footer link
    include("footer_link.php");
    //footer
    include("footer.php");

    ?>
</body>

</html>
<script type="text/javascript">

    function calculate(inputElement, id) {
        let val = parseInt($('#total_amount').val());
        if (val) {
            $('.preview1').html('')
            let percentage = $(inputElement).val();
            let amt = val * percentage / 100;
            $('#par-com' + id).val(amt);
        } else {
            $('.preview2').html('<p class="alert alert-warning">Please Enter Total Amount...!!</p>');
        }
    }


    $(document).ready(function (e) {
        // Submit form data via Ajax
        $("#edit_doctor").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "edit-custom-order-submit.php",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('#edit_banner_btn').html("Processing...");
                },
                success: function (data) {
                    $('#edit_banner_btn').html("Submit");
                    if (data == 'ok') {
                        //console.log(data);
                        $('.preview1').html('<p class="alert alert-success">Successfully Saved</p>');
                        setTimeout(location.reload.bind(location), 1500);
                    }
                    else {
                        $('.preview1').html(`'<p class="alert alert-warning">${data}</p>`);
                    }
                }
            });
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $('.summernote').summernote();

</script>
<script>
    $("#product-select1").select2();
    $("#user-select").select2();

    $("#user-select").on('change', function () {
        var id = $(this).val();
        $.ajax({
            url: "fetch-parents.php",
            type: "POST",
            data: { id },
            success: function (data) {
                let res = JSON.parse(data);
                if (res.status == 200) {
                    $('#user-inputs').html(""); // Clear previous content
                    var row = $('<div class="row border p-2 mt-2 mb-2"></div>');
                    res.data.forEach(function (user) {
                        // Create row


                        // Create User A input
                        var userA = $(`
                                <div class="form-group col-sm-6">
                                    <label>${user.name} (${user.user_type})</label>
                                    <div class="custom-field-parent">
                                        <input type="number" class="form-control custom-input" oninput="calculate(this,${user.user_id})" name="percentage[]" placeholder="Enter Percentage">
                                        <input readonly type="number" class="form-control custom-input" id="par-com${user.user_id}" name="par-com[]" placeholder="Commission Amount">
                                    </div>
                                    <input type="hidden" class="form-control" name="parent_ids[]" value="${user.user_id}">
                                </div>
                            `);

                        row.append(userA);
                    });
                    $('#user-inputs').append(row); // Append each row individually
                } else {
                    $('#user-inputs').html('<h4>No Parent Found</h4>');
                }
            }
        })
    })

</script>