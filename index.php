<?php

define('security', true);


require_once 'inc/header.php'; ?>
<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

	<!-- HEADER-AREA START -->
	<?php require_once 'inc/menu.php'; ?>
	<!-- HEADER-AREA END -->
	<!-- Mobile-menu start -->
	<?php require_once 'inc/mobilmenu.php'; ?>
	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->
	<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/indexbanner.png) no-repeat scroll center center / cover;">
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
				<?php require_once 'inc/sidebar.php'; ?>


				<?php
				// ! sayfalama için s değişkeni koyduk
				$s = @intval(get('s'));
				if (!$s) {
					$s = 1;
				}

				$plist = $db->prepare("SELECT * FROM urunler WHERE 
					urundurum = :ud AND urunvitrin = :uv ORDER BY uruntarih DESC");
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

										$price = 0;

										foreach ($plist as $rowi) {
											if (@$bgift > 0) {
												$calc = $rowi['urunfiyat'] * $bgift / 100;
												$price = $rowi['urunfiyat'] - $calc;
											} else {
												$price = $rowi['urunfiyat'];
											}

									?>

											<div class="col-lg-4 col-md-6">
												<div class="single-product">
													<div class="product-img">
														<?php if (@$bgift > 0) { ?>

															<span class="pro-price-2"><strike><?php echo $rowi['urunfiyat'] . '₺'; ?></strike> <?php echo $price . '₺'; ?></span>
														<?php } else { ?>
															<span class="pro-price-2"><?php echo $price . '₺'; ?></span>
														<?php } ?>
														<a href="<?php echo site . '/product/' . $rowi['urunsef']; ?>"><img width="270" height="270" src="<?php echo site . '/uploads/product/' . $rowi['urunkapak']; ?>" alt="<?php echo $rowi['urunbaslik'] ?>" /></a>
													</div>
													<div class="product-info clearfix text-center">
														<div class="fix">
															<h4 class="post-title"><a href="<?php echo site . '/product/' . $rowi['urunsef']; ?>"><?php echo $rowi['urunbaslik'] ?></a></h4>
														</div>
														<div class="product-action clearfix">
															<a href="<?php echo site . '/product/' . $rowi['urunsef']; ?>" title="Ürün Detayı"><i class="zmdi zmdi-arrow-right"></i> Detay</a>
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
										pagination($s, ceil($total / $lim), '?s=');
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