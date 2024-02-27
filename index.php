<?php require_once 'inc/header.php'; ?>
<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

	<!-- HEADER-AREA START -->
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
							<h2>Ürünler</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
								<li>Ürünler</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- PRODUCT-AREA START -->
	<div class="product-area pt-80 pb-80 product-style-2">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 order-2 order-lg-1">
					<!-- Widget-Search start -->
					<aside class="widget widget-search mb-30">
						<form action="#">
							<input type="text" placeholder="Search here..." />
							<button type="submit">
								<i class="zmdi zmdi-search"></i>
							</button>
						</form>
					</aside>

					<aside class="widget widget-categories  mb-30">
						<div class="widget-title">
							<h4>Categories</h4>
						</div>
						<div id="cat-treeview" class="widget-info product-cat boxscrol2">
							<ul>
								<li><span>Chair</span>
									<ul>
										<li><a href="#">T-Shirts</a></li>
										<li><a href="#">Striped Shirts</a></li>
										<li><a href="#">Half Shirts</a></li>
										<li><a href="#">Formal Shirts</a></li>
										<li><a href="#">Bilazers</a></li>
									</ul>
								</li>
								<li class="open"><span>Furniture</span>
									<ul>
										<li><a href="#">Men Bag</a></li>
										<li><a href="#">Shoes</a></li>
										<li><a href="#">Watch</a></li>
										<li><a href="#">T-shirt</a></li>
										<li><a href="#">Shirt</a></li>
									</ul>
								</li>
								<li><span>Accessories</span>
									<ul>
										<li><a href="#">T-Shirts</a></li>
										<li><a href="#">Striped Shirts</a></li>
										<li><a href="#">Half Shirts</a></li>
										<li><a href="#">Formal Shirts</a></li>
										<li><a href="#">Bilazers</a></li>
									</ul>
								</li>
								<li><span>Top Brands</span>
									<ul>
										<li><a href="#">T-Shirts</a></li>
										<li><a href="#">Striped Shirts</a></li>
										<li><a href="#">Half Shirts</a></li>
										<li><a href="#">Formal Shirts</a></li>
										<li><a href="#">Bilazers</a></li>
									</ul>
								</li>
								<li><span>Jewelry</span>
									<ul>
										<li><a href="#">T-Shirts</a></li>
										<li><a href="#">Striped Shirts</a></li>
										<li><a href="#">Half Shirts</a></li>
										<li><a href="#">Formal Shirts</a></li>
										<li><a href="#">Bilazers</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</aside>

					<aside class="widget shop-filter mb-30">
						<div class="widget-title">
							<h4>Price</h4>
						</div>
						<div class="widget-info">
							<div class="price_filter">
								<div class="price_slider_amount">
									<input type="submit" value="You range :" />
									<input type="text" id="amount" name="price" placeholder="Add Your Price" />
								</div>
								<div id="slider-range"></div>
							</div>
						</div>
					</aside>

				</div>


				<?php
				// ! sayfalama için s değişkeni koyduk
				$s = @intval(get('s'));
				if (!$s) {
					$s = 1;
				}

				$plist = $db->prepare("SELECT * FROM urunler WHERE 
					urundurum = :ud AND urunvitrin = :uv ");
				$plist->execute([
					':ud' => 1,
					':uv' => 1,
				]);


				$total = $plist->rowCount();
				$lim = 9;
				$show = $s * $lim - $lim;

				$plist = $db->prepare("SELECT * FROM urunler WHERE urundurum = :ud AND urunvitrin = :uv ORDER BY uruntarih DESC LIMIT :show,:lim");

				$plist->bindValue(':ud', (int) 1, PDO::PARAM_INT);
				$plist->bindValue(':uv', (int) 1, PDO::PARAM_INT);
				$plist->bindValue(':show', (int) $show, PDO::PARAM_INT);
				$plist->bindValue(':lim', (int) $lim, PDO::PARAM_INT);

				$plist->execute();
				// ! ürün pagination ile alakalı
				if ($s > ceil($total / $lim)) {
					$s = 1;
				}


				?>

				<div class="col-lg-9 order-1 order-lg-2">
					<!-- Shop-Content End -->
					<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
						<div class="product-option mb-30 clearfix">
							<!-- Nav tabs -->

							<p class="mb-0">Ürün Listesi <?php echo $total; ?></p>


						</div>
						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane active" id="grid-view">
								<div class="row">
									<!-- Single-product start -->
									<?php if ($plist->rowCount()) {

										foreach ($plist as $row) { ?>

											<div class="col-lg-4 col-md-6">
												<div class="single-product">
													<div class="product-img">

														<span class="pro-price-2"><?php echo $row['urunfiyat'] . '₺' ?></span>
														<a href="single-product.html"><img width="270" height="270" src="<?php echo site . '/uploads/product/' . $row['urunkapak']; ?>" alt="<?php echo $row['urunbaslik'] ?>" /></a>
													</div>
													<div class="product-info clearfix text-center">
														<div class="fix">
															<h4 class="post-title"><a href="#"><?php echo $row['urunbaslik'] ?></a></h4>
														</div>

														<div class="product-action clearfix">
															<a href="wishlist.html" title="Ürün Detayı"><i class="zmdi zmdi-arrow-right"></i></a>
															<a href="cart.html" title="Spete Ekle"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
														</div>
													</div>
												</div>
											</div>
									<?php }
									} else {
										alert('Ürün bulunmuyor', 'danger');
									} ?>
									<!-- Single-product end -->
								</div>
							</div>

						</div>



						<!-- Pagination start -->
						<div class="shop-pagination text-center">
							<div class="pagination">
								<ul>
									<?php
									if ($total > $lim) {
										pagination($s, ceil($total / $lim), 'index.php?s=');
									}
									?>
								</ul>
							</div>
						</div>
						<!-- Pagination end -->


					</div>
					<!-- Shop-Content End -->
				</div>
			</div>
		</div>
	</div>
	<!-- PRODUCT-AREA END -->
	<!-- FOOTER START -->
	<footer>
		<?php require_once 'inc/footer.php'; ?>