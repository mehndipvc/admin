<?php
session_start();
if (!empty($_SESSION['username'])) {
    echo '<script>window.location.href="dashboard.php"</script>';
}
?>
<!DOCTYPE html>
<html>
<?php
//header link
include("header_link.php");
?>

<body>

    <?php
    //database file link
    include("config.php");
    ?>
    <div class="account-page">
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <div class="account-content">
                <div class="container">

                    <!-- Account Logo -->

                    <!-- /Account Logo -->

                    <div class="account-box">
                        <div class="account-wrapper">
                            <div class="account-logo" style="width: 368px;">
                                <a href="#"><img src="images/logo/logo.png" alt=""
                                        style="width: 100%;padding-left: 50px;"></a>
                            </div>
                            <h3 class="account-title">Login</h3>
                            <p class="account-subtitle">Access to our dashboard</p>

                            <!-- Account Form -->
                            <form id="login">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" type="text" name="username">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label>Password</label>
                                        </div>
                                    </div>
                                    <input class="form-control" type="password" name="password">
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary account-btn" type="submit">Login</button>
                                </div>
                            </form>
                            <!-- /Account Form -->
                            <div class="statusMsg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Wrapper -->
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
<script type="text/javascript">
    $(document).ready(function (e) {
        // Submit form data via Ajax
        $("#login").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "verify.php",
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
                    // setTimeout(function () {
                    //     $("#doctor").load("doctor-list.php #doctor");
                    //     $("#fupForm").load("doctor-list.php #fupForm");
                    // }, 1000);

                },
            });
        });
    });
</script>

</html>