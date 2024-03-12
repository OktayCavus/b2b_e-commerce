<?php

use Verot\Upload\Upload;

require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> <?php echo get('process') ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">İşlemler</li>
            <li class="breadcrumb-item"><a href="#"><?php echo get('process') ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <?php

            $process = @get('process');
            if (!$process) {
                go(admin);
            }

            switch ($process) {
                case 'newcategory':

                    if (isset($_POST['add'])) {
                        $name = post('name');
                        $seourl = post('seourl');
                        if (!$seourl) {
                            $seflink = sef_link($name);
                        } else {
                            $seflink = $seourl;
                        }
                        $keyw = post('seok');
                        $desc = post('seod');

                        if (!$name || !$keyw || !$desc) {
                            alert('Tüm alanları doldur', 'danger');
                        } else {
                            $already = $db->prepare("SELECT katsef FROM urun_kategoriler WHERE katsef = :k");
                            $already->execute([
                                ':k' => $seflink
                            ]);
                            if ($already->rowCount()) {
                                alert('Bu kategori zaten kayıtlı', 'danger');
                            } else {
                                require_once 'inc/class.upload.php';
                                $image = new Upload($_FILES['cimage']);
                                if ($image->uploaded) {
                                    $extension = pathinfo($image->file_src_name, PATHINFO_EXTENSION);
                                    if ($extension != 'png') {
                                        alert('Sadece PNG dosyaları kabul edilir.', 'danger');
                                    } else {
                                        // ! hangi resmin hangi bayiye ait olduğunu görmek için başına bayikodu yazdırıldı
                                        $rname = $seflink . "-" . uniqid();
                                        // ! image altındaki png izin verildi
                                        $image->allowed = array("image/png");
                                        $image->file_new_name_body = $rname;

                                        // ! yükleneceği yer
                                        $image->process("../uploads");
                                        if ($image->processed) {
                                            $add = $db->prepare("INSERT INTO urun_kategoriler SET
                                             katbaslik =:k ,
                                             katsef = :s,
                                             katkeyw = :ke,
                                             katdesc = :de,
                                             katresim = :re,
                                             katekleyen = :kae
                                             ");
                                            $result = $add->execute([
                                                ':k' => $name,
                                                ':s' => $seflink,
                                                ':ke' => $keyw,
                                                ':de' => $desc,
                                                ':re' => $rname . '.png',
                                                ':kae' => $aid

                                            ]);

                                            if ($result) {
                                                alert('Kategori Eklendi ', 'success');
                                                go(admin . "/categories.php", 2);
                                            } else {
                                                alert('hata oluştu', 'danger');
                                                print($add->errorInfo());
                                            }
                                        } else {
                                            alert('Resim yüklenemedi', 'danger');
                                            print_r($image->error);
                                        }
                                    }
                                } else {
                                    alert('Resim seçmediniz', 'danger');
                                    print_r($image->error);
                                }
                            }
                        }
                    }

            ?>
                    <div class="tile">
                        <h3 class="tile-title">Yeni Kategori Ekle</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="tile-body">

                                <div class="form-group">
                                    <label class="control-label">Kategori Adı</label>
                                    <input class="form-control" name="name" type="text" placeholder="Kategori Adı">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Kategori SEO URL (örn: canavar-oyun-bilgisayarlari)</label>
                                    <input class="form-control" name="seourl" type="text" placeholder="Kategori SEO URL">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Kategori SEO Keywords</label>
                                    <input class="form-control" name="seok" type="text" placeholder="Kategori SEO Keywords">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Kategori SEO Description</label>
                                    <input class="form-control" name="seod" type="text" placeholder="Kategori SEO Description">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Kategori Resim</label>
                                    <input class="form-control" type="file" name="cimage">
                                </div>



                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/categories.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                            </div>

                        </form>


                    </div>

                <?php
                    break;

                case 'newbank':

                    if (isset($_POST['add'])) {

                        $name = post('name');
                        $hno = post('hno');
                        $sname = post('sname');
                        $iban = post('iban');

                        if (!$name || !$hno || !$sname || !$iban) {
                            alert("Boş alan bırakma", 'danger');
                        } else {
                            $already = $db->prepare("SELECT bankaiban FROM bankalar WHERE bankaiban = :k");
                            $already->execute([
                                ':k' => $iban
                            ]);
                            if ($already->rowCount()) {
                                alert('Bu banka hesabı zaten kayıtlı', 'danger');
                            } else {
                                $add = $db->prepare("INSERT INTO bankalar SET 
                                bankaadi = :b,
                                bankahesap = :k,
                                bankasube = :s,
                                bankaiban = :i,
                                bankaekleyen = :be
                                ");
                                $result = $add->execute([
                                    ':b' => $name,
                                    ':k' => $hno,
                                    ':s' => $sname,
                                    ':i' => $iban,
                                    ':be' => $aid
                                ]);
                                if ($result) {
                                    alert('Banka eklendi', 'success');
                                    go(admin . "/banks.php", 2);
                                } else {
                                    alert('HATA', 'danger');
                                    print_r($add->errorInfo());
                                }
                            }
                        }
                    }


                ?>

                    <div class="tile">
                        <h3 class="tile-title">Yeni Banka Ekle</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="tile-body">

                                <div class="form-group">
                                    <label class="control-label">Banka Adı</label>
                                    <input class="form-control" name="name" type="text" placeholder="Banka Adı">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Hesap No</label>
                                    <input class="form-control" name="hno" type="text" placeholder="Hesap No">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Şube Adı/No</label>
                                    <input class="form-control" name="sname" type="text" placeholder="Şube Adı/No">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">IBAN</label>
                                    <input class="form-control" name="iban" type="text" placeholder="IBAN">
                                </div>

                                <div class="tile-footer">
                                    <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Banka Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/statuslist.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                                </div>

                        </form>


                    </div>


                <?php
                    break;


                case 'newstatus':

                    if (isset($_POST['add'])) {

                        $baslik = post('baslik');
                        $code = post('code');

                        if (!$baslik || !$code) {
                            alert("Boş alan bırakma", 'danger');
                        } else {
                            $already = $db->prepare("SELECT durumkodu FROM durumkodlari WHERE durumkodu = :k");
                            $already->execute([
                                ':k' => $code
                            ]);
                            if ($already->rowCount()) {
                                alert('Bu durum kodu zaten kayıtlı', 'danger');
                            } else {
                                $add = $db->prepare("INSERT INTO durumkodlari SET durumbaslik = :b , durumkodu = :k , durumekleyen = :ek");
                                $result = $add->execute([
                                    ':b' => $baslik,
                                    ':k' => $code,
                                    ':ek' => $aid
                                ]);
                                if ($result) {
                                    alert('Durum eklendi', 'success');
                                    go(admin . "/statuslist.php", 2);
                                } else {
                                    alert('HATA', 'danger');
                                    print_r($add->errorInfo());
                                }
                            }
                        }
                    }


                ?>

                    <div class="tile">
                        <h3 class="tile-title">Yeni Durum Ekle</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="tile-body">

                                <div class="form-group">
                                    <label class="control-label">Durum Başlık</label>
                                    <input class="form-control" name="baslik" type="text" placeholder="Durum Başlık">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Durum Kodu</label>
                                    <input class="form-control" name="code" type="text" placeholder="Durum Kodu">
                                </div>

                                <div class="tile-footer">
                                    <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/statuslist.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                                </div>

                        </form>


                    </div>

            <?php
                    break;

                default:

                    break;
            } ?>




        </div>

        <div class="clearix"></div>

    </div>
</main>
<?php require_once "inc/footer.php"; ?>