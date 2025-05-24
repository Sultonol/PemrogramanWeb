<?php
require_once __DIR__ . '/../Database/Database.php';

class Keuangan
{
    private $koneksi;

    public function __construct()
    {
        $db = new Database();
        $this->koneksi = $db->getConnection();
    }

    public function addTransaksi($tanggal, $jenis, $sumber, $jumlah, $keterangan = null)
    {
        $tanggal = $this->koneksi->real_escape_string($tanggal);
        $jenis = $this->koneksi->real_escape_string($jenis);
        $sumber = $this->koneksi->real_escape_string($sumber);
        $jumlah = (float)$jumlah;
        $keterangan = $this->koneksi->real_escape_string($keterangan);

        // Ambil saldo total_keuangan terakhir
        $result = $this->koneksi->query("SELECT total_keuangan FROM keuangan ORDER BY tanggal DESC, id DESC LIMIT 1");
        $saldo_terakhir = 0;
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $saldo_terakhir = (float)$row['total_keuangan'];
        }

        // Hitung saldo baru berdasarkan jenis transaksi
        if ($jenis === 'masuk') {
            $total_keuangan_baru = $saldo_terakhir + $jumlah;
        } elseif ($jenis === 'keluar') {
            $total_keuangan_baru = $saldo_terakhir - $jumlah;
        } else {
            // Jika jenis tidak valid, tidak mengubah saldo
            $total_keuangan_baru = $saldo_terakhir;
        }

        $sql = "INSERT INTO keuangan (tanggal, jenis, sumber, jumlah, keterangan, total_keuangan) 
                VALUES ('$tanggal', '$jenis', '$sumber', $jumlah, '$keterangan', $total_keuangan_baru)";

        return $this->koneksi->query($sql);
    }

    public function getRekapByTanggal($startDate, $endDate)
    {
        $startDate = $this->koneksi->real_escape_string($startDate);
        $endDate = $this->koneksi->real_escape_string($endDate);

        $sql = "SELECT tanggal, jenis, sumber, jumlah, keterangan, total_keuangan
                FROM keuangan
                WHERE tanggal BETWEEN '$startDate' AND '$endDate'
                ORDER BY tanggal ASC";

        $result = $this->koneksi->query($sql);
        $data = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getAllTransaksi()
    {
        $sql = "SELECT * FROM keuangan ORDER BY tanggal DESC";
        $result = $this->koneksi->query($sql);
        $data = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
