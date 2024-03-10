<?php


require_once "../system/function.php";
if (@$_SESSION['login'] == @sha1(md5(IP() . $bcode))) {
    go(site);
}

if ($_POST) {


    $bcode = post('bcode');
    $bmail = post('bmail');
    $code = uniqid('oktaycavus_');
    $codelink = site . "/recovery-password/" . $code;
    if (!$bcode || !$bmail) {
        echo 'empty';
    } else {
        $row2 = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:k AND bayimail=:m");
        $row2->execute([':k' => $bcode, ':m' => $bmail]);
        if ($row2->rowCount()) {

            $up = $db->prepare("UPDATE bayiler SET sifirlamakodu=:s WHERE bayikodu=:k AND bayimail=:m");
            $up->execute([':s' => $code, ':k' => $bcode, ':m' => $bmail]);

            require_once 'class.phpmailer.php';
            require_once 'class.smtp.php';

            $mail = new PHPMailer();
            $mail->Host       = $row->smtphost;
            $mail->Port       = $row->smtpport;
            $mail->SMTPSecure = $row->smtpsec;
            $mail->Username   = $row->smtpmail;
            $mail->Password   = $row->smtpsifre;
            $mail->SMTPAuth   = true;
            $mail->IsSMTP();
            $mail->AddAddress($bmail);

            $mail->From       = $row->smtpmail;
            $mail->FromName   = "Şifre Sıfırlama";
            $mail->CharSet    = 'UTF-8';
            $mail->Subject    = "Şifre sıfırlama linkiniz";
            $mailcontent      = "
            <p>Şifrenizi sıfırlamak için lütfen aşağıda yer alan linke tıklayınız</p>
            <p><b>Sıfırlama linki :</b>" . $codelink . "</p>
            ";

            $mail->MsgHTML($mailcontent);
            if ($mail->Send()) {
            }
            echo 'ok';
        } else {
            echo 'error';
        }
    }
}
