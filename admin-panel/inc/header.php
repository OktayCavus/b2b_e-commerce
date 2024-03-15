<?php require_once './systemadmin/function.php';

if (@$_SESSION['adminlogin'] != @sha1(md5(IP() . $aid))) {
    go(admin . "/adminlogin.php");
}

$lastmessages = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum = :d
ORDER BY id DESC LIMIT 10");
$lastmessages->execute([
    ':d' => 2
]);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>B2B ADMİN PANEL</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?php echo admin; ?>">B2B</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <li class="app-search">
                <input class="app-search__input" type="search" placeholder="Search">
                <button class="app-search__button"><i class="bi bi-search"></i></button>
            </li>
            <!--Notification Menu-->
            <?php if ($lastmessages->rowCount()) { ?>


                <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Show notifications"><i class="bi bi-bell fs-5"></i></a>
                    <ul class="app-notification dropdown-menu dropdown-menu-right">
                        <li class="app-notification__title">Mesajlar (<?php echo $lastmessages->rowCount() ?>)</li>
                        <div class="app-notification__content">
                            <?php foreach ($lastmessages as $lm) { ?>
                                <li><a class="app-notification__item" href="#">
                                        <div>
                                            <p class="app-notification__message"><?php echo $lm['mesajisim'] . " size mesaj yolladı"; ?></p>
                                            <p class="app-notification__meta"><?php echo $lm['mesajkonu'] . " --- " . dt($lm['mesajtarih']); ?></p>
                                        </div>
                                    </a></li>
                            <?php             } ?>


                </li>
            <?php  } else {
                alert('Mesaj Bulunmuyor', 'danger');
            } ?>
            </div>
            <li class="app-notification__footer"><a href="#">Tüm Yeni Mesajlar</a></li>
        </ul>
        </li>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i>
                <?php echo $aname; ?></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="page-user.html"><i class="bi bi-person me-2 fs-5"></i> Profilim</a></li>
                <li><a class="dropdown-item" href="page-user.html"><i class="bi bi-lock me-2 fs-5"></i> Şifemi Değiştir</a></li>
                <li><a onclick="return confirm(' Çıkış yapmak istiyor musunuz ?');" class="dropdown-item" href="page-login.html"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Çıkış Yap</a></li>
            </ul>
        </li>
        </ul>
    </header>