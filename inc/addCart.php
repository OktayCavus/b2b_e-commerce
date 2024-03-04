<?php

require_once '../system/function.php';

if ($_POST) {
    $qty = post('qtybutton');
    $pcode = post("pcode");

    if (@$_SESSION['login'] == @sha1(md5(IP() . $bcode))) {
        if (!$qty || !$pcode) {
            echo 'empty';
        } else {
            if ($qty < 1) {
                echo 'qty';
            } else {

                // Gelen pcode'a göre ürün bilgilerini alalım
                $prow = $db->prepare("SELECT urunkodu,urunfiyat,urundurum FROM urunler WHERE urunkodu = :k");
                $prow->execute([
                    ':k' => $pcode,
                ]);
                $productrow = $prow->fetch(PDO::FETCH_OBJ);

                if ($productrow) {
                    // Ürün varsa, toplam fiyatları hesaplayalım
                    $totalprice = ($productrow->urunfiyat) * $qty;
                    $tax = $totalprice * ($row->sitekdv / 100);
                    $subtotal = $totalprice + $tax;

                    // Mevcut sepeti kontrol edelim
                    $currentCart = $db->prepare("SELECT sepeturun,sepetadet FROM sepet WHERE sepeturun = :s AND sepetbayi = :b");
                    $currentCart->execute([
                        ':s' => $productrow->urunkodu,
                        ':b' => $bcode
                    ]);
                    if ($currentCart->rowCount()) {
                        // Mevcut sepet varsa, sepeti güncelleyelim
                        $currentCartRow = $currentCart->fetch(PDO::FETCH_OBJ);
                        $currentqty = $currentCartRow->sepetadet + $qty;

                        $totalprice = ($productrow->urunfiyat) * $currentqty;
                        $tax = $totalprice * ($row->sitekdv / 100);
                        $subtotal = $totalprice + $tax;

                        $result = $db->prepare("UPDATE sepet SET 
                            sepetadet = :sa,
                            birimfiyat = :bf,
                            toplam = :tf,
                            kdv = :kdv
                            WHERE sepeturun = :u AND sepetbayi = :b");

                        $result->execute([
                            ':sa' => $currentqty,
                            ':bf' => $productrow->urunfiyat,
                            ':tf' => $subtotal,
                            ':u' => $productrow->urunkodu,
                            ':b' => $bcode,
                            ':kdv' => $row->sitekdv
                        ]);
                    } else {
                        // Mevcut sepet yoksa, yeni bir sepet oluşturalım
                        $result = $db->prepare("INSERT INTO sepet SET 
                            sepetbayi = :sb,
                            sepeturun = :su,
                            sepetadet = :sa,
                            birimfiyat = :bf,
                            toplam = :tf,
                            sepettarih = :ta,
                            sepetsilinme = :si,
                            kdv = :kdv");

                        $result->execute([
                            ':sb' => $bcode,
                            ':su' => $productrow->urunkodu,
                            ':sa' => $qty,
                            ':bf' => $productrow->urunfiyat,
                            ':tf' => $subtotal,
                            ':ta' => date('Y-m-d'),
                            ':si' => date("Y-m-d", strtotime("+7 days")),
                            ':kdv' => $row->sitekdv
                        ]);
                    }

                    if ($result->rowCount()) {
                        echo 'ok';
                    } else {
                        echo 'error';
                    }
                } else {
                    // Ürün bulunamadıysa hata döndür
                    echo 'error';
                }
            }
        }
    } else {
        echo "login";
    }
}
