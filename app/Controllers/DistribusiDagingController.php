<?php
require_once __DIR__ . '/../Models/DistribusiDaging.php';

class DistribusiDagingController
{
    private $model;

    public function __construct()
    {
        $this->model = new DistribusiDaging();
    }

    public function showPembagianDaging($tanggal)
    {
        $dataPembagian = $this->model->getPembagianDagingByTanggal($tanggal);
        include __DIR__ . '/../Views/pembagian_daging.php';
    }

    public function prosesDistribusi($tanggal)
    {
        $this->model->simpanPembagianDaging($tanggal);
        header("Location: index.php?page=pembagian_daging&tanggal=$tanggal");
        exit;
    }

    // Helper cek data sudah ada atau belum
    public function sudahAdaPembagian($tanggal)
    {
        $data = $this->model->getPembagianDagingByTanggal($tanggal);
        return !empty($data);
    }
}
