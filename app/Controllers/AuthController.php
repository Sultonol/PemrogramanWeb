<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByLogin($username, $password);

            if ($user) {
                $roles = [];
                if ($user['is_warga'] == 1) $roles[] = 'warga';
                if ($user['is_panitia'] == 1) $roles[] = 'panitia';
                if ($user['is_kurban'] == 1) $roles[] = 'pekurban';
                if ($user['is_admin'] == 1) $roles[] = 'admin';

                $_SESSION['user'] = [
                    'id' => $user['warga_id'],
                    'username' => $user['username'],
                    'nama' => $user['nama'],
                    'roles' => $roles
                ];

                header('Location: index.php?page=dashboard');
                exit;
            } else {
                $_SESSION['error'] = 'Username atau password salah!';
                header('Location: index.php?page=login');
                exit;
            }
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
