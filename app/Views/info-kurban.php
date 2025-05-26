<?php
// session_start(); // jangan dipanggil ulang

if (isset($_SESSION['user'])) {
    echo "User: " . htmlspecialchars($_SESSION['user']['nama']);
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Info Qurban</title>
</head>
<body>
  <h1>Qurban</h1>
</body>
</html>