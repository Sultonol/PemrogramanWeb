<?php
require_once __DIR__ . '/../Database/Database.php';

class User
{
    private $koneksi;

    public function __construct()
    {
        $db = new Database();
        $this->koneksi = $db->getConnection();
    }

    public function getUserByLogin($username, $password)
    {
        $username = $this->koneksi->real_escape_string($username);
        $password = $this->koneksi->real_escape_string($password);

        $sql = "SELECT u.*, w.nama, w.nik, w.is_panitia, w.is_kurban, w.is_admin, w.is_warga, w.id as warga_id
                FROM users u
                JOIN warga w ON u.warga_id = w.id
                WHERE u.username = '$username' AND u.password = SHA2('$password', 256)
                LIMIT 1";

        $result = $this->koneksi->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function getUserById($id)
    {
        $id = (int)$id;
        $sql = "SELECT u.*, w.nama, w.nik, w.is_panitia, w.is_kurban, w.is_admin, w.is_warga, w.id as warga_id
                FROM users u
                JOIN warga w ON u.warga_id = w.id
                WHERE w.id = $id
                LIMIT 1";

        $result = $this->koneksi->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function getAllActivePekurban()
    {
        $sql = "SELECT u.*, w.nama, w.nik
                FROM users u
                JOIN warga w ON u.warga_id = w.id
                WHERE w.is_kurban = 1";

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
