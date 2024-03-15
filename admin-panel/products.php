<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i> Ürün Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#">Ürün Listesi</a></li>
    </ul>
  </div>
  <div class="row">


    <form action="" method="GET" class="col-md-12">
      <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Ürün adı ya da ürün kodu giriniz ve entera tıklayınız" />
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

      $query = $db->prepare("SELECT * FROM urunler
      INNER JOIN urun_kategoriler ON urun_kategoriler.id=urunler.urunkatid
       ORDER BY urunler.id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM urunler 
       INNER JOIN urun_kategoriler ON urun_kategoriler.id=urunler.urunkatid
      ORDER BY urunler.id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Ürün Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Kodu</th>
                  <th>Resim</th>
                  <th>Başlık</th>
                  <th>Kategori</th>
                  <th>Fiyat</th>
                  <th>Stok</th>
                  <th>Durum</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['urunkodu']; ?></a></td>
                    <td><img src="<?php echo site . "/uploads/product/" . $key['urunkapak'] ?>" alt="" width="100" height="100"> </td>
                    <td><?php echo $key['urunbaslik']; ?></td>
                    <td><?php echo $key['katbaslik']; ?></td>
                    <td><?php echo $key['urunfiyat'] . "₺"; ?></td>
                    <td><?php echo $key['urunstok']; ?></td>
                    <td><?php echo $key['urundurum'] == 1 ? '<span class="me-1 badge bg-success ">Aktif</span>' : '<span class="me-1 badge bg-danger">Pasif</span>'; ?></td>

                    <td>
                      <a title="Düzenle" href="" class="bi bi-pen"></a> |
                      <a title="Banner Resmi" href="" class="bi bi-card-image"></a> |
                      <a title="Özellikler" href="" class="bi bi-gear"></a> |
                      <a title="Ürün çoklu fotoğraf" href="" class="bi bi-images"></a> |
                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Silf" href="<?php b2b("deleteproduct", $key['urunkodu']) ?>" class="bi bi-x-lg"></a>
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
              pagination($s, ceil($total / $lim), 'products.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'products.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>