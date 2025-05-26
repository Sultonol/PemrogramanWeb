<?php
if (!isset($_SESSION['user']) || !in_array('pekurban', $_SESSION['user']['roles'])) {
    http_response_code(403);
    exit('Akses ditolak.');
}
?>
<section>
  <h2>Dashboard Pekurban</h2>
  <p>Halo pekurban, ini halaman khusus pekurban</p>
  <ul>
    <li><a href="index.php?page=status-qurban">Status Qurban Saya</a></li>
    <li><a href="index.php?page=upload-bukti">Upload Bukti Transfer</a></li>
    <li><a href="index.php?page=qrcode-kartu">Lihat Kartu QR Qurban</a></li>
  </ul>
</section>
