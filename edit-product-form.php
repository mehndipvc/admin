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
//database file link
include("config.php");
?>
               <?php
 // header
include("header.php");
if(empty($_GET['id']))
{
    echo '<script>window.location.href="product"</script>';
}
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
                                <h3 class="page-title">Product</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Product</li>
                                </ul>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="product" class="btn add-btn"><i class="fa fa-plus"></i> Add Product</a>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    $id=base64_decode($_GET['id']);
                    $cnt='0';
                    $val=$obj->arr("SELECT * FROM items WHERE id='$id'");
                    if(!empty($val['id']))
                    {
                    
                    $old=$val['image'];?>
                    <!-- /Page Header -->
                    <script src="js/jquery-3.2.1.min.js"></script>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="card-body">
                               <form id="edit_doctor" enctype="multipart/form-data">
                               <div class="form-group">
                                     <label>Category <span class="text-danger">*</span></label>
                                     <select class="form-control" name="cat_id">
                                         <option value="">--Select- -</option>
                                         <?php
                                            $cat_fetch = $obj->fetch("SELECT * FROM category ORDER BY name ASC");
                                            foreach ($cat_fetch as $cval) {
                                            ?>
                                             <option value="<?= $cval['id'] ?>" <?php echo ($cval['id']==$val['cat_id'])?'selected':''; ?>><?= $cval['name'] ?></option>
                                         <?php  } ?>
                                     </select>
                                 </div>
                                 <div class="form-group">
                                     <label>Item Code <span class="text-danger">*</span></label>
                                     <input class="form-control" type="text" name="code" id="code" value="<?= $val['code'] ?>" />
                                 </div>
                                 <div class="form-group">
                                     <label>Name <span class="text-danger">*</span></label>
                                     <input class="form-control" type="text" name="name" id="name" value="<?= $val['name'] ?>"/>
                                 </div>
                                
                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input class="form-control" value="<?php echo $val['price']; ?>" type="text" name="price" />
                                    <span class="qly"></span>
                                </div>
                                <div class="form-group">
                                    <label>Qty <span class="text-danger">*</span></label>
                                    <input class="form-control" value="<?php echo $val['quantity']; ?>" type="text" name="qty" />
                                    <span class="qly"></span>
                                </div>
                                 <div class="form-group">
                                    <label>About <span class="text-danger">*</span></label>
                                    <textarea class="form-control summernote" name="about"><?php echo base64_decode($val['about']); ?></textarea>
                                    <span class="des" style="color: red;"></span>
                                </div>
                                <div class="form-group">
                                    <label>Features <span class="text-danger">*</span></label>
                                    <textarea class="form-control summernote" name="features"><?php echo base64_decode($val['features']); ?></textarea>
                                    <span class="des" style="color: red;"></span>
                                </div>
                               <div class="form-group">
                                    <label>Stock</label>
                                    <select class="form-control" name="stock">
                                        <option value="Available" <?= ($val['status']=='Available')?'selected':''?>>Available</option>
                                        <option value="Not Available" <?= ($val['status']=='Not Available')?'selected':''?>>Not Available</option>
                                    </select>
                                </div>
                                
                                <?php
                                    $unser = json_decode($val['image_url']);
                                    $to_img = 0;
                                    foreach ($unser as $itemimg) {
                                        $to_img++;
                                ?>
                                    <div class="form-group">
                                        <label>Image <span class="text-danger">*</span></label><br />
                                        <a data-fancybox="image" id="imga" data-src="<?php echo $itemimg->image; ?>" style="cursor:pointer;">
                                            <img class="thumbnail img<?php echo $to_img; ?>" id="img" src="<?php echo $itemimg->image; ?>" style="width: 100px;" />
                                        </a>
                                        <div style="display: flex;justify-content: center;align-items: center;">
                                            <input id="image<?php echo $val['id']; ?>" class="form-control file<?php echo $to_img; ?>" type="file" style="margin-top: 10px;" name="img[]" />
                                            <button type="button" class="btn btn-danger delete-image" data-img-id="<?php echo $to_img; ?>" data-image-url="<?php echo $itemimg->image; ?>"><i class="fa fa-remove" style="padding-top:8px;"></i></button>
                                        </div>
                                        <input type="hidden" name="old_image[]" value="<?php echo $itemimg->image; ?>" id="old_image" />
                                        
                                        <input type="hidden" name="track_img<?=$to_img?>" value="<?=$to_img ?>"/>
                                        
                                        <!-- Delete Button -->
                                        
                                    </div>
                                
                                    <script type="text/javascript">
                                        // Change image preview when file is selected
                                        $(".file<?php echo $to_img; ?>").on("change", function (e) {
                                            e.preventDefault();
                                            var src = URL.createObjectURL(event.target.files[0]);
                                            $(".img<?php echo $to_img; ?>").prop("src", src);
                                        });
                                
                                        // Delete image functionality
                                        $(".delete-image").on("click", function () {
                                            var imageUrl = $(this).data("image-url");
                                            var imgId = $(this).data("img-id");
                                            
                                            // Optionally remove the image element
                                            $(".img" + imgId).remove();
                                            $(this).closest(".form-group").remove(); // Remove the form group containing the image and delete button
                                
                                        });
                                    </script>
                                <?php } ?>

                                <div class="add_img"></div>
                                
                                
                                <div class="submit-section">
                                    <span  class="btn btn-primary" id="add_input">+</span>
                                    <input type="hidden" class="total_img" name="total_img" value="<?php echo $to_img; ?>">
                                    <input type="hidden" name="doctor_id" value="<?php echo $val['id']; ?>" id="doctor_id" />
                                    <button name="submit" id="edit_banner_btn" class="btn btn-primary edit_banner_btn" >Submit</button>
                                </div>
                                <div class="preview1" style="text-align: center;"></div>
                            </form>
                          </div>
                        </div>
                    </div>
                    <?php }else{ echo '<script>window.location.href="product"</script>';} ?>
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
                url: "edit_product.php",
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
      var count = $('.total_img').val();
      $("#add_input").on("click", function(){
            count++;
           $('.total_img').val(count);
           var html_code = '';
            html_code +='<div class="form-group" id="ro_input'+count+'">';
            html_code +='<label>Image</label>';
            html_code +='<div style="width:100%;display:flex;">';
            html_code +='<input class="form-control" type="file" name="img[]" data-srno="'+count+'" id="image'+count+'" style="width:90%;">';
            html_code +='<span class="btn btn-danger remove_row" style="width:10%;" id="'+count+'"><i class="fa fa-remove" style="padding-top:8px;"></i></span>';
            html_code +='</div>';
            html_code +='</div>';
            $('.add_img').append(html_code);
      });
      $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
           $('#ro_input'+row_id).remove();
          count--;
          $('.total_img').val(count);
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
  