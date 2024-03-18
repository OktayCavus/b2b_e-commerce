<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i>Durum Kodu Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Durum Kodu Listesi</a></li>
    </ul>
  </div>
  <div class="row">

    <div class="col-md-12">

      <?php
      $s     = @intval(get('s'));
      if (!$s) {
        $s   = 1;
      }

      $query = $db->prepare("SELECT * FROM durumkodlari ORDER BY id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = 50;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM durumkodlari ORDER BY id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Durum Kodu Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Başlık</th>
                  <th>Durum Kodu</th>
                  <th>Tarih</th>
                  <th>Durum</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['id']; ?></a></td>
                    <td><?php echo $key['durumbaslik']; ?></td>
                    <td><?php echo $key['durumkodu']; ?></td>
                    <td><?php echo dt($key['durumtarih']); ?></td>
                    <td><?php echo $key['durumdurum'] == 1 ? '<span class="me-1 badge bg-success ">Aktif</span>' : '<span class="me-1 badge bg-danger">Pasif</span>'; ?>
                      <?php echo $key['silinmeyen_durum'] == 1 ? '<span class="me-1 badge bg-danger ">Silinmez Durum</span>' : null; ?>
                    </td>
                    <td>
                      <a title="Düzenle" href="<?php b2b("statusedit", $key['id']); ?>" class="bi bi-pen"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Sepetten sil" href="<?php b2b("statusdelete", $key['durumkodu']); ?>" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Durum kodu bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'statuslist.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'statuslist.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>