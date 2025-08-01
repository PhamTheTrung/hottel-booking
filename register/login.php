<?php
session_start(); // Bắt đầu phiên làm việc
include "../connect.php"; // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Truy vấn người dùng theo email, lấy cả Role
    $query = "SELECT UserID, FullName, PasswordHash, Role FROM Users WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        // Nếu có đúng 1 người dùng với email này
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $userid, $fullname, $hashed_password, $role);
            mysqli_stmt_fetch($stmt);

            // Kiểm tra mật khẩu
            if (password_verify($password, $hashed_password)) {
                // Đăng nhập thành công -> lưu session
                $_SESSION['user_id'] = $userid;
                $_SESSION['user_name'] = $fullname;
                $_SESSION['role'] = $role;

                // Chuyển hướng theo role
                if ($role === 'Admin') {
                    header("Location: ../dashboard_admin.php");
                    exit();
                } else {
                    header("Location: ../main.php");
                    exit();
                }
            } else {
                echo "Mật khẩu không đúng.";
            }
        } else {
            echo "<html>
<head>
    <link rel='stylesheet' href='tinh.css'> 
</head>
<body>
    <div class='message-box message-warning'>
        <p>Không tìm thấy tài khoản với email này.</p>
        <a href='login.html' class='return-btn warning'>Quay lại trang đăng nhập</a>
    </div>
</body>
</html>";
        }
    } else {
        echo "Lỗi truy vấn.";
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>
