<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga</title>
</head>

<body>
    <h3>Data Warga</h3>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
        <script>
            alert('Data berhasil diubah.');
        </script>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>No Telepon</th>
            <th>Peran</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1;
        foreach ($data as $row):
            $roles = explode(',', $row['role'] ?? '');
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['nik']) ?></td>
                <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                <td><?= implode(', ', $roles) ?: 'Belum Ada' ?></td>
                <td>
                    <form method="post" action="index.php?page=update-warga" style="display:inline;">
                        <input type="hidden" name="warga_id" value="<?= $row['id'] ?>">
                        <label>
                            <input type="checkbox" name="role[]" value="warga" <?= in_array('warga', $roles) ? 'checked' : '' ?>>
                            Warga
                        </label>
                        <label>
                            <input type="checkbox" name="role[]" value="panitia" <?= in_array('panitia', $roles) ? 'checked' : '' ?>>
                            Panitia
                        </label>
                        <label>
                            <input type="checkbox" name="role[]" value="kurban" <?= in_array('kurban', $roles) ? 'checked' : '' ?>>
                            Kurban
                        </label>
                        <label>
                            <input type="checkbox" name="role[]" value="admin" <?= in_array('admin', $roles) ? 'checked' : '' ?>>
                            Admin
                        </label>
                        <br>
                        <button type="submit">Update</button>
                    </form>

                    <form method="post" action="index.php?page=hapus-warga" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        <input type="hidden" name="warga_id" value="<?= $row['id'] ?>">
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>