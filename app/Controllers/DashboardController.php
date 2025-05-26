<?php

class DashboardController
{
    public function beranda()
    {
        // Misal: ambil dari session, tidak perlu query
        $user = $_SESSION['user'] ?? null;

        // Jika nanti mau load statistik dari model, bisa tambahkan di sini

        include __DIR__ . '/../Views/beranda.php';
    }
}
