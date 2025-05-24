<?php
require_once __DIR__ . '/../models/Keuangan.php';

class KeuanganController
{
    private $keuanganModel;

    public function __construct()
    {
        $this->keuanganModel = new Keuangan();
    }

    // Tampilkan halaman rekapan (semua data atau filter tanggal)
    public function index()
    {
        $data = [];

        if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
            $startDate = $_GET['start_date'];
            $endDate = $_GET['end_date'];
            $data['rekap'] = $this->keuanganModel->getRekapByTanggal($startDate, $endDate);
            $data['filter'] = ['start' => $startDate, 'end' => $endDate];
        } else {
            $data['rekap'] = $this->keuanganModel->getAllTransaksi();
            $data['filter'] = null;
        }

        include __DIR__ . '/../Views/keuangan.php';
    }

    // Form input transaksi baru
    public function create()
    {
        include __DIR__ . '/../Views/create.php';
    }

    // Simpan transaksi baru dari form
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tanggal = $_POST['tanggal'] ?? '';
            $jenis = $_POST['jenis'] ?? '';
            $sumber = $_POST['sumber'] ?? '';
            $jumlah = $_POST['jumlah'] ?? 0;
            $keterangan = $_POST['keterangan'] ?? null;

            $success = $this->keuanganModel->addTransaksi($tanggal, $jenis, $sumber, $jumlah, $keterangan);

            if ($success) {
                header('Location: index.php?page=keuangan');
                exit;
            } else {
                echo "Gagal menambah data keuangan.";
            }
        }
    }
}
