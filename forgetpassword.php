<?php

define('security', true);

require_once 'inc/header.php';

if (@$_SESSION['login'] == @sha1(md5(IP() . $bcode))) {
	go(site);
}
?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">
	<?php require_once 'inc/menu.php'; ?>

	<!-- HEADER-AREA END -->
	<?php require_once 'inc/mobilmenu.php'; ?>

	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->
	<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/indexbanner.png) no-repeat scroll center center / cover;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-banner">
						<div class="heading-banner-title">
							<h2>Şifremi Yenile</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
								<li>Şifremi Yenile</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- SHOPPING-CART-AREA START -->
	<div class="login-area  pt-80 pb-80">
		<div class="container">
			<div class="row">

				<div class="col-lg-6">
					<form action="" method="POST" onsubmit="return false;" id="forgetpasswordform">

						<div class="customer-login text-left">
							<h4 class="title-1 title-border text-uppercase mb-30">Şifremi Yenile</h4>

							<input type="text" placeholder="E-posta adresi" name="bmail">
							<input type="text" placeholder="Bayi kodu" name="bcode">
							<button type="submit" id="forgetbuton" onclick="forgetbutton();" class="button-one submit-button mt-15">Şifremi Yenile</button>
						</div>
					</form>

				</div>




			</div>
		</div>
	</div>
	<!-- SHOPPING-CART-AREA END -->
	<!-- FOOTER START -->
	<?php require_once 'inc/footer.php'; ?>