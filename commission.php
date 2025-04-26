<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
?>
<!DOCTYPE html>
<html>
<?php //header link
include("header_link.php");  ?>

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
                            <h3 class="page-title">Commission Plan</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Commission Plan</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add Plan</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped datatable custom-table mb-0" id="menu-load">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Type</th>
                                        <th>Amount</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = '0';
                                    $selct = $obj->fetch("SELECT * FROM individual_price ORDER BY id DESC");
                                    foreach ($selct as $val) {
                                        $cnt++;
                                        $pro_id = $val['product_id'];
                                        $pro_data = $obj->arr("SELECT * FROM products WHERE id='$pro_id'");
                                    ?>
                                        <tr class="holiday-upcoming">
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $val['user_type'] ?></td>
                                            <td><?= $pro_data['name']; ?></td>
                                            <td><?php echo $val['price'] ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_holiday<?php echo $cnt; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_holiday<?php echo $cnt; ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Edit Menu Modal -->
                                        <div class="modal custom-modal fade" id="edit_holiday<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Individual Price</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="edit_category" id="<?= $val['id'] ?>">
                                                            <div class="form-group">
                                                                <label>User Type <span class="text-danger">*</span></label>
                                                                <select name="user_type" id="user_type" class="form-control">
                                                                    <option value="Agent" <?= ($val['user_type']=='Agent')?'selected':''; ?>>Agent</option>
                                                                    <option value="Distributer" <?= ($val['user_type']=='Distributer')?'selected':''; ?>>Distributer</option>
                                                                    <option value="Dealer" <?= ($val['user_type']=='Dealer')?'selected':''; ?>>Dealer</option>
                                                                    <option value="Retailer" <?= ($val['user_type']=='Retailer')?'selected':''; ?>>Retailer</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Product <span class="text-danger">*</span></label>
                                                                <select name="product_id" class="form-control">
                                                                    <?php
                                                                    $pro_fet = $obj->fetch("SELECT * FROM products");
                                                                    foreach ($pro_fet as $pro_val) {
                                                                    ?>
                                                                        <option value="<?= $pro_val['id'] ?>" <?= ($val['product_id']==$pro_val['id'])?'selected':''; ?>><?= $pro_val['name'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Price <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" name="price" id="price" value="<?= $val['price'] ?>"/>
                                                            </div>

                                                            <div class="submit-section">
                                                                <input type="hidden" value="<?= $val['id'] ?>" name="id">
                                                                <button type="submit" name="submit" id="edit_menu_btn<?php echo $val['id']; ?>" class="btn btn-primary edit_menu_btn">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                            <div class="err_msg<?= $val['id'] ?> mt-3"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Edit Menu Modal -->
                                        <!-- Delete Menu Modal -->
                                        <div class="modal custom-modal fade" id="delete_holiday<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Delete Individual Price</h3>
                                                            <p>Are you sure want to delete?</p>
                                                        </div>
                                                        <div class="modal-btn delete-action">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button class="btn btn-primary continue-btn" value="<?php echo $val['id']; ?>" id="dlt_btn<?php echo $val['id']; ?>" style="width: 100%;">Delete</button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12" align="center" style="padding-top: 15px;"><span id="preview2"></span></div>
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
                                            $("#dlt_btn<?php echo $val['id']; ?>").click("submit", function() {
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
                                                        url: "delete_individual.php",
                                                        method: "POST",
                                                        data: {
                                                            dlt_btn: dlt_btn
                                                        },
                                                        success: function(data) {
                                                            //var result=JSON.parse(data);
                                                            //alert(data);
                                                            $("#preview2").html(data);
                                                            //alert("success");
                                                            //location.reload();
                                                            setTimeout(function() {
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
                            <h5 class="modal-title">Set Individual Price</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="add_category">
                                <div class="form-group">
                                    <label>User Type <span class="text-danger">*</span></label>
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value="Agent">Agent</option>
                                        <option value="Distributer">Distributer</option>
                                        <option value="Dealer">Dealer</option>
                                        <option value="Retailer">Retailer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="price" id="price" />
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
            <!-- /Add Menu Modal -->
            <?php  include("header.php"); ?>
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
    $('#add_category').on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: "add-individual.php",
            type: "post",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#submit').html('Processing...');
            },
            success: function(data) {
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
    $("#edit_file").on("change", function(e) {
        e.preventDefault();
        var src = URL.createObjectURL(event.target.files[0]);
        //alert(src);
        $(".image").prop("src", src);
    });
</script>
<script>
    $('.edit_category').on("submit", function(e) {
        e.preventDefault();
        const id = $('.edit_category').attr('id');
        $.ajax({
            url: "edit_individual.php",
            type: "post",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#edit_menu_btn' + id).html('Processing...');
            },
            success: function(data) {
                $('#edit_menu_btn' + id).html('Submit');
                if (data == 'ok') {
                    $('.err_msg' + id).html('<p class="alert alert-success">Successfully Saved</p>');
                    setTimeout(location.reload.bind(location), 1500);
                } else {
                    $('.err_msg' + id).html(data);
                }
            }
        });
    })
</script>