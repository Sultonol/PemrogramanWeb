<?php
if (!isset($_SESSION['user']) || !in_array('admin', $_SESSION['user']['roles'])) {
    http_response_code(403);
    exit('Akses ditolak.');
}
?>
<section>
  <h5>Dashboard Admin</h5>
  <ul>
    <li><a href="index.php?page=kelola-user">Kelola Akun Pengguna</a></li>
    <li><a href="index.php?page=laporan-sistem">Laporan Sistem</a></li>
    <li><a href="index.php?page=backup">Backup & Restore Data</a></li>
  </ul>
</section>
