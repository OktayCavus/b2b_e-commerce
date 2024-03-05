<?php


session_start();
ob_start('compress');
date_default_timezone_set('Europe/Istanbul');

try {
    $db = new PDO('mysql:host=localhost;dbname=b2b;charset=utf8', 'root', '');
    $db->query("SET CHARACTER SET utf8");
    $db->query("SET NAMES utf8");
} catch (Exception $e) {
    print_r($e->getMessage());
    die();
}


$query = $db->query("SELECT * FROM ayarlar LIMIT 1");
$query->execute();


if ($query->rowCount()) {
    $row = $query->fetch(PDO::FETCH_OBJ);

    $site = $row->siteurl;
    $sitebaslik = $row->sitebaslik;
    $sitekeyw = $row->sitekeyw;
    $sitedesc = $row->sitedesc;
    $sitelogo = $row->sitelogo;


    // Sabitler
    define('site', $site);
    define('baslik', $row->sitebaslik);
}


## giris kontrolleri
function IP2()
{

    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode(',', $ip);
            $ip = trim($tmp[0]);
        }
    } else {
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

// ! burdaki kod sayesinde benim session'um anlık olarak güncelleniyor
if (@$_SESSION['login'] == @sha1(md5(IP2() . $_SESSION['code']))) {
    $logincontrol = $db->prepare("select * from bayiler where id=:id AND bayikodu=:k");
    $logincontrol->execute([
        ':id' => $_SESSION['id'],
        ':k' => $_SESSION['code']
    ]);
    if ($logincontrol->rowCount()) {
        $par = $logincontrol->fetch(PDO::FETCH_OBJ);

        if ($par->bayidurum == 1) {
            $bid = $par->id;
            $blogo = $par->bayilogo;
            $bcode = $par->bayikodu;
            $bmail = $par->bayimail;
            $bname = $par->bayiadi;
            $bgift = $par->bayiindirim;
            $bphone = $par->bayitelefon;
            $bvno = $par->bayivergino;
            $bvd = $par->bayivergidairesi;
            $bstatus = $par->bayidurum;
            $bweb = $par->bayisite;
        } else {
            session_destroy();
        }
    } else {
        session_destroy();
    }
}
// ! bunun burda olmasının sebebi her yerde kullanılabilir halde şuan
