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
							<h2>Giriş / Kayıt</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
								<li>Giriş / Kayıt</li>
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
					<form action="" method="POST" onsubmit="return false;" id="bloginform">

						<div class="customer-login text-left">
							<h4 class="title-1 title-border text-uppercase mb-30">BAYİ GİRİŞ</h4>
							<p class="text-gray">If you have an account with us, Please login!</p>
							<input type="text" placeholder="E-posta ya da bayi kodu" name="bec">
							<input type="password" placeholder="Password" name="bpass">
							<p><a href="#" class="text-gray">Forget your password?</a></p>
							<button type="submit" id="loginbuton" onclick="loginbutton();" class="button-one submit-button mt-15">Giriş</button>
						</div>
					</form>

				</div>


				<div class="col-lg-6">
					<form action="" method="POST" onsubmit="return false;" id="bregisterform">

						<div class="customer-login text-left">
							<h4 class="title-1 title-border text-uppercase mb-30">BAYİ KAYIT</h4>

							<input type="text" placeholder="Your name here..." name="bname">
							<input type="text" placeholder="Email address here..." name="bmail">
							<input type="password" placeholder="Password" name="bpass">
							<input type="password" placeholder="Confirm password" name="bpass2">
							<input type="text" placeholder="Phone" name="bphone">
							<input type="text" placeholder="Tax No" name="bvno">
							<input type="text" placeholder="Vergi Dairesi" name="bvd">

							<button type="submit" id="registerbuton" onclick="registerbutton();" class="button-one submit-button mt-15">regiter</button>
						</div>
					</form>

				</div>

			</div>
		</div>
	</div>
	<!-- SHOPPING-CART-AREA END -->
	<!-- FOOTER START -->
	<?php require_once 'inc/footer.php'; ?>