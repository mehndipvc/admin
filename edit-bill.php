<?php
session_start();
if (empty($_SESSION['username'])) {
    echo '<script>window.location.href="login"</script>';
}
?>
<!DOCTYPE html>
<html>
<?php include("header_link.php"); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<body>
    <?php include("header.php"); ?>
    <?php
    require_once("config.php");
    if (!empty($_GET['id'])) 
    {
        $id = base64_decode($_GET['id']);
        $data = $obj->arr("SELECT * FROM billing WHERE id='$id'");
        if(!empty($data['invo_no'])) 
        {
            $invo_no = $data['invo_no'];
            $dtls_qr = $obj->fetch("SELECT * FROM billing_details WHERE bill_id = '$invo_no'");
        } 
        else 
        {
            echo '<script>window.location.href="billing"</script>';
        }
    } 
    else 
    {
        echo '<script>window.location.href="billing"</script>';
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
                            <h3 class="page-title">Billing</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="invoice">Back</a></li>
                                <li class="breadcrumb-item active">Update Billing</li>
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
                        <form id="edit-bill">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label>Receiver Name <sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="text" name="name" id="" class="form-control" value="<?= $data['name'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Email ID <sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="email" name="email" id="" class="form-control" value="<?= $data['email'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Mobile <sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="number" name="mobile" id="" class="form-control" value="<?= $data['mobile'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Billing Date<sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="date" name="date" id="" class="form-control" value="<?= $data['date'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Billing Address<sup>*</sup></label>
                                    <div class="form-group">
                                        <input type="text" name="bill_adrs" id="" class="form-control" value="<?= $data['bill_adrs'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>GSTIN/UIN</label>
                                    <div class="form-group">
                                        <input type="text" name="gstin" id="" class="form-control" value="<?= $data['gstin'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Delivery Note</label>
                                    <div class="form-group">
                                        <input type="text" name="del_note" id="" class="form-control" value="<?= $data['del_note'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Ref. No. & Date</label>
                                    <div class="form-group">
                                        <input type="text" name="ref_no" id="" class="form-control" value="<?= $data['ref_no'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Other References</label>
                                    <div class="form-group">
                                        <input type="text" name="other_ref" id="" class="form-control" value="<?= $data['other_ref'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Buyer’s Order No.</label>
                                    <div class="form-group">
                                        <input type="text" name="buy_ref" id="" class="form-control" value="<?= $data['buy_ref'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Dated</label>
                                    <div class="form-group">
                                        <input type="date" name="dated" id="" class="form-control" value="<?= $data['dated'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Dispatch Doc No.</label>
                                    <div class="form-group">
                                        <input type="text" name="disp_no" id="" class="form-control" value="<?= $data['disp_no'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Delivery Note Date</label>
                                    <div class="form-group">
                                        <input type="text" name="del_note_no" id="" class="form-control" value="<?= $data['del_note_no'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Dispatched through</label>
                                    <div class="form-group">
                                        <input type="text" name="dis_through" id="" class="form-control" value="<?= $data['dis_through'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Destination</label>
                                    <div class="form-group">
                                        <input type="text" name="destination" id="" class="form-control" value="<?= $data['destination'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Vessel/Flight No.</label>
                                    <div class="form-group">
                                        <input type="text" name="flight_no" id="" class="form-control" value="<?= $data['flight_no'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Recpt. by shipper</label>
                                    <div class="form-group">
                                        <input type="text" name="rec_shipper" id="" class="form-control" value="<?= $data['rec_shipper'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>City/Port of Loading</label>
                                    <div class="form-group">
                                        <input type="text" name="port_land" id="" class="form-control" value="<?= $data['port_land'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>City/Port of Dis.</label>
                                    <div class="form-group">
                                        <input type="text" name="port_disch" id="" class="form-control" value="<?= $data['port_disch'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>Terms of Delivery</label>
                                    <div class="form-group">
                                        <input type="text" name="terms_del" id="" class="form-control" value="<?= $data['terms_del'] ?>">
                                        <input type="hidden" name="invo_no" id="invo_no" class="form-control" value="<?= $data['invo_no']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 table-box">
                                    <!-- <table class="table table-stripted table-bordered" id="cr_tb"> -->
                                    <table style="height:150px;width:100%;border:1px solid black" class="table-bordered table-stripted" id="cr_tb">
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
                                            <?php
                                            $cnt = 0;
                                            foreach ($dtls_qr as $val) 
                                            {
                                                $cnt++;
                                            ?>
                                            <tr id="row_cnt<?=$cnt?>">
                                                <td><?= $cnt?></td>
                                                <td><input type="text" name="service[]" value="<?= $val['service'] ?>"></td>
                                                <td><input type="text" style="width: 50px;" id="item<?=$cnt?>" name="item[]" class="calculate" value="<?= $val['item'] ?>"></td>
                                                <td><input type="text" style="width: 100px;" id="price<?=$cnt?>" name="price[]" class="calculate" value="<?= $val['price'] ?>"></td>
                                                <td><input type="text" style="width: 50px;" id="dis_rate<?=$cnt?>" name="dis_rate[]" class="calculate" value="<?= $val['dis_rate'] ?>"></td>
                                                <td><input type="text" style="width: 80px;" id="dis_amt<?=$cnt?>" name="dis_amt[]" class="calculate" readonly value="<?= $val['dis_amt'] ?>"></td>
                                                <td><input type="text" style="width: 50px;" id="cgst_rate<?=$cnt?>" name="cgst_rate[]" class="calculate" value="<?= $val['cgst_rate'] ?>"></td>
                                                <td><input type="text" style="width: 80px;" id="cgst_amt<?=$cnt?>" name="cgst_amt[]" class="calculate" readonly value="<?= $val['cgst_amt'] ?>"></td>
                                                <td><input type="text" style="width: 50px;" id="sgst_rate<?=$cnt?>" name="sgst_rate[]" class="calculate" value="<?= $val['sgst_rate'] ?>"></td>
                                                <td><input type="text" style="width: 80px;" id="sgst_amt<?=$cnt?>" name="sgst_amt[]" class="calculate" readonly value="<?= $val['sgst_amt'] ?>"></td>
                                                <td><input type="text" style="width: 100px;" id="total<?=$cnt?>" name="total[]" readonly value="<?= $val['total'] ?>"></td>
                                                <td><input type="hidden" value="<?= $val['id'] ?>" name="bill_dtl_id[]"></td>
                                                <td><button class="btn btn-danger" id="remove_row<?=$cnt?>"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                            <script>
                                                $(document).on('click', '#remove_row<?=$cnt?>', function() {
                                                        let row_id = $(this).attr("id");
                                                        let total_amt_rm = $('#total' + row_id).val();
                                                        let final_amt_rm = $('#final_amt').text();
                                                        let result = parseInt(final_amt_rm) - parseInt(total_amt_rm);
                                                        $('#final_amt').val(result);
                                                        $('#row_cnt<?=$cnt?>').remove();
                                                        cnt--;
                                                        $('#total_count').val(cnt);
                                                    });
                                            </script>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12">
                                    <div class="text-right pr-18">
                                        <b class="text-right">Total Amount: </b><span id="final_amt"><?= $data['final_amt']?></span>
                                    </div>
                                    <div class="text-center pt-10">
                                        <input type="hidden" value="<?= $data['invo_no'] ?>" name="invo_no">
                                        <input type="hidden" value="<?= $data['id'] ?>" name="old_id">
                                        <input type="hidden" name="total_count" id="total_count" value="<?= $cnt ?>">
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i></button>
                                        <button class="btn btn-primary" id="edit-btn">Submit</button>
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
        $(document).ready(function() {
            let count = $('#total_count').val();
            $('#add_row').on("click", function() {
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
            $(document).on('click', '.remove_row', function() {
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
                                $('#sgst_amt' + i).val(sgst_rate);
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
            $(document).on('keyup', '.calculate', function() {
                call_final_total(count);
            });
        });
    </script>

    <script>
        $('#edit-bill').on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: "edit-invoice-form.php",
                type: "post",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#edit-btn').html('Processing');
                },
                success: function(data) {
                    $('#edit-btn').html('<i class="fa fa-floppy-oz"></i> Save');
                    $('.msg').html(data);
                    $(".alert").delay(3500).fadeOut();
                }

            })
        });
    </script>
</body>
</html>