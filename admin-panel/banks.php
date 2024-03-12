<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i>Banka Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Banka Listesi</a></li>
    </ul>
  </div>
  <div class="row">

    <div class="col-md-12">

      <?php
      $s     = @intval(get('s'));
      if (!$s) {
        $s   = 1;
      }

      $query = $db->prepare("SELECT * FROM bankalar ORDER BY bankaid DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = 50;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM bankalar ORDER BY bankaid DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>

        <div class="tile">
          <h3 class="tile-title">Banka Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Banka</th>
                  <th>Hesap no</th>
                  <th>Şube no</th>
                  <th>IBAN</th>
                  <th>Durum</th>
                  <th>Tarih</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['bankaid']; ?></a></td>
                    <td><?php echo $key['bankaadi']; ?></td>
                    <td><?php echo $key['bankahesap']; ?></td>
                    <td><?php echo $key['bankasube']; ?></td>
                    <td><?php echo $key['bankaiban']; ?></td>
                    <td><?php echo $key['bankadurum'] == 1 ? '<span class="me-1 badge bg-success ">Aktif</span>' : '<span class="me-1 badge bg-danger">Pasif</span>'; ?></td>
                    <td><?php echo dt($key['bankatarih']); ?></td>
                    <td>
                      <a title="Düzenle" href="" class="bi bi-pen"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Sepetten sil" href="" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Banka bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'banks.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'banks.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>