<?php
require_once __DIR__ . '/../Database/Database.php';

class DistribusiDaging
{
	private $koneksi;

	public function __construct()
	{
		$db = new Database();
		$this->koneksi = $db->getConnection();
	}

	public function getTotalBeratPerJenis()
	{
		$sql = "SELECT 
                    SUM(CASE WHEN jenis = 'sapi' THEN total_berat ELSE 0 END) AS total_sapi,
                    SUM(CASE WHEN jenis = 'kambing' THEN total_berat ELSE 0 END) AS total_kambing
                FROM hewan_qurban";
		$result = $this->koneksi->query($sql);
		return $result->fetch_assoc();
	}

	public function getJumlahPerKategori()
	{
		$sql = "SELECT 
                    SUM(CASE WHEN is_panitia = 1 THEN 1 ELSE 0 END) AS total_panitia,
                    SUM(CASE WHEN is_kurban = 1 THEN 1 ELSE 0 END) AS total_kurban,
                    SUM(CASE WHEN is_panitia = 0 AND is_kurban = 0 THEN 1 ELSE 0 END) AS total_warga
                FROM warga WHERE is_admin = 0";
		$result = $this->koneksi->query($sql);
		return $result->fetch_assoc();
	}

	public function hitungJatahPerKategori()
	{
		$berat = $this->getTotalBeratPerJenis();
		$totalBerat = ($berat['total_sapi'] ?? 0) + ($berat['total_kambing'] ?? 0);
		$jumlah = $this->getJumlahPerKategori();

		return [
			'total_daging' => $totalBerat,
			'kurban' => round(($totalBerat / 3) / max(1, $jumlah['total_kurban']), 2),
			'panitia' => round(($totalBerat / 3) / max(1, $jumlah['total_panitia']), 2),
			'warga' => round(($totalBerat / 3) / max(1, $jumlah['total_warga']), 2),
		];
	}

	public function simpanPembagianDaging($tanggal)
	{
		$sql = "SELECT id, nama, is_kurban, is_panitia FROM warga WHERE is_admin = 0";
		$result = $this->koneksi->query($sql);
		$jatah = $this->hitungJatahPerKategori();

		while ($row = $result->fetch_assoc()) {
			$warga_id = $row['id'];
			$roles = [];

			if ($row['is_kurban']) $roles[] = 'kurban';
			if ($row['is_panitia']) $roles[] = 'panitia';
			$roles[] = 'warga'; // Semua warga tetap dapat jatah

			foreach ($roles as $role) {
				$jumlah_kg = $jatah[$role] ?? 0;
				$kode_qr = $this->generateKodeQR($warga_id, $role, $tanggal);

				$stmt = $this->koneksi->prepare("INSERT INTO pembagian_daging (warga_id, kategori, jumlah_kg, tanggal, qr_code) VALUES (?, ?, ?, ?, ?)");
				$stmt->bind_param("isdss", $warga_id, $role, $jumlah_kg, $tanggal, $kode_qr);
				$stmt->execute();
			}
		}
	}

	private function generateKodeQR($warga_id, $role, $tanggal)
	{
		// Ganti IP sesuai IP lokal laptop kamu
		$baseUrl = 'http://192.168.18.18/Qurban_RT/public/index.php';
		return $baseUrl . '?halaman=detail_pembagian&id=' . $warga_id . '&role=' . $role . '&tanggal=' . $tanggal;
	}

	public function getPembagianDagingByTanggal($tanggal)
	{
		$tanggal = $this->koneksi->real_escape_string($tanggal);
		$sql = "SELECT pd.*, w.nama 
                FROM pembagian_daging pd 
                JOIN warga w ON pd.warga_id = w.id 
                WHERE pd.tanggal = '$tanggal'
                ORDER BY FIELD(pd.kategori, 'warga', 'panitia', 'kurban'), w.nama ASC";
		$result = $this->koneksi->query($sql);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
}
