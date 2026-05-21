<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=mysqli_query($con,$sql_p);
		if(mysqli_num_rows($query_p)!=0){
			$row_p=mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
		
		}else{
			$message="Product ID is invalid";
		}
	}
		echo "<script>alert('Product has been added to the cart')</script>";
		echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
}


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">

	    <title>Leo's Parts Shop & Accessories</title>

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/blue.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<!-- Font Awesome 6 CDN -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

		<style>
    .container {
        width: 90% !important;
        margin: auto;
    }
</style>
		

		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">

	</head>
    <body class="cnt-home">
	
		
	
		<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>
</header>

<!-- ============================================== HEADER : END ============================================== -->
<div class="body-content outer-top-xs" id="top-banner-and-menu">
	<div class="container">
		<div class="furniture-container homepage-container">
		<div class="row">
		
			<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
				<!-- ================================== TOP NAVIGATION ================================== -->
	<?php include('includes/side-menu.php');?>
<!-- ================================== TOP NAVIGATION : END ================================== -->
			</div><!-- /.sidemenu-holder -->	
			
			<div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
				<!-- ========================================== SECTION – HERO ========================================= -->
			
<div id="hero" class="homepage-slider3">
	<div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
		<div class="full-width-slider">	
			<div class="item" style="background-image: url(assets/images/sliders/parts1.jpg);">
				<!-- /.container-fluid -->
			</div><!-- /.item -->
		</div><!-- /.full-width-slider -->
	    
	    <div class="full-width-slider">
			<div class="item full-width-slider" style="background-image: url(assets/images/sliders/logo1.webp);">
			</div><!-- /.item -->
		</div><!-- /.full-width-slider -->






	</div><!-- /.owl-carousel -->
</div>
<br></br>
			
<!-- ========================================= SECTION – HERO : END ========================================= -->	
				<!-- ============================================== INFO BOXES ============================================== -->

<div class="info-boxes wow fadeInUp">
	<div class="info-boxes-inner">
		<div class="row">
			<div class="col-md-3 col-sm-4 col-lg-4">
				<div class="info-box">
					<div class="row">
						<div class="col-xs-2">
						     <i class="icon fa fa-peso-sign"></i>
						</div>
						<div class="col-xs-10">
							<h4 class="info-box-heading green">money back</h4>
						</div>
					</div>	
					<h6 class="text">30 Day Money Back Guarantee.</h6>
				</div>
			</div><!-- .col -->

			<div class="hidden-md col-sm-4 col-lg-4">
				<div class="info-box">
					<div class="row">
						<div class="col-xs-2">
							<i class="icon fa fa-truck"></i>
						</div>
						<div class="col-xs-10">
							<h4 class="info-box-heading green">free shipping</h4>
						</div>
					</div>
					<h6 class="text">free ship-on oder</h6>	
				</div>
			</div><!-- .col -->

			<div class="col-md-6 col-sm-4 col-lg-4">
				<div class="info-box">
					<div class="row">
						<div class="col-xs-2">
							<i class="icon fa fa-gift"></i>
						</div>
						<div class="col-xs-10">
							<h4 class="info-box-heading green">Special Sale</h4>
						</div>
					</div>
					<h6 class="text">items-sale up to 20% off </h6>	
				</div>
			</div><!-- .col -->
		</div><!-- /.row -->
	</div><!-- /.info-boxes-inner -->
	
