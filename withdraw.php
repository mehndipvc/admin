<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
?>
<?php
    //database file link
    include("config.php");
    ?>
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
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Withdrawal History</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Withdrawal History</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    <div class="col-sm-12 mb-3 com-history">

                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0" id="commission-history">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    $selct = $obj->fetch("SELECT * FROM `withdraw` ORDER BY id DESC");

                                    foreach ($selct as $val) {
                                        $cnt++;
                                        $user_id = $val['user_id'];
                                        $User = $obj->arr("SELECT name,mobile FROM users WHERE user_id='$user_id'");
                                        ?>
                                        <tr class="holiday-upcoming">
                                            <td><?= $cnt ?></td>
                                            <td><?= $User['name'] ?></td>
                                            <td><?= $User['mobile'] ?></td>
                                            <td><?= $val['amount'] ?></td>
                                            <td>
                                                <?php
                                                if ($val['status'] == 'Approved') {
                                                    ?>
                                                    <span class="badge badge-success"><?= $val['status'] ?></span>
                                                <?php } else if ($val['status'] == 'Reject') { ?>
                                                        <span class="badge badge-danger"><?= $val['status'] ?></span>
                                                <?php } else { ?>
                                                        <span class="badge badge-warning"><?= $val['status'] ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-info" data-toggle="modal"
                                                    data-target="#edit<?php echo $cnt; ?>">Edit</button>
                                            </td>
                                        </tr>

                                        <!-- Edit banner Modal -->
                                        <div class="modal custom-modal fade" id="edit<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Withdraw</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label>Amount <span class="text-danger">*</span></label><br />
                                                            <input type="numner" value="<?php echo $val['amount']; ?>"
                                                                id="amount<?= $val['id'] ?>" class="form-control" readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Status <span class="text-danger">*</span></label><br />
                                                            <select class="form-control" id="status<?= $val['id'] ?>">
                                                                <option value="">Select status</option>
                                                                <option value="Approved"
                                                                    <?= ($val['status'] == 'Approved') ? 'selected' : ''; ?>>Approve
                                                                </option>
                                                                <option value="Reject"
                                                                    <?= ($val['status'] == 'Reject') ? 'selected' : ''; ?>>Reject
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="submit-section">
                                                            <input type="hidden" value="<?php echo $val['user_id']; ?>"
                                                                id="user_id<?= $val['id'] ?>">
                                                            <button class="btn btn-primary editSubmit"
                                                                id="<?= $val['id'] ?>">Submit</button>
                                                        </div>
                                                        <div class="erMsg<?= $val['id'] ?> mt-2" style="text-align: center;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Edit banner Modal -->


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

    //footer
    include("footer.php");

    ?>
    <script>


        $('.editSubmit').on("click", function () {
            let id = $(this).attr("id");
            let status = $('#status' + id).val();
            let user_id = $('#user_id' + id).val();
            let amount = $('#amount' + id).val();
            $.ajax({
                url: "approve-withdraw.php",
                type: "post",
                data: { id: id, status: status, user_id: user_id, amount: amount },
                beforeSend: function () {
                    $('.editSubmit').html('Processing...');
                },
                success: function (data) {
                    $('.editSubmit').html('Submit');
                    if (data == 200) {
                        $('.erMsg' + id).html('<p class="alert alert-success">Information Successfully Submitted</p>');
                        setTimeout(location.reload.bind(location), 1500);
                    } else {
                        $('.erMsg' + id).html(data);
                    }
                }
            });
        });


        $(document).ready(function () {
            var table = $('#commission-history').DataTable({
                "searching": true,
            });
        });
    </script>
</body>

</html>