<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/KeuanganController.php';
require_once __DIR__ . '/../app/Controllers/DistribusiDagingController.php';
require_once __DIR__ . '/../app/Models/User.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        if (isset($_SESSION['user'])) {
            header('Location: index.php?page=dashboard');
            exit;
        }
        require_once __DIR__ . '/../app/Views/home.php';
        break;

    case 'login':
        $auth = new AuthController();
        if (isset($_SESSION['user'])) {
            header('Location: index.php?page=dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->login();
        } else {
            require_once __DIR__ . '/../app/Views/Auth/login.php';
        }
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'dashboard':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once __DIR__ . '/../app/Views/dashboard.php';
        break;

    case 'info-kurban':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $userModel = new User();
        // $daftarPekurban = $userModel->getAllPekurban();

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
        $tanggal = date('Y-m-d');

        $refleksi = new ReflectionClass($controller);
        $property = $refleksi->getProperty('model');
        $property->setAccessible(true);
        $model = $property->getValue($controller);

        $dataSudahAda = !empty($model->getPembagianDagingByTanggal($tanggal));

        if (!$dataSudahAda) {
            $model->simpanPembagianDaging($tanggal);
        }

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

    // case 'hewan_qurban_peserta':
    //     if (!isset($_SESSION['user']) || !in_array('admin', $_SESSION['user']['roles'])) {
    //         header('Location: index.php?page=login');
    //         exit;
    //     }
    //     $hewan_id = $_GET['hewan_id'] ?? 0;
    //     $controller = new HewanQurbanPesertaController();
    //     $controller->index($hewan_id);
    //     break;

    // case 'hewan_qurban_peserta_tambah':
    //     if (!isset($_SESSION['user']) || !in_array('admin', $_SESSION['user']['roles'])) {
    //         header('Location: index.php?page=login');
    //         exit;
    //     }
    //     $hewan_id = $_GET['hewan_id'] ?? 0;
    //     $controller = new HewanQurbanPesertaController();
    //     $controller->tambahPeserta($hewan_id);
    //     break;

    // case 'hewan_qurban_peserta_hapus':
    //     if (!isset($_SESSION['user']) || !in_array('admin', $_SESSION['user']['roles'])) {
    //         header('Location: index.php?page=login');
    //         exit;
    //     }
    //     $id = $_GET['id'] ?? 0;
    //     $hewan_id = $_GET['hewan_id'] ?? 0;
    //     $controller = new HewanQurbanPesertaController();
    //     $controller->hapusPeserta($id, $hewan_id);
    //     break;

    default:
        echo "Halaman tidak ditemukan!";
        break;
}
