<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Models/User.php';

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        $auth = new AuthController();
        if (isset($_SESSION['user'])) {
            header('Location: index.php?page=dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->login();  // Akan redirect di dalamnya jika sukses atau gagal
        } else {
            require_once __DIR__ . '/../app/Views/Auth/login.php';
        }
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'dashboard':
    case 'warga':
    case 'panitia':
    case 'pekurban':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $userModel = new User();
        $user = $_SESSION['user'];

        // Pastikan roles ada di session user
        $roles = $user['roles'] ?? [];

        // Ambil data pekurban aktif jika bukan pekurban
        $activePekurban = [];
        if (!in_array('pekurban', $roles)) {
            $activePekurban = $userModel->getAllActivePekurban();
        }

        require_once __DIR__ . '/../app/Views/dashboard.php';
        break;

    default:
        echo "Halaman tidak ditemukan!";
        break;
}
