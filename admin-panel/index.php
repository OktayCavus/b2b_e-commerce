<?php require_once 'inc/header.php'; ?>
<!-- Sidebar menu-->
<?php require_once 'inc/sidebar.php'; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i> Dashboard</h1>
      <p>A free and open source Bootstrap 5 admin template</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
        <div class="info">
          <h4>Users</h4>
          <p><b>5</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon bi bi-heart fs-1"></i>
        <div class="info">
          <h4>Likes</h4>
          <p><b>25</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon bi bi-folder2 fs-1"></i>
        <div class="info">
          <h4>Uploades</h4>
          <p><b>10</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon bi bi-star fs-1"></i>
        <div class="info">
          <h4>Stars</h4>
          <p><b>500</b></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Son 10 Sipariş</h3>

      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Son 10 Yeni Mesaj</h3>

      </div>
    </div>
  </div>
</main>
<?php require_once 'inc/footer.php'; ?>