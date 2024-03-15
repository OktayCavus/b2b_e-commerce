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

                case 'customeraddress':

                    $s    = @intval(get('s'));
                    if (!$s) {
                        $s = 1;
                    }

                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }

                    $bquery = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:k");
                    $bquery->execute([':k' => $code]);
                    if ($bquery->rowCount()) {
                        $row = $bquery->fetch(PDO::FETCH_OBJ);
                    }

                    $query = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:k");
                    $query->execute([':k' => $code]);

                    $total = $query->rowCount();
                    $lim   = 50;
                    $show  = $s * $lim - $lim;



                    $query = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:k ORDER BY id DESC LIMIT :show,:lim");
                    $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
                    $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
                    $query->bindValue(':k', $code, PDO::PARAM_STR);
                    $query->execute();

                    if ($s > ceil($total / $lim)) {
                        $s = 1;
                    }

                    if ($query->rowCount()) {


            ?>

                        <div class="tile">
                            <h3 class="tile-title">Bayi Adresleri (<?php echo $total; ?>)</h3>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Adres Bayi</th>
                                            <th>Adres Başlık</th>
                                            <th>Adres Tarif</th>
                                            <th>Adres Durum</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($query as $pow) { ?>

                                            <tr>
                                                <td><?php echo $pow['id']; ?></td>
                                                <td><?php echo $row->bayiadi; ?></td>
                                                <td><?php echo $pow['adresbaslik']; ?></td>
                                                <td><?php echo $pow['adrestarif']; ?></td>
                                                <td><?php echo $pow['adresdurum'] == 1 ? '<span class="badge badge-success ">Aktif</span>' : '<span class="badge badge-danger ">Pasif</span>'; ?></td>
                                                <td><a onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b('customeraddressactive', $pow['id']); ?>"><i class="fa fa-check"></i></a> | <a onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b('customeraddressdelete', $pow['id']); ?>"><i class="fa fa-close"></i></a></td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>


                            <div>
                                <ul class="pagination">
                                    <?php
                                    if ($total > $lim) {
                                        pagination($s, ceil($total / $lim), 'process.php?process=customeraddress&id=' . $code . '&s=');
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>


                    <?php


                    } else {
                        alert("Bayiye ait adres bulunmamaktadır", "danger");
                    }


                    break;

                case 'customerlog':

                    $s    = @intval(get('s'));
                    if (!$s) {
                        $s = 1;
                    }

                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }

                    $bquery = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:k");
                    $bquery->execute([':k' => $code]);
                    if ($bquery->rowCount()) {
                        $row = $bquery->fetch(PDO::FETCH_OBJ);
                    }

                    $query = $db->prepare("SELECT * FROM bayi_loglar WHERE logbayi=:k");
                    $query->execute([':k' => $code]);

                    $total = $query->rowCount();
                    $lim   = 30;
                    $show  = $s * $lim - $lim;



                    $query = $db->prepare("SELECT * FROM bayi_loglar WHERE logbayi=:k ORDER BY logtarih DESC LIMIT :show,:lim");
                    $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
                    $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
                    $query->bindValue(':k', $code, PDO::PARAM_STR);
                    $query->execute();

                    if ($s > ceil($total / $lim)) {
                        $s = 1;
                    }

                    if ($query->rowCount()) {


                    ?>

                        <div class="tile">
                            <h3 class="tile-title">Banka Listesi (<?php echo $total; ?>)</h3>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Bayi</th>
                                            <th>Açıklama</th>
                                            <th>Tarih</th>
                                            <th>IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($query as $pow) { ?>

                                            <tr>
                                                <td><?php echo $pow['id']; ?></td>
                                                <td><?php echo $row->bayiadi; ?></td>
                                                <td><?php echo $pow['logaciklama']; ?></td>
                                                <td><?php echo dt($pow['logtarih']); ?></td>
                                                <td><?php echo $pow['logip']; ?></td>



                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>


                            <div>
                                <ul class="pagination">
                                    <?php
                                    if ($total > $lim) {
                                        pagination($s, ceil($total / $lim), 'process.php?process=customerlog&id=' . $code . '&s=');
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>


                    <?php


                    } else {
                        alert("Bayiye ait log kaydı bulunmamaktadır", "danger");
                    }


                    break;

                case 'customerlogo':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }

                    $query = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:k");
                    $query->execute([':k' => $code]);
                    if ($query->rowCount()) {

                        $row = $query->fetch(PDO::FETCH_OBJ);

                        if (isset($_POST['upp'])) {

                            require_once 'inc/class.upload.php';
                            $image  = new Upload($_FILES['bimage']);
                            if ($image->uploaded) {

                                $rname = $code . "-" . uniqid();
                                $image->allowed = array("image/png");
                                $image->file_new_name_body = $rname;
                                $image->file_max_size      = 1024 * 1024; //max 1 mb
                                $image->process("../uploads/customer");

                                if ($image->processed) {

                                    $up = $db->prepare("UPDATE bayiler SET bayilogo=:logo WHERE bayikodu=:k");
                                    $up->execute([':logo' => $rname . '.png', ':k' => $code]);
                                    if ($up) {
                                        @unlink("../uploads/customer/" . $row->bayilogo);
                                        alert("Bayi logosu güncellendi", "success");
                                        go($_SERVER['HTTP_REFERER'], 2);
                                    } else {
                                        alert("Hata oluştu", "danger");
                                    }
                                } else {
                                    alert("Resim yüklenemedi", "danger");
                                }
                            } else {
                                alert("Resim seçmediniz", "danger");
                            }
                        }
                    ?>


                        <div class="tile">
                            <h3 class="tile-title"><?php echo $row->bayiadi . "(" . $code . ")"; ?> Adlı Bayiyi Güncelliyorsunuz</h3>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="tile-body">

                                    <div class="form-group">
                                        <label class="control-label">Bayi Logo</label>
                                        <img src="<?php echo $site . '/uploads/customer/' . $row->bayilogo; ?>" width="250" height="250" />
                                        <input class="form-control" name="bimage" type="file">
                                    </div>

                                </div>
                                <div class="tile-footer">
                                    <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/customers.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                                </div>

                            </form>
                        </div>

                    <?php

                    } else {
                        go(admin);
                    }

                    break;

                case 'customeredit':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }

                    $query = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:k");
                    $query->execute([':k' => $code]);
                    if ($query->rowCount()) {

                        $row = $query->fetch(PDO::FETCH_OBJ);

                        if (isset($_POST['upp'])) {

                            $bname  = post('bname');
                            $bmail  = post('bmail');
                            $bpass  = post('bpass');
                            $bgift  = post('bgift');
                            $bphone = post('bphone');
                            $bfax   = post('bfax');
                            $bvno   = post('bvno');
                            $bvd    = post('bvd');
                            $bweb   = post('bweb');
                            $bstatus = post('bstatus');

                            if (!$bname || !$bmail || !$bphone || !$bvd || !$bvno || !$bstatus) {
                                alert("Web site, indirim oranı ve fax dışındakileri doldurunuz", "danger");
                            } else {

                                if (!filter_var($bmail, FILTER_VALIDATE_EMAIL)) {
                                    alert("Hatalı e-posta", "danger");
                                } else {

                                    $already = $db->prepare("SELECT bayikodu,bayimail FROM bayiler WHERE bayimail=:m AND bayikodu !=:k");
                                    $already->execute([':m' => $bmail, ':k' => $code]);
                                    if ($already->rowCount()) {
                                        alert("Bu e-posta adresi sistemde kayıtlı", "danger");
                                    } else {

                                        if ($_POST['bpass'] == "") {

                                            $up = $db->prepare("UPDATE bayiler SET
                                        bayiadi          =:a,
                                        bayimail         =:m,
                                        bayiindirim      =:i,
                                        bayitelefon      =:t,
                                        bayifaks          =:f,
                                        bayivergino      =:v,
                                        bayivergidairesi =:d,
                                        bayisite         =:si,
                                        bayidurum        =:du WHERE bayikodu=:k
                                    ");

                                            $up->execute([
                                                ':a'   => $bname,
                                                ':m'   => $bmail,
                                                ':i'   => $bgift,
                                                ':t'   => $bphone,
                                                ':f'   => $bfax,
                                                ':v'   => $bvno,
                                                ':d'   => $bvd,
                                                ':si'  => $bweb,
                                                ':du'  => $bstatus,
                                                ':k'   => $code
                                            ]);
                                        } else {

                                            $up = $db->prepare("UPDATE bayiler SET
                                        bayiadi          =:a,
                                        bayimail         =:m,
                                        bayiindirim      =:i,
                                        bayitelefon      =:t,
                                        bayifaks          =:f,
                                        bayivergino      =:v,
                                        bayivergidairesi =:d,
                                        bayisite         =:si,
                                        bayidurum        =:du,
                                        bayisifre        =:sif WHERE bayikodu=:k
                                    ");

                                            $up->execute([
                                                ':a'   => $bname,
                                                ':m'   => $bmail,
                                                ':i'   => $bgift,
                                                ':t'   => $bphone,
                                                ':f'   => $bfax,
                                                ':v'   => $bvno,
                                                ':d'   => $bvd,
                                                ':si'  => $bweb,
                                                ':du'  => $bstatus,
                                                ':sif' => sha1(md5($bpass)),
                                                ':k'   => $code
                                            ]);
                                        }

                                        if ($up) {
                                            alert("Bayi başarıyla güncellendi", "success");
                                            go($_SERVER['HTTP_REFERER'], 2);
                                        } else {
                                            alert("Hata oluştu", "danger");
                                        }
                                    }
                                }
                            }
                        }
                    ?>

                        <div class="tile">
                            <h3 class="tile-title"><?php echo $row->bayiadi . "(" . $code . ")"; ?> Adlı Bayiyi Güncelliyorsunuz</h3>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="tile-body">

                                    <div class="form-group">
                                        <label class="control-label">Bayi Adı</label>
                                        <input class="form-control" name="bname" type="text" placeholder="Bayi adı" value="<?php echo $row->bayiadi; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bayi Mail</label>
                                        <input class="form-control" name="bmail" type="text" placeholder="Bayi mail" value="<?php echo $row->bayimail; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bayi Şifre</label>
                                        <span style="color:#b10021">Değiştirmek istemiyorsanız boş bırakınız...</span>
                                        <input class="form-control" name="bpass" type="text" placeholder="Bayi şifresi" value="">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bayi İndirim Oranı (%)</label>
                                        <input class="form-control" name="bgift" type="number" placeholder="Bayi indirim oranı" value="<?php echo $row->bayiindirim; ?>">
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label">Bayi Telefon</label>
                                        <input class="form-control" name="bphone" type="number" placeholder="Bayi telefon" value="<?php echo $row->bayitelefon; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bayi Fax</label>
                                        <input class="form-control" name="bfax" type="number" placeholder="Bayi telefon" value="<?php echo $row->bayifax; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bayi Vergi No</label>
                                        <input class="form-control" name="bvno" type="text" placeholder="Bayi vergi no" value="<?php echo $row->bayivergino; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bayi Vergi Dairesi</label>
                                        <input class="form-control" name="bvd" type="text" placeholder="Bayi vergi dairesi" value="<?php echo $row->bayivergidairesi; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bayi Web Site</label>
                                        <input class="form-control" name="bweb" type="text" placeholder="Bayi web sitesi" value="<?php echo $row->bayisite; ?>">
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label">Bayi Durum</label>

                                        <select name="bstatus" class="form-control">
                                            <option value="1" <?php echo $row->bayidurum == 1 ? 'selected' : null; ?>>Aktif</option>
                                            <option value="2" <?php echo $row->bayidurum == 2 ? 'selected' : null; ?>>Pasif</option>
                                        </select>

                                    </div>

                                </div>
                                <div class="tile-footer">
                                    <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/customers.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                                </div>

                            </form>
                        </div>
                    <?php

                    } else {
                        go(admin);
                    }
                    break;

                case 'pagedelete':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT id,kapak FROM sayfalar WHERE id = :b");
                    $query->execute([
                        ':b' => $code
                    ]);

                    if ($query->rowCount()) {
                        $row = $query->fetch(PDO::FETCH_OBJ);
                        $delete = $db->prepare("DELETE FROM sayfalar WHERE id = :k");
                        $result = $delete->execute([
                            ':k' => $code
                        ]);
                        if ($result) {
                            alert("Sayfa silindi", 'success');
                            @unlink('../uploads/' . $row['kapak']);
                            go($_SERVER['HTTP_REFERER'], 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }


                    break;

                case 'messagedelete':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT * FROM mesajlar WHERE id = :b");
                    $query->execute([
                        ':b' => $code
                    ]);

                    if ($query->rowCount()) {
                        $delete = $db->prepare("DELETE FROM mesajlar WHERE id = :k");
                        $result = $delete->execute([
                            ':k' => $code
                        ]);
                        if ($result) {
                            alert("Mesaj silindi", 'success');
                            go($_SERVER['HTTP_REFERER'], 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }


                    break;
                case 'deletebank':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT bankaid FROM bankalar WHERE bankaid = :b");
                    $query->execute([
                        ':b' => $code
                    ]);

                    if ($query->rowCount()) {
                        $delete = $db->prepare("UPDATE bankalar SET bankadurum = :d WHERE bankaid =:k");
                        $result = $delete->execute([
                            ':d' => 2,
                            ':k' => $code
                        ]);
                        if ($result) {
                            alert("Banka hesabı pasife alındı", 'success');
                            go(admin . '/banks.php', 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }


                    break;

                case 'statusdelete':
                    $id = get('id');
                    if (!$id) {
                        go(admin);
                    }


                    $dquery = $db->prepare("SELECT id,durumkodu,silinmeyen_durum FROM durumkodlari WHERE silinmeyen_durum=:si");
                    $dquery->execute([':si' => 1]);
                    $queryrow = $dquery->fetch(PDO::FETCH_OBJ);



                    $query = $db->prepare("SELECT * FROM durumkodlari WHERE durumkodu=:b");
                    $query->execute([':b' => $id]);

                    if ($query->rowCount()) {
                        $row  = $query->fetch(PDO::FETCH_OBJ);
                        if ($row->silinmeyen_durum == 1) {
                            alert('Bu durum silinmez olarak ayarlanmıştır', 'danger');
                        } else {
                            // ! silinecek kategorideki ürünlerin urunkatid'sini silinmeyenkategorinin id'si yapıyoruz
                            $up = $db->prepare("UPDATE siparisler SET siparisdurum=:k WHERE siparisdurum=:kk");
                            $up->execute([':k' => $queryrow->durumkodu, ':kk' => $id]);
                            if ($up) {

                                $delete = $db->prepare('DELETE FROM durumkodlari WHERE durumkodu=:id');
                                $result = $delete->execute([':id' => $id]);
                                if ($result) {
                                    alert("Durum kodu silindi ve bu durum koduna ait tüm siparişlern durumu silinmez duruma aktarıldı", "success");
                                    go(admin . "/statuslist.php", 2);
                                } else {
                                    alert("Hata oluştu", "danger");
                                }
                            }
                        }
                    } else {
                        go(admin);
                    }


                    break;

                case 'commentdelete':
                    $code = get('id');

                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT id FROM urun_yorumlar WHERE id = :u");
                    $query->execute([
                        ':u' => $code,
                    ]);
                    if ($query->rowCount()) {
                        $delete = $db->prepare("DELETE FROM urun_yorumlar WHERE id =:u ");
                        $result = $delete->execute([
                            ':u' => $code,
                        ]);
                        if ($result) {
                            alert("Ürün yorumu silindi", 'success');
                            go(admin . '/comments.php', 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }

                    break;

                case 'deletenotification':
                    $code = get('id');
                    $bayi = get('bayi');

                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT id FROM havalebildirim WHERE id = :u");
                    $query->execute([
                        ':u' => $code,
                    ]);

                    if ($query->rowCount()) {
                        $delete = $db->prepare("DELETE FROM havalebildirim WHERE id =:u AND havalebayi = :b");
                        $result = $delete->execute([
                            ':u' => $code,
                            ':b' => $bayi
                        ]);
                        if ($result) {
                            alert($bayi . " kodlu bayinin havale bildirimi silindi", 'success');
                            go(admin . '/notifications.php', 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }


                    break;


                case 'deletecart':
                    $code = get('id');
                    $bayi = get('bayi');

                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT sepeturun FROM sepet WHERE sepeturun = :u");
                    $query->execute([
                        ':u' => $code,
                    ]);

                    if ($query->rowCount()) {
                        $delete = $db->prepare("DELETE FROM sepet WHERE sepeturun =:u AND sepetbayi = :b");
                        $result = $delete->execute([
                            ':u' => $code,
                            ':b' => $bayi
                        ]);
                        if ($result) {
                            alert("Ürün sepetten silindi", 'success');
                            go(admin . '/cart.php', 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }


                    break;

                case 'orderdelete':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }



                    $query = $db->prepare("SELECT sipariskodu,siparisdurum FROM siparisler WHERE sipariskodu = :b");
                    $query->execute([
                        ':b' => $code
                    ]);

                    if ($query->rowCount()) {
                        $rowk = $query->fetch(PDO::FETCH_OBJ);

                        if (isset($_POST['up'])) {
                            $status = post('orderstatus');
                            if (!$status) {
                                alert('durum seçiniz', 'danger');
                            } else {
                                $up = $db->prepare("UPDATE siparisler SET 
                                siparisdurum = :d WHERE sipariskodu = :k");
                                $up->execute([
                                    ':d' => $status,
                                    ':k' => $code
                                ]);
                                if ($up->rowCount()) {
                                    alert('Sipariş güncellendi', 'success');
                                    go(admin . "/orders.php", 2);
                                } else {
                                    alert('hata oluştu', 'danger');
                                }
                            }
                        }
                    ?>

                        <div class="tile">
                            <h3 class="tile-title">Sipariş silme ekranı</h3>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="tile-body">

                                    <div class="form-group">
                                        <label class="control-label">Sipariş durumu seçiniz</label>
                                        <select name="orderstatus" class="form-control">
                                            <?php
                                            $dcode = $db->prepare("SELECT * FROM durumkodlari WHERE durumdurum = :d");
                                            $dcode->execute([
                                                ':d' => 1
                                            ]);
                                            if ($dcode->rowCount()) {
                                                foreach ($dcode as $dco) { ?>
                                                    <option <?php echo $dco['durumkodu'] == $rowk->siparisdurum ? 'selected' : null; ?> value="<?php echo $dco['durumkodu'] ?>"><?php echo $dco['durumbaslik'] ?> </option>'
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>





                                </div>
                                <div class="tile-footer">
                                    <button class="btn btn-primary" name="up" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Sipariş durumunu güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/categories.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                                </div>

                            </form>


                        </div>

                    <?php

                    } else {
                        go(admin);
                    }


                    break;

                case 'deleteproduct':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT urunkodu FROM urunler WHERE urunkodu = :b");
                    $query->execute([
                        ':b' => $code
                    ]);

                    if ($query->rowCount()) {
                        $delete = $db->prepare("UPDATE urunler SET urundurum = :d WHERE urunkodu =:k");
                        $result = $delete->execute([
                            ':d' => 2,
                            ':k' => $code
                        ]);
                        if ($result) {
                            alert("Ürün pasife alındı", 'success');
                            go(admin . '/products.php', 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }


                    break;



                case 'deletecategory':
                    $id = get('id');
                    if (!$id) {
                        go(admin);
                    }

                    // ! silinmeyen kategori bul
                    $dquery = $db->prepare("SELECT id,silinmeyen_kat FROM urun_kategoriler WHERE silinmeyen_kat=:si");
                    $dquery->execute([':si' => 1]);
                    $queryrow = $dquery->fetch(PDO::FETCH_OBJ);

                    // ! bize gelen id'nin kategorisine ait herşeyi getir

                    $query = $db->prepare("SELECT * FROM urun_kategoriler WHERE id=:b");
                    $query->execute([':b' => $id]);

                    if ($query->rowCount()) {
                        $row  = $query->fetch(PDO::FETCH_OBJ);
                        if ($row->silinmeyen_kat == 1) {
                            alert('Bu kategori silinmez olarak ayarlanmıştır', 'danger');
                        } else {
                            // ! silinecek kategorideki ürünlerin urunkatid'sini silinmeyenkategorinin id'si yapıyoruz
                            $up = $db->prepare("UPDATE urunler SET urunkatid=:k WHERE urunkatid=:kk");
                            $up->execute([':k' => $queryrow->id, ':kk' => $id]);
                            if ($up) {

                                $delete = $db->prepare('DELETE FROM urun_kategoriler WHERE id=:id');
                                $result = $delete->execute([':id' => $id]);
                                if ($result) {
                                    alert("Kategori silindi ve içerikleri silinmez kategoriye aktarıldı", "success");
                                    @unlink("../uploads/product/" . $row->katresim);
                                    go(admin . "/categories.php", 2);
                                } else {
                                    alert("Hata oluştu", "danger");
                                }
                            }
                        }
                    } else {
                        go(admin);
                    }


                    break;

                case 'customerdelete':
                    $code = get('id');
                    if (!$code) {
                        go(admin);
                    }
                    $query = $db->prepare("SELECT bayikodu FROM bayiler WHERE bayikodu = :b");
                    $query->execute([
                        ':b' => $code
                    ]);

                    if ($query->rowCount()) {
                        $delete = $db->prepare("UPDATE bayiler SET bayidurum = :d WHERE bayikodu =:k");
                        $result = $delete->execute([
                            ':d' => 2,
                            ':k' => $code
                        ]);
                        if ($result) {
                            alert("Bayi pasife alındı", 'success');
                            go(admin . '/customers.php', 2);
                        } else {
                            alert('Hata oluştu', 'danger');
                        }
                    } else {
                        go(admin);
                    }


                    break;



                case 'newproduct':

                    if (isset($_POST['add'])) {
                        $pname = post('pname');
                        $purl = post('purl');
                        if (!$purl) {
                            $seflink = sef_link($pname);
                        } else {
                            $seflink = $purl;
                        }
                        $pcontent = $_POST["pcontent"];
                        $pcat = post('pcat');
                        $pcode = post('pcode');
                        $pstock = post('pstock');
                        $pprice = post('pprice');
                        $pseok = post('pseokeyw');
                        $pseod = post('pseod');
                        $pv = post('pv');


                        if (!$pname  || !$pcontent || !$pcat || !$pcode || !$pstock || !$pseok || !$pprice || !$pseod || !$pv) {
                            alert('Tüm alanları doldur', 'danger');
                        } else {
                            $already = $db->prepare("SELECT urunsef,urunkodu FROM urunler WHERE urunsef = :s OR urunkodu = :k");
                            $already->execute([
                                ':s' => $seflink,
                                ':k' => $pcode
                            ]);
                            if ($already->rowCount()) {
                                alert('Bu ürün koduna veya seflinke ait ürün zaten kayıtlı', 'danger');
                            } else {
                                require_once 'inc/class.upload.php';
                                $image = new Upload($_FILES['pimage']);
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
                                        $image->process("../uploads/product/");
                                        if ($image->processed) {



                                            $add = $db->prepare("INSERT INTO urunler SET
                                             urunkatid =:k ,
                                             urunbaslik = :b,
                                             urunsef = :s,
                                             urunicerik = :i,
                                             urunkapak = :kp,
                                             urunfiyat = :f,
                                             urunkodu = :c,
                                             urunstok = :ss,
                                             urunkeyw = :keyw,
                                             urundesc = :desc,
                                             urunekleyenid = :ek,
                                             urunvitrin = :vi

                                        ");
                                            $result = $add->execute([
                                                ':k' => $pcat,
                                                ':b' => $pname,
                                                ':s' => $seflink,
                                                ':i' => $pcontent,
                                                ':kp' => $rname . '.png',
                                                ':f' => $pprice,
                                                ':c' => $pcode,
                                                ':ss' => $pstock,
                                                ':keyw' => $pseok,
                                                ':desc' => $pseod,
                                                ':ek' => $aid,
                                                ':vi' => $pv,

                                            ]);

                                            $urun = $db->prepare("INSERT INTO urun_resimler SET 
                                            resimurun = :ru,
                                            kapak = :k,
                                            resimdosya = :rd,
                                            resimekleyen = :e
                                            ");

                                            $urun->execute([
                                                ':ru' => $pcode,
                                                ':k' => 2,
                                                ':rd' => $rname . '.png',
                                                ':e' => $aid
                                            ]);

                                            if ($urun->rowCount() <= 0) {
                                                alert('ürün resimleri yüklenemedi', 'danger');
                                            }

                                            if ($result) {
                                                alert('Ürün Eklendi ', 'success');
                                                go(admin . "/products.php", 2);
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
                        <h3 class="tile-title">Yeni Ürün Ekle</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="tile-body">

                                <div class="form-group">
                                    <label class="control-label">Ürün Adı</label>
                                    <input class="form-control" name="pname" type="text" placeholder="Ürün Adı">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Ürün SEO URL (örn: asus-pc-i5)</label>
                                    <input class="form-control" name="purl" type="text" placeholder="Ürün SEO URL">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Ürün Kategorisi</label>
                                    <select name="pcat" class="form-control">
                                        <option value="0">Kategori Seçiniz</option>
                                        <?php
                                        $cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum = :d");
                                        $cat->execute([
                                            ':d' => 1
                                        ]);
                                        if ($cat->rowCount()) {
                                            foreach ($cat as $c) {
                                                echo '<option value ="' . $c['id'] . '"> ' . $c['katbaslik'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Ürün Kodu</label>
                                    <input class="form-control" name="pcode" type="text" placeholder="Ürün Kodu">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Ürün Kapak Resim</label>
                                    <input class="form-control" type="file" name="pimage">
                                </div>



                                <div class="form-group">
                                    <label class="control-label">Vitrin Durumu</label>
                                    <select name="pv" class="form-control">
                                        <option value="0">Vitrin Durumu Seçiniz</option>
                                        <option value="1">Vitrinde görünsün</option>
                                        <option value="2">Kategori listesinde görünsün</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Ürün SEO Keywords</label>
                                    <input class="form-control" name="pseokeyw" type="text" placeholder="Ürün SEO Keywords">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Ürün SEO Description</label>
                                    <input class="form-control" name="pseod" type="text" placeholder="Ürün SEO Description">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Ürün Stok</label>
                                    <input class="form-control" name="pstock" type="number" placeholder="Ürün Stok">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Ürün Fiyat</label>
                                    <input class="form-control" name="pprice" type="text" placeholder="Ürün Fiyat">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Ürün Açıklama</label>
                                    <textarea class="ckeditor" name="pcontent"></textarea>
                                </div>

                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" name="add" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>
                                    Kayıt Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/products.php">
                                    <i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                            </div>

                        </form>


                    </div>

                <?php
                    break;

                case 'newpage':

                    if (isset($_POST['add'])) {
                        $pname = post('pname');
                        $purl = post('purl');
                        $pcontent = $_POST["pcontent"];
                        if (!$purl) {
                            $seflink = sef_link($pname);
                        } else {
                            $seflink = $purl;
                        }


                        if (!$pname  || !$pcontent) {
                            alert('Tüm alanları doldur', 'danger');
                        } else {
                            $already = $db->prepare("SELECT sef FROM sayfalar WHERE sef = :k");
                            $already->execute([
                                ':k' => $seflink
                            ]);
                            if ($already->rowCount()) {
                                alert('Bu kategori zaten kayıtlı', 'danger');
                            } else {
                                require_once 'inc/class.upload.php';
                                $image = new Upload($_FILES['pimage']);
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
                                            $add = $db->prepare("INSERT INTO sayfalar SET
                                             baslik =:k ,
                                             sef = :s,
                                             icerik = :ke,
                                             kapak = :de,
                                             ekleyen = :e
                                        ");
                                            $result = $add->execute([
                                                ':k' => $pname,
                                                ':s' => $seflink,
                                                ':ke' => $pcontent,
                                                ':de' => $rname . '.png',
                                                ':e' => $aid

                                            ]);

                                            if ($result) {
                                                alert('Sayfa Eklendi ', 'success');
                                                go(admin . "/pages.php", 2);
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
                        <h3 class="tile-title">Yeni Sayfa Ekle</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="tile-body">

                                <div class="form-group">
                                    <label class="control-label">Sayfa Adı</label>
                                    <input class="form-control" name="pname" type="text" placeholder="Sayfa Adı">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Sayfa SEO URL (örn: Misyon-vizyon)</label>
                                    <input class="form-control" name="purl" type="text" placeholder="Sayfa SEO URL">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Sayfa Kapak Resim</label>
                                    <input class="form-control" type="file" name="pimage">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Sayfa İçerik</label>
                                    <textarea class="ckeditor" name="pcontent"></textarea>

                                </div>




                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" name="add" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>
                                    Kayıt Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin; ?>/pages.php">
                                    <i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
                            </div>

                        </form>


                    </div>

                <?php
                    break;
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
                                        $image->process("../uploads/product/");
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