<?php require_once 'inc/header.php';

if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
	go(site);
} ?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

	<?php require_once 'inc/menu.php'; ?>

	<!-- HEADER-AREA END -->
	<!-- Mobile-menu start -->
	<?php require_once 'inc/mobilmenu.php'; ?>

	<?php

	$shopping = $db->prepare("SELECT * FROM sepet 
	INNER JOIN urunler on urunler.urunkodu = sepet.sepeturun WHERE sepetbayi = :b");
	$shopping->execute([
		':b' => $bcode,
	]);

	if (isset($_GET['productdelete'])) {
		// ! ilgili ürünün kodunu alıyor 
		$code = get('code');
		$delete = $db->prepare("DELETE FROM sepet WHERE sepeturun = :u AND sepetbayi = :b");
		$delete->execute([
			':u' => $code,
			':b' => $bcode,
		]);
		go($_SERVER['HTTP_REFERER']);
	}

	if (isset($_GET['qtybutton'])) {
		$pcode = get('pcode');
		$qtybutton = get('qtybutton');

		if ($pcode && $qtybutton) {
			$prow = $db->prepare("SELECT urunkodu,urunfiyat,urundurum FROM urunler WHERE urunkodu = :k");
			$prow->execute([
				':k' => $pcode,
			]);
			$productrow = $prow->fetch(PDO::FETCH_OBJ);

			$totalprice = ($productrow->urunfiyat) * $qtybutton;
			$tax = $totalprice * ($row->sitekdv / 100);
			$subtotal = $totalprice + $tax;

			$result = $db->prepare("UPDATE sepet SET 
			sepetadet = :sa,
			birimfiyat = :bf,
			toplam = :tf,
			kdv = :kdv
			WHERE sepeturun = :u AND sepetbayi = :b");

			$result->execute([
				':sa' => $qtybutton,
				':bf' => $productrow->urunfiyat,
				':tf' => $subtotal,
				':u' => $productrow->urunkodu,
				':b' => $bcode,
				':kdv' => $row->sitekdv
			]);

			go($_SERVER['HTTP_REFERER']);
		}
	}



	?>

	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->
	<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/indexbanner.png) no-repeat scroll center center / cover;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-banner">
						<div class="heading-banner-title">
							<h2>Alışveriş Sepeti</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
								<li>Alışveriş Sepeti</li>
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
							<li><a class="active" href="#shopping-cart" data-bs-toggle="tab">Sepetim (<?php echo $shopping->rowCount(); ?>)</a></li>

							<!-- Tab panes -->
							<div class="tab-content">
								<!-- shopping-cart start -->
								<div class="tab-pane active" id="shopping-cart">
									<?php if ($shopping->rowCount()) { ?>




										<div class="shop-cart-table">
											<div class="table-content table-responsive">
												<table>
													<thead>
														<tr>
															<th class="product-thumbnail">Ürün</th>
															<th class="product-price">Fiyat</th>
															<th class="product-quantity">Adet</th>
															<th class="product-subtotal">Toplam</th>
															<th class="product-remove">Kaldır</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$totalprice = 0;


														foreach ($shopping as $cart) {
															$ptax = $cart['kdv'] == 0 ? '' : "+KDV";

														?>
															<tr>
																<td class="product-thumbnail  text-left">
																	<!-- Single-product start -->
																	<div class="single-product">
																		<div class="product-img">
																			<a href="<?php echo site . "/product.php?productsef=" . $cart['urunsef']; ?>"><img src="<?php echo site . "/uploads/product/" . $cart['urunkapak'] ?>" width="270" height="270" alt="<?php echo $cart['urunbaslik']; ?>" /></a>
																		</div>
																		<div class="product-info">
																			<h4 class="post-title"><a class="text-light-black" href="<?php echo site . "/product.php?productsef=" . $cart['urunsef']; ?>"><?php echo $cart['urunbaslik']; ?></a></h4>

																		</div>
																	</div>
																	<!-- Single-product end -->
																</td>
																<td class="product-price"><?php echo $cart['urunfiyat'] . "₺" . $ptax; ?></td>
																<td class="product-quantity">
																	<form action="<?php echo site . "/cart.php"; ?>" method="GET">
																		<input type="number" min="1" value="<?php echo $cart['sepetadet']; ?>" name="qtybutton" class="cart-plus-minus-box">
																		<input type="hidden" name="pcode" value="<?php echo $cart['sepeturun']; ?>">
																		<button type="submit" class="btn btn-default">Güncelle</button>
																	</form>
																</td>

																<td class="product-subtotal"><?php echo $cart['toplam'] . "₺"; ?></td>
																<td class="product-remove">
																	<a onclick="return confirm('Ürünü sepetten silmek istiyor musunuz?');" href="<?php echo site . "/cart.php?productdelete&code=" . $cart['sepeturun']; ?>"><i class="zmdi zmdi-close"></i></a>
																</td>
															</tr>
														<?php
															$totalprice += $cart['toplam'];
														} ?>

													</tbody>
												</table>
											</div>
										</div>
										<div class="row">

											<div class="col-md-6">
												<div class="customer-login payment-details mt-30">
													<h4 class="title-1 title-border text-uppercase">Alışveriş Detayları</h4>
													<table>
														<tbody>


															<tr>
																<td class="text-left">KDV</td>
																<td class="text-end"><?php echo "%" . $row->sitekdv; ?></td>
															</tr>
															<tr>
																<td class="text-left">Genel Toplam</td>
																<td class="text-end"><?php echo $totalprice . "₺"; ?></td>
															</tr>
														</tbody>


													</table>
													<a href="<?php echo site . "/checkout.php" ?>"><button type="submit" data-text="get a quote" class="button-one submit-button mt-15">Ödeme yap & Siparişi Tamamla</button></a>
												</div>
											</div>
										</div>




									<?php } else {
										alert("Sepetinize ürün eklenmemiştir! ", 'danger');
									} ?>

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