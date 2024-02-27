
<?php

require_once '../system/function.php';

if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {

    $hbank = post('hbank');
    $hdate = post('hdate');
    $hhour = post('hhour');
    $hmoney = post('hmoney');
    $hdesc = post('hdesc');

    if (!$hbank || !$hdate || !$hhour || !$hmoney) {

        echo 'empty';
    } else {

        if (!is_numeric($hmoney)) {
            echo 'number';
        } else {
            $result = $db->prepare("INSERT INTO havalebildirim SET
                
            havalebayi= :b 
            , havaletarih= :t
            , havalesaat= :s 
            , havaletutar=:tu,
            havalenot = :n,
            banka = :ba,
            havaleip = :i

       ");

            $result->execute([
                ':b'   => $bcode,
                ':t' => $hdate,
                ':s' => $hhour,
                ':n' => $hdesc,
                ':tu' => $hmoney,
                ':ba' => $hbank,
                ':i' => IP(),

            ]);

            if ($result->rowCount()) {
                echo "ok";
            } else {
                echo 'error';
            }
        }
    }
}
