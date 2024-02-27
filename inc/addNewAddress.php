
<?php

require_once '../system/function.php';

if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {

    $adresbaslik  = post('adresbaslik');
    $adrestarif = post('adrestarif');

    if (!$adresbaslik || !$adrestarif) {

        echo 'empty';
    } else {

        $result = $db->prepare("INSERT INTO bayi_adresler SET
                
                 adresbaslik= :adresbaslik 
                 , adrestarif= :adrestarif
                 , adresdurum= :adresdurum 
                 , adresbayi=:kod 

            ");

        $result->execute([
            ':kod'   => $bcode,
            ':adresbaslik' => $adresbaslik,
            ':adrestarif' => $adrestarif,
            ':adresdurum' => 1
        ]);


        if ($result->rowCount()) {
            echo "ok";
        } else {
            echo 'error';
        }
    }
}
