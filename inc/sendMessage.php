<?php

require_once '../system/function.php';

if ($_POST) {

    $name = post('name');
    $email = post('email');
    $subject = post('subject');
    $message = post('message');
    if (isset($_SESSION['login'])) {
        $bcode = $bcode;
    } else {
        $bcode = "Belirtilmemiş";
    }


    if (!$name || !$email || !$message) {
        echo 'empty';
    } elseif (strlen($message) < 100) {
        echo 'char';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'format';
    } else {
        $result = $db->prepare("INSERT INTO mesajlar SET
            mesajisim= :mi,
            mesajposta= :mp,
            mesajkonu= :mk,
            mesajicerik=:mic,
            mesajip = :i
        ");

        $result->execute([
            ':mi'   => $name,
            ':mp' => $email,
            ':mk' => $subject,
            ':mic' => $message,
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
            $mail->Subject = $subject;
            $mailcontent = "
            <p><b>Adı:</b>" . $name . "</p>
            <p><b>E-posta:</b>" . $email . "</p>
            <p><b>Konu:</b>" . $subject . "</p>
            <p><b>Mesaj:</b>" . $message . "</p>
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
                ':a' => 'Yeni mesaj gönderimi yaptı'
            ]);
            echo "ok";
        } else {
            echo 'error';
        }
    }
}
