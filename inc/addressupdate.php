<?php

require_once '../system/function.php';

if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {

    $adresbaslik  = post('adresbaslik');
    $adrestarif = post('adrestarif');
    $status = post("status");
    $addressid = post("addressid");

    if (!$adresbaslik || !$adrestarif || !$status || !$addressid) {

        echo 'empty';
    } else {

        $result = $db->prepare("UPDATE bayi_adresler SET
                
                 adresbaslik= :adresbaslik , adrestarif= :adrestarif,adresdurum= :adresdurum WHERE adresbayi=:kod AND id=:id

            ");

        $result->execute([
            ':kod'   => $bcode,
            ':id'    => $addressid,
            ':adresbaslik' => $adresbaslik,
            ':adrestarif' => $adrestarif,
            ':adresdurum' => $status
        ]);


        if ($result) {
            $log = $db->prepare("INSERT INTO bayi_loglar SET 
            logbayi = :b,
            logip = :i,
            logaciklama = :a
            ");
            $log->execute([
                ':b' => $bcode,
                ':i' => IP(),
                ':a' => $addressid . " id'li adresi güncelledi"
            ]);
            echo  "ok";
        } else {
            echo 'error';
        }
    }
}
