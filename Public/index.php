<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load controller
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/WargaController.php';
require_once __DIR__ . '/../app/Controllers/KeuanganController.php';
require_once __DIR__ . '/../app/Controllers/DistribusiDagingController.php';
require_once __DIR__ . '/../app/Models/User.php';

$page = $_GET['page'] ?? 'home';
$subpage = $_GET['subpage'] ?? null;

// ROUTING UTAMA
switch ($page) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new AuthController();
            $auth->login();
        } else {
            require_once __DIR__ . '/../app/Views/Auth/login.php';
        }
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'update-warga':
        $controller = new WargaController();
        $controller->update();
        break;

    case 'hapus-warga':
        $controller = new WargaController();
        $controller->delete();
        break;

    case 'proses_pembagian':
        $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
        $controller = new DistribusiDagingController();
        $controller->prosesDistribusi($tanggal);
        break;

    case 'dashboard':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        ob_start();
        $subpage = $_GET['subpage'] ?? 'beranda';

        switch ($subpage) {
            case 'beranda':
                require_once __DIR__ . '/../app/Controllers/DashboardController.php';
                $controller = new DashboardController();
                $controller->beranda();
                break;

            case 'warga':
                $controller = new WargaController();
                $controller->index();
                break;

            case 'keuangan':
                $controller = new KeuanganController();
                $controller->index();
                break;

            case 'pembagian_daging':
                $controller = new DistribusiDagingController();
                $tanggal = $_GET['tanggal'] ?? date('Y-m-d');
                $controller->showPembagianDaging($tanggal);
                break;

            case 'laporan':
                echo "<h3>Laporan</h3><p>Rekap laporan tampil di sini.</p>";
                break;

            default:
                echo "<p>Halaman tidak ditemukan!</p>";
                break;
        }

        $konten = ob_get_clean();
        require_once __DIR__ . '/../app/Views/dashboard.php';
        break;

    default:
        echo "Halaman tidak ditemukan!";
        break;
}
