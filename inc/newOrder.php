
<?php

require_once '../system/function.php';

if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {

    $name  = post('name');
    $phone = post('phone');
    $payment = post('payment');
    $note = post('note');
    $address = post('address');
    $code = uniqid();

    if (!$name || !$phone || !$payment || !$address) {

        echo 'empty';
    } else {

        $carttotal = $db->prepare("SELECT SUM(toplam) as toplamfiyat FROM sepet WHERE sepetbayi = :b ");
        $carttotal->execute([
            ':b' => $bcode
        ]);
        $carttotalrow = $carttotal->fetch(PDO::FETCH_OBJ);

        $result = $db->prepare("INSERT INTO siparisler SET 
            siparisbayi = :b,
            siparisisim = :i,
            siparistel = :t,
            siparistarih = :ta,
            siparissaat= :sa,
            siparisnot = :not,
            siparistutar = :sip,
            siparisodeme = :so,
            sipariskodu = :code,
            siparisadres = :ad
            ");

        $result->execute([
            ':b' => $bcode,
            ':i' => $name,
            ':t' => $phone,
            ':ta' => date("Y-m-d"),
            ':sa' => date("H-i"),
            ':not' => $note,
            ':sip' => $carttotalrow->toplamfiyat,
            ':so' => $payment,
            ':code' => $code,
            ':ad' => $address
        ]);



        if ($result->rowCount()) {
            // ! sepetteki ürünleri siparislere aktaracaz
            $cart = $db->prepare("SELECT * FROM sepet INNER JOIN urunler on urunler.urunkodu = sepet.sepeturun WHERE sepetbayi = :b");
            $cart->execute([
                ':b' => $bcode
            ]);

            if ($cart->rowCount()) {
                foreach ($cart as $ca) {
                    $orderproduct = $db->prepare("INSERT INTO siparis_urunler SET 
                    sipkodu = :s,
                    sipurun = :u,
                    sipbirimfiyat = :b,
                    sipadet = :a,
                    siptoplam = :t,
                    sipurunadi = :ua
                    ");
                    $orderproduct->execute([
                        ':s' => $code,
                        ':u' => $ca['sepeturun'],
                        ':b' => $ca['birimfiyat'],
                        ':a' => $ca['sepetadet'],
                        ':t' => $ca['toplam'],
                        ':ua' => $ca['urunbaslik']
                    ]);
                }
            }

            $log = $db->prepare("INSERT INTO bayi_loglar SET 
            logbayi = :b,
            logip = :i,
            logaciklama = :a
        ");
            $log->execute([
                ':b' => $par->bayikodu,
                ':i' => IP(),
                ':a' => $code .  ' nolu siparişi oluşturdu'
            ]);


            $deletecart = $db->prepare("DELETE FROM sepet WHERE sepetbayi = :b");
            $deletecart->execute([
                ':b' => $bcode
            ]);

            echo "ok";
        } else {
            echo 'error';
        }
    }
}
