<?php
session_start(); // Bắt đầu session
include "../../connect.php"; // Kết nối CSDL

// Kiểm tra nếu không phải admin
// if (!isset($_SESSION["username"]) || $_SESSION["username"] !== "admin") {
//     echo "<p style='color:red; text-align:center;'>Bạn không có quyền truy cập trang này!</p>";
//     exit();
// }

// Xử lý Thêm hoặc Cập nhật
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_user'])) {
    $id = $_POST['user_id'] ?? '';
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($id) {
        // Cập nhật (không thay mật khẩu)
        $sql = "UPDATE Users SET FullName=?, Email=?, PhoneNumber=?, Address=? WHERE UserID=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $fullname, $email, $phone, $address, $id);
    } else {
        // Thêm mới (có mật khẩu)
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO Users (FullName, Email, PasswordHash, PhoneNumber, Address) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $fullname, $email, $password, $phone, $address);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: user.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

// Xử lý xóa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM Users WHERE UserID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: user.php");
    exit();
}

// Lấy danh sách
$result = mysqli_query($conn, "SELECT UserID, FullName, Email, PhoneNumber, Address FROM Users");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Người Dùng</title>
    <link rel="stylesheet" href="user.css">
</head>

<body>
    <div class="container">
        <h2>Quản lý Người Dùng</h2>

        <form method="POST">
            <input type="hidden" name="user_id" id="user_id">
            <input type="text" name="fullname" id="fullname" placeholder="Họ tên" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="text" name="phone" id="phone" placeholder="Số điện thoại">
            <input type="text" name="address" id="address" placeholder="Địa chỉ">
            <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
            <button type="submit" name="save_user" class="btn">Lưu</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Hành động</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['UserID'] ?></td>
                    <td><?= htmlspecialchars($row['FullName']) ?></td>
                    <td><?= htmlspecialchars($row['Email']) ?></td>
                    <td><?= htmlspecialchars($row['PhoneNumber']) ?></td>
                    <td><?= htmlspecialchars($row['Address']) ?></td>
                    <td>
                        <button class="btn edit-btn" onclick="editUser(
                    '<?= $row['UserID'] ?>',
                    '<?= htmlspecialchars($row['FullName']) ?>',
                    '<?= htmlspecialchars($row['Email']) ?>',
                    '<?= htmlspecialchars($row['PhoneNumber']) ?>',
                    '<?= htmlspecialchars($row['Address']) ?>'
                )">Sửa</button>
                        <a href="?delete=<?= $row['UserID'] ?>" class="btn delete-btn" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <a href="dashboard.php" class="btn back-btn">Quay lại</a>
        <a href="../../admin_rooms.php" class="btn" style="background:#007bff;color:#fff;margin-left:10px;">Quản lý phòng (Admin)</a>
    </div>
    <script src="user.js"></script>
</body>

</html>