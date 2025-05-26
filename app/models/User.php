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
        $stmt = $this->koneksi->prepare("
            SELECT u.*, w.nama, w.nik, w.is_panitia, w.is_kurban, w.is_admin, w.is_warga, w.id AS warga_id
            FROM users u
            JOIN warga w ON u.warga_id = w.id
            WHERE u.username = ? AND u.password = SHA2(?, 256)
            LIMIT 1
        ");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() ?? null;
    }

    public function getUserById($id)
    {
        $id = (int)$id;
        $stmt = $this->koneksi->prepare("
            SELECT u.*, w.nama, w.nik, w.is_panitia, w.is_kurban, w.is_admin, w.is_warga, w.id AS warga_id
            FROM users u
            JOIN warga w ON u.warga_id = w.id
            WHERE w.id = ?
            LIMIT 1
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() ?? null;
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

    public function getAllWarga()
    {
        $sql = "SELECT w.id, w.nama, w.nik, w.no_telepon, u.role
                FROM warga w
                LEFT JOIN users u ON w.id = u.warga_id
                ORDER BY w.id ASC";
        $result = $this->koneksi->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function updateRole($warga_id, $role_string)
    {
        $warga_id = (int)$warga_id;
        $role_string = $this->koneksi->real_escape_string($role_string);

        // Cek apakah user sudah ada
        $cek = $this->koneksi->query("SELECT * FROM users WHERE warga_id = $warga_id");

        if ($cek->num_rows > 0) {
            return $this->koneksi->query("UPDATE users SET role = '$role_string' WHERE warga_id = $warga_id");
        } else {
            $username = 'user' . $warga_id;
            $password = password_hash('123456', PASSWORD_BCRYPT);
            return $this->koneksi->query("INSERT INTO users (username, password, warga_id, role) VALUES ('$username', '$password', '$warga_id', '$role_string')");
        }
    }


    public function deleteWarga($warga_id)
    {
        $warga_id = (int)$warga_id;

        $stmt1 = $this->koneksi->prepare("DELETE FROM users WHERE warga_id = ?");
        $stmt1->bind_param("i", $warga_id);
        $stmt1->execute();

        $stmt2 = $this->koneksi->prepare("DELETE FROM warga WHERE id = ?");
        $stmt2->bind_param("i", $warga_id);
        return $stmt2->execute();
    }
}
