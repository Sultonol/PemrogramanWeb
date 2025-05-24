<!DOCTYPE html>
<html>
<head>
    <title>Rekap Keuangan</title>
</head>
<body>
    <h2>Rekap Keuangan</h2>

    <form method="GET" action="index.php">
        <input type="hidden" name="page" value="keuangan">
        <label>Filter Tanggal:</label><br>
        Dari: <input type="date" name="start_date" value="<?= htmlspecialchars($data['filter']['start'] ?? '') ?>">
        Sampai: <input type="date" name="end_date" value="<?= htmlspecialchars($data['filter']['end'] ?? '') ?>">
        <button type="submit">Filter</button>
        <a href="index.php?page=keuangan">Reset</a>
    </form>

    <p><a href="index.php?page=keuangan-create">Tambah Transaksi</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Sumber</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Total Uang</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['rekap'])): ?>
                <?php foreach ($data['rekap'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['tanggal']) ?></td>
                        <td><?= htmlspecialchars($item['jenis']) ?></td>
                        <td><?= htmlspecialchars($item['sumber']) ?></td>
                        <td><?= number_format($item['jumlah'], 2) ?></td>
                        <td><?= htmlspecialchars($item['keterangan']) ?></td>
                        <td><?= number_format($item['total_keuangan']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">Data tidak ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>