 <?php
 session_start();
 if (empty($_SESSION['username'])) {
     echo '<script>window.location.href="login.php"</script>';
 }
 $assetImgUrl = "https://mehndipvc.shop/api/assets/";
 ?>
 <?php
 include("config.php"); ?>
<!DOCTYPE html>
<html>
<?php //header link
include("header_link.php"); ?>
<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <body>
<style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top:10px !important;
    }
    .select2-container--default .select2-selection--single {
        display: flex;
        height: 43px;
        align-items: center;
    }
</style>
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
                    <?php

                    $old = $val['image']; ?>
                    <!-- /Page Header -->
                    <script src="js/jquery-3.2.1.min.js"></script>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="card-body">
                               <form id="edit_doctor" enctype="multipart/form-data">
                               <div class="form-group">
                                     <label>User <span class="text-danger">*</span></label>
                                     <select class="form-control" name="user_id" id="user-select">
                                         <option value="">--Select- -</option>
                                         <?php
                                         $cat_fetch = $obj->fetch("SELECT * FROM users");
                                         foreach ($cat_fetch as $cval) {
                                             ?>
                                                                     <option value="<?= $cval['user_id'] ?>"><?= $cval['name'] ?> [<?= $cval['user_type'] ?>]</option>
                                         <?php } ?>
                                     </select>
                                 </div>
                                 
                                
                                <div class="add_product row">
                                    <div class="form-group col-sm-6">
                                        <label>Product</label>
                                        <select class="form-control" id="product-select1" name="item[]">
                                            <?php
                                            $fetch = $obj->fetch("SELECT * FROM `items`");
                                            foreach ($fetch as $val) {
                                                ?>
                                                                    <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Qty</label>
                                        <input type="number" min="1" class="form-control" name="qty[]">
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <label style="visibility:hidden;">Qty</label>
                                        <span  class="btn btn-primary" id="add_input">+</span>
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
                                <div class="submit-section">
                                    
                                    <input type="hidden" class="total_product" name="total_product" value="1">
                                    <button name="submit" id="edit_banner_btn" class="btn btn-primary edit_banner_btn" >Submit</button>
                                </div>
                                <div class="preview1" style="text-align: center;"></div>
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
    $(document).ready(function (e) {
        // Submit form data via Ajax
        $("#edit_doctor").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "add-order-submit.php",
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
                            $('.preview1').html(data);
                        }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(".file").on("change", function (e) {
        e.preventDefault();
        var src = URL.createObjectURL(event.target.files[0]);
        //alert(src);
        $(".img").prop("src", src);
    });
</script>

 <script>
  $(document).ready(function(){
      var count = $('.total_product').val();
      $("#add_input").on("click", function(){
          count++;
          $('.total_product').val(count);

          var html_code = '';
          html_code += '<div class="form-group col-sm-6 ro_input' + count + '">';
          html_code += '<label>Product</label>';
          html_code += '<select class="form-control product-select" id="product-select' + count + '" name="item[]">';
          <?php foreach ($fetch as $val) { ?>
                                  html_code += '<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>';
          <?php } ?>
          html_code += '</select>';
          html_code += '</div>';
          html_code += '<div class="form-group col-sm-6 ro_input' + count + '">';
          html_code += '<label>Qty</label>';
          html_code += '<div style="width:100%;display:flex;gap:10px;">';
          html_code += '<input type="number" class="form-control" min="1" name="qty[]" style="width:90%;">';
          html_code += '<span class="btn btn-danger remove_row" style="width:10%;" id="' + count + '"><i class="fa fa-remove" style="padding-top:8px;"></i></span>';
          html_code += '</div>';
          html_code += '</div>';

          $('.add_product').append(html_code);

          // Initialize Select2 after the element is appended
          $("#product-select" + count).select2();
      });

      $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          $('.ro_input' + row_id).remove();
          count--;
          $('.total_product').val(count);
      });
  });
</script>


  <script>
    $('#menu').on("change",function(){
        var menu = $('#menu').val();
        $.ajax({
            url: "fetch-submenu.php",
            type: "POST",
            data: {menu:menu},
            success: function(data)
            {
                $('#submenu').html(data);
            }
        })
    })
</script>
<script>
$(".cat option").each(function() {
  $(this).siblings('[value="'+ this.value +'"]').remove();
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
        
        // $("#user-select").on('change',function(){
        //     var id = $(this).val();
        //     $.ajax({
        //         url: "fetch-parents.php",
        //         type: "POST",
        //         data: {id},
        //         success: function(data)
        //         {
        //             let res = JSON.parse(data);
        //             if(res.status==200){
        //                 var row = $('<div class="row border p-2 mt-2 mb-2"></div>');
        //                 const rows = res.data.map(function(user) {
                        
                
        //                 // Create User A input
        //                 var userA = $('<div class="form-group col-sm-6"></div>').html(`
        //                     <label>${user.name} (${user.user_type})</label>
        //                     <input type="text" class="form-control" name="par-com[]" placeholder="Enter Commission Amount">
        //                     <input type="hidden" class="form-control" name="parent_ids[]" value="${user.user_id}">
        //                 `);
                        
        //                 row.append(userA);
                
        //                 return row;
        //             });
                
        //             // Append all rows to the container
        //             $('#user-inputs').html(rows);
        //             }else{
        //                 $('#user-inputs').html('<h4>No Parent Found</h4>');
        //             }
        //         }
        //     })
        // })
        
    </script>
  