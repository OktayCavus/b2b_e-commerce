<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i>Yeni Mesaj Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Yeni Mesaj Listesi</a></li>
    </ul>
  </div>
  <div class="row">

    <form action="" method="GET" class="col-md-12">
      <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Kişi adı veya e-posta giriniz ve entera tıklayınız" />
      </div>
    </form>

    <form action="" method="GET" class="col-md-3">
      <div class="form-group">
        <input type="text" name="blim" class="form-control" placeholder="Listeleme sayısı giriniz" />
      </div>
    </form>


    <div class="col-md-12">

      <?php
      $s     = @intval(get('s'));
      if (!$s) {
        $s   = 1;
      }

      $blim   = @intval(get('blim'));
      if (!$blim) {
        $blim = 50;
      }

      $query = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum = :d ORDER BY id DESC");
      $query->execute([
        ':d' => 2
      ]);
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum = :d ORDER BY id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->bindValue(':d', (int) 2, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Yeni Mesaj Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>İsim</th>
                  <th>E-posta</th>
                  <th>Konu</th>
                  <th>Tarih</th>
                  <th>Durum</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['id']; ?></a></td>
                    <td><?php echo $key['mesajisim']; ?></td>
                    <td><?php echo $key['mesajposta']; ?></td>
                    <td><?php echo $key['mesajkonu']; ?></td>
                    <td><?php echo dt($key['mesajtarih']); ?></td>
                    <td><span class="me-1 badge bg-danger ">Yeni Mesaj</span></td>
                    <td>
                      <a title="Mesajı görüntüle" href="" class="bi bi-eye"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Sepetten sil" href="" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Yeni Mesaj bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'newmessages.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'newmessages.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>