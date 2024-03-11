<?php require_once 'systemadmin/function.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <title>B2B ADMİN PANEL</title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1>B2B Admin Panel</h1>
    </div>
    <?php
    if (isset($_POST['adminlogin'])) {
      $email = post('email');
      $password = post('password');
      $crypto = sha1(md5($password));
      if (!$email || !$password) {
        alert('Lütfen boş alan bırakma', 'danger');
      } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          alert('E-posta formatı hatalı', 'danger');
        } else {
          $alogin = $db->prepare("SELECT * FROM admin WHERE admin_posta = :p AND admin_sifre = :s ");
          $alogin->execute([
            ':p' => $email,
            ':s' => $crypto
          ]);
          if ($alogin->rowCount()) {
            $adminrow = $alogin->fetch(PDO::FETCH_OBJ);
            if ($adminrow->admin_durum == 1) {

              $_SESSION['adminlogin'] = sha1(md5(IP() . $adminrow->admin_id));
              $_SESSION['adminid'] = $adminrow->admin_id;
              alert('Yönetici girişi başarılı', 'success');

              $logadd = $db->prepare("INSERT INTO adminlog SET 
              alogadmin = :ad,
              alogaciklama = :ac ");
              $logadd->execute([
                ':ad' => $adminrow->admin_id,
                ':ac' => $adminrow->admin_id . " id'li yönetici girişi yaptı"
              ]);


              go(admin, 2);
            } else {
              alert('Yöneticiliğiniz pasife alındı', 'danger');
            }
          } else {
            alert('Böyle bir yönetici bulunmuyor', 'danger');
          }
        }
      }
    }
    ?>
    <div class="login-box">
      <form class="login-form" action="" method="POST">
        <h3 class="login-head"><i class="bi bi-person me-2"></i>YÖNETİCİ GİRİŞİ</h3>
        <div class="mb-3">
          <label class="form-label">E-Posta</label>
          <input class="form-control" name="email" type="text" placeholder="E-posta adresi" autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Şifre</label>
          <input class="form-control" type="password" placeholder="Şifre" name="password">
        </div>

        <div class="mb-3 btn-container d-grid">
          <button type="submit" name="adminlogin" class="btn btn-primary btn-block"><i class="bi bi-box-arrow-in-right me-2 fs-5"></i>Giriş Yap</button>
        </div>
      </form>

    </div>
  </section>

</body>

</html>