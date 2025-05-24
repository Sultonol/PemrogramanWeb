<?php
// require_once __DIR__ . '/../Database/Database.php';
// if (!isset($_SESSION['user'])) {
//     header('Location: index.php?page=login');
//     exit;
// }
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proses_pembagian'])) {
//     $tahun = date('Y');
//     $tanggal = date('Y-m-d');
//     $created_at = date('Y-m-d H:i:s');
//     $sql = "SELECT SUM(total_berat) AS total_berat FROM hewan_qurban WHERE tahun = '$tahun'";
//     $result = $conn->query($sql);
//     $row = $result->fetch_assoc();
//     $total_berat = $row['total_berat'] ?? 0;

//     if ($total_berat <= 0) {
//         $message = "Belum ada data hewan qurban untuk tahun $tahun.";
//     } else {
//         $sql = "SELECT id, is_warga, is_panitia, is_kurban, is_admin FROM warga WHERE is_admin = 0";
//         $result = $conn->query($sql);

//         $warga = [];
//         $jumlah_panitia = 0;
//         $jumlah_peserta = 0;
//         $jumlah_warga_biasa = 0;

//         while ($row = $result->fetch_assoc()) {
//             $kategori = 'warga';
//             if ($row['is_panitia'] == 1) $kategori = 'panitia';
//             else if ($row['is_kurban'] == 1) $kategori = 'peserta';

//             $warga[] = ['id' => $row['id'], 'kategori' => $kategori];

//             if ($kategori == 'panitia') $jumlah_panitia++;
//             else if ($kategori == 'peserta') $jumlah_peserta++;
//             else $jumlah_warga_biasa++;
//         }
//         $total_unit = ($jumlah_panitia * 1.5) + ($jumlah_peserta * 1.2) + $jumlah_warga_biasa;
//         $berat_per_unit = $total_berat / $total_unit;
//         function jatah_per_kategori($kategori, $berat_per_unit) {
//             if ($kategori == 'panitia') return 1.5 * $berat_per_unit;
//             if ($kategori == 'peserta') return 1.2 * $berat_per_unit;
//             return 1.0 * $berat_per_unit;
//         }
//         function generateQrCode($warga_id, $tanggal) {
//             return md5($warga_id . $tanggal . uniqid());
//         }
//         $conn->query("DELETE FROM pembagian_daging_warga WHERE tanggal LIKE '$tahun%'");
//         $stmt = $conn->prepare("INSERT INTO pembagian_daging_warga (warga_id, kategori, jumlah_kg, tanggal, qr_code, created_at) VALUES (?, ?, ?, ?, ?, ?)");

//         foreach ($warga as $w) {
//             $id_warga = $w['id'];
//             $kategori = $w['kategori'];
//             $jumlah_kg = jatah_per_kategori($kategori, $berat_per_unit);
//             $qr_code = generateQrCode($id_warga, $tanggal);

//             $stmt->bind_param("isdsss", $id_warga, $kategori, $jumlah_kg, $tanggal, $qr_code, $created_at);
//             $stmt->execute();
//         }

//         $stmt->close();

//         $message = "Pembagian daging qurban berhasil disimpan.";
//     }
// }
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Proses Pembagian Daging Qurban</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">

<?php if (!empty($message)): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post">
    <button type="submit" name="proses_pembagian" class="btn btn-primary">Hitung & Simpan Pembagian Daging</button>
</form>

</body>
</html> -->
