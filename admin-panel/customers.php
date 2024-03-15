<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i> Bayi Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Bayi Listesi</a></li>
    </ul>
  </div>
  <div class="row">


    <form action="" method="GET" class="col-md-12">
      <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Bayi adı ya da bayi kodu giriniz ve entera tıklayınız" />
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

      $query = $db->prepare("SELECT * FROM bayiler ORDER BY id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM bayiler ORDER BY id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Bayi Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Kodu</th>
                  <th>Adı</th>
                  <th>Mail</th>
                  <th>Tel</th>
                  <th>Durum</th>
                  <th>İndirim</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['bayikodu']; ?></a></td>
                    <td><?php echo $key['bayiadi']; ?></td>
                    <td><?php echo $key['bayimail']; ?></td>
                    <td><?php echo $key['bayitelefon']; ?></td>
                    <td><?php echo $key['bayidurum'] == 1 ? '<span class="me-1 badge bg-success ">Aktif</span>' : '<span class="me-1 badge bg-danger">Pasif</span>'; ?></td>
                    <td><?php echo "%" . $key['bayiindirim']; ?></td>
                    <td>
                      <a title="Düzenle" href="<?php b2b("customeredit", $key['bayikodu']) ?>" class="bi bi-pen"></a> |
                      <a title="Logo" href="<?php b2b("customerlogo", $key['bayikodu']) ?>" class="bi bi-camera"></a> |
                      <a title="Log" href="<?php b2b("customerlog", $key['bayikodu']) ?>" class="bi bi-list"></a> |
                      <a title="Adres" href="<?php b2b("customeraddress", $key['bayikodu']) ?>" class="bi bi-geo-alt"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Bayi Pasif" href="<?php b2b('customerdelete', $key['bayikodu']) ?>" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Bayi bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'customers.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'customers.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>