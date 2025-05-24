<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi Keuangan</title>
</head>
<body>
    <h2>Tambah Transaksi Keuangan</h2>

    <form method="POST" action="index.php?page=keuangan-store">
        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" required><br><br>

        <label>Jenis:</label><br>
        <select name="jenis" required>
            <option value="masuk">Masuk</option>
            <option value="keluar">Keluar</option>
        </select><br><br>

        <label>Sumber:</label><br>
        <input type="text" name="sumber" placeholder="Contoh: Iuran warga / Pembelian hewan qurban" required><br><br>

        <label>Jumlah (Rp):</label><br>
        <input type="number" name="jumlah" step="0.01" required><br><br>

        <label>Keterangan (optional):</label><br>
        <textarea name="keterangan"></textarea><br><br>

        <button type="submit">Simpan</button>
        <a href="index.php?page=keuangan">Batal</a>
    </form>
</body>
</html>
