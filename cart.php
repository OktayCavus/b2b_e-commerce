<?php require_once 'inc/header.php'; ?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

	<?php require_once 'inc/menu.php'; ?>

	<!-- HEADER-AREA END -->
	<!-- Mobile-menu start -->
	<?php require_once 'inc/mobilmenu.php'; ?>

	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->
	<div class="heading-banner-area overlay-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-banner">
						<div class="heading-banner-title">
							<h2>Shopping Cart</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="index.html">Home</a></li>
								<li>Shopping Cart</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- SHOPPING-CART-AREA START -->
	<div class="shopping-cart-area  pt-80 pb-80">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="shopping-cart">
						<!-- Nav tabs -->
						<ul class="cart-page-menu nav row clearfix mb-30">
							<li><a class="active" href="#shopping-cart" data-bs-toggle="tab">Sepetim</a></li>

							<!-- Tab panes -->
							<div class="tab-content">
								<!-- shopping-cart start -->
								<div class="tab-pane active" id="shopping-cart">
									<form action="#">
										<div class="shop-cart-table">
											<div class="table-content table-responsive">
												<table>
													<thead>
														<tr>
															<th class="product-thumbnail">Product</th>
															<th class="product-price">Price</th>
															<th class="product-quantity">Quantity</th>
															<th class="product-subtotal">Total</th>
															<th class="product-remove">Remove</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="product-thumbnail  text-left">
																<!-- Single-product start -->
																<div class="single-product">
																	<div class="product-img">
																		<a href="single-product.html"><img src="img/product/2.jpg" alt="" /></a>
																	</div>
																	<div class="product-info">
																		<h4 class="post-title"><a class="text-light-black" href="#">dummy product name</a></h4>
																		<p class="mb-0">Color : Black</p>
																		<p class="mb-0">Size : SL</p>
																	</div>
																</div>
																<!-- Single-product end -->
															</td>
															<td class="product-price">$56.00</td>
															<td class="product-quantity">
																<div class="cart-plus-minus">
																	<input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
																</div>
															</td>
															<td class="product-subtotal">$112.00</td>
															<td class="product-remove">
																<a href="#"><i class="zmdi zmdi-close"></i></a>
															</td>
														</tr>
														<tr>
															<td class="product-thumbnail  text-left">
																<!-- Single-product start -->
																<div class="single-product">
																	<div class="product-img">
																		<a href="single-product.html"><img src="img/product/12.jpg" alt="" /></a>
																	</div>
																	<div class="product-info">
																		<h4 class="post-title"><a class="text-light-black" href="#">dummy product name</a></h4>
																		<p class="mb-0">Color : Black</p>
																		<p class="mb-0">Size : SL</p>
																	</div>
																</div>
																<!-- Single-product end -->
															</td>
															<td class="product-price">$56.00</td>
															<td class="product-quantity">
																<div class="cart-plus-minus">
																	<input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
																</div>
															</td>
															<td class="product-subtotal">$112.00</td>
															<td class="product-remove">
																<a href="#"><i class="zmdi zmdi-close"></i></a>
															</td>
														</tr>
														<tr>
															<td class="product-thumbnail  text-left">
																<!-- Single-product start -->
																<div class="single-product">
																	<div class="product-img">
																		<a href="single-product.html"><img src="img/product/6.jpg" alt="" /></a>
																	</div>
																	<div class="product-info">
																		<h4 class="post-title"><a class="text-light-black" href="#">dummy product name</a></h4>
																		<p class="mb-0">Color : Black</p>
																		<p class="mb-0">Size : SL</p>
																	</div>
																</div>
																<!-- Single-product end -->
															</td>
															<td class="product-price">$56.00</td>
															<td class="product-quantity">
																<div class="cart-plus-minus">
																	<input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
																</div>
															</td>
															<td class="product-subtotal">$112.00</td>
															<td class="product-remove">
																<a href="#"><i class="zmdi zmdi-close"></i></a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="customer-login mt-30">
													<h4 class="title-1 title-border text-uppercase">coupon discount</h4>
													<p class="text-gray">Enter your coupon code if you have one!</p>
													<input type="text" placeholder="Enter your code here.">
													<button type="submit" data-text="apply coupon" class="button-one submit-button mt-15">apply coupon</button>
												</div>
											</div>
											<div class="col-md-6">
												<div class="customer-login payment-details mt-30">
													<h4 class="title-1 title-border text-uppercase">payment details</h4>
													<table>
														<tbody>
															<tr>
																<td class="text-left">Cart Subtotal</td>
																<td class="text-end">$155.00</td>
															</tr>
															<tr>
																<td class="text-left">Cart Subtotal</td>
																<td class="text-end">$15.00</td>
															</tr>
															<tr>
																<td class="text-left">Vat</td>
																<td class="text-end">$00.00</td>
															</tr>
															<tr>
																<td class="text-left">Order Total</td>
																<td class="text-end">$170.00</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="customer-login mt-30">
													<h4 class="title-1 title-border text-uppercase">culculate shipping</h4>
													<p class="text-gray">Enter your coupon code if you have one!</p>
													<div class="row">
														<div class="col-md-4">
															<input type="text" placeholder="Country">
														</div>
														<div class="col-md-4">
															<input type="text" placeholder="Region / State">
														</div>
														<div class="col-md-4">
															<input type="text" placeholder="Post code">
														</div>
													</div>
													<button type="submit" data-text="get a quote" class="button-one submit-button mt-15">get a quote</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- SHOPPING-CART-AREA END -->
	<!-- FOOTER START -->
	<?php require_once 'inc/footer.php'; ?>