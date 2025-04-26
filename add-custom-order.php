 <?php
    session_start();
    if(empty($_SESSION['username']))
    {
        echo '<script>window.location.href="login.php"</script>';
    }
    $assetImgUrl = "https://mehndipvc.shop/api/assets/";
    ?>
<!DOCTYPE html>
<html>
<?php //header link
include("header_link.php"); ?>
<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <body>


<?php
include("config.php");
include("header.php");
?>
<style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top:10px !important;
    }
    .select2-container--default .select2-selection--single {
        display: flex;
        height: 43px;
        align-items: center;
    }
    .custom-field-parent{
        display:flex;
        gap:5px;
    }
    .custom-input{
        width:45% !important;
    }
</style>
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
                                <h3 class="page-title">Add Order</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Add order</li>
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
                                             <option value="">--Select- -</option>
                                             <?php
                                                $cat_fetch = $obj->fetch("SELECT * FROM users");
                                                foreach ($cat_fetch as $cval) {
                                                ?>
                                                 <option value="<?= $cval['user_id'] ?>"><?= $cval['name'] ?> [<?= $cval['user_type'] ?>]</option>
                                             <?php  } ?>
                                         </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                       <div class="form-group">
                                         <label>Total Amount <span class="text-danger">*</span></label>
                                         <input class="form-control" name="total_amount" id="total_amount" type="number" required>
                                        </div>
                                     </div>
                                     
                                </div>
                               
                                 
                                 <div id="user-inputs">
                                     
                                 </div>
                                
                                
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="example-textarea" class="form-label">Status</label>
                                        <select class="form-control" name="confirmation" id="staTus">
                                            <option value="Pending Confirmation">Pending Confirmation</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Confirmed">Confirmed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Upload Invoice (doc, docx, pdf, xls, xlsx)</label>
                                        <input type="file" class="form-control" name="invoice">
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button name="submit" id="edit_banner_btn" class="btn btn-primary edit_banner_btn" >Submit</button>
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

function calculate(inputElement,id){
    let val=parseFloat($('#total_amount').val());
    if(val){
        $('.preview1').html('')
        let percentage = $(inputElement).val();  
        let amt=val*percentage/100;
        $('#par-com'+id).val(amt);
    }else{
        $('.preview2').html('<p class="alert alert-warning">Please Enter Total Amount...!!</p>');
    }
}


    $(document).ready(function (e) {
        // Submit form data via Ajax
        $("#edit_doctor").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "add-custom-order-submit.php",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#edit_banner_btn').html("Processing...");
                },
                success: function (data) {
                    $('#edit_banner_btn').html("Submit");
                    if(data=='ok')
                        {
                            //console.log(data);
                            $('.preview1').html('<p class="alert alert-success">Successfully Saved</p>');
                           setTimeout(location.reload.bind(location), 1500);
                        }
                        else
                        {
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
        
        $("#user-select").on('change',function(){
            var id = $(this).val();
            $.ajax({
                url: "fetch-parents.php",
                type: "POST",
                data: {id},
                success: function(data)
                {
                    let res = JSON.parse(data);
                    if (res.status == 200) {
                        $('#user-inputs').html(""); // Clear previous content
                        var row = $('<div class="row border p-2 mt-2 mb-2"></div>');
                        res.data.forEach(function(user) {
                            // Create row
                            
                    
                            // Create User A input
                            var userA = $(`
                                <div class="form-group col-sm-6">
                                    <label>${user.name} (${user.user_type})</label>
                                    <div class="custom-field-parent">
                                        <input type="text" class="form-control custom-input" oninput="calculate(this,${user.user_id})" name="percentage[]" placeholder="Enter Percentage">
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
  