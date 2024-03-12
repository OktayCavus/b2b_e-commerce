<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name"><?php echo $aname; ?></p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item active" href="<?php echo admin; ?>">
                <i class="app-menu__icon bi bi-speedometer"></i>
                <span class="app-menu__label">Ana Sayfa</span>
            </a>
        </li>

        <li><a class="app-menu__item " href="<?php echo admin; ?>/customers.php">
                <i class="app-menu__icon bi bi-person"></i>
                <span class="app-menu__label">Bayiler</span>
            </a>
        </li>


        <li class="treeview"><a class="app-menu__item" href="<?php echo admin; ?>/categories.php" data-toggle="treeview"><i class="app-menu__icon bi bi-list"></i>
                <span class="app-menu__label">Kategoriler</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="<?php echo admin; ?>/categories.php"><i class="icon bi bi-circle-fill"></i> Kategori Listesi </a></li>
                <li><a class="treeview-item" href="<?php b2b('newcategory'); ?>"><i class="icon bi bi-circle-fill"></i> Yeni Kategori ekle</a></li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="<?php echo admin; ?>/products.php" data-toggle="treeview"><i class="app-menu__icon bi bi-gift"></i>
                <span class="app-menu__label">Ürünler</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="<?php echo admin; ?>/products.php"><i class="icon bi bi-circle-fill"></i> Ürün Listesi </a></li>
                <li><a class="treeview-item" href="<?php b2b('newproduct'); ?>"><i class="icon bi bi-circle-fill"></i> Yeni Ürün ekle</a></li>
            </ul>
        </li>

        <li><a class="app-menu__item " href="<?php echo admin; ?>/orders.php">
                <i class="app-menu__icon bi bi-bag-check-fill"></i>
                <span class="app-menu__label">Siparişler</span>
            </a>
        </li>

        <li><a class="app-menu__item " href="<?php echo admin; ?>/cart.php">
                <i class="app-menu__icon bi bi-basket"></i>
                <span class="app-menu__label">Sepete eklenen ürünler</span>
            </a>
        </li>

        <li><a class="app-menu__item " href="<?php echo admin; ?>/notifications.php">
                <i class="app-menu__icon bi bi-megaphone"></i>
                <span class="app-menu__label">Havale Bildirimleri</span>
            </a>
        </li>

        <li><a class="app-menu__item " href="<?php echo admin; ?>/comments.php">
                <i class="app-menu__icon bi bi-chat-left-text"></i>
                <span class="app-menu__label">Ürün Yorumları</span>
            </a>
        </li>

        <li class="treeview"><a class="app-menu__item" href="<?php echo admin; ?>/statuslist.php" data-toggle="treeview"><i class="app-menu__icon bi bi-pen"></i>
                <span class="app-menu__label">Sipariş Durum Kodları </span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo admin; ?>/statuslist.php"><i class="icon bi bi-circle-fill"></i> Durum Kodu Listesi</a></li>

                <li><a class="treeview-item" href="<?php b2b('newstatus'); ?>"><i class="icon bi bi-circle-fill"></i> Yeni Durum Kodu Ekle</a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-bank"></i>
                <span class="app-menu__label">Bankalar </span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo admin; ?>/banks.php"><i class="icon bi bi-circle-fill"></i> Banka Listesi</a></li>

                <li><a class="treeview-item" href="<?php b2b('newbank'); ?>"><i class="icon bi bi-circle-fill"></i> Yeni Banka Ekle</a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-envelope"></i>
                <span class="app-menu__label">Mesajlar </span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo admin; ?>/newmessages.php"><i class="icon bi bi-circle-fill"></i>Yeni Mesajlar</a></li>

                <li><a class="treeview-item" href="<?php echo admin; ?>/oldmessages.php"><i class="icon bi bi-circle-fill"></i> Geçmiş Mesajlar</a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-file-earmark"></i>
                <span class="app-menu__label">Sayfalar </span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo admin; ?>/pages.php"><i class="icon bi bi-circle-fill"></i>Sayfa Listesi</a></li>
                <li><a class="treeview-item" href="<?php b2b('newpage'); ?>"><i class="icon bi bi-circle-fill"></i> Yeni Sayfa ekle</a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-gear"></i>
                <span class="app-menu__label">Ayarlar </span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i>Genel Ayarlar</a></li>
                <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i>Logo Ayarları</a></li>
                <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i>SMTP Ayarları</a></li>
                <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i>İletişim Ayarları</a></li>
            </ul>
        </li>



    </ul>
</aside>