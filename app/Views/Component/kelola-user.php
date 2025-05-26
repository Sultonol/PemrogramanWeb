<?php
require_once __DIR__ . '/../../models/Kelola-user.php';

$model = new KelolaUserModel();
$data_warga = $model->getAllWargaWithUserStatus();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Kelola User</title>
</head>
<body>

<a href=""></a>
<h2>Daftar Warga</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIK</th>
            <th>No Telepon</th>
            <th>Panitia</th>
            <th>Kurban</th>
            <th>Admin</th>
            <th>Status Akun</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $data_warga->fetch_assoc()) : ?>
        <tr>
          <form method="POST" action="../app/Controllers/ProsesUbahPeranController.php">
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['nik']) ?></td>
                <td><?= htmlspecialchars($row['no_telepon']) ?></td>

                <td><input type="checkbox" name="is_panitia" <?= $row['is_panitia'] ? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="is_kurban" <?= $row['is_kurban'] ? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="is_admin" <?= $row['is_admin'] ? 'checked' : '' ?>></td>

                <td><?= $row['user_id'] ? '✔️ Sudah' : '❌ Belum' ?></td>

                <td>
                    <input type="hidden" name="warga_id" value="<?= $row['id'] ?>">
                    <button type="submit">Simpan Peran</button>
                    <?php if ($row['user_id']) : ?>
                        <a href="../Controllers/ProsesHapusUserController.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Yakin ingin hapus akun ini?')">Hapus Akun</a>
                    <?php else : ?>
                        <a href="form_tambah_user.php?warga_id=<?= $row['id'] ?>">Tambah Akun</a>
                    <?php endif; ?>
                </td>
                
            </form>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
