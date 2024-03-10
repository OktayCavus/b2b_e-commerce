<?php

define('security', true);

require_once 'inc/header.php'; ?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

	<!-- HEADER-AREA START -->
	<?php require_once 'inc/menu.php'; ?>

	<!-- HEADER-AREA END -->
	<!-- Mobile-menu start -->

	<?php
	// ! burda sef lenovo%20v15%20-%201%20intel%20core böyle veya 
	// ! Asus%20i5%20-%201%20intel%20core böyle bir şey geliyor
	$sef = get('productsef');
	if (!$sef) {
		go(site);
	}

	$product = $db->prepare("SELECT * FROM urunler WHERE urundurum = :d AND urunsef= :se");
	$product->execute([
		':d' => 1,
		':se' => $sef,
	]);
	if ($product->rowCount()) {
		$price = 0;
		$row = $product->fetch(PDO::FETCH_OBJ);
		if (@$bgift > 0) {
			$calc = $row->urunfiyat * $bgift / 100;
			$price = $row->urunfiyat - $calc;
		} else {
			$price = $row->urunfiyat;
		}
	} else {
		go(site);
	}


	// ! ÜRÜN YRUMLARI SORGU 
	$comments = $db->prepare("SELECT * FROM urun_yorumlar WHERE yorumurun = :yu AND yorumdurum = :yd ORDER BY yorumtarih DESC");
	$comments->execute([
		':yu' => $row->urunkodu,
		':yd' => 1
	]);



	?>


	<?php require_once 'inc/mobilmenu.php'; ?>

	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->
	<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/product/<?php echo $row->urunbanner; ?>) no-repeat scroll center center / cover;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-banner">
						<div class="heading-banner-title">
							<h2><?php echo $row->urunbaslik; ?></h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Home</a></li>
								<li>Ürün</li>

								<li><?php echo $row->urunbaslik; ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- PRODUCT-AREA START -->
	<div class="product-area single-pro-area pt-80 pb-80 product-style-2">
		<div class="container">
			<div class="row shop-list single-pro-info no-sidebar">
				<!-- Single-product start -->
				<div class="col-lg-12">
					<div class="single-product clearfix">
						<!-- Single-pro-slider Big-photo start -->
						<div class="single-pro-slider single-big-photo view-lightbox slider-for">
							<?php
							// ! ürün resim
							$pimage = $db->prepare("SELECT resimurun,resimdosya,resimdurum,kapak FROM urun_resimler WHERE resimurun = :u");
							$pimage->execute([
								':u' => $row->urunkodu,
							]);
							if ($pimage->rowCount()) {
								foreach ($pimage as $pim) {

							?>
									<div>
										<img src="<?php echo site . "/uploads/product/" . $pim['resimdosya']; ?>" alt=" <?php echo $row->urunbaslik; ?>" width=" 370" height="450" />
										<a class="view-full-screen" href="<?php echo site . "/uploads/product/" . $pim['resimdosya']; ?>" data-lightbox="roadtrip" data-title="<?php echo $row->urunbaslik; ?>">
											<i class="zmdi zmdi-zoom-in"></i>
										</a>
									</div>
							<?php
								}
							}

							?>


						</div>
						<!-- Single-pro-slider Big-photo end -->
						<div class="product-info">
							<div class="fix">
								<h4 class="post-title floatleft"><?php echo $row->urunbaslik; ?><b> Ürün Kodu:
										<?php echo $row->urunkodu; ?>
									</b></h4>

							</div>
							<div class="fix mb-20">

								<span class="pro-price">
									<?php
									if (@$bgift > 0) {
										echo '<strike>' . $row->urunfiyat . '₺</strike> ' . $price . '₺';
									} else {
										echo $price . '₺';
									}
									?>
								</span>

								</span>
							</div>
							<div class="product-description">
								<p><?php echo strip_tags(mb_substr($row->urunicerik, 0, 1000, "utf8")); ?></p>
							</div>

							<div class="clearfix">

								<form action="" method="POST" onsubmit="return false;" id="addCartForm">

									<input type="number" value="1" name="qtybutton" class="cart-plus-minus-box" min="1" oninput="validity.valid||(value='1');">
									<input type="hidden" value="<?php echo $row->urunkodu; ?>" name="pcode" class="cart-plus-minus-box">

									<div class="product-action clearfix">

										<button onclick="addCart();" id="addCartt" class="btn btn-default" type="submit"><i class="zmdi zmdi-shopping-cart-plus"></i>Sepete Ekle</button>
									</div>
								</form>

							</div>
							<div class="single-pro-slider single-sml-photo slider-nav">
								<?php
								$pimage = $db->prepare("SELECT resimurun,resimdosya,resimdurum,kapak FROM urun_resimler WHERE resimurun = :u");
								$pimage->execute([
									':u' => $row->urunkodu,
								]);
								if ($pimage->rowCount()) {
									foreach ($pimage as $pimg) { ?>
										<div>
											<img width="70" height="83" src="<?php echo site . "/uploads/product/" . $pimg['resimdosya']; ?>" alt="<?php echo $row->urunbaslik; ?>" />
										</div>
								<?php		}
								}

								?>


							</div>

						</div>
					</div>
				</div>

			</div>

			<div class="single-pro-tab">
				<div class="row">
					<div class="col-md-3">
						<div class="single-pro-tab-menu">
							<!-- Nav tabs -->
							<ul class="nav d-block">
								<li><a class="active" href="#description" data-bs-toggle="tab">ÜRÜN AÇIKLAMASI</a></li>
								<li><a href="#reviews" data-bs-toggle="tab">ÜRÜN YORUMLARI (<?php echo $comments->rowCount();  ?>)</a></li>
								<li><a href="#information" data-bs-toggle="tab">ÜRÜN ÖZELLİKLERİ</a></li>

							</ul>
						</div>
					</div>
					<div class="col-md-9">
						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane active" id="description">
								<div class="pro-tab-info pro-description">
									<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik; ?> Açıklaması</h3>

									<?php echo $row->urunicerik; ?>

								</div>
							</div>

							<div class="tab-pane " id="reviews">
								<div class="pro-tab-info pro-reviews">
									<div class="customer-review mb-60">
										<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik; ?>Ürün Yorumları (<?php echo $comments->rowCount() ?>) </h3>
										<?php
										if ($comments->rowCount()) {
											foreach ($comments as $comment) { ?>
												<li class="mb-30" style="border-bottom:2px solid #ddd; list-style:none;">
													<div class="pro-reviewer-comment">
														<div class="fix">
															<div class="floatleft mbl-center">
																<h5 class="text-uppercase mb-0"><strong><?php echo $comment['yorumisim']; ?></strong></h5>
																<p class="reply-date"><?php echo dt($comment['yorumtarih']); ?></p>
															</div>

														</div>
														<p class="mb-0"><?php echo $comment['yorumicerik']; ?></p>
													</div>
												</li>

										<?php	}
										} else {
											alert('ÜRÜN İÇİN YORUM YAPILMAMIŞ', 'warning');
										}
										?>

									</div>


									<?php
									// ! giriş yaptı mı kontrolü yapalım yorum bırakmak için

									if (@$_SESSION['login'] == @sha1(md5(IP() . $bcode))) { ?>
										<div class="leave-review">
											<h3 class="tab-title title-border mb-30">Yorum Yapın</h3>

											<div class="reply-box">
												<form action="#" id="commentform" onsubmit="return false">

													<div class="row">
														<div class="col-md-12">
															<textarea class="custom-textarea" name="commentcontent" placeholder="Yorum Yapınız..."></textarea>
															<input type="hidden" name="productcode" value="<?php echo $row->urunkodu; ?>" />
															<button type="submit" onclick="addNewComment();" id="addNewComentButon" class="button-one submit-button mt-20">submit review</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									<?php

									} else {
										alert("Yorum yapabilmek için lütfen <a href= '" . site . "/login-register'>  giriş yapınız </a>", "danger");
									}


									?>


								</div>
							</div>
							<div class="tab-pane" id="information">
								<div class="pro-tab-info pro-information">
									<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik; ?> Özellikleri</h3>

									<div class="table-responsive">
										<table class="table table-hover">
											<?php
											$pskills = $db->prepare("SELECT * FROM urun_ozellikler WHERE ozellikurun = :ou AND ozellikdurum = :od");
											$pskills->execute([
												':ou' => $row->urunkodu,
												':od' => 1
											]);
											if ($pskills->rowCount()) {
												foreach ($pskills as $pskill) { ?>

													<tr>
														<th><?php echo $pskill['ozellikbaslik']; ?></th>
														<td><?php echo $pskill['ozellikicerik']; ?></td>
													</tr>
											<?php	}
											} else {
												alert('ÜRÜN ÖZELLİĞİ EKLENMEMİŞ', 'danger');
											}
											?>

										</table>
									</div>

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- single-product-tab end -->
		</div>
	</div>
	<!-- PRODUCT-AREA END -->
	<!-- FOOTER START -->
	<?php require_once 'inc/footer.php'; ?>