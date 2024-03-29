<?php

require_once '../system/function.php';

if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {

    $bpass  = post('password');
    $bpass2 = post('password2');
    $crypto = sha1(md5($bpass));


    if (!$bpass || !$bpass2) {

        echo 'empty';
    } else {

        if ($bpass != $bpass2) {
            echo 'match';
        } else {

            $result = $db->prepare("UPDATE bayiler SET
                
                bayisifre=:bsifre WHERE bayikodu=:kod AND id=:id

            ");

            $result->execute([
                ':bsifre'     => $crypto,
                ':kod'   => $bcode,
                ':id'    => $bid
            ]);

            if ($result) {
                $log = $db->prepare("INSERT INTO bayi_loglar SET 
                logbayi = :b,
                logip = :i,
                logaciklama = :a
            ");
                $log->execute([
                    ':b' => $par->bayikodu,
                    ':i' => IP(),
                    ':a' => 'Kullanıcı şifresini değiştirdi'
                ]);

                echo 'ok';
            } else {
                echo 'error';
            }
        }
    }
}
