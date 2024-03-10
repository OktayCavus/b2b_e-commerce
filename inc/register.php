<?php

require_once "../system/function.php";

// ! burdaki bcode config.php ' den geliyor login.php inc'nin altındaki encode değişkeni ile kontrol

if (@$_SESSION['login'] == @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {

    $bname = post("bname");
    $bmail = post("bmail");
    $bpass = post("bpass");
    $bpass2 = post("bpass2");
    $bphone = post("bphone");
    $bvno = post("bvno");
    $bvd = post("bvd");
    $bcodee = uniqid();
    $crypto = sha1(md5($bpass));

    if (!$bname || !$bmail || !$bpass || !$bpass2 || !$bphone || !$bvno || !$bvd) {
        // ! burası custom.js'deki empty'ye karşılık gelsin diye oluşturuldu
        echo "empty";
    } else {
        if (!filter_var($bmail, FILTER_VALIDATE_EMAIL)) {
            echo "format";
        } else {
            if ($bpass != $bpass2) {
                echo "match";
            } else {
                $already = $db->prepare("SELECT bayimail FROM bayiler WHERE bayimail=:b");

                $already->execute([':b' => $bmail]);


                if ($already->rowCount()) {
                    echo "already";
                } else {
                    $result = $db->prepare("INSERT INTO bayiler SET 
                    bayikodu=:bcode ,
                    bayiadi=:bname,
                    bayimail=:bmail,
                    bayisifre=:bpass,
                    bayitelefon=:bphone,
                    bayivergino=:bvno,
                    bayivergidairesi=:bvd
                    ");

                    $result->execute([
                        ':bcode' => $bcodee,
                        ':bname' => $bname,
                        ':bmail' => $bmail,
                        ':bpass' => $crypto,
                        ':bphone' => $bphone,
                        ':bvno' => $bvno,
                        ':bvd' => $bvd
                    ]);


                    if ($result->rowCount()) {


                        $mail = new PHPMailer();
                        $mail->Host = $row->smtphost;
                        $mail->Port = $row->smtpport;
                        $mail->SMTPSecure = $row->smtpsec;
                        $mail->Username = $row->smtpmail;
                        $mail->Password = $row->smtpsifre;
                        $mail->SMTPAuth = true;
                        // ! SMTP sınıfı başlasın
                        $mail->IsSMTP();
                        $mail->AddAddress($row->smtpkime);

                        $mail->From = $row->smtpmail;
                        $mail->FromName = "Mail başlığı burası";
                        $mail->CharSet = "UTF-8";
                        $mail->Subject = "Yeni bayi kaydı";
                        $mailcontent = "
                        <p><b>Bayi Kodu:</b>" . $bcode . "</p>
                        <p><b>Bayi Adı:</b>" . $bname . "</p>
                        <p><b>Bayi Mail:</b>" . $bmail . "</p>
                        <p><b>Bayi Telefon:</b>" . $bphone . "</p>
                        <p><b>Vergi No:</b>" . $bvno . "</p>
                        <p><b>Vergi Dairesi:</b>" . $bvd . "</p>
                        <p><b>IP:</b>" . IP() . "</p>
                        ";

                        $mail->MsgHTML($mailcontent);
                        $mail->Send();

                        $log = $db->prepare("INSERT INTO bayi_loglar SET 
                        logbayi = :b,
                        logip = :i,
                        logaciklama = :a
                    ");
                        $log->execute([
                            ':b' => $bcodee,
                            ':i' => IP(),
                            ':a' => 'Yeni kayıt oluşturuldu'
                        ]);
                        echo "ok";
                    } else {
                        echo "error";
                    }
                }
            }
        }
    }
}
