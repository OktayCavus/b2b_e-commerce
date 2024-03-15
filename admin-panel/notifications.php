<?php require_once "inc/header.php"; ?>
<!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-table"></i> Havale Bildirimleri Listesi</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo admin; ?>" <i class="bi bi-house-door fs-6"></i></a></li>
      <li class="breadcrumb-item active"><a href="#"> Havale Bildirimleri Listesi</a></li>
    </ul>
  </div>
  <div class="row">

    <form action="" method="GET" class="col-md-12">
      <div class="form-group">
        <input type="text" name="q" class="form-control" placeholder="Bayi kodu giriniz ve entera tıklayınız" />
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

      $query = $db->prepare("SELECT *,havalebildirim.id FROM havalebildirim 
      INNER JOIN bayiler ON bayiler.bayikodu=havalebildirim.havalebayi
      INNER JOIN bankalar ON bankalar.bankaid=havalebildirim.banka
      ORDER BY havalebildirim.id DESC");
      $query->execute();
      $total = $query->rowCount();
      $lim = $blim;
      $show = $s * $lim - $lim;

      $query = $db->prepare("SELECT *,havalebildirim.id FROM havalebildirim 
      INNER JOIN bayiler ON bayiler.bayikodu=havalebildirim.havalebayi
      INNER JOIN bankalar ON bankalar.bankaid=havalebildirim.banka
      ORDER BY havalebildirim.id DESC LIMIT :show , :lim");
      $query->bindValue(':show', (int) $show, PDO::PARAM_INT);
      $query->bindValue(':lim', (int) $lim, PDO::PARAM_INT);
      $query->execute();

      if ($s > ceil($total / $lim)) {
        $s = 1;
      }


      if ($query->rowCount()) { ?>




        <div class="tile">
          <h3 class="tile-title">Havale Bildirim Listesi (<?php echo $total; ?>)</h3>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Bayi Adı</th>
                  <th>Tutar</th>
                  <th>Açıklama</th>
                  <th>Banka</th>
                  <th>Tarih</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($query as $key) { ?>
                  <tr>
                    <td><a href=""> <?php echo $key['id']; ?></a></td>
                    <td><?php echo $key['bayiadi']; ?></td>
                    <td><?php echo $key['havaletutar']; ?></td>
                    <td><?php echo $key['havalenot']; ?></td>
                    <td><?php echo $key['bankaadi']; ?></td>
                    <td><?php echo dt($key['havaletarih']) . " | " . $key['havalesaat']; ?></td>
                    <td>
                      <a title="Düzenle" href="" class="bi bi-pen"></a> |

                      <a onclick="return confirm('Onaylıyor musunuz ?');" title="Sepetten sil" href="<?php b2b("deletenotification", $key['id'], $key['havalebayi']) ?>" class="bi bi-x-lg"></a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      <?php } else {
        alert('Havale bildirim bulunmuyor', 'danger');
      } ?>
      <div>
        <ul class="pagination">
          <?php
          if ($total > $lim) {
            if ($blim) {
              pagination($s, ceil($total / $lim), 'notifications.php?blim=' . $blim . '&s=');
            } else {
              pagination($s, ceil($total / $lim), 'notifications.php?s=');
            }
          } ?>
        </ul>
      </div>
    </div>

  </div>
</main>
<?php require_once "inc/footer.php"; ?>