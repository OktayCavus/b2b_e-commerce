<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i> Yorum Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#"> Yorum Listesi</a></li>
    </ul>
  </div>
  <div class="row">

    <form action="" method="GET" class="col-md-12">
      <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Bayi adı ya da ürün kodu giriniz ve entera tıklayınız" />
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

      $query = $db->prepare("SELECT *,urun_yorumlar.id FROM urun_yorumlar
      INNER JOIN urunler ON urunler.urunkodu = urun_yorumlar.yorumurun
      ORDER BY urun_yorumlar.id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT *,urun_yorumlar.id FROM urun_yorumlar
      INNER JOIN urunler ON urunler.urunkodu = urun_yorumlar.yorumurun
      ORDER BY urun_yorumlar.id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Yorum Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Ürün</th>
                  <th>Bayi</th>
                  <th>Tarih</th>
                  <th>IP</th>
                  <th>Durum</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href="<?php b2b("commentdetail", $key['id']) ?>"> <?php echo $key['id']; ?></a></td>
                    <td><?php echo $key['yorumurun']; ?></td>
                    <td><?php echo $key['yorumisim']; ?></td>
                    <td><?php echo dt($key['yorumtarih']); ?></td>
                    <td><?php echo $key['yorumip']; ?></td>
                    <td><?php echo $key['yorumdurum'] == 1 ? '<span class="me-1 badge bg-success ">Onaylı</span>' : '<span class="me-1 badge bg-danger">Onay Bekliyor</span>'; ?></td>
                    <td>
                      <a title="Düzenle" href="<?php b2b("commentdetail", $key['id']) ?>" class="bi bi-eye"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Sepetten sil" href="<?php b2b("commentdelete", $key['id']) ?>" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Yorum bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'comments.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'comments.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>