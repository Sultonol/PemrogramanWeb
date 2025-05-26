<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Qurban RT</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <h2>Dashboard Qurban RT</h2>
    <a href="index.php?page=logout">Logout</a>
  </header>

  <div class="container">
    <nav class="sidebar">
      <ul>
        <li><a href="index.php?page=dashboard&subpage=beranda">Beranda</a></li>
        <li><a href="index.php?page=dashboard&subpage=warga">Data Warga</a></li>
        <li><a href="index.php?page=dashboard&subpage=keuangan">Keuangan</a></li>
        <li><a href="index.php?page=dashboard&subpage=pembagian_daging">Pembagian Daging</a></li>
        <li><a href="index.php?page=dashboard&subpage=laporan">Laporan</a></li>
      </ul>
    </nav>

    <main class="konten">
      <?= isset($konten) ? $konten : '<p>Konten tidak tersedia.</p>'; ?>
    </main>
  </div>
</body>
</html>