</div><!-- /.info-boxes -->
<!-- ============================================== INFO BOXES : END ============================================== -->		
			</div><!-- /.homebanner-holder -->
			
		</div><!-- /.row -->
		<br></br>	

		<!-- ============================================== SCROLL TABS ============================================== -->
		<div id="product-tabs-slider" class="scroll-tabs inner-bottom-vs  wow fadeInUp">
    <div class="more-info-tab clearfix">
        <h3 class="new-product-title pull-left">Featured Items</h3>
    </div>

    <div class="tab-content outer-top-xs">

        <!-- FEATURED ITEMS -->
        <div class="tab-pane in active" id="all">            
            <div class="product-grid">
                <div class="row">
                    <?php
                    $ret=mysqli_query($con,"select * from products limit 25"); // only 25 products (5x5)
                    $count = 0;
                    while ($row=mysqli_fetch_array($ret)) {
                        ?>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <div class="products">
                                <div class="product">       
                                    <div class="product-image">
                                        <div class="image">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" 
                                                     width="180" height="180" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="product-info text-left">
                                        <h3 class="name">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <?php echo htmlentities($row['productName']);?>
                                            </a>
                                        </h3>
                                        <div class="rating rateit-small"></div>
                                        <div class="product-price">  
                                            <span class="price">₱ <?php echo htmlentities($row['productPrice']);?></span>
                                            <span class="price-before-discount">₱ <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                                        </div>
                                    </div>

                                    <?php if($row['productAvailability']=='In Stock'){ ?>
                                        <div class="action">
                                            <a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" 
                                               class="lnk btn btn-primary">Add to Cart</a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="action" style="color:red">OUT OF STOCK</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $count++;
                        if($count % 6 == 0){ echo '</div><div class="row">'; } // new row every 5 items
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- BOOKS -->
        <div class="tab-pane" id="books">
            <div class="product-grid">
                <div class="row">
                    <?php
                    $ret=mysqli_query($con,"select * from products where category=3 limit 25");
                    $count = 0;
                    while ($row=mysqli_fetch_array($ret)) {
                        ?>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <div class="products">
                                <div class="product">       
                                    <div class="product-image">
                                        <div class="image">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" 
                                                     width="180" height="300" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="product-info text-left">
                                        <h3 class="name">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <?php echo htmlentities($row['productName']);?>
                                            </a>
                                        </h3>
                                        <div class="rating rateit-small"></div>
                                        <div class="product-price">  
                                            <span class="price">₱ <?php echo htmlentities($row['productPrice']);?></span>
                                            <span class="price-before-discount">₱ <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                                        </div>
                                    </div>

                                    <?php if($row['productAvailability']=='In Stock'){ ?>
                                        <div class="action">
                                            <a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" 
                                               class="lnk btn btn-primary">Add to Cart</a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="action" style="color:red">OUT OF STOCK</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $count++;
                        if($count % 5 == 0){ echo '</div><div class="row">'; }
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- FURNITURE -->
        <div class="tab-pane" id="furniture">
            <div class="product-grid">
                <div class="row">
                    <?php
                    $ret=mysqli_query($con,"select * from products where category=5 limit 25");
                    $count = 0;
                    while ($row=mysqli_fetch_array($ret)) {
                        ?>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <div class="products">
                                <div class="product">       
                                    <div class="product-image">
                                        <div class="image">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" 
                                                     width="180" height="300" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="product-info text-left">
                                        <h3 class="name">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <?php echo htmlentities($row['productName']);?>
                                            </a>
                                        </h3>
                                        <div class="rating rateit-small"></div>
                                        <div class="product-price">  
                                            <span class="price">₱ <?php echo htmlentities($row['productPrice']);?></span>
                                            <span class="price-before-discount">₱ <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                                        </div>
                                    </div>

                                    <?php if($row['productAvailability']=='In Stock'){ ?>
                                        <div class="action">
                                            <a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" 
                                               class="lnk btn btn-primary">Add to Cart</a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="action" style="color:red">OUT OF STOCK</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $count++;
                        if($count % 5 == 0){ echo '</div><div class="row">'; }
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

		    

         <!-- ============================================== TABS ============================================== -->
			<div class="sections prod-slider-small outer-top-small">
				<div class="row">
					<div class="col-md-12.5">
	                   <section class="section">
	                   	<h3 class="section-title">MOTORCYCLE PARTS</h3>
	                   	<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme" data-item="5">
	   
<?php
$ret=mysqli_query($con,"select * from products where category=7");
while ($row=mysqli_fetch_array($ret)) 
{
?>



		<div class="item item-carousel">
			<div class="products">
				
	<div class="product">		
		<div class="product-image">
			<div class="image">
				<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><img  src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>"  width="180" height="200"></a>
			</div><!-- /.image -->			                        		   
		</div><!-- /.product-image -->
			
		
		<div class="product-info text-left">
			<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
			<div class="rating rateit-small"></div>
			<div class="description"></div>

			<div class="product-price">	
				<span class="price">
					₱ <?php echo htmlentities($row['productPrice']);?>			</span>
										     <span class="price-before-discount">₱ <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
									
			</div>
			
		</div>
				<?php if($row['productAvailability']=='In Stock'){?>
					<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add to Cart</a></div>
				<?php } else {?>
						<div class="action" style="color:red">OUT OF STOCK</div>
					<?php } ?>
			</div>
			</div>
		</div>
<?php }?>

		
	
				                   	</div>
	                   </section>

					</div>
				</div>
			</div>

		<!-- ============================================== TABS : END ============================================== -->

		<div class="sections prod-slider-small outer-top-small">
				<div class="row">
					<div class="col-md-12.5">
	                   <section class="section">
	                   	<h3 class="section-title">MOTORCYCLE ACCESSORIES</h3>
	                   	<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme" data-item="5">
	   
<?php
$ret=mysqli_query($con,"select * from products where category=8");
while ($row=mysqli_fetch_array($ret)) 
{
?>



		<div class="item item-carousel">
			<div class="products">
				
	<div class="product">		
		<div class="product-image">
			<div class="image">
				<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><img  src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>"  width="180" height="200"></a>
			</div><!-- /.image -->			                        		   
		</div><!-- /.product-image -->
			
		
		<div class="product-info text-left">
			<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
			<div class="rating rateit-small"></div>
			<div class="description"></div>

			<div class="product-price">	
				<span class="price">
					₱ <?php echo htmlentities($row['productPrice']);?>			</span>
										     <span class="price-before-discount">₱ <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
									
			</div>
			
		</div>
				<?php if($row['productAvailability']=='In Stock'){?>
					<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add to Cart</a></div>
				<?php } else {?>
						<div class="action" style="color:red">OUT OF STOCK</div>
					<?php } ?>
			</div>
			</div>
		</div>
<?php }?>


		
	
				                   	</div>
	                   </section>

					</div>
				</div>
			</div>

	
<?php include('includes/brands-slider.php');?>
</div>
</div>
<?php include('includes/footer.php');?>
	
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<!-- For demo purposes – can be removed on production -->
	
	<script src="switchstylesheet/switchstylesheet.js"></script>
	
	<script>
		$(document).ready(function(){ 
			$(".changecolor").switchstylesheet( { seperator:"color"} );
			$('.show-theme-options').click(function(){
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
		   $('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
	<!-- For demo purposes – can be removed on production : End -->

	

</body>
</html>