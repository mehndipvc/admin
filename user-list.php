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
    include("header.php");
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
                            <h3 class="page-title">User List</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">User List</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                
                <!-- Edit Modal -->
                <div class="modal custom-modal fade" id="add_user" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-body">
                                        <form id="add-user">
                                            <div class="form-group">
                                                <label>User Type</label><br>
                                                <select class="form-control" name="user_type" id="user_type_add" required>
                                                    <option value="">---Select Type---</option>
                                                    <option value="Agent">Agent</option>
                                                    <option value="CNF">CNF</option>
                                                    <option value="Distributor">Distributor</option>
                                                    <option value="Dealer">Dealer</option>
                                                    <option value="Customer">Customer</option>
                                                </select>
                                            </div>
                                        
                                            <div class="form-group">
                                                <label>Parent user</label>
                                                <select class="form-control" id="parent-user" name="parent" required>
                                                    <option value="">---Select Parent---</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input type="text" class="form-control" id="username" name="username" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email ID</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="text" class="form-control" id="pass" name="password" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="Active">Active</option>
                                                    <option value="Block">Block</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary continue-btn" id="submit-btn">Submit</button>
                                            </div>
                                            <div class="form-group errorMsg">
                                                
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / End Edit Modal -->
                
                
                <div class="row">
                    <div class="col-sm-12 text-right mb-3">
                        <a href="export-user.php" download class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
                        <a href="tree-view" class="btn btn-primary"><i class="fa fa-users"></i> Tree View</a>
                        <a href="#" data-toggle="modal" data-target="#add_user" class="btn btn-primary"><i class="fa fa-plus"></i> Add User</a>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0" id="menu-load">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Password</th>
                                        <th>User Type</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Parent</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = '0';
                                    $selct = $obj->fetch("SELECT * FROM users ORDER BY id DESC");
                                    foreach ($selct as $val) {
                                        $par_id=$val['parent_id'];
                                        $selct_par = $obj->arr("SELECT name FROM users WHERE id='$par_id'");
                                        $cnt++;
                                    ?>
                                        <tr class="holiday-upcoming">
                                            <td><?= $cnt; ?></td>
                                            <td><?= $val['user_id'] ?></td>
                                            <td><?= $val['password'] ?></td>
                                            <td><?= $val['user_type'] ?></td>
                                            <td><?= $val['name']; ?></td>
                                            <td><?= $val['email'] ?></td>
                                            <td><?= $val['mobile'] ?></td>
                                            <td><?=$selct_par['name']?></td>
                                            <td><?= $val['status'] ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_modal<?php echo $cnt; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
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
                                                            <h3>Delete User</h3>
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
                                                        <div class="form-body">
                                                                <div class="form-group">
                                                                    <label>Parent user</label><br>
                                                                    <select class="form-control select-search" id="parent<?php echo $val['id']; ?>" style="width:100%;">
                                                                        <option value="">-select-</option>
                                                                        <?php
                                                                        if($val['user_type']=='Agent')
                                                                        {
                                                                            $fetch_user=$obj->fetch("SELECT * FROM users WHERE user_type='Admin' ORDER BY name ASC");
                                                                        }
                                                                        elseif($val['user_type']=='CNF')
                                                                        {
                                                                            $fetch_user=$obj->fetch("SELECT * FROM users WHERE user_type='Agent' ORDER BY name ASC");
                                                                        }
                                                                        elseif($val['user_type']=='Distributor')
                                                                        {
                                                                            $fetch_user=$obj->fetch("SELECT * FROM users WHERE user_type='Agent' || user_type='CNF' ORDER BY name ASC");
                                                                        }
                                                                        elseif($val['user_type']=='Dealer')
                                                                        {
                                                                            $fetch_user=$obj->fetch("SELECT * FROM users WHERE user_type='Agent' || user_type='Distributor' || user_type='CNF' ORDER BY name ASC");
                                                                        }
                                                                        elseif($val['user_type']=='Customer')
                                                                        {
                                                                            $fetch_user=$obj->fetch("SELECT * FROM users WHERE user_type='Agent' || user_type='Distributor' || user_type='Dealer' || user_type='CNF' ORDER BY name ASC");
                                                                        }
                                                                         
                                                                            foreach($fetch_user as $us_val){
                                                                                ?>
                                                                                <option value="<?= $us_val['id'] ?>" <?= ($us_val['id']==$val['parent_id'])?'selected':''?>><?= $us_val['name'] ?> [<?php echo $us_val['user_type'] ?>]</option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>User Name</label>
                                                                    <input type="text" class="form-control" id="username<?php echo $val['id']; ?>" value="<?= $val['name'] ?>">
                                                                    <input type="hidden" id="user_id<?php echo $val['id']; ?>" value="<?= $val['user_id'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Mobile Number</label>
                                                                    <input type="text" class="form-control" id="mobile<?php echo $val['id']; ?>" value="<?= $val['mobile'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email ID</label>
                                                                    <input type="email" class="form-control" id="email<?php echo $val['id']; ?>" value="<?= $val['email'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>User Type</label><br>
                                                                    <select class="form-control" name="user_type" id="user_type<?=$val['id']?>">
                                                                        <option value="Agent" <?= ($val['user_type'])=='Agent'?'selected':'' ?>>Agent</option>
                                                                        <option value="CNF" <?= ($val['user_type'])=='CNF'?'selected':'' ?>>CNF</option>
                                                                        <option value="Distributor" <?= ($val['user_type'])=='Distributor'?'selected':'' ?>>Distributor</option>
                                                                        <option value="Dealer" <?= ($val['user_type'])=='Dealer'?'selected':'' ?>>Dealer</option>
                                                                        <option value="Customer" <?= ($val['user_type'])=='Customer'?'selected':'' ?>>Customer</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>New Password</label>
                                                                    <input type="text" class="form-control" id="pass<?php echo $val['id']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select class="form-control" id="staTus<?php echo $val['id']; ?>">
                                                                        <option value="Active">Active</option>
                                                                        <option value="Block">Block</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-primary continue-btn editSubmit" id="<?php echo $val['id']; ?>">Submit</button>
                                                                </div>
                                                                <div class="form-group errorMsg<?php echo $val['id']; ?>">
                                                                    
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Edit Modal -->
                                        
                                        
                                        
                                        
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
                                                        url: "delete_user.php",
                                                        method: "POST",
                                                        data: {
                                                            dlt_btn: dlt_btn
                                                        },
                                                        success: function(data) {
                                                            //var result=JSON.parse(data);
                                                            //alert(data);
                                                            $("#preview<?php echo $cnt; ?>").html(data);
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
        </div>
    </div>
    <?php
    //footer link
    include("footer_link.php");

    //footer
    include("footer.php");

    ?>
    <script>
    $('.select-search').select2({
        
    });
    
    
    $('#add-user').on("submit", function(e){
       e.preventDefault();
       //alert('ok')
       $.ajax({
           url:"add-user.php",
           type:"POST",
           data:new FormData(this),
           cache:false,
           contentType:false,
           processData: false,
           beforeSend:function(){
               $('#submit-btn').html('Processing...');
           },
           success: function(data)
           {
               $('#submit-btn').html('Submit');
               if(data==200){
                   $('.errorMsg').html('<p class="alert alert-info">User Successfully Added</p>');
                    setTimeout(location.reload.bind(location), 1500);
               }else{
                   $('.errorMsg').html(data);
               }
           }
       });
    });
    
    $('#user_type_add').on("change", function(){
        
       let type=$(this).val();

       $.ajax({
           url:"fetch-type-user.php",
           type:"post",
           data:{user_type:type},
           success: function(data)
           {
            //   $('.errorMsg'+id).html(data);
            //   setTimeout(location.reload.bind(location), 1500);
            console.log(data);
            $('#parent-user').html(data);
           }
       });
    });
    
    
            $('.editSubmit').on("click", function(){
               let id = $(this).attr("id");
               let status = $('#staTus'+id).val();
               let username = $('#username'+id).val();
               let pass = $('#pass'+id).val();
               let parent=$('#parent'+id).val();
               let user_type=$('#user_type'+id).val();
               let mobile=$('#mobile'+id).val();
               let email=$('#email'+id).val();
               let user_id=$('#user_id'+id).val();
               
               $.ajax({
                   url:"user-update.php",
                   type:"post",
                   data:{id:id,status:status,username:username,pass:pass,parent:parent,user_type:user_type,mobile:mobile,email:email,user_id:user_id},
                   beforeSend:function()
                   {
                       $(this).html('Processing...');
                   },
                   success: function(data)
                   {
                       $(this).html('Submit');
                       $('.errorMsg'+id).html(data);
                       
                       //console.log(data);
                       
                       setTimeout(location.reload.bind(location), 1500);
                   }
               });
            });
    </script>
    <script>
    $(document).ready(function(){
          var table = $('#menu-load').DataTable({
            "searching": true
        });
     });
    </script>
</body>

</html>
