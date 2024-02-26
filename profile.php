<?php require_once 'inc/header.php';

if ($_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

?>
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
                            <h2>Bayi Profil</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="#">Anasayfa</a></li>
                                <li>Profil</li>
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
                    <!-- Widget-Categories start -->
                    <aside class="widget widget-categories  mb-30">
                        <div class="widget-title">
                            <h4>Menü</h4>
                        </div>
                        <div id="cat-treeview" class="widget-info product-cat boxscrol2">
                            <ul>
                                <li> <a href="<?php echo site . "/profile.php?process=profile"; ?> "><span>Profil Bilgileri</a></span>
                                <li> <a href="<?php echo site . "/profile.php?process=order"; ?> "><span>Siparişlerim</a></span>
                                <li> <a href="<?php echo site . "/profile.php?process=adress"; ?> "><span>Adreslerim</a></span>
                                <li> <a href="<?php echo site . "/profile.php?process=notification"; ?> "><span>Havale Bildirimlerim</a></span>
                                <li> <a href="<?php echo site . "/cart.php"; ?> "><span>Sepetim</a></span>
                                <li> <a href="<?php echo site . "/logout.php"; ?> "><span>Çıkış</a></span>


                                </li>

                            </ul>
                        </div>
                    </aside>

                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <?php
                    $process = get('process');

                    switch ($process) {
                        case 'notification':
                    ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li>Havale Bildirimlerim</li>
                                    </ul>

                                </div>
                                <!-- Tab panes -->
                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">




                                        </div>
                                    </div>

                                </div>

                            </div>
                        <?php
                            break;
                        case 'order':
                        ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li>Siparişlerim</li>
                                    </ul>

                                </div>
                                <!-- Tab panes -->
                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">




                                        </div>
                                    </div>

                                </div>

                            </div>
                        <?php
                            break;
                        case 'adress':
                        ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li>Adreslerim</li>
                                    </ul>

                                </div>
                                <!-- Tab panes -->
                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">




                                        </div>
                                    </div>

                                </div>

                            </div>
                        <?php
                            break;
                        case 'profile':
                        ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li>Profil</li>
                                    </ul>

                                </div>
                                <!-- Tab panes -->
                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">
                                            <!-- Single-product start -->
                                            <div class="col-lg-12 col-md-12">
                                                <form action="" method="POST">

                                                    <div class="customer-login">

                                                        <p class="text-gray">E-posta</p>
                                                        <input type="text" placeholder="E-posta ya da bayi kodu" name="bec">

                                                        <button type="submit" class="button-one submit-button mt-15">Profil Güncelle</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Single-product end -->
                                        </div>
                                    </div>

                                </div>

                            </div>
                    <?php
                            break;
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT-AREA END -->
    <!-- FOOTER START -->
    <footer>
        <?php require_once 'inc/footer.php'; ?>