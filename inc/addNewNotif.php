
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

                require_once 'class.phpmailer.php';
                require_once 'class.smtp.php';

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
                $mail->Subject = 'havale bildirimi';
                $mailcontent = "
                <p><b>Bayi Kodu:</b>" . $bcode . "</p>
                <p><b>Tarih:</b>" . $hdate . "</p>
                <p><b>Saat:</b>" . $hhour . "</p>
                <p><b>Miktar:</b>" . $hmoney . "</p>
                <p><b>Banka:</b>" . $hbank . "</p>
                <p><b>Not:</b>" . $hdesc . "</p>
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
                    ':b' => $bcode,
                    ':i' => IP(),
                    ':a' => "Yeni havale bildirimi yaptı"
                ]);
                echo "ok";
            } else {
                echo 'error';
            }
        }
    }
}
