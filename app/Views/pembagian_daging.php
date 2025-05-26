<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pembagian Daging</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h2>Rekap Pembagian Daging - <?= htmlspecialchars($tanggal) ?></h2>

<?php if (empty($grouped)): ?>
    <p>Belum ada data pembagian untuk tanggal ini.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nama Warga</th>
                <th>Warga (kg)</th>
                <th>Panitia (kg)</th>
                <th>Kurban (kg)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grouped as $warga): ?>
                <tr>
                    <td><?= htmlspecialchars($warga['nama']) ?></td>
                    <td><?= $warga['warga'] ?: '-' ?></td>
                    <td><?= $warga['panitia'] ?: '-' ?></td>
                    <td><?= $warga['kurban'] ?: '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
