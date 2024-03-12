<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i>Sayfa Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Sayfa Listesi</a></li>
    </ul>
  </div>
  <div class="row">

    <div class="col-md-12">

      <?php
      $s     = @intval(get('s'));
      if (!$s) {
        $s   = 1;
      }

      $query = $db->prepare("SELECT * FROM sayfalar ORDER BY id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = 50;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM sayfalar ORDER BY id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Sayfa Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Başlık</th>
                  <th>Resim </th>
                  <th>Tarih</th>
                  <th>Durum</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['id']; ?></a></td>
                    <td><?php echo $key['baslik']; ?></td>
                    <td><img src="<?php echo site . "/uploads/" . $key['kapak']; ?>" alt="" width="100" height="100"> </td>
                    <td><?php echo dt($key['tarih']); ?></td>
                    <td><?php echo $key['durum'] == 1 ? '<span class="me-1 badge bg-success ">Aktif</span>' : '<span class="me-1 badge bg-danger">Pasif</span>'; ?></td>
                    <td>
                      <a title="Sayfa Düzenle" href="" class="bi bi-pen"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Sayfa sil" href="" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Sayfa  bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'pages.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'pages.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>