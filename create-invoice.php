<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
?>
<?php include("config.php");?>
<!DOCTYPE html>
<html>
<?php include("header_link.php"); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <?php include("header.php"); ?>
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Billing List</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Billing List</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="create-invoice" class="btn add-btn"><i class="fa fa-plus"></i> Create Bill</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <div class="row">
                    <div class="col-md-12">
                        <form action="create-invoice-form.php" method="post">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label>Receiver Name <sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="text" name="name" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Email ID <sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="email" name="email" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Mobile <sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="number" name="mobile" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Billing Date<sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="date" name="date" id="" class="form-control"
                                            value="<?php echo date("Y-m-d") ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Billing Address<sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="text" name="bill_adrs" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>GSTIN/UIN</label>
                                    <div class="form-group">
                                        <input type="text" name="gstin" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Delivery Note</label>
                                    <div class="form-group">
                                        <input type="text" name="del_note" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Ref. No. & Date</label>
                                    <div class="form-group">
                                        <input type="text" name="ref_no" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Other References</label>
                                    <div class="form-group">
                                        <input type="text" name="other_ref" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Buyer’s Order No.</label>
                                    <div class="form-group">
                                        <input type="text" name="buy_ref" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Dated</label>
                                    <div class="form-group">
                                        <input type="date" name="dated" id="" class="form-control"
                                            value="<?php echo date("Y-m-d") ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Dispatch Doc No.</label>
                                    <div class="form-group">
                                        <input type="text" name="disp_no" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Delivery Note Date</label>
                                    <div class="form-group">
                                        <input type="text" name="del_note_no" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Dispatched through</label>
                                    <div class="form-group">
                                        <input type="text" name="dis_through" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Destination</label>
                                    <div class="form-group">
                                        <input type="text" name="destination" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Vessel/Flight No.</label>
                                    <div class="form-group">
                                        <input type="text" name="flight_no" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Recpt. by shipper</label>
                                    <div class="form-group">
                                        <input type="text" name="rec_shipper" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>City/Port of Loading</label>
                                    <div class="form-group">
                                        <input type="text" name="port_land" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>City/Port of Dis.</label>
                                    <div class="form-group">
                                        <input type="text" name="port_disch" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Terms of Delivery</label>
                                    <div class="form-group">
                                        <input type="text" name="terms_del" id="" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12 table-box">
                                    <!-- <table class="table table-stripted table-bordered" id="cr_tb"> -->
                                    <table style="height:150px;width:100%;border:1px solid black"
                                        class="table-bordered table-stripted" id="cr_tb">
                                        <thead>
                                            <tr style="height:50px">
                                                <th>Sl</th>
                                                <th>Description of Goods</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th colspan="2">Discount</th>
                                                <th colspan="2">CGST(%)</th>
                                                <th colspan="2">SGST(%)</th>
                                                <th colspan="2">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Rate</td>
                                                <td>Amt</td>
                                                <td>Rate</td>
                                                <td>Amt</td>
                                                <td>Rate</td>
                                                <td>Amt</td>
                                                <td>Amt</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td><input type="text" name="service[]"></td>
                                                <td><input type="text" style="width: 50px;" id="item1" name="item[]"
                                                        class="calculate"></td>
                                                <td><input type="text" style="width: 100px;" id="price1" name="price[]"
                                                        class="calculate"></td>
                                                <td><input type="text" style="width: 50px;" id="dis_rate1"
                                                        name="dis_rate[]" class="calculate"></td>
                                                <td><input type="text" style="width: 80px;" id="dis_amt1"
                                                        name="dis_amt[]" class="calculate" readonly></td>
                                                <td><input type="text" style="width: 50px;" id="cgst_rate1"
                                                        name="cgst_rate[]" class="calculate"></td>
                                                <td><input type="text" style="width: 80px;" id="cgst_amt1"
                                                        name="cgst_amt[]" class="calculate" readonly></td>
                                                <td><input type="text" style="width: 50px;" id="sgst_rate1"
                                                        name="sgst_rate[]" class="calculate"></td>
                                                <td><input type="text" style="width: 80px;" id="sgst_amt1"
                                                        name="sgst_amt[]" class="calculate" readonly></td>
                                                <td><input type="text" style="width: 100px;" id="total1" name="total[]"
                                                        readonly></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12">
                                    <div class="text-right pr-18">
                                        <b class="text-right">Total Amount: </b><span id="final_amt"
                                            name="final_amt"></span>
                                    </div>
                                    <div class="text-center pt-10">
                                        <input type="hidden" name="total_count" id="total_count" value="1">
                                        <button type="reset" class="btn btn-danger"><i
                                                class="fa fa-refresh"></i></button>
                                        <button class="btn btn-primary" id="createBtn">Submit</button>
                                        <a href="javascript:void(0)" class="btn btn-warning" id="add_row">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-12 msg"></div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include("footer_link.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $('.summernote').summernote();
    </script>
    <script>
        $(document).ready(function () {
            let count = $('#total_count').val();
            $('#add_row').on("click", function () {
                count++;
                let html_code = '';
                html_code += '<tr id="ro' + count + '">';
                html_code += '<td>' + count + '</td>';
                html_code += '<td><input type="text" name="service[]"></td>';
                html_code += '<td><input type="text" style="width: 50px;" id="item' + count + '" name="item[]" class="calculate"></td>';
                html_code += '<td><input type="text" style="width: 100px;" id="price' + count + '" name="price[]" class="calculate"></td>';
                html_code += '<td><input type="text" style="width: 50px;" id="dis_rate' + count + '" name="dis_rate[]" class="calculate"></td>';
                html_code += '<td><input type="text" style="width: 80px;"  id="dis_amt' + count + '" name="dis_amt[]" class="calculate" readonly></td>';
                html_code += '<td><input type="text" style="width: 50px;" id="cgst_rate' + count + '" name="cgst_rate[]" class="calculate"></td>';
                html_code += '<td><input type="text" style="width: 80px;" id="cgst_amt' + count + '"  name="cgst_amt[]" class="calculate" readonly></td>';
                html_code += '<td><input type="text" style="width: 50px;" id="sgst_rate' + count + '" name="sgst_rate[]" class="calculate"></td>';
                html_code += '<td><input type="text" style="width: 80px;" id="sgst_amt' + count + '" name="sgst_amt[]" class="calculate" readonly></td>';
                html_code += '<td><input type="text" style="width: 100px;" id="total' + count + '" name="total[]" class="calculate" readonly></td>';
                html_code += '<td><button class="btn btn-danger remove_row" id="' + count + '"><i class="fa fa-times"></i></button></td>';
                html_code += '</tr>';
                $('#total_count').val(count);
                $('#cr_tb tbody').append(html_code);
            });
            $(document).on('click', '.remove_row', function () {
                let row_id = $(this).attr("id");
                let total_amt_rm = $('#total' + row_id).val();
                let final_amt_rm = $('#final_amt').text();
                let result = parseInt(final_amt_rm) - parseInt(total_amt_rm);
                $('#final_amt').val(result);
                $('#ro' + row_id).remove();
                count--;
                $('#total_count').val(count);
            });

            function call_final_total(count) {
                let final_amt = 0;
                for (let i = 0; i <= count; i++) {
                    let item = 0;
                    let price = 0;
                    let dis_rate = 0;
                    let dis_amt = 0;
                    let cgst_rate = 0;
                    let cgst_amt = 0;
                    let sgst_rate = 0;
                    let sgst_amt = 0;
                    let total = 0;
                    let actual_amt = 0;
                    let item_total_amt = 0;
                    let all_total_amt = 0;

                    item = $('#item' + i).val();
                    if (item > 0) {
                        price = $('#price' + i).val();
                        if (price > 0) {
                            actual_amt = parseInt(price) * parseInt(item);
                            $('#total' + i).val(actual_amt);
                            dis_rate = $('#dis_rate' + i).val();
                            if (dis_rate > 0) {
                                dis_amt = parseInt(actual_amt) * parseInt(dis_rate) / 100;
                                $('#dis_amt' + i).val(dis_amt);
                            } else {
                                $('#dis_amt' + i).val('');
                            }
                            item_total_amt = parseInt(actual_amt) - parseInt(dis_amt);

                            cgst_rate = $('#cgst_rate' + i).val();
                            if (cgst_rate > 0) {
                                cgst_amt = parseInt(item_total_amt) * parseInt(cgst_rate) / 100;
                                $('#cgst_amt' + i).val(cgst_amt);
                            } else {
                                $('#cgst_amt' + i).val('');
                            }

                            sgst_rate = $('#sgst_rate' + i).val();
                            if (sgst_rate > 0) {
                                sgst_amt = parseInt(item_total_amt) * parseInt(sgst_rate) / 100;
                                $('#sgst_amt' + i).val(sgst_amt);
                            } else {
                                $('#sgst_amt' + i).val('');
                            }

                            all_total_amt = parseInt(item_total_amt) + parseInt(cgst_amt) + parseInt(sgst_amt);
                            final_amt = parseInt(final_amt) + parseInt(all_total_amt);
                            $('#total' + i).val(all_total_amt);
                        }
                    }
                }
                $('#final_amt').text(final_amt);

            }
            $(document).on('keyup', '.calculate', function () {
                call_final_total(count);
            });
        });
    </script>
    <script>
        $('#create-bill').on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                url: "create-invoice-form.php",
                type: "post",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#createBtn').html('Processing');
                },
                success: function (data) {
                    $('#createBtn').html('Submit');
                    $('.msg').html(data);
                    $(".alert").delay(3500).fadeOut();
                }

            })
        });
    </script>
</body>

</html>