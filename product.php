<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
$assetImgUrl = "https://mehndipvc.shop/api/assets/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>

    <?php include("header_link.php"); ?>

    <!-- Bootstrap & Summernote -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <!-- Fancybox v3 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

    <!-- jQuery and JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php include("config.php"); ?>

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">
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

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="product-table table table-striped custom-table mb-0" id="productTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Features</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            $products = $obj->fetch("SELECT * FROM `items`");
                            foreach ($products as $val) {
                                $cnt++;
                                $cat = $obj->arr("SELECT * FROM category WHERE id='{$val['cat_id']}'");
                                $features = base64_decode($val['features']);
                                ?>
                                <tr>
                                    <td><?= $cnt ?></td>
                                    <td><?= $val['code'] ?></td>
                                    <td><?= $cat['name'] ?></td>
                                    <td><?= $val['name'] ?></td>
                                    <td><?= $val['price'] ?></td>
                                    <td><?= $val['quantity'] ?></td>
                                    <td><?= $val['status'] ?></td>
                                    <td>
                                        <i class="fa fa-eye" data-toggle="modal" data-target="#featuresModal<?= $cnt ?>" style="cursor:pointer;"></i>
                                        <div class="modal fade" id="featuresModal<?= $cnt ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?= $val['name'] ?> Features</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body"><?= $features ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="edit-product-form?id=<?= base64_encode($val['id']) ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteModal<?= $cnt ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="deleteModal<?= $cnt ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h4>Are you sure you want to delete this product?</h4>
                                                <div class="mt-4">
                                                    <button class="btn btn-danger delete-btn" data-id="<?= $val['id'] ?>">Yes, Delete</button>
                                                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <div class="delete-status mt-2" id="status<?= $val['id'] ?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add Product Modal -->
            <div class="modal fade" id="add_holiday" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Product</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="fupForm" enctype="multipart/form-data">
                                <!-- Category, Code, Name, Price, Qty fields -->
                                <!-- About -->
                                <div class="form-group">
                                    <label>About</label>
                                    <textarea class="form-control summernote" name="about"></textarea>
                                </div>
                                <!-- Features -->
                                <div class="form-group">
                                    <label>Features</label>
                                    <textarea class="form-control summernote" name="features"></textarea>
                                </div>
                                <!-- Image Upload -->
                                <div class="form-group">
                                    <label>Image</label>
                                    <input class="form-control" type="file" name="image[]" />
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
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <div class="statusMsg mt-2 text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Add Product Modal -->

        </div>
    </div>
</div>

<?php include("footer_link.php"); ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    $(document).ready(function () {
        $('.summernote').summernote();

        $('#productTable').DataTable({
            pageLength: 100,
            searching: true
        });

        $('#add').on('click', function () {
            let count = $('#total_item').val();
            count++;
            $('#total_item').val(count);
            $('#row').append(`<div class="form-group" id="ro${count}">
                <label>Image ${count}</label>
                <div class="d-flex">
                    <input type="file" name="image[]" class="form-control" style="width:90%;">
                    <span class="btn btn-danger remove_row" style="width:10%;" data-id="${count}"><i class="fa fa-remove"></i></span>
                </div>
            </div>`);
        });

        $(document).on('click', '.remove_row', function () {
            let id = $(this).data('id');
            $(`#ro${id}`).remove();
        });

        $('#fupForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "add_product.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.statusMsg').html('Submitting...');
                },
                success: function (data) {
                    if (data === 'ok') {
                        $('.statusMsg').html('<div class="alert alert-success">Product added successfully!</div>');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        $('.statusMsg').html(`<div class="alert alert-danger">${data}</div>`);
                    }
                }
            });
        });

        $('.delete-btn').click(function () {
            let id = $(this).data('id');
            $.post('delete_product.php', { dlt_btn: id }, function (data) {
                $(`#status${id}`).html(data);
                setTimeout(() => location.reload(), 1500);
            });
        });
    });
</script>

</body>
</html>
