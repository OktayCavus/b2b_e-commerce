<?php
define('security', true);


require_once 'inc/header.php'; ?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">
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
							<h2>Mesajınız İçin Teşekkürler</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
								<li>Mesajınız İçin Teşekkürler</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- contact-us-AREA START -->
	<div class="contact-us-area  pt-80 pb-80">
		<div class="container">
			<div class="thankyour-area bg-white mb-30">
				<div class="row">
					<div class="col-md-12">
						<div class="thankyou">
							<h2 class="text-center mb-0">Mesajınız için teşekkür ederiz <a href="<?php echo site; ?>"> ana sayfaya dönmek için tıklayınız.</a></h2>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
	<!-- ABOUT-US-AREA END -->
	<!-- FOOTER START -->
	<?php require_once 'inc/footer.php'; ?>