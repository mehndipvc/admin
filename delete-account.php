<html><head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Mehndi Profile | Admin</title>
        <link rel="icon" type="image/png" href="">
        <!--<link rel="shortcut icon" type="image/x-icon" href="">-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/line-awesome.min.css">
        <link rel="stylesheet" href="css/morris.css">
        <link rel="stylesheet" href="css/fullcalendar.min.css">
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="css/select2.min.css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    </head>
       <body>
        
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
                <a href="#"><img src="images/logo/logo.png" alt="" style="width: 100%;padding-left: 50px;"></a>
            </div>
                    <h3 class="account-title">Delete Account</h3>
                    <p class="account-subtitle">Delete your account</p>
                    
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
                            <button class="btn btn-primary account-btn" type="submit">Delete</button>
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
        
        
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
                <script src="js/jquery.slimscroll.min.js"></script>
        <script src="js/select2.min.js"></script>
                <script src="js/raphael.min.js"></script>
        <!-- Datetimepicker JS -->
                <script src="js/moment.min.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <!-- Calendar JS -->
                <script src="js/jquery-ui.min.js"></script>
        <script src="js/fullcalendar.min.js"></script>
        <script src="js/jquery.fullcalendar.js"></script>
        <script src="js/app.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $('#image-slider').slick({
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                ]
            });
        });
        
    </script>    
    <script type="text/javascript">
    $(document).ready(function (e) {
        // Submit form data via Ajax
        $("#login").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "delete-account-req.php",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('.account-btn').html("Processing...");
                },
                success: function (data) {
                   $('.account-btn').html("Delete");
                    
                    if(data==200){
                        $(".statusMsg").html('<p class="alert alert-success">We Have Received Your Account Deletion Request</p>');
                        setTimeout(location.reload.bind(location),1500);
                    }else{
                        $(".statusMsg").html(data);
                    }
                    
                    // setTimeout(function () {
                    //     $("#doctor").load("doctor-list.php #doctor");
                    //     $("#fupForm").load("doctor-list.php #fupForm");
                    // }, 1000);
                  
                },
            });
        });
    });
</script>
<div class="sidebar-overlay"></div></body></html>