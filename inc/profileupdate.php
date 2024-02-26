<?php

require_once "../system/function.php";

// ! burdaki bcode config.php ' den geliyor login.php inc'nin altındaki encode değişkeni ile kontrol
// ! giriş yapmayan kişi profil güncelleyemez o yüzden bu kod parçası var
if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {
    $bname = post("bname");
    $bmail = post("bmail");
    $bphone = post("bphone");
    $bvno = post("bvno");
    $bvd = post("bvd");
    $bweb = post("bweb");
    if (!$bname || !$bmail ||  !$bphone || !$bvno || !$bvd) {
        // ! burası custom.js'deki empty'ye karşılık gelsin diye oluşturuldu
        echo "empty";
    } else {
        if (!filter_var($bmail, FILTER_VALIDATE_EMAIL)) {
            echo "format";
        } else {

            $already = $db->prepare("SELECT bayikodu,bayimail FROM bayiler WHERE bayimail=:b AND bayikodu !=:bayikodu");
            $already->execute([':b' => $bmail, ':bayikodu' => $bcode]);


            if ($already->rowCount()) {
                echo "already";
            } else {
                $result = $db->prepare("UPDATE bayiler SET
                   
                    bayiadi     =:bname,
                    bayimail    =:bmail,
                    bayitelefon =:bphone,
                    bayisite    =:bweb,
                    bayivergino =:bvno,
                    bayivergidairesi =:bvd WHERE bayikodu=:kod AND id=:id

                ");
                // ! burdaki bid config içerisindeki yerden geliyor
                $result->execute([
                    ':kod' => $bcode,
                    ':id' => $bid,
                    ':bname' => $bname,
                    ':bmail' => $bmail,
                    ':bphone' => $bphone,
                    ':bvno' => $bvno,
                    ':bvd' => $bvd,
                    ':bweb' => $bweb,
                ]);


                if ($result) {
                    echo "ok";
                } else {
                    echo "error";
                }
            }
        }
    }
}
