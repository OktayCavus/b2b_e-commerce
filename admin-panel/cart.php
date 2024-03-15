<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i> Sepete Eklenen Ürün Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Sepete Eklenen Ürün Listesi</a></li>
    </ul>
  </div>
  <div class="row">

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

      $query = $db->prepare("SELECT * FROM sepet ORDER BY id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM sepet ORDER BY id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Sepet Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Kodu</th>
                  <th>Bayi Kodu</th>
                  <th>Birim Fiyat</th>
                  <th>Adet</th>
                  <th>Toplam Fiyat</th>
                  <th>Tarih</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['sepeturun']; ?></a></td>
                    <td><?php echo $key['sepetbayi']; ?></td>
                    <td><?php echo $key['birimfiyat']; ?></td>
                    <td><?php echo $key['sepetadet']; ?></td>
                    <td><?php echo $key['toplam']; ?></td>
                    <td><?php echo dt($key['sepettarih']); ?></td>
                    <td>
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Sepetten sil" href="<?php b2b("deletecart", $key['sepeturun'], $key['sepetbayi']) ?>" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Sepette ürün bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'cart.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'cart.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>