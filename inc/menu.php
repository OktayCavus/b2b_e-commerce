<header id="sticky-menu" class="header header-2">
    <div class="header-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 offset-md-4 col-7">
                    <div class="logo text-md-center">
                        <a href="index.html"><img src="img/logo/logo.png" alt="" /></a>
                    </div>
                </div>
                <div class="col-md-4 col-5">
                    <div class="mini-cart text-end">
                        <ul>
                            <li>
                                <a class="cart-icon" href="#">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                    <span>3</span>
                                </a>
                                <div class="mini-cart-brief text-left">
                                    <div class="cart-items">
                                        <p class="mb-0">You have <span>03 items</span> in your shopping bag</p>
                                    </div>
                                    <div class="all-cart-product clearfix">
                                        <div class="single-cart clearfix">
                                            <div class="cart-photo">
                                                <a href="#"><img src="img/cart/1.jpg" alt="" /></a>
                                            </div>
                                            <div class="cart-info">
                                                <h5><a href="#">dummy product name</a></h5>
                                                <p class="mb-0">Price : $ 100.00</p>
                                                <p class="mb-0">Qty : 02 </p>
                                                <span class="cart-delete"><a href="#"><i class="zmdi zmdi-close"></i></a></span>
                                            </div>
                                        </div>
                                        <div class="single-cart clearfix">
                                            <div class="cart-photo">
                                                <a href="#"><img src="img/cart/2.jpg" alt="" /></a>
                                            </div>
                                            <div class="cart-info">
                                                <h5><a href="#">dummy product name</a></h5>
                                                <p class="mb-0">Price : $ 300.00</p>
                                                <p class="mb-0">Qty : 01 </p>
                                                <span class="cart-delete"><a href="#"><i class="zmdi zmdi-close"></i></a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-totals">
                                        <h5 class="mb-0">Total <span class="floatright">$500.00</span></h5>
                                    </div>
                                    <div class="cart-bottom  clearfix">
                                        <a href="cart.html" class="button-one floatleft text-uppercase" data-text="View cart">View cart</a>
                                        <a href="checkout.html" class="button-one floatright text-uppercase" data-text="Check out">Check out</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MAIN-MENU START -->
    <div class="menu-toggle menu-toggle-2 hamburger hamburger--emphatic d-none d-md-block">
        <div class="hamburger-box">
            <div class="hamburger-inner"></div>
        </div>
    </div>
    <div class="main-menu  d-none d-md-block">
        <nav>
            <ul>
                <li><a href="<?php echo site; ?>">ANA SAYFA</a></li>
                <li><a href="<?php echo site; ?>">ÜRÜNLER</a></li>

                <?php if (!isset($_SESSION['login'])) { ?>
                    <li><a href="<?php echo site; ?>/login.php">KAYIT OL</a></li>
                    <li><a href="<?php echo site; ?>/login.php">GİRİŞ YAP</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo site; ?>/profile.php?process=profile">HESABIM</a></li>
                <?php } ?>
                <li><a onclick="return confirm('Onaylıyor musunuz?');" href="<?php echo site; ?>/logout.php">ÇIKIŞ YAP</a></li>

                <li><a href="<?php echo site; ?>/contact.php">BİZE ULAŞIN</a></li>
            </ul>
        </nav>
    </div>
    <!-- MAIN-MENU END -->
</header>