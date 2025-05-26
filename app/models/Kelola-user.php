<?php
require_once __DIR__ . '/../Database/Database.php';

class KelolaUserModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllWargaWithUserStatus() {
        $query = "SELECT w.*, u.id AS user_id FROM warga w 
                  LEFT JOIN users u ON w.id = u.warga_id";
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query error: " . $this->conn->error);
        }
        return $result;
    }

    public function updatePeran($warga_id, $is_panitia, $is_kurban, $is_admin) {
        $query = "UPDATE warga SET is_panitia = ?, is_kurban = ?, is_admin = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiii", $is_panitia, $is_kurban, $is_admin, $warga_id);
        return $stmt->execute();
    }
}
