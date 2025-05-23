<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

$roles = $_SESSION['user']['roles'];
$nama = $_SESSION['user']['nama'];

$roleMap = [
    'pekurban' => 'Pekurban',
    'panitia' => 'Panitia',
    'warga' => 'Warga',
];

$activeRoles = array_intersect_key($roleMap, array_flip(array_intersect(array_keys($roleMap), $roles)));
$peranDisplay = implode(', ', $activeRoles);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: row;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #343a40;
      padding-top: 1rem;
    }
    .sidebar .nav-link {
      color: #adb5bd;
    }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      color: #fff;
      background-color: #495057;
    }
    .content {
      margin-left: 250px;
      padding: 2rem;
      flex-grow: 1;
    }
  </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
  <h4 class="text-white px-3">Dashboard</h4>
  <nav class="nav flex-column px-3">
    <?php if (in_array('admin', $roles)): ?>
      <a class="nav-link" href="#adminPanel">Admin Panel</a>
    <?php endif; ?>
    <?php if (in_array('pekurban', $roles)): ?>
      <a class="nav-link" href="#pekurbanFeature">Pekurban</a>
    <?php endif; ?>
    <?php if (in_array('panitia', $roles)): ?>
      <a class="nav-link" href="#panitiaFeature">Panitia</a>
    <?php endif; ?>
    <?php if (in_array('warga', $roles)): ?>
      <a class="nav-link" href="#wargaFeature">Warga</a>
    <?php endif; ?>

    <hr class="text-secondary">
    <a class="nav-link text-danger" href="index.php?page=logout">Logout</a>
  </nav>

  <div class="mt-auto px-3 pb-3 text-white">
    Selamat datang,<br><strong><?= htmlspecialchars($nama) ?></strong>
  </div>
</div>

<div class="content">
  <h4>Selamat datang, <?= htmlspecialchars($nama) ?>.</h4>
  <?php if (count($activeRoles) > 0): ?>
    <p>Anda sebagai <?= $peranDisplay ?>.</p>
  <?php endif; ?>

  <?php if (in_array('admin', $roles)): ?>
    <section id="adminPanel" class="mb-4">
      <p>Fitur khusus admin di sini.</p>
    </section>
  <?php endif; ?>

  <?php if (in_array('pekurban', $roles)): ?>
    <section id="pekurbanFeature" class="mb-4">
      <p>Info tentang status qurban dan pembayaran.</p>
    </section>
  <?php endif; ?>

  <?php if (in_array('panitia', $roles)): ?>
    <section id="panitiaFeature" class="mb-4">
      <p>Daftar pekurban yang Anda kelola:</p>
    </section>
  <?php endif; ?>

  <?php if (in_array('warga', $roles)): ?>
    <section id="wargaFeature" class="mb-4">
      <p>Daftar pekurban aktif di lingkungan Anda.</p>
    </section>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
