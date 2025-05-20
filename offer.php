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

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <?php
        //database file link
        include("config.php");
        include("header.php");
        ?>
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Offers</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Offers</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i
                                    class="fa fa-plus"></i> Set Offer</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0" id="offer-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Offer Type</th>
                                        <th>Offer</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = '0';
                                    $selct = $obj->fetch("SELECT * FROM discounts ORDER BY id DESC");
                                    foreach ($selct as $val) {
                                        $cnt++;
                                        $pro_id = $val['item_id'];
                                        $pro_data = $obj->arr("SELECT * FROM items WHERE id='$pro_id'");
                                        ?>
                                        <tr class="holiday-upcoming">
                                            <td><?php echo $cnt; ?></td>
                                            <td><?= $pro_data['name']; ?></td>
                                            <td><?php echo $val['discount_type'] ?></td>
                                            <td><?php echo $val['amount'] ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#edit_offer<?php echo $cnt; ?>"><i
                                                                class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_holiday<?php echo $cnt; ?>"><i
                                                                class="fa fa-trash-o m-r-5"></i> Delete</a>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Offer Modal -->
                                        <div class="modal custom-modal fade" id="edit_offer<?php echo $cnt; ?>"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Offer</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="edit_form<?php echo $cnt; ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <label>Product <span class="text-danger">*</span></label>
                                                                <select name="product_id" class="form-control"
                                                                    id="product_det">

                                                                    <?php
                                                                    $pro_fet = $obj->fetch("SELECT * FROM items");
                                                                    foreach ($pro_fet as $pro_val) {
                                                                        ?>
                                                                        <option value="<?= $pro_val['id'] ?>"
                                                                            <?= ($pro_val['id'] == $val['item_id']) ? 'selected' : ''; ?>>
                                                                            <?= $pro_val['name'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Offer Type </label>
                                                                <select name="offer_type" id="offer_type"
                                                                    class="form-control">
                                                                    <option value="Price"
                                                                        <?= ($val['discount_type'] == 'Price') ? 'selected' : ''; ?>>
                                                                        Price</option>
                                                                    <option value="Percentage"
                                                                        <?= ($val['discount_type'] == 'Percentage') ? 'selected' : ''; ?>>
                                                                        Percentage</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group price" id="pri_div">
                                                                <label>Offer </label>
                                                                <input class="form-control" type="text" name="offer"
                                                                    id="offer" value="<?= $val['amount'] ?>" />
                                                            </div>

                                                            <div class="submit-section">
                                                                <input class="form-control" type="hidden" name="id" id="id"
                                                                    value="<?= $val['id'] ?>" />
                                                                <button type="submit" name=""
                                                                    class="btn btn-primary submit-btn" id="edit_offer_btn">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                            <div class="edit-msg-offer mt-2"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Edit Offer Modal -->

                                        <!--Edit Offer Js-->
                                        <script>
                                            $('#edit_form<?php echo $cnt; ?>').on("submit", function (e) {
                                                e.preventDefault();
                                                const id = $('.edit_category').attr('id');
                                                $.ajax({
                                                    url: "edit_offer.php",
                                                    type: "post",
                                                    data: new FormData(this),
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    beforeSend: function () {
                                                        $('#edit_offer_btn').html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span> Loading...');
                                                    },
                                                    success: function (data) {
                                                        $('#edit_offer_btn').html('Submit');
                                                        $('.edit-msg-offer').html(data);
                                                        if (data == 'ok') {
                                                            $('.edit-msg-offer').html('<p class="alert alert-success">Successfully Saved</p>');
                                                            setTimeout(location.reload.bind(location), 1500);
                                                        } else {
                                                            $('.edit-msg-offer').html(data);
                                                        }
                                                    }
                                                });
                                            })
                                        </script>

                                        <!-- Delete Menu Modal -->
                                        <div class="modal custom-modal fade" id="delete_holiday<?php echo $cnt; ?>"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Delete Offer</h3>
                                                            <p>Are you sure want to delete?</p>
                                                        </div>
                                                        <div class="modal-btn delete-action">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button class="btn btn-primary continue-btn"
                                                                        value="<?php echo $val['id']; ?>"
                                                                        id="dlt_btn<?php echo $val['id']; ?>"
                                                                        style="width: 100%;">Delete</button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="javascript:void(0);" data-dismiss="modal"
                                                                        class="btn btn-primary cancel-btn">Cancel</a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12" align="center"
                                                                    style="padding-top: 15px;"><span
                                                                        id="preview<?php echo $val['id']; ?>"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Delete Menu Modal -->
                                        <!-- Edit script Modal -->

                                        <!-- Delete Script Modal -->
                                        <script>
                                            $("#dlt_btn<?php echo $val['id']; ?>").click("submit", function () {
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
                                                        url: "delete-offer.php",
                                                        method: "POST",
                                                        data: {
                                                            dlt_btn: dlt_btn
                                                        },
                                                        success: function (data) {
                                                            //var result=JSON.parse(data);
                                                            //alert(data);
                                                            $("#preview<?php echo $val['id']; ?>").html(data);
                                                            //alert("success");
                                                            //location.reload();
                                                            setTimeout(function () {
                                                                setTimeout(location.reload.bind(location), 1500);
                                                            }, 1000);
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

            <!-- Add Menu Modal -->
            <div class="modal custom-modal fade" id="add_holiday" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Set Offer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="add_category">
                                <div class="form-group">
                                    <label>Product <span class="text-danger">*</span></label>
                                    <select name="product_id" class="form-control" id="product_det">
                                        <option value="">Select Product</option>
                                        <?php
                                        $pro_fet = $obj->fetch("SELECT * FROM items");
                                        foreach ($pro_fet as $pro_val) {
                                            ?>
                                            <option value="<?= $pro_val['id'] ?>"><?= $pro_val['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Offer Type </label>
                                    <select name="offer_type" id="offer_type" class="form-control">
                                        <option value="Price">Price</option>
                                        <option value="Percentage">Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group price" id="pri_div">
                                    <label>Offer </label>
                                    <input class="form-control" type="text" name="offer" id="offer" />
                                </div>

                                <div class="submit-section">
                                    <button type="submit" name="" class="btn btn-primary submit-btn" id="submit">
                                        Submit
                                    </button>
                                </div>
                                <div class="preview mt-3"></div>
                            </form>
                        </div>
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
</body>

</html>
<script>
    $('#add_category').on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "add-offer.php",
            type: "post",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#submit').html('Processing...');
            },
            success: function (data) {
                $('#submit').html('Submit');
                if (data == 'ok') {
                    $('.preview').html('<p class="alert alert-success">Successfully Saved</p>');
                    setTimeout(location.reload.bind(location), 1500);
                } else {
                    $('.preview').html(data);
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $("#edit_file").on("change", function (e) {
        e.preventDefault();
        var src = URL.createObjectURL(event.target.files[0]);
        //alert(src);
        $(".image").prop("src", src);
    });
</script>

<script>
    $('#user_type').on("change", function () {
        let user_type = $('#user_type').val();
        $.ajax({
            url: "fetch-user.php",
            type: "post",
            data: { user_type: user_type },
            success: function (data) {
                $('#user_id').html(data);
            }
        })
    })
</script>
<script>
    $('#commission').on("change", function () {
        let commission = $('#commission').val();
        if (commission == 'Manual') {
            $('#pri_div').show();
            $('#per_div').hide();
        }
        else if (commission == 'Percentage') {
            $('#pri_div').hide();
            $('#per_div').show();
        }
    });
</script>
<script>
    $('#search').on("keyup", function () {
        let search = $('#search').val();
        $("#menu-load tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1)
        });
    })
</script>
<script>
    $('#catgor').on("change", function () {
        var category = $(this).val();
        $.ajax({
            url: "fetch-product.php",
            type: "post",
            data: { category: category },
            success: function (data) {
                $('#product_det').html(data);
            }
        })
    });
    $(document).ready(function () {
        var table = $('#offer-table').DataTable({
            "searching": true
        });
    });
</script>