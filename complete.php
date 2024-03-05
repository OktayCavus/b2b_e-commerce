<?php

define('security', true);

require_once 'inc/header.php'; ?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">
	<?php require_once 'inc/menu.php'; ?>

	<!-- HEADER-AREA END -->
	<!-- Mobile-menu start -->
	<?php require_once 'inc/header.php'; ?>

	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->
	<div class="heading-banner-area overlay-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-banner">
						<div class="heading-banner-title">
							<h2>order complete</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="index.html">Home</a></li>
								<li>order complete</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- ORDER-AREA START -->
	<div class="shopping-cart-area  pt-80 pb-80">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="shopping-cart">
						<!-- Nav tabs -->
						<ul class="cart-page-menu nav row clearfix mb-30">
							<li><a class="active" href="#order-complete" data-bs-toggle="tab">SİPARİŞ TAMAMLANDI</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<!-- shopping-cart start -->

							<!-- check-out end -->
							<!-- order-complete start -->
							<div class="tab-pane active" id="order-complete">
								<form action="#">
									<div class="thank-recieve bg-white mb-30">
										<p>Thank you. Your order has been received.</p>
									</div>
									<div class="order-info bg-white text-center clearfix mb-30">
										<div class="single-order-info">
											<h4 class="title-1 text-uppercase text-light-black mb-0">order no</h4>
											<p class="text-uppercase text-light-black mb-0"><strong>m 2653257</strong></p>
										</div>
										<div class="single-order-info">
											<h4 class="title-1 text-uppercase text-light-black mb-0">Date</h4>
											<p class="text-uppercase text-light-black mb-0"><strong>june 15, 2021</strong></p>
										</div>
										<div class="single-order-info">
											<h4 class="title-1 text-uppercase text-light-black mb-0">Total</h4>
											<p class="text-uppercase text-light-black mb-0"><strong>$ 170.00</strong></p>
										</div>
										<div class="single-order-info">
											<h4 class="title-1 text-uppercase text-light-black mb-0">payment method</h4>
											<p class="text-uppercase text-light-black mb-0"><a href="#"><strong>check payment</strong></a></p>
										</div>
									</div>
								</form>
							</div>
							<!-- order-complete end -->
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ORDER-AREA END -->
	<!-- FOOTER START -->
	<?php require_once 'inc/footer.php'; ?>