
<?php

require_once '../system/function.php';

if (@$_SESSION['login'] != @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {

    $comment = post('commentcontent');
    $product = post('productcode');

    if (!$comment || !$product) {

        echo 'empty';
    } else {

        if (strlen($comment) < 200) {
            echo 'char';
        } else {
            $result = $db->prepare("INSERT INTO urun_yorumlar SET
            yorumbayi= :yb,
            yorumurun= :yu,
            yorumisim= :yi,
            yorumicerik=:yic,
            yorumdurum = :yd,
            yorumip = :i
");

            // ! bname config php ' den gelyor bcode'da aynı
            $result->execute([
                ':yb'   => $bcode,
                ':yu' => $product,
                ':yi' => $bname,
                ':yic' => $comment,
                ':yd' => 1,
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
