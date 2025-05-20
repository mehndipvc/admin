<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login.php"</script>';
}
?>
<?php include("config.php"); ?>
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
        // header
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
                            <h3 class="page-title">Edit Property</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Property</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="property.php" class="btn add-btn"><i class="fa fa-eye"></i> View Property</a>
                        </div>
                    </div>
                </div>

                <?php
                $id = base64_decode($_GET['id']);
                $cnt = '0';
                $val = $obj->arr("SELECT * FROM property WHERE id='$id'");
                $old = $val['image']; ?>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="edit_doctor">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Location <span class="text-danger">*</span></label>
                                                <select class="form-control" aria-label="Default select example"
                                                    id="location" name="location">
                                                    <option selected>Open this select Location</option>
                                                    <?php
                                                    $fetch = $obj->fetch('SELECT * from brand');
                                                    foreach ($fetch as $va) { ?>
                                                        <option value="<?php echo $va['id'] ?>" <?php echo ($va['id'] == $val['location']) ? 'selected' : ''; ?>>
                                                            <?php echo $va['brand'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Sub Location <span class="text-danger">*</span></label>
                                                <select class="form-control" aria-label="Default select example"
                                                    id="sublocation" name="sub_location">
                                                    <?php
                                                    $mid = $val['sub_location'];
                                                    $fet = $obj->fetch("SELECT * From model WHERE id='$mid'");
                                                    foreach ($fet as $vaf) { ?>
                                                        <option value="<?php echo $vaf['id'] ?>" <?php echo ($vaf['id'] == $val['sub_location']) ? 'selected' : ''; ?>>
                                                            <?php echo $vaf['model'] ?>
                                                        </option>

                                                        <?php
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Bhk <span class="text-danger">*</span></label>
                                                <select class="form-control" aria-label="Default select example"
                                                    id="bhk" name="bhk">
                                                    <option selected>Select Bhk</option>
                                                    <?php
                                                    $fetch_bhk = $obj->fetch('SELECT * from year');
                                                    foreach ($fetch_bhk as $val_bhk) {
                                                        ?>
                                                        <option value="<?php echo $val_bhk['id'] ?>" <?php echo ($val_bhk['id'] == $val['bhk']) ? 'selected' : ''; ?>>
                                                            <?php echo $val_bhk['year'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Property Type <span class="text-danger">*</span></label>
                                                <select class="form-control" aria-label="Default select example"
                                                    id="pro_type" name="pro_type">
                                                    <option value="">Select Property Type</option>
                                                    <option value="For Rent" <?php echo ('For Rent' == $val['pro_type']) ? 'selected' : ''; ?>>For Rent</option>
                                                    <option value="For Buy" <?php echo ('For Buy' == $val['pro_type']) ? 'selected' : ''; ?>>For Buy</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select class="form-control" aria-label="Default select example"
                                                    id="status" name="status">
                                                    <option value="">Select Status</option>
                                                    <option value="Ready To Move" <?php echo ('Ready To Move' == $val['status']) ? 'selected' : ''; ?>>Ready To Move
                                                    </option>
                                                    <option value="Under Construction" <?php echo ('Under Construction' == $val['status']) ? 'selected' : ''; ?>>Under
                                                        Construction</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Product Name <span class="text-danger">*</span></label>
                                                <input id="banner<?php echo $val['id']; ?>" class="form-control"
                                                    value="<?php echo $val['pro_name']; ?>" name="pro_name"
                                                    type="text" />
                                                <span class="dr_name"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Property Full Address <span class="text-danger">*</span></label>
                                                <input id="qly<?php echo $val['id']; ?>" class="form-control"
                                                    value="<?php echo $val['pro_full_ads']; ?>" type="text"
                                                    name="pro_full_ads" />
                                                <span class="qly"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control summernote" name="description">
                                            <?php echo base64_decode($val['description']); ?>
                                            </textarea>
                                                <span class="des" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Details <span class="text-danger">*</span></label>
                                                <textarea class="form-control summernote" name="details">
                                            <?php echo base64_decode($val['details']); ?>
                                            </textarea>
                                                <span class="des" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Amenities <span class="text-danger">*</span></label>
                                                <textarea class="form-control summernote" name="amenities">
                                            <?php echo base64_decode($val['amenities']); ?>
                                            </textarea>
                                                <span class="des" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Payment Plan <span class="text-danger">*</span></label>
                                                <textarea class="form-control summernote" name="payment_plan">
                                            <?php echo base64_decode($val['payment_plan']); ?>
                                            </textarea>
                                                <span class="des" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Floor Plan <span class="text-danger">*</span></label><br />
                                                <a data-fancybox="image" id="imga"
                                                    data-caption="<?php echo $val['floor_plan'] ?>"
                                                    data-src="<?php echo $val['floor_plan'] ?>" style="cursor:pointer;">
                                                    <img class="thumbnail img<?php echo $i; ?>" id="img"
                                                        src="<?php echo $val['floor_plan']; ?>" style="width: 100px;" />
                                                </a>
                                                <input id="image" class="form-control file" type="file"
                                                    style="margin-top: 10px;" name="floor_plan" />
                                                <input type="hidden" name="floor_plan_old"
                                                    value="<?php echo $val['floor_plan']; ?>" id="floor_plan_old" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Location Map Iframe<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="loc_map"
                                                    value='<?php echo base64_decode($val['loc_map']) ?>'>
                                                <span class="des" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Upload Brochure <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="brochure">
                                                <input type="hidden" name="brochure_old"
                                                    value="<?php echo $val['brochure']; ?>" id="brochure_old" />
                                                <span class="des" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <?php
                                        $unser = unserialize($val['image']);
                                        //print_r($unser);
                                        $cn = count($unser);
                                        $to_img = 0;
                                        for ($i = 0; $i < $cn; $i++) {
                                            if ($unser[$i]) {
                                                $to_img++;
                                                ?>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Image <span class="text-danger">*</span></label><br />
                                                        <a data-fancybox="image" id="imga"
                                                            data-caption="<?php echo $unser[$i] ?>"
                                                            data-src="<?php echo $unser[$i] ?>" style="cursor:pointer;">
                                                            <img class="thumbnail img<?php echo $i; ?>" id="img"
                                                                src="<?php echo $unser[$i]; ?>" style="width: 100px;" />
                                                        </a>
                                                        <input id="image<?php echo $val['id']; ?>"
                                                            class="form-control file<?php echo $i; ?>" type="file"
                                                            style="margin-top: 10px;" name="img[]" />
                                                        <input type="hidden" name="old_image[]"
                                                            value="<?php echo $unser[$i]; ?>" id="old_image<?php echo $i; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="btn btn-danger" id="dtimg<?php echo $i; ?>"><i
                                                                class="fa fa-trash"></i> Delete Image</p>

                                                    </div>
                                                </div>

                                                <script type="text/javascript">
                                                    $(".file<?php echo $i; ?>").on("change", function (e) {
                                                        e.preventDefault();
                                                        var src = URL.createObjectURL(event.target.files[0]);
                                                        //alert(src);
                                                        $(".img<?php echo $i; ?>").prop("src", src);
                                                    });
                                                </script>
                                                <script>
                                                    $('#dtimg<?php echo $i; ?>').on("click", function () {
                                                        //alert("jjh");
                                                        var image = $('#old_image<?php echo $i; ?>').val();
                                                        var product_id = <?php echo $val['id'] ?>;
                                                        $.ajax({
                                                            url: "delete_image.php",
                                                            type: "post",
                                                            data: { image: image, product_id, product_id },
                                                            success: function (data) {
                                                                //alert(data);
                                                                $('.preview1').html(data);
                                                                setTimeout(location.reload.bind(location), 1500);
                                                            }
                                                        })
                                                    })
                                                </script>
                                            <?php }
                                        } ?>

                                        <div class="add_img col-sm-12"></div>
                                        <div class="col-sm-12">
                                            <div class="submit-section">
                                                <span class="btn btn-primary" id="add_input">+</span>
                                                <input type="hidden" class="total_img" name="total_img"
                                                    value="<?php echo $to_img; ?>">
                                                <input type="hidden" name="doctor_id" value="<?php echo $val['id']; ?>"
                                                    id="doctor_id" />
                                                <button name="submit" id="edit_banner_btn<?php echo $val['id']; ?>"
                                                    class="btn btn-primary edit_banner_btn">Submit</button>
                                            </div>
                                            <div class="preview1" style="text-align: center;"></div>
                                        </div>
                                </form>
                            </div>
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
                url: "edit_property_form.php",
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
                    $(".preview1").html(data);
                    // setTimeout(function () {
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
        $(".img").prop("src", src);
    });
</script>

<script>
    $(document).ready(function () {
        var count = $('.total_img').val();
        $("#add_input").on("click", function () {
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
        $(document).on('click', '.remove_row', function () {
            var row_id = $(this).attr("id");
            $('#ro_input' + row_id).remove();
            count--;
            $('.total_img').val(count);
        });
    });
</script>
<script>
    $('#menu').on("change", function () {
        var menu = $('#menu').val();
        $.ajax({
            url: "fetch-submenu.php",
            type: "POST",
            data: {
                menu: menu
            },
            success: function (data) {
                $('#submenu').html(data);
            }
        })
    })
</script>
<script>
    $(".cat option").each(function () {
        $(this).siblings('[value="' + this.value + '"]').remove();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $('.summernote').summernote();
</script>