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
    <body>
        <?php
//database file link
include("config.php");
include("header.php");
?>
<script src="js/jquery-3.2.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <!-- Page Content -->
                <div class="content container-fluid">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h3 class="page-title">Gallery</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Gallery</li>
                                </ul>
                            </div>
                            <div class="col-sm-6 text-right d-flex ml-auto">
                                <select class="form-control" id="galCat">
                                    <option value="">-Filter category-</option>
                                    <?php
                                    $gal_fet=$obj->fetch("SELECT * FROM gal_category ORDER BY id DESC");
                                    foreach($gal_fet as $gal_fet_val){
                                    ?>
                                    <option value="<?= $gal_fet_val['id'] ?>"><?= $gal_fet_val['category'] ?></option>
                                    <?php } ?>
                                </select>
                                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add Gallery</a>
                            </div>
                            <!--<div class="col-auto float-right ml-auto">-->
                            <!--    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add Gallery</a>-->
                            <!--</div>-->
                        </div>
                    </div>
                    
                    <?php
                    if(!empty($_GET['galCat']))
                    {
                        $galCat=$_GET['galCat'];
                         $total_records = $obj->num("SELECT * FROM items_images WHERE cat_id='$galCat'");
                    }
                    else
                    {
                         $total_records = $obj->num("SELECT * FROM items_images");
                    }
                   
       
                    $total_pages = ceil($total_records / 50);
                    ?>
                    
                    <!-- /Page Header -->
                    <script src="js/jquery-3.2.1.min.js"></script>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="gallery-table-all">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>SL No.</th>
                                            <th>User</th>
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // $itemsPerPage = 100; // You can adjust this based on your preference
                                        // $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        // $offset = ($page - 1) * $itemsPerPage;
                                        
                                        
                                        $limit = 50;   
                                        if (isset($_GET["page"])) {  
                                          $pn  = $_GET["page"];  
                                        }  
                                        else {  
                                          $pn=1;  
                                        };   
                                      
                                        $start_from = ($pn-1) * $limit;
                                        
                                        
                                        
                                        
                                            $cnt='0';
                                            if(!empty($_GET['galCat']))
                                                {
                                                    $galCat=$_GET['galCat'];
                                                    $selct=$obj->fetch("SELECT * FROM items_images WHERE cat_id='$galCat' ORDER BY id DESC LIMIT $start_from, $limit");
                                                }
                                                else
                                                {
                                                     $selct=$obj->fetch("SELECT * FROM items_images ORDER BY id DESC LIMIT $start_from, $limit");
                                                }
                                             foreach($selct as $val) { 
                                            
                                            
                                            $cnt++; $old=$val['filename'];
                                            $cat_id=$val['cat_id'];
                                            $user_id=$val['user_id'];
                                            $data_cat=$obj->arr("SELECT * FROM gal_category WHERE id='$cat_id'");
                                            $data_user=$obj->arr("SELECT name FROM users WHERE user_id='$user_id'");
                                            
                                            $imageName = $val['filename'];
                                            ?>
                                        <tr class="holiday-upcoming">
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $val['id']; ?></td>
                                             <td><?php echo $data_user['name']; ?></td>
                                            <td><?php echo $data_cat['category']; ?></td>
                                            <td>
                                                <div>
                                                    <a href="https://app.pvcinterior.in/api/assets/<?php echo urlencode($imageName); ?>" target="_blank">
                                                        View
                                                    </a>
                                                </div>
                                            </td>
                                             <td><?php echo $val['status']; ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                       <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit<?php echo $cnt; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_holiday<?php echo $cnt; ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Edit banner Modal -->
                                        <div class="modal custom-modal fade" id="edit<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Gallery</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="edit_form<?php echo $cnt; ?>" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <label>Category <span class="text-danger">*</span></label><br />
                                                                <select class="form-control" name="cat_id">
                                                                    <option value="">Select Category</option>
                                                                    <?php
                                                                        $fet_cat=$obj->fetch("SELECT * FROM gal_category ORDER BY category ASC");
                                                                        
                                                                        foreach($fet_cat as $val_cat){
                                                                    ?>
                                                                    <option value="<?= $val_cat['id'] ?>" <?= ($val_cat['id']==$val['cat_id'])?'selected':'';?>><?= $val_cat['category'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Image <span class="text-danger">*</span></label><br />
                                                                
                                                               

                                                    <input  name="image_new[]" id="image<?php echo $val['id']; ?>" class="form-control file<?php echo $to_img; ?>" type="file" style="margin-top: 10px;"/>
                                                                <input type="hidden" name="old_image" value="<?php echo $val['filename'] ?>" id="old_image" />
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label>Status <span class="text-danger">*</span></label><br />
                                                                <select class="form-control" name="status">
                                                                    <option value="">Select status</option>
                                                                    <option value="Approve" <?= ($val['status']=='Approve')?'selected':'';?>>Approve</option>
                                                                    <option value="Reject" <?= ($val['status']=='Reject')?'selected':'';?>>Reject</option>
                                                                </select>
                                                            </div>
                                                            <div class="submit-section">
                                                                <input type="hidden" value="<?php echo $val['id']; ?>" name="id">
                                                                <input type="submit" name="submit" id="edit_banner_btn<?php echo $val['id']; ?>" class="btn btn-primary edit_banner_btn" value="Submit" />
                                                            </div>
                                                            <div class="erMsg<?= $cnt ?> mt-2" style="text-align: center;"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Edit banner Modal -->
                                        <!-- Delete banner Modal -->
                                        <div class="modal custom-modal fade" id="delete_holiday<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Delete Gallery</h3>
                                                            <p>Are you sure want to delete?</p>
                                                        </div>
                                                        <div class="modal-btn delete-action">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <input type="hidden" id="old_image1<?php echo $val['id']; ?>" value="<?php echo $old; ?>" />
                                                                    <button class="btn btn-primary continue-btn" value="<?php echo $val['item_id']; ?>" id="dlt_btn<?php echo $val['item_id']; ?>" style="width: 100%;">Delete</button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12" align="center" style="padding-top: 15px;"><span id="previewmsg<?php echo $val['id']; ?>"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Delete banner Modal -->
                                        <!-- Edit script Modal -->
                                        <script type="text/javascript">
                                            $(document).ready(function (e) {
                                                // Submit form data via Ajax
                                                $("#edit_form<?php echo $cnt; ?>").on("submit", function (e) {
                                                    e.preventDefault();
                                                    //alert("w");
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "edit_gallery.php",
                                                        data: new FormData(this),
                                                        contentType: false,
                                                        cache: false,
                                                        processData: false,
                                                        // beforeSend: function(){
                                                        //     $('.submitBtn').attr("disabled","disabled");
                                                        //     $('#fupForm').css("opacity",".5");
                                                        // },
                                                        success: function (data) {
                                                            $(".erMsg<?= $cnt ?>").html(data);
                                                            setTimeout(location.reload.bind(location), 1500);
                                                        },
                                                    });
                                                });
                                            });
                                        </script>
                                        <!-- End Edit Script Modal -->
                                        <!-- Delete Script Modal -->
                                        <script>
                                            $("#dlt_btn<?php echo $val['item_id']; ?>").click("submit", function () {
                                                var dlt_btn = $(this).val();
                                                var flag = true;
                                                var old_image1 = $("#old_image1<?php echo $val['id']; ?>").val();
                                                if (dlt_btn == "") {
                                                    $("#dlt_btn").css("border-color", "red");
                                                    flag = false;
                                                }
                                                if (old_image1 == "") {
                                                    flag = false;
                                                }

                                                if (flag) {
                                                    $.ajax({
                                                        url: "delete_galary.php",
                                                        method: "POST",
                                                        data: { dlt_btn: dlt_btn, old_image1: old_image1 },
                                                        success: function (data) {
                                                            $("#previewmsg<?php echo $val['id']; ?>").html(data);
                                                            setTimeout(location.reload.bind(location), 1500);
                                                        },
                                                    });
                                                }
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
                <?php
                $current_url = $_SERVER["REQUEST_URI"];
                
                // Parse the URL to get the query string part
                $parsed_url = parse_url($current_url, PHP_URL_QUERY);
                
                // Parse the query string to get the specific parameters
                parse_str($parsed_url, $query_params);
                
                // Now you can access the 'galCat' parameter
                $page_param = isset($query_params['galCat']) ? 'galCat=' . $query_params['galCat'] : '';
                ?>
                
                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                    </div>
                        
                    <div class="col-md-4 col-sm-4">
                        <nav aria-label="Page navigation example">
<?php
// Determine the current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $total_pages)); // Ensure the page is within valid range

// Define the range of pages to show around the current page
$range = 1; // Number of pages to show on either side of the current page
$start_page = max(1, $page - $range);
$end_page = min($total_pages, $page + $range);

// Ensure we always show pages 1, 2, 3 if there are at least 3 pages
if ($total_pages > 3) {
    if ($page <= 2) {
        $end_page = min(3, $total_pages); // Show pages 1, 2, 3
    } elseif ($page >= $total_pages - 1) {
        $start_page = max($total_pages - 2, 1); // Show last 3 pages
    }
}
?>

<ul class="pagination">
    <?php
    // Display "Previous" button
    $prev_page = $page - 1;
    ?>
    <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
        <a class="page-link" href="<?= $page_param ? '?' . $page_param . '&page=' . max($prev_page, 1) : '?page=' . max($prev_page, 1) ?>">Previous</a>
    </li>

    <?php
    // Display pagination links
    for ($i = $start_page; $i <= $end_page; $i++) {
        $link_url = $page_param ? '?' . $page_param . '&page=' . $i : '?page=' . $i;
        ?>
        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
            <a class="page-link" href="<?= $link_url ?>"><?php echo $i; ?></a>
        </li>
        <?php
    }
    ?>

    <?php
    // Display "Next" button
    $next_page = $page + 1;
    ?>
    <li class="page-item <?php if ($page == $total_pages) echo 'disabled'; ?>">
        <a class="page-link" href="<?= $page_param ? '?' . $page_param . '&page=' . min($next_page, $total_pages) : '?page=' . min($next_page, $total_pages) ?>">Next</a>
    </li>
</ul>




                        </nav>
                    </div>
                    
                    <div class="col-md-4">
                    </div>
                    
                </div>
                <!-- /Pagination -->


                <!-- Add banner Modal -->
                <div class="modal custom-modal fade" id="add_holiday" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Gallery</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add_category_form">
                                    <div class="form-group">
                                        <label>Category <span class="text-danger">*</span></label><br />
                                        <select class="form-control" name="cat_id">
                                            <option value="">Select Category</option>
                                            <?php
                                                $fet_cat=$obj->fetch("SELECT * FROM gal_category");
                                                
                                                foreach($fet_cat as $val_cat){
                                            ?>
                                            <option value="<?= $val_cat['id'] ?>"><?= $val_cat['category'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Image <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="image[]" id="image" multiple/>
                                        <span class="image" style="color: red;"></span>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" name="edit" class="btn btn-primary submit-btn" id="submitGallery">Submit</button>
                                    </div>
                                    <div class="statusMsg mt-1" style="text-align: center;"></div>
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
<script type="text/javascript">
    $(document).ready(function (e) {
        // Submit form data via Ajax
        $("#add_category_form").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "add-gallery.php",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#submitGallery').html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span> Loading...');
                },
                success: function (data) {
                    $(".statusMsg").html(data);
                    $('#submitGallery').html('Submit');
                    if (data == 200) {
                        $('.statusMsg').html('<p class="alert alert-success">Gallery added successfully</p>');
                        setTimeout(location.reload.bind(location), 1500);
                    } else {
                        $(".statusMsg").html(data);
                    }
                },
            });
        });
    });
</script>

<script type="text/javascript">
    $(".file").on("change", function (e) {
        e.preventDefault();
        var src = URL.createObjectURL(event.target.files[0]);
        //alert(src);
        $("#img").prop("src", src);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
 <script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
    // $(document).ready(function(){
    //   var table = $('#gallery-table-all').DataTable({
    //     "searching": true
    //   });
    // });
  </script>
  
  <script>
      $('#galCat').on("change", function(){
          let galCat = $('#galCat').val();
          window.location.href='gallery.php?galCat='+galCat+'';
      })
  </script>
  
