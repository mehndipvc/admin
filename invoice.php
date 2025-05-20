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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                            <h3 class="page-title">Billing List</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Billing List</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="create-invoice" class="btn add-btn"><i class="fa fa-plus"></i> Create Bill</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="billing-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="info">
                                        <th>Sl</th>
                                        <th>Invoice no.</th>
                                        <th>Billing Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Billing Add.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once("config.php");
                                    $cnt = 0;
                                    $sel_bill = $obj->fetch("SELECT * FROM billing ORDER BY id DESC");
                                    foreach ($sel_bill as $val_bill) {
                                        $cnt++;
                                        ?>
                                        <tr>
                                            <td><?= $cnt; ?></td>
                                            <td>#HFI<?= $val_bill['invo_no'] ?></td>
                                            <td><?= $val_bill['date'] ?></td>
                                            <td><?= $val_bill['name'] ?></td>
                                            <td><?= $val_bill['email'] ?></td>
                                            <td><?= $val_bill['mobile'] ?></td>
                                            <td><?= $val_bill['bill_adrs'] ?></td>
                                            <td>

                                                <a href="edit-bill?id=<?php echo base64_encode($val_bill['id']) ?>"
                                                    class="btn btn-add btn-sm"
                                                    style="background-color:#3fa242;color:white;margin-bottom:3px;"><i
                                                        class="fa fa-pencil"></i>
                                                </a>
                                                <a href="pdf/<?php echo $val_bill['invo_lbl'] ?>.pdf"
                                                    class="btn btn-primary btn-sm" target="_blank"><i
                                                        class="fa fa-file-text-o"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#del_bill<?php echo $cnt ?>"><i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal3 -->
                                        <!-- Delete-->
                                        <div class="modal fade" id="del_bill<?php echo $cnt ?>" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header modal-header-primary">
                                                        <h3><i class="fa fa-list-ul m-r-5"></i> Delete Billing </h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true">×</button>

                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <div class="col-md-12 form-group user-form-group">
                                                                        <label class="control-label">Are you sure, you want
                                                                            to delete the details of billing?</label>
                                                                    </div><br>
                                                                    <div class="col-md-12 del"></div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-add btn-sm modal_del_btn"
                                                            style="background-color:#3fa242;color:white;"
                                                            id="<?php echo $val_bill['invo_no'] ?>">YES</button>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-dismiss="modal">NO</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->






                                    <?php } ?>
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    //footer link
    include("footer_link.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $('.summernote').summernote();
    </script>

    <script>
        $('.modal_del_btn').on("click", function () {
            let invo_no = $(this).attr('id');
            $.ajax({
                url: "del-billing.php",
                type: "post",
                data: { invo_no: invo_no },
                beforeSend: function () {
                    $(this).html('Processing');
                },
                success: function (data) {
                    $(this).html('YES');
                    $('.del').html(data);
                    $(".alert").delay(1500).fadeOut();
                    setTimeout(location.reload.bind(location), 1500);
                }
            })
        });
        $(document).ready(function () {
            var table = $('#billing-table').DataTable({
                "searching": true
            });
        });
    </script>
</body>

</html>