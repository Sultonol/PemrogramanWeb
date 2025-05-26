<?php
if (!isset($_SESSION['user'])) {
  header('Location: index.php?page=login');
  exit;
}

$user = $_SESSION['user'];
$roles = $user['roles'] ?? [];

// Tentukan konten apa yang akan ditampilkan sesuai role utama user.
// Misal prioritas: admin > panitia > pekurban > warga
if (in_array('admin', $roles)) {
  $pageRole = 'admin';
} elseif (in_array('panitia', $roles)) {
  $pageRole = 'panitia';
} elseif (in_array('pekurban', $roles)) {
  $pageRole = 'pekurban';
} elseif (in_array('warga', $roles)) {
  $pageRole = 'warga';
} else {
  $pageRole = 'home'; // default fallback
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Dashboard - <?= htmlspecialchars($pageRole) ?></title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      width: 200px;
      height: 100vh;
      background-color: #f8f9fa;
      border-right: 1px solid #ddd;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      overflow-y: auto;
    }

    .sidebar h4 {
      margin-bottom: 1rem;
    }

    .sidebar .nav-link {
      cursor: pointer;
      color: #333;
      display: block;
      padding: 10px 15px;
      border-radius: 5px;
      margin-bottom: 5px;
      text-decoration: none;
    }

    .sidebar .nav-link:hover {
      background-color: #007bff;
      color: white;
      text-decoration: none;
    }

    .content {
      margin-left: 250px;
      padding: 30px;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h4>Menu</h4>
    <?php if (in_array('admin', $roles)): ?>
      <a href="index.php?page=dashboard&role=admin" class="nav-link <?= $pageRole === 'admin' ? 'active' : '' ?>">Admin</a>
    <?php endif; ?>
    <?php if (in_array('panitia', $roles)): ?>
      <a href="index.php?page=dashboard&role=panitia" class="nav-link <?= $pageRole === 'panitia' ? 'active' : '' ?>">Panitia</a>
    <?php endif; ?>
    <?php if (in_array('pekurban', $roles)): ?>
      <a href="index.php?page=dashboard&role=pekurban" class="nav-link <?= $pageRole === 'pekurban' ? 'active' : '' ?>">Pekurban</a>
    <?php endif; ?>
    <?php if (in_array('warga', $roles)): ?>
      <a href="index.php?page=dashboard&role=warga" class="nav-link <?= $pageRole === 'warga' ? 'active' : '' ?>">Warga</a>
    <?php endif; ?>
    <a href="index.php?page=logout" class="nav-link text-danger">Logout</a>
  </div>

  <div class="content">
    <?php
    // Jika ada role yang dipilih via query string (klik menu), pakai itu
    if (isset($_GET['role']) && in_array($_GET['role'], ['admin', 'panitia', 'pekurban', 'warga'])) {
      $pageRole = $_GET['role'];
    }

    // Tampilkan konten role sesuai
    switch ($pageRole) {
      case 'admin':
        include __DIR__ . '/../Views/Component/admin.php';
        break;
      case 'panitia':
        include __DIR__ . '/../Views/Component/panitia.php';
        break;
      case 'pekurban':
        include __DIR__ . '/../Views/Component/pekurban.php';
        break;
      case 'warga':
        include __DIR__ . '/../Views/Component/warga.php';
        break;
      default:
        echo "<h4>Selamat Datang, " . htmlspecialchars($user['name']) . "</h4>";
        echo "<p>Silakan pilih menu di sebelah kiri.</p>";
        break;
    }
    ?>
  </div>
</body>

</html>