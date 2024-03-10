<?php

use Verot\Upload\Upload;

define('security', true);

require_once 'inc/header.php';

if ($_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

?>


<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" />


<style>
    .pagination {
        background: transparent !important;
        display: flex !important;
        padding: 15px !important;
    }
</style>
<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">
    <?php require_once 'inc/menu.php'; ?>
    <?php require_once 'inc/mobilmenu.php'; ?>


    <div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/indexbanner.png) no-repeat scroll center center / cover;">
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
                                <li> <a href="<?php echo site . "/my-profile"; ?> "><span>Profil Bilgileri</a></span>
                                <li> <a href="<?php echo site . "/change-password"; ?> "><span>Şifremi Değiştir</a></span>
                                <li> <a href="<?php echo site . "/change-logo"; ?> "><span>Logo Düzenle</a></span>
                                <li> <a href="<?php echo site . "/order"; ?> "><span>Siparişlerim</a></span>
                                <li> <a href="<?php echo site . "/address"; ?> "><span>Adreslerim</a></span>
                                <li> <a href="<?php echo site . "/notification"; ?> "><span>Havale Bildirimlerim</a></span>
                                <li> <a href="<?php echo site . "/cart"; ?> "><span>Sepetim</a></span>
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

                        case 'changeLogo':
                            if (isset($_POST['logoupdate'])) {
                                require_once 'inc/class.upload.php';

                                $image = new Upload($_FILES['logoimage']);

                                if ($image->uploaded) {
                                    $extension = pathinfo($image->file_src_name, PATHINFO_EXTENSION);
                                    if ($extension != 'png') {
                                        alert('Sadece PNG dosyaları kabul edilir.', 'danger');
                                    } else {
                                        // ! hangi resmin hangi bayiye ait olduğunu görmek için başına bayikodu yazdırıldı
                                        $rname = $bcode . "-" . uniqid();
                                        // ! image altındaki png izin verildi
                                        $image->allowed = array("image/png");
                                        $image->file_new_name_body = $rname;

                                        // ! yükleneceği yer
                                        $image->process("uploads/customer");
                                        if ($image->processed) {
                                            $up = $db->prepare('UPDATE bayiler SET bayilogo = :b WHERE bayikodu = :k');
                                            $up->execute([
                                                ':b' => $rname . '.png',
                                                ':k' => $bcode
                                            ]);
                                            if ($up) {
                                                alert('Logo Başarıyla Güncellendi', 'success');
                                                go(site . "/profile.php?process=changeLogo", 2);
                                            } else {
                                                alert('Hata Oluştu', 'danger');
                                            }
                                        } else {
                                            alert('resim yüklenemedi', 'alert');
                                        }
                                    }
                                } else {
                                    alert('Resim seçmediniz', 'danger');
                                }
                            }

                    ?>
                            <form action="" method="POST" enctype="multipart/form-data">

                                <div class="customer-login text-left">
                                    <h4 class="title-1 title-border text-uppercase mb-30">Logo Güncelle</h4>
                                    <img src="<?php echo site . "/uploads/customer/" . $blogo; ?>" width="100" height="100" alt="<?php echo $bcode; ?>" />
                                    <input type="file" placeholder="Bayi Logo" name="logoimage">
                                    <button type="submit" name="logoupdate" class="button-one submit-button mt-15">Logo Güncelle</button>
                                </div>
                            </form>
                        <?php
                            break;
                        case 'newaddress':
                        ?>
                            <form action="" method="POST" onsubmit="return false;" id="addNewAddressForm">

                                <div class="customer-login text-left">
                                    <h4 class="title-1 title-border text-uppercase mb-30">Yeni Adres Ekle</h4>
                                    <input type="text" placeholder="ADRES BASLIK" name="adresbaslik">
                                    <input type="text" placeholder="ADRES TARİF" name="adrestarif">
                                    <button type="submit" id="addNewAddressButon" onclick="addNewAddressButton();" class="button-one submit-button mt-15">Adres Ekle</button>
                                </div>
                            </form>
                        <?php
                            break;

                        case 'order':

                            $orders = $db->prepare("SELECT * FROM siparisler
                                INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum
                            WHERE siparisbayi=:b ");
                            $orders->execute([':b' => $bcode]);

                        ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li>Siparişlerim ( <?php echo $orders->rowCount(); ?> )</li>
                                    </ul>
                                </div>
                                <!-- Tab panes -->

                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">

                                            <div class="table-responsive">

                                                <?php

                                                if ($orders->rowCount()) {


                                                ?>
                                                    <table class="table table-hover" id="b2btable">
                                                        <thead>
                                                            <tr>
                                                                <th>KOD</th>
                                                                <th>DURUM</th>
                                                                <th>TUTAR</th>
                                                                <th>ÖDEME TÜRÜ</th>
                                                                <th>TARİH</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($orders as $order) { ?>
                                                                <tr>
                                                                    <td><a href="<?php echo site . "/profile?process=orderdetail&code=" . $order['sipariskodu']; ?>" title="Sipariş detayı"><?php echo $order['sipariskodu']; ?></a></td>
                                                                    <td><?php echo $order['durumbaslik']; ?></td>
                                                                    <td><?php echo $order['siparistutar']; ?> ₺</td>
                                                                    <td><?php echo $order['siparisodeme'] == 1 ? 'Havale' : 'Kredi Kartı'; ?></td>
                                                                    <td><?php echo dt($order['siparistarih']) . " | " . $order['siparissaat']; ?></td>

                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                <?php } else {
                                                    alert('Siparişiniz bulunmuyor', 'danger');
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- Pagination start -->

                                <!-- Pagination end -->
                            </div>
                        <?php
                            break;


                        case 'orderdetail':
                            $code = get('code');
                            if (!$code) {
                                go(site);
                            }
                            // ! burda siparisler ile birleştirme sebebi başka insanın siparişini görememek için
                            $orders = $db->prepare("SELECT * FROM siparis_urunler as su
                                    INNER JOIN siparisler as s ON s.sipariskodu = su.sipkodu 
                                    INNER JOIN bayi_adresler AS ba ON s.siparisadres = ba.id
                                WHERE siparisbayi=:b AND sipariskodu = :code");
                            $orders->execute([
                                ':b' => $bcode,
                                ':code' => $code
                            ]);

                        ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li><?php echo $code . " nolu siparişime ait ürünler (" . $orders->rowCount() . ")"; ?></li>
                                        <li><a href="<?php echo site . "/profile?process=order"; ?>">Listeye Dön</a></li>


                                    </ul>
                                </div>
                                <!-- Tab panes -->

                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">

                                            <div class="table-responsive">

                                                <?php

                                                if ($orders->rowCount()) {


                                                ?>
                                                    <table class="table table-hover" id="b2btable">
                                                        <thead>
                                                            <tr>
                                                                <th>Ürün Adı</th>
                                                                <th>Ürün fiyat</th>
                                                                <th>Adet</th>
                                                                <th>Toplam</th>
                                                                <th>Adres</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($orders as $order) { ?>
                                                                <tr>

                                                                    <td><?php echo $order['sipurunadi']; ?></td>
                                                                    <td><?php echo $order['sipbirimfiyat']; ?> ₺</td>
                                                                    <td><?php echo $order['sipadet']; ?></td>
                                                                    <td><?php echo $order['siptoplam']; ?></td>
                                                                    <td><?php echo $order['adresbaslik']; ?></td>

                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                <?php } else {
                                                    alert('Siparişiniz bulunmuyor', 'danger');
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- Pagination start -->

                                <!-- Pagination end -->
                            </div>
                        <?php
                            break;

                        case 'newnotification':
                        ?>
                            <form action="" method="POST" onsubmit="return false;" id="addNewNotifForm">

                                <div class="customer-login text-left">
                                    <h4 class="title-1 title-border text-uppercase mb-30">Yeni Adres Ekle</h4>
                                    <select name="hbank">
                                        <option value="0" readonly> Havale yapacağınız bankayı seçiniz </option>
                                        <?php
                                        $banks = $db->prepare("Select * from bankalar where bankadurum = :d");
                                        $banks->execute([
                                            ':d' => 1
                                        ]);
                                        if ($banks->rowCount()) {
                                            foreach ($banks as $bank) {
                                                echo '<option value="' . $bank['bankaid'] . '">' . $bank['bankaadi'] . '</option>';
                                            }
                                        }                                        ?>
                                    </select>
                                    <input type="date" placeholder="Havale tarihi" name="hdate">
                                    <input type="text" placeholder="Havale Saati" name="hhour">
                                    <input type="text" placeholder="Havale Tutarı" name="hmoney">
                                    <textarea name="hdesc" rows="10" placeholder="Havale Açıklaması"></textarea>
                                    <button type="submit" id="addNewNotifButon" onclick="addNewNotifButton();" class="button-one submit-button mt-15">Havale bildirimi yap</button>
                                </div>
                            </form>
                        <?php
                            break;
                        case 'notification':

                            $notifications = $db->prepare("SELECT * FROM havalebildirim 
                                INNER JOIN bankalar ON bankalar.bankaid = havalebildirim.banka
                                WHERE havalebayi=:b");
                            $notifications->execute([':b' => $bcode]);

                        ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li>Havale Bildirimlerim ( <?php echo $notifications->rowCount(); ?> ) | </li>
                                        <li><a href="<?php echo site; ?>/profile.php?process=newnotification">[Yeni Bildirim Ekle]</a></li>
                                    </ul>
                                </div>
                                <!-- Tab panes -->

                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">

                                            <div class="table-responsive">

                                                <?php

                                                if ($notifications->rowCount()) {


                                                ?>
                                                    <table class="table table-hover" id="b2btable">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>TARİH</th>
                                                                <th>TUTAR</th>
                                                                <th>BANKA</th>
                                                                <th>NOT</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($notifications as $notification) { ?>
                                                                <tr>

                                                                    <td><?php echo $notification['id']; ?></td>
                                                                    <td><?php echo dt($notification['havaletarih']) . " | " . $notification['havalesaat']; ?></td>
                                                                    <td><?php echo $notification['havaletutar']; ?> ₺</td>
                                                                    <td><?php echo $notification['bankaadi']; ?></td>
                                                                    <td><?php echo $notification['havalenot']; ?></td>

                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                <?php } else {
                                                    alert('Adres bulunmuyor', 'danger');
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php
                            break;
                        case 'addressdelete':
                            $id = get('id');
                            if (!$id) {
                                go(site);
                            }
                            // ! burda yapılan sorgu şu doğru bayi adresini doğru bayiye mi giriyoruz
                            $query = $db->prepare("Select * FROM bayi_adresler WHERE adresbayi=:b AND id=:id");
                            $query->execute([
                                ':b' => $bcode,
                                ':id' => $id,
                            ]);
                            if ($query->rowCount()) {

                                $delete = $db->prepare("UPDATE bayi_adresler SET adresdurum = :d WHERE adresbayi = :b AND id = :id");
                                $delete->execute([
                                    ':d' => 2,
                                    ':b' => $bcode,
                                    ':id' => $id,
                                ]);
                                if ($delete) {
                                    alert('Adres pasife alındı', "success");
                                    // ! GELDİĞİ YERE GERİ DÖN
                                    go($_SERVER["HTTP_REFERER"], 2);
                                } else {
                                    alert("hata oluştu", "danger");
                                }
                            } else {
                                go(site);
                            }
                            break;
                        case 'addressedit':
                            $id = get('id');
                            if (!$id) {
                                go(site);
                            }
                            // ! burda yapılan sorgu şu doğru bayi adresini doğru bayiye mi giriyoruz
                            $query = $db->prepare("Select * FROM bayi_adresler WHERE adresbayi=:b AND id=:id");
                            $query->execute([
                                ':b' => $bcode,
                                ':id' => $id,
                            ]);
                            if ($query->rowCount()) {
                                $row = $query->fetch(PDO::FETCH_OBJ);
                            ?>
                                <form action="" method="POST" onsubmit="return false;" id="changeaddresform">

                                    <div class="customer-login text-left">
                                        <h4 class="title-1 title-border text-uppercase mb-30"><?php echo $row->adresbaslik; ?> | Adresini Düzenle</h4>
                                        <input type="text" value="<?php echo $row->adresbaslik; ?>" placeholder="ADRES BASLIK" name="adresbaslik">
                                        <input type="text" value="<?php echo $row->adrestarif; ?>" placeholder="ADRES TARİF" name="adrestarif">

                                        <select name="status">
                                            <option value="1" <?php echo $row->adresdurum == 1 ? 'selected' : null; ?>>Aktif</option>
                                            <option value="2" <?php echo $row->adresdurum == 2 ? 'selected' : null; ?>>Pasif</option>
                                        </select>
                                        <input type="hidden" value="<?php echo $row->id; ?>" name="addressid" />



                                        <button type="submit" id="changeaddressbuton" onclick="changeaddressbutton();" class="button-one submit-button mt-15">Adres güncelle</button>
                                    </div>
                                </form>
                            <?php
                            } else {
                                go(site);
                            }
                            break;
                        case 'adress':

                            $address = $db->prepare("SELECT * FROM bayi_adresler
                                WHERE adresbayi=:b");
                            $address->execute([':b' => $bcode]);

                            ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav d-block shop-tab">
                                        <li>Adreslerim ( <?php echo $address->rowCount(); ?> ) | </li>
                                        <li><a href="<?php echo site; ?>/profile.php?process=newaddress">[Yeni Adres Ekle]</a></li>
                                    </ul>
                                </div>
                                <!-- Tab panes -->

                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">

                                            <div class="table-responsive">

                                                <?php

                                                if ($address->rowCount()) {


                                                ?>
                                                    <table class="table table-hover" id="b2btable">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>BAŞLIK</th>
                                                                <th>AÇIK ADRES</th>
                                                                <th>DURUM</th>
                                                                <th>İŞLEM</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($address as $order) { ?>
                                                                <tr>

                                                                    <td><?php echo $order['id']; ?></td>
                                                                    <td><?php echo $order['adresbaslik']; ?></td>
                                                                    <td><?php echo $order['adrestarif']; ?></td>
                                                                    <td><?php echo $order['adresdurum'] == 1 ? 'Aktif' : 'Pasif'; ?>
                                                                    <td>
                                                                        <a href="<?php echo site; ?>/profile.php?process=addressedit&id=<?php echo $order['id']; ?>" title="Adres düzenle"><i style="font-size:20px" class="zmdi zmdi-edit"></i></a>
                                                                        |
                                                                        <a href="<?php echo site; ?>/profile.php?process=addressdelete&id=<?php echo $order['id']; ?>" title="Adresi pasife al"><i style="font-size:20px" class="zmdi zmdi-close"></i></a>
                                                                    </td>
                                                                    </td>

                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                <?php } else {
                                                    alert('Adres bulunmuyor', 'danger');
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- Pagination start -->

                                <!-- Pagination end -->
                            </div>
                        <?php
                            break;
                        case 'changePassword':
                        ?> <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">

                                    <ul class="nav d-block shop-tab">
                                        <li>Şifremi Değiştir</li>
                                    </ul>

                                </div>
                                <!-- Tab panes -->
                                <div class="login-area">
                                    <div class="container">
                                        <div class="row">
                                            <!-- Single-product start -->
                                            <div class="col-lg-12 col-md-12">
                                                <form action="" method="POST" onsubmit="return false;" id="passwordChangeForm">

                                                    <div class="customer-login">

                                                        <p class="text-gray">Yeni Şifreniz</p>
                                                        <input type="password" name="password" placeholder="Yeni Şifreniz">

                                                        <p class="text-gray">Yeni Şifreniz Tekrar</p>
                                                        <input type="password" name="password2" placeholder="Yeni Şifreniz Tekrar">




                                                        <button type="submit" id="passwordChangeButon" onclick="passwordChangeButton();" class="button-one submit-button mt-15">Şifremi Güncelle</button>
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
                        case 'profile':
                        ?>
                            <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                <div class="product-option mb-30 clearfix">

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
                                                <form action="" method="POST" onsubmit="return false;" id="profileupdateform">

                                                    <div class="customer-login">

                                                        <p class="text-gray">BAYİ KODU</p>
                                                        <input type="text" disabled value="<?php echo $bcode; ?>">

                                                        <p class="text-gray">BAYİ ADI</p>
                                                        <input type="text" placeholder="Bayi Adı" value="<?php echo $bname; ?>" name="bname">

                                                        <p class="text-gray">BAYİ Mail</p>
                                                        <input type="text" placeholder="Bayi Mail" value="<?php echo $bmail; ?>" name="bmail">

                                                        <p class="text-gray">BAYİ Telefon</p>
                                                        <input type="text" placeholder="Bayi Telefon" value="<?php echo $bphone; ?>" name="bphone">

                                                        <p class="text-gray">BAYİ Vergi No</p>
                                                        <input type="text" placeholder="Bayi Vergi No" value="<?php echo $bvno; ?>" name="bvno">

                                                        <p class="text-gray">BAYİ Vergi Dairesi</p>
                                                        <input type="text" placeholder="Bayi Vergi Dairesi" value="<?php echo $bvd; ?>" name="bvd">

                                                        <p class="text-gray">BAYİ Site</p>
                                                        <input type="text" placeholder="Bayi Site" value="<?php echo $bweb; ?>" name="bweb">

                                                        <button type="submit" id="profileupdatebuton" onclick="profileupdatebutton();" class="button-one submit-button mt-15">Profil Güncelle</button>
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

        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#b2btable').DataTable();
            });
        </script>