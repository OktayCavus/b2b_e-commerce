<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i> Sipariş Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Sipariş Listesi</a></li>
    </ul>
  </div>
  <div class="row">


    <form action="" method="GET" class="col-md-12">
      <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Sipariş kodu veya bayi adı giriniz ve entera tıklayınız" />
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

      $query = $db->prepare("SELECT * FROM siparisler
      INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum
      INNER JOIN bayiler ON bayiler.bayikodu = siparisler.siparisbayi
       ORDER BY siparisler.id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM siparisler 
            INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum
            INNER JOIN bayiler ON bayiler.bayikodu = siparisler.siparisbayi
      ORDER BY siparisler.id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Siparis Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Kodu</th>
                  <th>Bayi Adı</th>
                  <th>Tlf</th>
                  <th>Tarih</th>
                  <th>Tutar</th>
                  <th>Durum</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href="<?php b2b("orderdetail", $key['sipariskodu']) ?>"> <?php echo $key['sipariskodu']; ?></a></td>
                    <td><?php echo $key['bayiadi']; ?></td>
                    <td><?php echo $key['siparistel']; ?></td>
                    <td><?php echo dt($key['siparistarih']) . " |" . $key['siparissaat']; ?></td>
                    <td><?php echo $key['siparistutar'] . "₺"; ?></td>
                    <td><?php echo $key['durumbaslik']; ?></td>
                    <td>
                      <a title="Siparişi görüntüle" href="<?php b2b("orderdetail", $key['sipariskodu']) ?>" class="bi bi-eye"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Silf" href="<?php b2b("orderdelete", $key['sipariskodu']) ?>" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Ürün bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'orders.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'orders.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>