<?php

require_once '../system/function.php';

if ($_POST) {

    $name = post('name');
    $email = post('email');
    $subject = post('subject');
    $message = post('message');

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
            echo "ok";
        } else {
            echo 'error';
        }
    }
}
