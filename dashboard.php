<?php
session_start();
if (empty($_SESSION['username'])) {
	echo '<script>window.location.href="login.php"</script>';
}
?>
<?php include("config.php"); ?>
<!DOCTYPE html>
<html>
<?php include("header_link.php"); ?>

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
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title">Welcome <?php echo $_SESSION['username']; ?>!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">Dashboard</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="row">
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-file-text-o"></i></span>
								<div class="dash-widget-info">
									<?php
									require_once("config.php");
									$sel_cat = $obj->num("SELECT * FROM `category`");
									?>
									<h3><?php echo $sel_cat; ?></h3>
									<span>Category</span>
								</div>
							</div>
							<a href="category" class="top_box_link"></a>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-shopping-cart"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_item = $obj->num("SELECT * FROM `items`");
									?>
									<h3><?php echo $sel_item; ?></h3>
									<span>Products</span>
								</div>
							</div>
							<a href="product" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-user"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_user = $obj->num("SELECT * FROM `users`");
									?>
									<h3><?php echo $sel_user; ?></h3>
									<span>Users</span>
								</div>
							</div>
							<a href="user-list" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-history"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_order = $obj->num("SELECT * FROM `orders`");
									?>
									<h3><?php echo $sel_order; ?></h3>
									<span>Orders</span>
								</div>
							</div>
							<a href="order" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-user"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_agent = $obj->num("SELECT id FROM `users` WHERE user_type='Agent'");
									?>
									<h3><?php echo $sel_agent; ?></h3>
									<span>Agent</span>
								</div>
							</div>
							<a href="user-list.php?type=Agent" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-truck"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_order = $obj->num("SELECT * FROM `users` WHERE user_type='CNF'");
									?>
									<h3><?php echo $sel_order; ?></h3>
									<span>CNF</span>
								</div>
							</div>
							<a href="user-list.php?type=CNF" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-industry"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_distributor = $obj->num("SELECT * FROM `users` WHERE user_type='Distributor'");
									?>
									<h3><?php echo $sel_distributor; ?></h3>
									<span>Distributor</span>
								</div>
							</div>
							<a href="user-list.php?type=Distributor" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-handshake-o"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_order = $obj->num("SELECT * FROM `orders`");
									?>
									<h3><?php echo $sel_order; ?></h3>
									<span>Dealer</span>
								</div>
							</div>
							<a href="order.php?type=Dealer" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-user"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_cust = $obj->num("SELECT * FROM `users` WHERE user_type='Customer'");
									?>
									<h3><?php echo $sel_cust; ?></h3>
									<span>Customer</span>
								</div>
							</div>
							<a href="user-list.php?type=Customer" class="top_box_link"></a>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-picture-o"></i>
								</span>
								<div class="dash-widget-info">
									<?php
									$sel_picture = $obj->num("SELECT id FROM `items_images`");
									?>
									<h3><?php echo $sel_picture; ?></h3>
									<span>Picture Gallery</span>
								</div>
							</div>
							<a href="gallery" class="top_box_link"></a>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
	<?php
	//footer link
	include("footer_link.php");

	?>
</body>

</html>