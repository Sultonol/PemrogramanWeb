<?php
session_start();
require_once __DIR__ . '/../models/Kelola-user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $warga_id = intval($_POST['warga_id']);
    $is_panitia = isset($_POST['is_panitia']) ? 1 : 0;
    $is_kurban = isset($_POST['is_kurban']) ? 1 : 0;
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $model = new KelolaUserModel();
    $berhasil = $model->updatePeran($warga_id, $is_panitia, $is_kurban, $is_admin);

    if ($berhasil) {
        header("Location: ../../public/index.php?page=kelola-user&success=Peran berhasil diubah");
        exit;
    } else {
        echo "Gagal mengubah peran.";
    }
} else {
    http_response_code(405);
    echo 'Metode tidak diizinkan.';
}


//../../index.php?page=kelola-user&success=Peran berhasil diubah