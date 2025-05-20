<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
?>
<?php
//database file link
include("config.php");
?>
<!DOCTYPE html>
<html>
<?php //header link
include("header_link.php"); ?>
<style>
    .pagination a {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 2px;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    .pagination span {
        padding: 8px 16px;
        color: #666;
    }
</style>

<body>
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
                            <h3 class="page-title">Individual Price</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Individual Price</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i
                                    class="fa fa-plus"></i> Set Price</a>
                        </div>
                    </div>
                </div>

                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row mb-3">
                    <div class="col-sm-12 d-flex" style="flex-direction:row">
                        <form action="" method="get">
                            <select class="" name="field" required>
                                <option value="">Select Field</option>
                                <option value="Username">Username</option>
                                <option value="user_type">User Type</option>
                                <option value="Category">Category</option>
                            </select>
                            <input type="text" placeholder="Search..." name="search">
                            <input type="submit" value="Search">
                        </form>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>User Type</th>
                                        <th>Category</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Commission</th>
                                        <th>Amt.</th>
                                        <th>Percentage</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Items per page and current page
                                    $items_per_page = 10; // Number of records per page
                                    $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                    $offset = ($current_page - 1) * $items_per_page;

                                    // Filtering
                                    $field = isset($_GET['field']) ? $_GET['field'] : '';
                                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                                    // Base SQL query for fetching records
                                    $sql = "SELECT * FROM individual_price WHERE 1=1";

                                    // Build WHERE conditions based on the selected filter
                                    $where_clause = " WHERE 1=1"; // Dynamic WHERE clause for filters
                                    
                                    if ($field == 'Username') {
                                        // Fetch user IDs based on matching usernames
                                        $user_data_filter = $obj->fetch("SELECT user_id FROM users WHERE name LIKE '%$search%'");
                                        if (!empty($user_data_filter)) {
                                            $user_ids = array_column($user_data_filter, 'user_id');
                                            $user_ids_imploded = implode(",", array_map('intval', $user_ids)); // Safely handle user IDs
                                            $where_clause .= " AND user_id IN ($user_ids_imploded)";
                                        } else {
                                            $where_clause .= " AND user_id = 0"; // No match found, return empty result
                                        }
                                    } elseif ($field == 'user_type') {
                                        // Filter by user type
                                    
                                        $user_data_filter = $obj->fetch("SELECT user_id FROM users WHERE user_type LIKE '%$search%'");
                                        if (!empty($user_data_filter)) {
                                            $user_ids = array_column($user_data_filter, 'user_id');
                                            $user_ids_imploded = implode(",", array_map('intval', $user_ids)); // Safely handle user IDs
                                            $where_clause .= " AND user_id IN ($user_ids_imploded)";
                                        } else {
                                            $where_clause .= " AND user_id = 0"; // No match found, return empty result
                                        }

                                    } elseif ($field == 'Category') {
                                        // Fetch category IDs based on matching categories
                                        $category_data_filter = $obj->fetch("SELECT id FROM category WHERE name LIKE '%$search%'");
                                        if (!empty($category_data_filter)) {
                                            $category_ids = array_column($category_data_filter, 'id');
                                            $category_ids_imploded = implode(",", array_map('intval', $category_ids)); // Safely handle category IDs
                                            $where_clause .= " AND category IN ($category_ids_imploded)";
                                        } else {
                                            $where_clause .= " AND category = 0"; // No match found, return empty result
                                        }
                                    }

                                    // Count total records based on filter for pagination
                                    $total_records_query = "SELECT COUNT(*) AS count FROM individual_price $where_clause";
                                    $total_records = $obj->fetch($total_records_query)[0]['count'];
                                    $total_pages = ceil($total_records / $items_per_page);

                                    // Fetch filtered records with pagination
                                    $sql = "SELECT * FROM individual_price $where_clause LIMIT $offset, $items_per_page";
                                    $selct = $obj->fetch($sql);

                                    // Display the records (adjust your table rendering as needed)
                                    $cnt = $offset;
                                    foreach ($selct as $val) {
                                        $cnt++;
                                        $pro_id = $val['product_id'];
                                        $user_name = $val['user_id'];
                                        $cat_id = $val['category'];
                                        $pro_data = $obj->arr("SELECT * FROM items WHERE id='$pro_id'");
                                        $user_data = $obj->arr("SELECT * FROM users WHERE user_id='$user_name'");
                                        $category_data = $obj->arr("SELECT name FROM category WHERE id='$cat_id'");
                                        ?>
                                        <tr class="holiday-upcoming">

                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $user_data['name'] ?></td>
                                            <td><?php echo $val['user_type'] ?></td>
                                            <td><?= $category_data['name'] ?></td>
                                            <td>
                                                <?= (strlen($pro_id) == 3) ? $pro_data['name'] : 'All'; ?>
                                            </td>
                                            <td><?php echo $val['set_price'] ?></td>
                                            <td><?php echo $val['commission'] ?></td>
                                            <td><?php echo $val['price'] ?></td>
                                            <td><?php echo $val['percentage'] ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#edit<?php echo $cnt; ?>"><i
                                                                class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_holiday<?php echo $cnt; ?>"><i
                                                                class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Menu Modal -->
                                        <div class="modal custom-modal fade" id="edit<?php echo $cnt; ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Individual Price</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="edit_individual<?php echo $cnt; ?>">
                                                            <div class="form-group">
                                                                <label>User Type <span class="text-danger">*</span></label>
                                                                <select name="user_typeEdit" id="<?= $val['id'] ?>"
                                                                    class="form-control user_typeEdit">
                                                                    <option value="">Select User Type</option>
                                                                    <option value="Agent" <?php echo ($val['user_type'] == 'Agent') ? 'selected' : ''; ?>>
                                                                        Agent</option>
                                                                    <option value="Distributor" <?php echo ($val['user_type'] == 'Distributor') ? 'selected' : ''; ?>>Distributor</option>
                                                                    <option value="Dealer" <?php echo ($val['user_type'] == 'Dealer') ? 'selected' : ''; ?>>
                                                                        Dealer</option>
                                                                    <option value="Customer" <?php echo ($val['user_type'] == 'Customer') ? 'selected' : ''; ?>>Retailer</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>User List <span class="text-danger">*</span></label>
                                                                <select name="user_idEdit" class="form-control"
                                                                    id="userList<?= $val['id'] ?>">
                                                                    <option value="<?php echo $user_data['user_id'] ?>">
                                                                        <?php echo $user_data['name'] ?>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <lebel>Category</lebel>
                                                                <select class="form-control categoryEdit"
                                                                    id="<?= $val['id'] ?>" name="categoryEdit">
                                                                    <option value="">Select Category</option>
                                                                    <?php
                                                                    $category_fet = $obj->fetch("SELECT * FROM category");
                                                                    foreach ($category_fet as $cat_val) {
                                                                        $cat_id = $val['category'];
                                                                        ?>
                                                                        <option value="<?= $cat_val['id'] ?>" <?php echo ($cat_id === $cat_val['id']) ? 'selected' : ''; ?>>
                                                                            <?= $cat_val['name'] ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Product <span class="text-danger">*</span></label>
                                                                <select name="product_idEdit"
                                                                    class="form-control product-select"
                                                                    id="product_detEdit<?= $val['id'] ?>">
                                                                    <option
                                                                        value="<?= (strlen($pro_id) == 3) ? $pro_data['name'] : 'All Products' ?>">
                                                                        <?= (strlen($pro_id) == 3) ? $pro_data['name'] : 'All Products'; ?>
                                                                    </option>

                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Set Price</label>
                                                                <input class="form-control" type="text" name="set_priceEdit"
                                                                    id="set_price<?= $val['id'] ?>"
                                                                    value="<?= $val['set_price']; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Commission </label>
                                                                <select name="commissionEdit" id="commissionEdit"
                                                                    class="form-control">
                                                                    <option value="Agent" <?php echo ($val['commission'] == 'Manual') ? 'selected' : ''; ?>>Manual</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group price" id="pri_div">
                                                                <label>Price </label>
                                                                <input class="form-control" type="text" name="priceEdit"
                                                                    id="priceEdit" value="<?= $val['price']; ?>" />
                                                            </div>
                                                            <div class="form-group d-non" id="per_div">
                                                                <label>Percentage </label>
                                                                <input class="form-control" type="text"
                                                                    name="percentageEdit" id="percentageEdit"
                                                                    value="<?= $val['price']; ?>" />
                                                            </div>

                                                            <div class="submit-section">
                                                                <input class="form-control" type="hidden"
                                                                    name="individual_id" id="individual_id"
                                                                    value="<?= $val['id']; ?>" />
                                                                <button type="submit" name=""
                                                                    class="btn btn-primary submit-btn submit_edit"
                                                                    id="submit">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                            <div class="preview_edit<?php echo $cnt; ?> mt-3"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Menu Modal -->
                                        <script>
                                            $('#edit_individual<?php echo $cnt; ?>').on("submit", function (e) {
                                                e.preventDefault();
                                                console.log('Test');
                                                $.ajax({
                                                    url: "edit_individual.php",
                                                    type: "post",
                                                    data: new FormData(this),
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    beforeSend: function () {
                                                        $('.submit_edit').html('Processing...');
                                                    },
                                                    success: function (data) {
                                                        $('.submit_edit').html('Submit');
                                                        if (data == 'ok') {
                                                            $('.preview_edit<?php echo $cnt; ?>').html('<p class="alert alert-success">Successfully Saved</p>');
                                                            setTimeout(location.reload.bind(location), 1500);
                                                        } else {
                                                            $('.preview_edit<?php echo $cnt; ?>').html(data);
                                                        }
                                                    }
                                                });
                                            })
                                        </script>
                                        <!-- Delete Menu Modal -->
                                        <div class="modal custom-modal fade" id="delete_holiday<?php echo $cnt; ?>"
                                            role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Delete Individual Price</h3>
                                                            <p>Are you sure want to delete?</p>
                                                        </div>
                                                        <div class="modal-btn delete-action">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button class="btn btn-primary continue-btn"
                                                                        value="<?php echo $val['id']; ?>"
                                                                        id="dlt_btn<?php echo $val['id']; ?>"
                                                                        style="width: 100%;">Delete</button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="javascript:void(0);" data-dismiss="modal"
                                                                        class="btn btn-primary cancel-btn">Cancel</a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12" align="center"
                                                                    style="padding-top: 15px;"><span
                                                                        id="preview<?php echo $val['id']; ?>"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / End Delete Menu Modal -->
                                        <!-- Edit script Modal -->

                                        <!-- Delete Script Modal -->
                                        <script>
                                            $("#dlt_btn<?php echo $val['id']; ?>").click("submit", function () {
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
                                                        url: "delete_individual.php",
                                                        method: "POST",
                                                        data: {
                                                            dlt_btn: dlt_btn
                                                        },
                                                        success: function (data) {
                                                            //var result=JSON.parse(data);
                                                            //alert(data);
                                                            $("#preview<?php echo $val['id']; ?>").html(data);
                                                            //alert("success");
                                                            //location.reload();
                                                            setTimeout(function () {
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
                            <!-- Pagination Links -->
                            <div class="pagination mt-3">
                                <?php
                                // Number of page links to show before and after the current page
                                $range = 2;

                                // Start and End range for pagination links
                                $start = max(1, $current_page - $range);
                                $end = min($total_pages, $current_page + $range);

                                // Build the base URL for pagination links (preserving query parameters)
                                $base_url = '?';
                                if (!empty($field)) {
                                    $base_url .= 'field=' . urlencode($field) . '&';
                                }
                                if (!empty($search)) {
                                    $base_url .= 'search=' . urlencode($search) . '&';
                                }

                                // Previous Button
                                if ($current_page > 1) {
                                    echo '<a href="' . $base_url . 'page=' . ($current_page - 1) . '">Previous</a>';
                                }

                                // First Page
                                if ($start > 1) {
                                    echo '<a href="' . $base_url . 'page=1">1</a>';
                                    if ($start > 2) {
                                        echo '<span>...</span>'; // Ellipses
                                    }
                                }

                                // Page Number Links
                                for ($i = $start; $i <= $end; $i++) {
                                    if ($i == $current_page) {
                                        echo '<a class="active">' . $i . '</a>';
                                    } else {
                                        echo '<a href="' . $base_url . 'page=' . $i . '">' . $i . '</a>';
                                    }
                                }

                                // Last Page
                                if ($end < $total_pages) {
                                    if ($end < $total_pages - 1) {
                                        echo '<span>...</span>'; // Ellipses
                                    }
                                    echo '<a href="' . $base_url . 'page=' . $total_pages . '">' . $total_pages . '</a>';
                                }

                                // Next Button
                                if ($current_page < $total_pages) {
                                    echo '<a href="' . $base_url . 'page=' . ($current_page + 1) . '">Next</a>';
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Content -->

            <!-- Add Menu Modal -->
            <div class="modal custom-modal fade" id="add_holiday" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Set Individual Price</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="add_category">
                                <div class="form-group">
                                    <label>User Type <span class="text-danger">*</span></label>
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value="">Select User Type</option>
                                        <option value="Agent">Agent</option>
                                        <option value="Distributor">Distributor</option>
                                        <option value="Dealer">Dealer</option>
                                        <option value="Customer">Customer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>User List <span class="text-danger">*</span></label>
                                    <select name="user_id" class="form-control" id="user_id">
                                        <option value="">Select User</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <lebel>Category</lebel>
                                    <select class="form-control" id="catgor" name="category">
                                        <option value="">Select Category</option>
                                        <?php
                                        $category_fet = $obj->fetch("SELECT * FROM category");
                                        foreach ($category_fet as $cat_val) {
                                            ?>
                                            <option value="<?= $cat_val['id'] ?>"><?= $cat_val['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Product <span class="text-danger">*</span></label>
                                    <select name="product_id" class="form-control product-select" id="product_det">
                                        <option value="">Select Product</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Set Price</label>
                                    <input class="form-control" type="text" name="set_price" id="set_price2" />
                                </div>
                                <div class="form-group">
                                    <label>Commission </label>
                                    <select name="commission" id="commission" class="form-control">
                                        <option value="Manual">Manual</option>
                                    </select>
                                </div>
                                <div class="form-group price" id="pri_div">
                                    <label>Price </label>
                                    <input class="form-control" type="text" name="price" id="set_price" />
                                </div>
                                <div class="form-group d-non" id="per_div">
                                    <label>Percentage </label>
                                    <input class="form-control" type="text" name="percentage" id="percentage" />
                                </div>

                                <div class="submit-section">
                                    <button type="submit" name="" class="btn btn-primary submit-btn" id="submit">
                                        Submit
                                    </button>
                                </div>
                                <div class="preview mt-3"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Menu Modal -->
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
<script>
    $('#add_category').on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "add-individual.php",
            type: "post",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#submit').html('Processing...');
            },
            success: function (data) {
                $('#submit').html('Submit');
                if (data == 'ok') {
                    $('.preview').html('<p class="alert alert-success">Successfully Saved</p>');
                    setTimeout(location.reload.bind(location), 1500);
                } else {
                    $('.preview').html(data);
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $("#edit_file").on("change", function (e) {
        e.preventDefault();
        var src = URL.createObjectURL(event.target.files[0]);
        //alert(src);
        $(".image").prop("src", src);
    });
</script>

<script>
    $('#user_type').on("change", function () {
        let user_type = $('#user_type').val();
        $.ajax({
            url: "fetch-user.php",
            type: "post",
            data: { user_type: user_type },
            success: function (data) {
                $('#user_id').html(data);
            }
        })
    })
</script>
<script>
    $('#commission').on("change", function () {
        let commission = $('#commission').val();
        if (commission == 'Manual') {
            $('#pri_div').show();
            $('#per_div').hide();
        }
        else if (commission == 'Percentage') {
            $('#pri_div').hide();
            $('#per_div').show();
        }
    });
</script>
<script>
    $(document).ready(function () {
        var table = $('#menu-load').DataTable({
            "searching": true // Enable searching
        });

        // Search functionality
        $('#myInput').on('keyup', function () {
            table.search(this.value).draw(); // Perform search on DataTable
        });
    });
</script>
<script>
    $('#catgor').on("change", function () {
        var category = $(this).val();
        if (!category) {
            $('#product_det').html('<option value="">Select Product</option>');
        } else {
            $.ajax({
                url: "fetch-product.php",
                type: "post",
                data: { category: category },
                success: function (data) {
                    $('#product_det').html(data);
                    console.log(data);
                }
            })
        }
    });
</script>
<script>
    $(document).on("change", ".product-select", function () {
        let selectedOption = $(this).find(":selected");
        let price = selectedOption.data("price");

        $("#set_price2").val(price);

        let id = $(this).attr('id');
        let matches = id.match(/\d+/g);
        id = matches ? matches[matches.length - 1] : null;
        $("#set_price" + id).val(price);

        // if(selectedOption.val()=='allProduct'){
        //     $("#set_price2").attr('disabled','disabled');
        // }else{
        //     $("#set_price2").attr('disabled','disabled');
        // }

    });

    $('.user_typeEdit').on("change", function () {
        let editID = $(this).attr('id');
        let user_type_edit = $(this).val();
        $.ajax({
            url: "fetch-user.php",
            type: "post",
            data: { user_type: user_type_edit },
            success: function (data) {
                $('#userList' + editID).html(data);
            }
        })
    })
</script>
<script>
    $('.categoryEdit').on("change", function () {
        let catEditID = $(this).attr('id');
        var category = $(this).val();
        if (!category) {
            $('#product_det').html('<option value="">Select Product</option>');
        } else {
            $.ajax({
                url: "fetch-product.php",
                type: "post",
                data: { category: category },
                success: function (data) {
                    $('#product_detEdit' + catEditID).html(data);
                }
            })
        }
    });
</script>