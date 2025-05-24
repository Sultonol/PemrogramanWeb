<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload class jika sudah pakai composer
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/KeuanganController.php';
require_once __DIR__ . '/../app/Controllers/DistribusiDagingController.php';
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
            $auth->login(); // Proses login
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
        $roles = $user['roles'] ?? [];

        $activePekurban = [];
        if (!in_array('pekurban', $roles)) {
            $activePekurban = $userModel->getAllActivePekurban();
        }

        require_once __DIR__ . '/../app/Views/dashboard.php';
        break;

    case 'info-kurban':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once __DIR__ . '/../app/Views/info-kurban.php';
        break;

    case 'jatah-daging':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        require_once __DIR__ . '/../app/Views/jatah-daging.php';
        break;

    case 'pembagian_daging':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $controller = new DistribusiDagingController();

        // Contoh: tanggal hari ini
        $tanggal = date('Y-m-d');

        // Mengecek apakah data pembagian untuk tanggal ini sudah ada
        $refleksi = new ReflectionClass($controller);
        $property = $refleksi->getProperty('model');
        $property->setAccessible(true);
        $model = $property->getValue($controller);

        $dataSudahAda = !empty($model->getPembagianDagingByTanggal($tanggal));

        if (!$dataSudahAda) {
            $model->simpanPembagianDaging($tanggal);
        }

        // Tampilkan halaman
        $controller->showPembagianDaging($tanggal);
        break;




    case 'keuangan':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new KeuanganController();
        $controller->index();
        break;

    case 'keuangan-create':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new KeuanganController();
        $controller->create();
        break;

    case 'keuangan-store':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new KeuanganController();
        $controller->store();
        break;

    default:
        echo "Halaman tidak ditemukan!";
        break;
}
