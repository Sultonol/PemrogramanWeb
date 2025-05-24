<?php
require_once __DIR__ . '/../models/DistribusiDaging.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$distribusi = new DistribusiDaging();
$data = $distribusi->getPembagianDagingByTanggal($tanggal);

// Group data per warga_id
$grouped = [];
foreach ($data as $row) {
    $id = $row['warga_id'];
    if (!isset($grouped[$id])) {
        $grouped[$id] = [
            'nama' => $row['nama'],
            'warga' => 0,
            'panitia' => 0,
            'kurban' => 0,
            'qr_warga' => '',
            'qr_panitia' => '',
            'qr_kurban' => '',
        ];
    }
    $grouped[$id][$row['kategori']] = (float)$row['jumlah_kg'];
    $grouped[$id]['qr_' . $row['kategori']] = $row['qr_code'];
}

// Hitung jumlah peran aktif per warga (berdasarkan jatah > 0)
foreach ($grouped as $id => &$warga) {
    $count = 0;
    if ($warga['warga'] > 0) $count++;
    if ($warga['panitia'] > 0) $count++;
    if ($warga['kurban'] > 0) $count++;
    $warga['count_roles'] = $count;
}
unset($warga);

// Urutkan berdasarkan jumlah peran (descending)
usort($grouped, function($a, $b) {
    return $b['count_roles'] <=> $a['count_roles'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Rekap Pembagian Daging</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h2>Rekap Pembagian Daging - <?= htmlspecialchars($tanggal) ?></h2>

<table>
    <thead>
        <tr>
            <th>Nama Warga</th>
            <th>Jatah Warga (kg)</th>
            <th>QR Warga</th>
            <th>Jatah Panitia (kg)</th>
            <th>QR Panitia</th>
            <th>Jatah Kurban (kg)</th>
            <th>QR Kurban</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($grouped)): ?>
            <tr><td colspan="7">Belum ada data pembagian untuk tanggal ini.</td></tr>
        <?php else: ?>
            <?php foreach ($grouped as $warga): ?>
                <tr>
                    <td><?= htmlspecialchars($warga['nama']) ?></td>
                    <td><?= $warga['warga'] > 0 ? htmlspecialchars(number_format($warga['warga'], 2)) : '-' ?></td>
                    <td>
                        <?php if ($warga['qr_warga']): ?>
                            <!-- <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($warga['qr_warga']) ?>&size=150x150" alt="QR Warga" width="100" /> -->
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= $warga['panitia'] > 0 ? htmlspecialchars(number_format($warga['panitia'], 2)) : '-' ?></td>
                    <td>
                        <?php if ($warga['qr_panitia']): ?>
                            <!-- <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($warga['qr_panitia']) ?>&size=150x150" alt="QR Panitia" width="100" /> -->
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= $warga['kurban'] > 0 ? htmlspecialchars(number_format($warga['kurban'], 2)) : '-' ?></td>
                    <td>
                        <?php if ($warga['qr_kurban']): ?>
                            <!-- <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($warga['qr_kurban']) ?>&size=150x150" alt="QR Kurban" width="100" /> -->
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
