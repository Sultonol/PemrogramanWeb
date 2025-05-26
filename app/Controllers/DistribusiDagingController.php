<?php
require_once __DIR__ . '/../Models/DistribusiDaging.php';

class DistribusiDagingController
{
    private $model;

    public function __construct()
    {
        $this->model = new DistribusiDaging();
    }

    public function showPembagianDaging($tanggal = null)
    {
        $tanggal = $tanggal ?? date('Y-m-d');
        $dataPembagian = $this->model->getPembagianDagingByTanggal($tanggal);

        // Buat data siap ditampilkan di view
        $grouped = [];
        foreach ($dataPembagian as $row) {
            $id = $row['warga_id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'nama' => $row['nama'],
                    'warga' => 0,
                    'panitia' => 0,
                    'kurban' => 0,
                    'qr_warga' => '',
                    'qr_panitia' => '',
                    'qr_kurban' => '',
                ];
            }

            $grouped[$id][$row['kategori']] = (float)$row['jumlah_kg'];
            $grouped[$id]['qr_' . $row['kategori']] = $row['qr_code'];
        }

        foreach ($grouped as &$warga) {
            $count = 0;
            if ($warga['warga'] > 0) $count++;
            if ($warga['panitia'] > 0) $count++;
            if ($warga['kurban'] > 0) $count++;
            $warga['count_roles'] = $count;
        }

        usort($grouped, fn($a, $b) => $b['count_roles'] <=> $a['count_roles']);

        // Kirim ke view
        include __DIR__ . '/../Views/pembagian_daging.php';
    }

    public function prosesDistribusi($tanggal)
    {
        $this->model->simpanPembagianDaging($tanggal);
        header("Location: index.php?page=dashboard&subpage=pembagian_daging&tanggal=$tanggal");
        exit;
    }
}
