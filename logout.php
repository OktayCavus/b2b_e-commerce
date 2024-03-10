<?php

require_once 'system/function.php';

$log = $db->prepare("INSERT INTO bayi_loglar SET 
logbayi = :b,
logip = :i,
logaciklama = :a
");
$log->execute([
    ':b' => $bcode,
    ':i' => IP(),
    ':a' => 'Çıkış Yapıldı'
]);


session_destroy();
header('Location:' . site);
