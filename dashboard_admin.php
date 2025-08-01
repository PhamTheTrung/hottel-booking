<?php
session_start();
// Chỉ cho phép admin truy cập
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Chào mừng Admin!</h2>
        <div class="mb-3">
            <a href="main.php" class="btn btn-primary">Trang chủ</a>
            <a href="register/user/user.php" class="btn btn-success">Quản lý người dùng</a>
            <a href="admin_rooms.php" class="btn btn-info">Quản lý phòng</a>
        </div>
        <p>Chọn chức năng bạn muốn quản lý.</p>
    </div>
</body>
</html>
