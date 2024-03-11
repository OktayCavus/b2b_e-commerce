<?php require_once 'inc/header.php'; ?>
<!-- Sidebar menu-->
<?php require_once 'inc/sidebar.php'; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i> Admin Panel</h1>

    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Ana Sayfa</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
        <div class="info">
          <h4>Bayiler</h4>
          <p><b><?php echo rowresult('bayiler'); ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon bi bi-bag-check-fill fs-1"></i>
        <div class="info">
          <h4>Siparişler</h4>
          <p><b><?php echo rowresult('siparisler'); ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon bi bi-envelope fs-1"></i>
        <div class="info">
          <h4>Yeni Mesaj</h4>
          <p><b><?php echo rowresult('mesajlar', 'mesajdurum', 2); ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon bi bi-gift fs-1"></i>
        <div class="info">
          <h4>Ürünler</h4>
          <p><b><?php echo rowresult('urunler'); ?></b></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">


    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Son 10 Sipariş</h3>
        <?php
        $lastorders = $db->prepare("SELECT * FROM siparisler 
        INNER JOIN bayiler ON bayiler.bayikodu = siparisler.siparisbayi 
        INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum 
        ORDER BY siparisler.id DESC LIMIT 10");
        $lastorders->execute();
        if ($lastorders->rowCount()) {  ?>


          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>Kod</th>
                <th>Bayi</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Tarih</th>
              </thead>
              <tbody>
                <?php
                foreach ($lastorders as $order) { ?>
                  <tr>
                    <td><a href="#"><?php echo $order['sipariskodu']; ?></a></td>
                    <td><?php echo $order['bayiadi']; ?></td>
                    <td><?php echo $order['siparistutar'] . " ₺"; ?></td>
                    <td><?php echo $order['durumbaslik']; ?></td>
                    <td><?php echo dt($order['siparistarih']) . " | " . $order['siparissaat']; ?></td>


                  </tr>
                <?php  } ?>

              </tbody>
            </table>
          <?php } else {
          alert('Sipariş bulunmuyor', 'danger');
        } ?>
          </div>

      </div>
    </div>


    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Son 10 Yorum</h3>
        <?php
        $lastcomments = $db->prepare("SELECT *,urun_yorumlar.id FROM urun_yorumlar 
        INNER JOIN urunler ON urunler.urunkodu = urun_yorumlar.yorumurun
         WHERE yorumdurum = :d
        ORDER BY urun_yorumlar.id DESC LIMIT 10");
        $lastcomments->execute([
          ':d' => 2
        ]);
        if ($lastcomments->rowCount()) {  ?>


          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>ID</th>
                <th>Ürün</th>
                <th>Bayi</th>
                <th>Tarih</th>
              </thead>
              <tbody>
                <?php
                foreach ($lastcomments as $comment) { ?>
                  <tr>
                    <td><a href="#">#<?php echo $comment['id']; ?></a></td>
                    <td><?php echo $comment['urunbaslik']; ?></td>
                    <td><?php echo $comment['yorumisim'] . " ₺"; ?></td>
                    <td><?php echo dt($comment['yorumtarih']); ?></td>

                  </tr>
                <?php  } ?>

              </tbody>
            </table>
          <?php } else {
          alert('Yorum bulunmuyor', 'danger');
        } ?>

          </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Son 10 Yeni Mesaj</h3>
        <?php
        $lastmessages = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum = :d
        ORDER BY id DESC LIMIT 10");
        $lastmessages->execute([
          ':d' => 2
        ]);
        if ($lastmessages->rowCount()) {  ?>


          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>ID</th>
                <th>İsim</th>
                <th>E-posta</th>
                <th>Tarih</th>
              </thead>
              <tbody>
                <?php
                foreach ($lastmessages as $message) { ?>
                  <tr>
                    <td><a href="#">#<?php echo $message['id']; ?></a></td>
                    <td><?php echo $message['mesajisim']; ?></td>
                    <td><?php echo $message['mesajposta'] . " ₺"; ?></td>
                    <td><?php echo dt($message['mesajtarih']); ?></td>

                  </tr>
                <?php  } ?>

              </tbody>
            </table>
          <?php } else {
          alert('Mesaj bulunmuyor', 'danger');
        } ?>

          </div>
      </div>
    </div>



</main>
<?php require_once 'inc/footer.php'; ?>