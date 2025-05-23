<?php
class Database {
    private $host = "localhost";
    private $users = "root";
    private $password = "sulton2495";
    private $database = "db_qurban";
    public $koneksi;

    public function __construct() {
        $this->koneksi = new mysqli(
            $this->host,
            $this->users,
            $this->password,
            $this->database
        );

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
        $this->koneksi->set_charset("utf8");
    }

    public function getConnection() {
        return $this->koneksi;
    }
}
