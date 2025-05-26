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
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username dan password harus diisi.';
                header('Location: index.php?page=login');
                exit;
            }

            $user = $this->userModel->getUserByLogin($username, $password);

            if ($user) {
                // Mapping role dari data warga
                $roles = array_filter([
                    $user['is_admin']   ? 'admin'   : null,
                    $user['is_panitia'] ? 'panitia' : null,
                    $user['is_kurban']  ? 'pekurban': null,
                    $user['is_warga']   ? 'warga'   : null,
                ]);

                // Simpan ke session
                $_SESSION['user'] = [
                    'id'       => $user['warga_id'],
                    'username' => $user['username'],
                    'nama'     => $user['nama'],
                    'roles'    => $roles
                ];

                header('Location: index.php?page=dashboard&subpage=beranda');
                exit;
            } else {
                $_SESSION['error'] = 'Username atau password salah!';
                header('Location: index.php?page=login');
                exit;
            }
        } else {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header('Location: index.php?page=login');
        exit;
    }
}
