 <?php
    session_start();
    if (empty($_SESSION['username'])) {
        echo '<script>window.location.href="login"</script>';
    }
            $assetImgUrl = "https://mehndipvc.shop/api/assets/";
    ?>
 <!DOCTYPE html>
 <html>
 <?php //header link
    include("header_link.php"); ?>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
 <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                             <h3 class="page-title">Products</h3>
                             <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                 <li class="breadcrumb-item active">Products</li>
                             </ul>
                         </div>
                         <div class="col-auto float-right ml-auto">
                             
                             <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add Product</a>
                             <a href="export-product.php" download class="btn add-btn"><i class="fa fa-download"></i> Export</a>
                         </div>
                     </div>
                 </div>
                 <!-- /Page Header -->
                 <script src="js/jquery-3.2.1.min.js"></script>
                 <div class="row">
                     
                     <div class="col-md-12">
                         <div class="table-responsive">
                             <table class="product-table table table-striped custom-table mb-0" id="doctor">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Item Code</th>
                                         <th>Category</th>
                                         <th>Name</th>
                                         <th>price</th>
                                         <th>Qty</th>
                                         <th>Status</th>
                                         <th>Features</th>
                             
                                         <th class="text-right">Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $cnt = '0';
                                        $cnt1 = 0;
                                        $selct = $obj->fetch("SELECT * FROM `items`");
                                        foreach ($selct as $val) {
                                            $cat_id=$val['cat_id'];
                                            $cat_data=$obj->arr("SELECT * FROM category WHERE id='$cat_id'");
                                            $cnt++;
                                            $cnt1++;
                                           //print_r($un=json_decode($val['image_url']));
                                           $un=json_decode($val['image_url']);
                                           $un=array_reverse(isset($un)?$un:[]);
                                           ?>
                                           
                                         <tr class="holiday-upcoming">
                                             <td><?php echo $cnt; ?></td>
                                             <td><?php echo $val['code'] ?></td>
                                             <td><?php echo $cat_data['name'] ?></td>
                                             <td><?php echo $val['name'] ?></td>
                                             <td><?php echo $val['price'] ?></td>
                                             <td><?php echo $val['quantity'] ?></td>
                                             <td><?php echo $val['status'] ?></td>
                                             <td>
                                                 <i class="fa fa-eye" data-toggle="modal" data-target="#exampleModalLong<?php echo $cnt; ?>" style="cursor:pointer;font-size:24px;"></i>

                                                 <!-- Modal -->
                                                 <div class="modal fade" id="exampleModalLong<?php echo $cnt; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                     <div class="modal-dialog" role="document">
                                                         <div class="modal-content">
                                                             <div class="modal-header">
                                                                 <?php echo $val['name'] ?> Features
                                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                     <span aria-hidden="true">&times;</span>
                                                                 </button>
                                                             </div>
                                                             <div class="modal-body">
                                                                 <?php echo base64_decode($val['features']); ?>
                                                             </div>
                                                             <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </td>                                                
                                           
                                             <td class="text-right">
                                                 <div class="dropdown dropdown-action">
                                                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                     <div class="dropdown-menu dropdown-menu-right">
                                                         <a class="dropdown-item" href="edit-product-form?id=<?php echo base64_encode($val['id']); ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                         <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_holiday<?php echo $cnt; ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                     </div>
                                                 </div>
                                             </td>
                                         </tr>
                                         
                                         <!-- Delete banner Modal -->
                                         <div class="modal custom-modal fade" id="delete_holiday<?php echo $cnt; ?>" role="dialog">
                                             <div class="modal-dialog modal-dialog-centered">
                                                 <div class="modal-content">
                                                     <div class="modal-body">
                                                         <div class="form-header">
                                                             <h3>Delete Product</h3>
                                                             <p>Are you sure want to delete?</p>
                                                         </div>
                                                         <div class="modal-btn delete-action">
                                                             <div class="row">
                                                                 <div class="col-6">
                                                                     <input type="hidden" id="old_image1<?php echo $val['id']; ?>" value="<?php echo $old; ?>" />
                                                                     <button class="btn btn-primary continue-btn" value="<?php echo $val['id']; ?>" id="dlt_btn<?php echo $val['id']; ?>" style="width: 100%;">Delete</button>
                                                                 </div>
                                                                 <div class="col-6">
                                                                     <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                 </div>
                                                             </div>
                                                             <div class="row">
                                                                 <div class="col-12" align="center" style="padding-top: 15px;"><span id="preview<?php echo $val['id']; ?>"></span></div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <!-- / End Delete banner Modal -->
                                         <!-- Delete Script Modal -->
                                         <script>
                                             $("#dlt_btn<?php echo $val['id']; ?>").click("submit", function() {
                                                 var dlt_btn = $(this).val();
                                                 //alert(dlt_btn);
                                                     $.ajax({
                                                         url: "delete_product.php",
                                                         method: "POST",
                                                         data: {
                                                             dlt_btn: dlt_btn
                                                         },
                                                         success: function(data) {
                                                             //var result=JSON.parse(data);
                                                             //alert(data);
                                                             $("#preview<?php echo $val['id']; ?>").html(data);
                                                             //alert("success");
                                                             //location.reload();
                                                             setTimeout(function() {
                                                                 setTimeout(location.reload.bind(location), 1500);
                                                             }, 1000);
                                                         },
                                                     });
                                                 
                                             });
                                         </script>
                                         <!-- End Delete Script Modal -->
                                         <!-- End Delete Script Modal -->

                                     <?php } ?>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
             <!-- /Page Content -->

             <!-- Add banner Modal -->
             <div class="modal custom-modal fade" id="add_holiday" role="dialog">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title">Add Product</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         <div class="modal-body">
                             <form id="fupForm" enctype="multipart/form-data">
                                 <div class="form-group">
                                     <label>Category <span class="text-danger">*</span></label>
                                     <select class="form-control" name="cat_id">
                                         <option value="">--Select- -</option>
                                         <?php
                                            $cat_fetch = $obj->fetch("SELECT * FROM category ORDER BY name ASC");
                                            foreach ($cat_fetch as $cval) {
                                            ?>
                                             <option value="<?= $cval['id'] ?>"><?= $cval['name'] ?></option>
                                         <?php  } ?>
                                     </select>
                                 </div>
                                 <div class="form-group">
                                     <label>Item Code <span class="text-danger">*</span></label>
                                     <input class="form-control" type="text" name="code" id="code" />
                                 </div>
                                 <div class="form-group">
                                     <label>Name <span class="text-danger">*</span></label>
                                     <input class="form-control" type="text" name="name" id="name" />
                                 </div>
                                 <div class="form-group">
                                     <label>Price <span class="text-danger">*</span></label>
                                     <input class="form-control" type="text" name="price" id="price" />
                                 </div>
                                 <div class="form-group">
                                     <label>Qty <span class="text-danger">*</span></label>
                                     <input class="form-control" type="text" name="qty" id="qty" />
                                 </div>
                                 <div class="form-group">
                                     <label>About <span class="text-danger">*</span></label>
                                     
                                     <?php
                                     $about='<h6><span style="color: rgb(100, 100, 100); font-family: Roboto, sans-serif; text-align: justify;">uPVC Sheet, panel,
                                     louvers has been gaining its acceptance in interior design in recent times. PVC is a soft and flexible material that do not
                                     break easily. Earlier plywood was the main option for the residential and commercial interiors because people used to think
                                     it is safer than other available materials. However PVCs are completely nontoxic, termite proof, water proof, damp proof,
                                     and fire returned.</span><span style="font-size: 14px;">.</span></h6>';
                                     ?>
                                     
                                     <textarea class="form-control summernote" name="about"><?=$about?></textarea>
                                     <span class="des" style="color: red;"></span>
                                 </div>
                                 <div class="form-group">
                                     <label>Features <span class="text-danger">*</span></label>
                                     <?php
                                     $feature='<table class="table table-bordered"><tbody><tr><td><b><span style="font-size: 13px;">Thickness</span></b></td><td>
                                     <b>20mm</b></td></tr><tr><td><b><span style="font-size: 13px;">Height</span></b></td><td><b>78"</b></td></tr><tr><td><b>
                                     <span style="font-size: 13px;">Width</span></b></td><td><b>22"</b></td></tr><tr><td><b><span style="font-size: 13px;">
                                     Weight</span></b></td><td><b>6.3 Kg</b></td></tr></tbody></table><table class="table table-bordered"><tbody><tr><td>
                                     *GST & Transportation Extra.</td></tr></tbody></table>';
                                     ?>
                                     <textarea class="form-control summernote" name="features"><?=$feature?></textarea>
                                     <span class="des" style="color: red;"></span>
                                 </div>
                                 <div class="form-group">
                                     <label>Image <span class="text-danger">*</span></label>
                                     <input class="form-control" type="file" name="image[]" id="image" />
                                     <span class="image" style="color: red;"></span>
                                 </div>
                                 <div id="row"></div>
                                <div class="form-group">
                                    <label>Stock</label>
                                    <select class="form-control" name="stock">
                                        <option value="Available">Available</option>
                                        <option value="Not Available">Not Available</option>
                                    </select>
                                </div>
                                 <div class="submit-section">
                                     <span class="btn btn-primary" id="add">+</span>
                                     <input type="hidden" name="total_item" id="total_item" value="1">
                                     <button type="submit" name="edit" class="btn btn-primary submit-btn" id="submit">
                                         Submit
                                     </button>
                                 </div>
                             </form>
                             <div class="statusMsg" style="text-align: center;"></div>
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
     <script type="text/javascript">
         $(document).ready(function(e) {
             $("#fupForm").on("submit", function(e) {
                 e.preventDefault();
                 $.ajax({
                     type: "POST",
                     url: "add_product.php",
                     data: new FormData(this),
                     contentType: false,
                     cache: false,
                     processData: false,
                     beforeSend: function() {
                         $('#submit').html('Processing...');
                     },
                     success: function(data) {
                         $('#submit').html('Submit');
                         if(data=='ok')
                         {
                             $(".statusMsg").html('<p class="alert alert-success"><i class="fa fa-check-square-o"></i> Successfully Submitted</p>');
                             setTimeout(location.reload.bind(location), 2500);
                         }
                         else
                         {
                            
                            $(".statusMsg").html(data);
                         }
                         
                     },
                 });
             });
         });
     </script>

     <script type="text/javascript">
         $(".file").on("change", function(e) {
             e.preventDefault();
             var src = URL.createObjectURL(event.target.files[0]);
             //alert(src);
             $(".img").prop("src", src);
         });
     </script>
     <script>
         $(document).ready(function() {
             var count = 1;
             $("#add").on("click", function() {
                 count++;
                 $('#total_item').val(count);
                 var html_code = '';
                 html_code += '<div class="form-group" id="ro' + count + '">';
                 html_code += '<label>Image ' + count + '</label>';
                 html_code += '<div style="width:100%;display:flex;">';
                 html_code += '<input class="form-control" type="file" name="image[]" data-srno="' + count + '" id="image' + count + '" style="width:90%;">';
                 html_code += '<span class="btn btn-danger remove_row" style="width:10%;" id="' + count + '"><i class="fa fa-remove" style="padding-top:8px;"></i></span>';
                 html_code += '</div>';
                 html_code += '</div>';
                 $('#row').append(html_code);
             });
             $(document).on('click', '.remove_row', function() {
                 var row_id = $(this).attr("id");
                 $('#ro' + row_id).remove();
                 count--;
                 $('#total_item').val(count);
             });
         });
     </script>
     <script>
         $(document).ready(function() {
             var count = $('.total_img').val();
             $("#add_input").on("click", function() {
                 count++;
                 $('.total_img').val(count);
                 var html_code = '';
                 html_code += '<div class="form-group" id="ro_input' + count + '">';
                 html_code += '<label>Image</label>';
                 html_code += '<div style="width:100%;display:flex;">';
                 html_code += '<input class="form-control" type="file" name="img[]" data-srno="' + count + '" id="image' + count + '" style="width:90%;">';
                 html_code += '<span class="btn btn-danger remove_row" style="width:10%;" id="' + count + '"><i class="fa fa-remove" style="padding-top:8px;"></i></span>';
                 html_code += '</div>';
                 html_code += '</div>';
                 $('.add_img').append(html_code);
             });
             $(document).on('click', '.remove_row', function() {
                 var row_id = $(this).attr("id");
                 $('#ro_input' + row_id).remove();
                 count--;
                 $('.total_img').val(count);
             });
         });
         $(document).ready(function(){
              var table = $('#doctor').DataTable({
                "searching": true,
                "pageLength": 100
            });
         });
     </script>.
     <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
     <script>
         $('.summernote').summernote();
     </script>
     


 </body>

 </html>