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
                            <h3 class="page-title">Commission History</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Commission History</li>
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
                                        <th>User Type</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Commission amt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    $selct = $obj->fetch("SELECT * FROM users WHERE name!='Admin'");
                                    
                                    foreach ($selct as $val) {
                                        $cnt++;
                                        $id=$val['id'];
                                        $user_id=$val['user_id'];
                                    ?>
                                        <tr class="holiday-upcoming">
                                            <td><?=$cnt?></td>
                                            <td><?= $val['user_type'] ?></td>
                                            <td><?= $val['name'] ?></td>
                                            <td><?= $val['mobile'] ?></td>
                                            <td><?= $val['email'] ?></td>
                                            <td>
                                               <span style="font-family:calibri;">₹</span> <?= $val['wallet']!=''?$val['wallet']:0 ?>
                                            </td>
                                        </tr>
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
    function fetchCommissionDetails(id,userId){

        $.ajax({
            url: "https://mehndipvc.shop/api/fetch-indivisual-price.php",
            type: "post",
            data: { id: id, user_id: userId },
            beforeSend: function () {
                $(this).html('Processing...');
            },
            success: function (data) {
                var data = JSON.parse(data);
                var sum = 0;
                data.forEach(function(item) {
                    sum += item.earning_amount;
                });
                $(this).html('View Commission');
                $('.com-history').html(data);
                $('.show-commission'+id).html('<span style="font-family:cambria;font-size: 16px;font-weight: 600;">₹ ' + sum + '</span>');
                
                // setTimeout(location.reload.bind(location), 1500);
            }
        });
    }
    
            $('.editSubmit').on("click", function(){
               let id = $(this).attr("id");
               let status = $('#staTus'+id).val();
               $.ajax({
                   url:"edit-order.php",
                   type:"post",
                   data:{id:id,status:status},
                   beforeSend:function()
                   {
                       $(this).html('Processing...');
                   },
                   success: function(data)
                   {
                       $(this).html('Submit');
                       $('.errorMsg'+id).html(data);
                       setTimeout(location.reload.bind(location), 1500);
                   }
               });
            });
            
            
            $(document).ready(function(){
              var table = $('#commission-history').DataTable({
                "searching": true,
            });
         });
    </script>
</body>

</html>
