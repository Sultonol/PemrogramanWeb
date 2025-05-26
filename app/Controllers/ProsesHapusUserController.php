<?php
session_start();
include '../model/koneksi.php';

// Cek akses admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('Akses ditolak.');
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Hapus user dari tabel users
    $sql = "DELETE FROM users WHERE id = $user_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../view/kelola-user.php?success=Akun berhasil dihapus");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    http_response_code(400);
    exit('ID user tidak ditemukan.');
}
?>
