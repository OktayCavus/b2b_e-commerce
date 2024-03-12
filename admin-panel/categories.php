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
      <li class="breadcrumb-item active"><a href="#">Kategori Listesi</a></li>
    </ul>
  </div>
  <div class="row">


    <form action="" method="GET" class="col-md-12">
      <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Kategori adı giriniz ve entera tıklayınız" />
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

      $query = $db->prepare("SELECT * FROM urun_kategoriler ORDER BY id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT * FROM urun_kategoriler ORDER BY id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Kategori Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>

                  <th>ID</th>
                  <th>Resim</th>
                  <th>Başlık</th>
                  <th>Durum</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['id']; ?></a></td>
                    <td><img src="<?php echo $site . "/uploads/product/" . $key['katresim']; ?>" width="100" height="100"></td>
                    <td><?php echo $key['katbaslik']; ?></td>
                    <td><?php echo $key['katdurum'] == 1 ? '<span class="me-1 badge bg-success ">Aktif</span>' : '<span class="me-1 badge bg-danger">Pasif</span>'; ?></td>
                    <td>
                      <a title="Düzenle" href="" class="bi bi-pen"></a> |
                      <a onclick="return confirm('Bu kategorideki tüm ürünler silinmez olarak seçilen kategoriye aktarılacak onaylıyor musunuz ?');" title="Sil" href="" class="bi bi-x-lg"></a> |

                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Kategori bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'categories.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'categories.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>