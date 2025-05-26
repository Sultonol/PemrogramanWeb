<?php
if ($user) {
	$nama = htmlspecialchars($user['nama']);
	$roles = $user['roles'] ?? [];
	$rolesFormatted = array_map('ucfirst', $roles);
	$roleText = implode(', ', $rolesFormatted);

	date_default_timezone_set('Asia/Jakarta');
	$jam = date('H');
	if ($jam >= 5 && $jam < 11) {
		$ucapan = 'Selamat pagi';
	} elseif ($jam >= 11 && $jam < 15) {
		$ucapan = 'Selamat siang';
	} elseif ($jam >= 15 && $jam < 18) {
		$ucapan = 'Selamat sore';
	} else {
		$ucapan = 'Selamat malam';
	}

	echo "<h3>Beranda</h3>";
	echo "<p>$ucapan, <strong>$nama</strong>!</p>";
	echo "<p>Peran Anda: <em>$roleText</em></p>";
} else {
	echo "<p>Data pengguna tidak ditemukan.</p>";
}
