 <?php
    session_start();
    if(empty($_SESSION['username']))
    {
        echo '<script>window.location.href="login.php"</script>';
    }
    $assetImgUrl = "https://app.pvcinterior.in/api/assets/";
    ?>
<!DOCTYPE html>
<html>
<?php //header link
include("header_link.php"); ?>
    <body>
        <?php
//database file link
include("config.php");
?>
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
                            <div class="col">
                                <h3 class="page-title">Banner</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Banner</li>
                                </ul>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add Banner</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    <script src="js/jquery-3.2.1.min.js"></script>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped datatable custom-table mb-0" id="banner-load">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $cnt='0';
                                            $selct=$obj->fetch("SELECT * FROM banners ORDER BY id DESC"); foreach($selct as $val) { $cnt++; $old=$val['filename'];?>
                                        <tr class="holiday-upcoming">
                                            <td><?php echo $cnt; ?></td>
                                            <td><img src="<?php echo $assetImgUrl . $val['filename']; ?>" style="width:100px;"></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_banner_modal<?php echo $cnt; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_holiday<?php echo $cnt; ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Edit banner Modal -->
                                        <div class="modal custom-modal fade" id="edit_banner_modal<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit banner</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="edit_banner<?php echo $cnt; ?>">
                                                            <div class="form-group">
                                                                <label>Image <span class="text-danger">*</span></label><br />
                                                                <img class="thumbnail" id="img" src="<?php echo $assetImgUrl . $val['filename']; ?>" style="width: 100px;" />
                                                                <input id="image<?php echo $val['id']; ?>" class="form-control file" type="file" style="margin-top: 10px;" name="image" />
                                                                <input type="hidden" name="old_image" value="<?php echo $assetImgUrl . $val['filename']; ?>" id="old_image" />
                                                                <span class="image"></span>
                                                            </div>
                                                            <div class="submit-section">
                                                                <input type="hidden" value="<?php echo $val['id']; ?>" name="banner_id">
                                                                <input type="submit" name="submit" id="edit_banner_btn<?php echo $val['id']; ?>" class="btn btn-primary edit_banner_btn" value="Submit" />
                                                            </div>
                                                            <div class="preview1" style="text-align: center;"></div>
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
                                                            <h3>Delete Banner</h3>
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
                                                $("#edit_banner<?php echo $cnt; ?>").on("submit", function (e) {
                                                    e.preventDefault();
                                                    //alert("w");
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "edit_banner.php",
                                                        data: new FormData(this),
                                                        contentType: false,
                                                        cache: false,
                                                        processData: false,
                                                        // beforeSend: function(){
                                                        //     $('.submitBtn').attr("disabled","disabled");
                                                        //     $('#fupForm').css("opacity",".5");
                                                        // },
                                                        success: function (data) {
                                                            //console.log(response);

                                                            // var mydata = JSON.parse(response);
                                                            // alert(data);
                                                            // console.log(response.message);
                                                            $(".preview1").html(data);
                                                           setTimeout(location.reload.bind(location), 1500);
                                                            // if(response.status == 1){
                                                            //     $('#fupForm')[0].reset();
                                                            //     $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                                                            // }else{
                                                            //     $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                                                            // }
                                                            // $('#fupForm').css("opacity","");
                                                            // $(".submitBtn").removeAttr("disabled");
                                                        },
                                                    });
                                                });
                                            });
                                        </script>
                                        <!-- End Edit Script Modal -->
                                        <!-- Delete Script Modal -->
                                        <script>
                                            $("#dlt_btn<?php echo $val['id']; ?>").click("submit", function () {
                                                var dlt_btn = $(this).val();
                                                var flag = true;
                                                var old_image1 = $("#old_image1<?php echo $val['id']; ?>").val();
                                                //alert(old_image1);

                                                /********validate all our form fields***********/
                                                if (dlt_btn == "") {
                                                    $("#dlt_btn").css("border-color", "red");
                                                    flag = false;
                                                }
                                                if (old_image1 == "") {
                                                    flag = false;
                                                }

                                                if (flag) {
                                                    $.ajax({
                                                        url: "delete_banner.php",
                                                        method: "POST",
                                                        data: { dlt_btn: dlt_btn, old_image1: old_image1 },
                                                        success: function (data) {
                                                            //var result=JSON.parse(data);
                                                           // alert(data);
                                                            $("#previewmsg<?php echo $val['id']; ?>").html(data);
                                                            //alert("success");
                                                            //location.reload();
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

                <!-- Add banner Modal -->
                <div class="modal custom-modal fade" id="add_holiday" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add banner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="fupForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Image <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="image" id="image" />
                                        <span class="image" style="color: red;"></span>
                                    </div>
                                    <div class="submit-section">
                                        <input type="submit" name="edit" class="btn btn-primary submit-btn" id="submit" value="Submit" />
                                    </div>
                                    <div class="statusMsg" style="text-align: center;"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add banner Modal -->

                <?php
 // header
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
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function (e) {
        // Submit form data via Ajax
        $("#fupForm").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "add_banner.php",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                // beforeSend: function(){
                //     $('.submitBtn').attr("disabled","disabled");
                //     $('#fupForm').css("opacity",".5");
                // },
                success: function (data) {
                    //console.log(response);

                    // var mydata = JSON.parse(response);
                    //alert(data);
                    // console.log(response.message);
                    $(".statusMsg").html(data);
                    setTimeout(location.reload.bind(location), 1500);
                    // if(response.status == 1){
                    //     $('#fupForm')[0].reset();
                    //     $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    // }else{
                    //     $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    // }
                    // $('#fupForm').css("opacity","");
                    // $(".submitBtn").removeAttr("disabled");
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
  </script>
