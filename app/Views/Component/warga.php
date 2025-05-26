<?php
if (!isset($_SESSION['user']) || !in_array('warga', $_SESSION['user']['roles'])) {
    http_response_code(403);
    exit('Akses ditolak.');
}
?>
<section>
  <h2>Dashboard Warga</h2>
  <p>halo warga, ini halaman khusus warga</p>
  <ul>
    <li><a href="index.php?page=data-penerima">Data Penerima Daging</a></li>
    <li><a href="index.php?page=info-kurban">Informasi Qurban</a></li>
  </ul>
</section>
