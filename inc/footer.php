		<!-- Footer-area start -->
		<div class="footer-area footer-2">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="single-footer">
							<h3 class="footer-title  title-border">İletişim Bilgileri</h3>
							<ul class="footer-contact">
								<?php // ! burdaki adres tel falan config.php'den geliyor  
								?>
								<li><span>Adres :</span><?php echo $row->adres; ?></li>
								<li><span>Telefon :</span><?php echo $row->tel; ?></li>
								<li><span>Email :</span><?php echo $row->eposta; ?></li>
							</ul>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6">
						<div class="single-footer">
							<h3 class="footer-title  title-border">Hesabım</h3>
							<ul class="footer-menu">
								<li><a href="<?php echo site; ?>/login.php"><i class="zmdi zmdi-dot-circle"></i>Bayi Kayıt</a></li>
								<li><a href="<?php echo site; ?>/login.php"><i class="zmdi zmdi-dot-circle"></i>Bayi Giriş</a></li>
								<li><a href="<?php echo site; ?>/cart.php"><i class="zmdi zmdi-dot-circle"></i>Sepetim</a></li>
								<li><a href="<?php echo site; ?>/contact.php"><i class="zmdi zmdi-dot-circle"></i>Bize Ulaşın</a></li>

							</ul>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6">
						<div class="single-footer">
							<h3 class="footer-title  title-border">Kurumsal</h3>
							<ul class="footer-menu">
								<?php
								$pages = $db->prepare("Select * from sayfalar WHERE durum = :d");
								$pages->execute([
									':d' => 1,
								]);
								if ($pages->rowCount()) {
									foreach ($pages as $page) { ?>
										<li><a href="<?php echo site ?>/page.php?pagesef=<?php echo $page['sef'] ?>"><i class="zmdi zmdi-dot-circle"></i><?php echo $page['baslik'] ?></a></li>


								<?php

									}
								}
								?>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- Footer-area end -->
		<!-- Copyright-area start -->
		<div class="copyright-area copyright-2">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="copyright">
							<p class="mb-0">&copy; <a href="#" target="_blank">Copyright &copy; </a> <?php echo date('Y') ?> Tüm Hakları Saklıdır</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="payment  text-md-end">
							<a href="#"><img src="img/payment/1.png" alt="" /></a>
							<a href="#"><img src="img/payment/2.png" alt="" /></a>
							<a href="#"><img src="img/payment/3.png" alt="" /></a>
							<a href="#"><img src="img/payment/4.png" alt="" /></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Copyright-area start -->
		</footer>
		<!-- FOOTER END -->


		</div>
		<!-- WRAPPER END -->

		<!-- all js here -->
		<!-- jquery latest version -->

		<script src="js/vendor/jquery-3.6.0.min.js"></script>
		<script src="js/vendor/jquery-migrate-3.3.2.min.js"></script>
		<!-- bootstrap js -->
		<script src="js/bootstrap.bundle.min.js"></script>
		<!-- jquery.meanmenu js -->
		<script src="js/jquery.meanmenu.js"></script>
		<!-- slick.min js -->
		<script src="js/slick.min.js"></script>
		<!-- jquery.treeview js -->
		<script src="js/jquery.treeview.js"></script>
		<!-- lightbox.min js -->
		<script src="js/lightbox.min.js"></script>
		<!-- jquery-ui js -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- jquery.nivo.slider js -->
		<!-- jquery.nicescroll.min js -->
		<script src="js/jquery.nicescroll.min.js"></script>
		<!-- countdon.min js -->
		<script src="js/countdon.min.js"></script>
		<!-- wow js -->
		<script src="js/wow.min.js"></script>
		<!-- plugins js -->
		<script src="js/plugins.js"></script>
		<!-- main js -->
		<script src="js/main.js"></script>
		<!-- custom js -->
		<script src="js/custom.js?v=1"></script>
		</body>

		</html>