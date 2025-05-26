<?php
// Pastikan user punya akses panitia
if (!isset($_SESSION['user']) || !in_array('panitia', $_SESSION['user']['roles'])) {
    echo "<div class='alert alert-danger'>Akses ditolak.</div>";
    exit;
}
?>

<h2>Dashboard Panitia</h2>
<p>Halo, Panitia! Ini adalah halaman khusus panitia.</p>
<ul>
    <li><a href="index.php?page=pembagian_daging" class="btn btn-primary">Distribusi Daging</a></li>
    <li><a href="index.php?page=keuangan" class="btn btn-warning">Data Keuangan</a></li>
</ul>
