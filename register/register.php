
<?php
include("../connect.php");

session_start();

// Get data from register form
$fullName = isset($_POST["username"]) ? trim($_POST["username"]) : '';
$email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
$phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : '';
$address = isset($_POST["address"]) ? trim($_POST["address"]) : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';
$confirmPassword = isset($_POST["confirm_Password"]) ? $_POST["confirm_Password"] : '';

// Validation
if (empty($fullName) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirmPassword)) {
    $message = "<div class='alert alert-danger'>Vui lòng điền đầy đủ thông tin.</div>";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "<div class='alert alert-danger'>Email không hợp lệ.</div>";
} else if (strlen($password) < 6) {
    $message = "<div class='alert alert-danger'>Mật khẩu phải có ít nhất 6 ký tự.</div>";
} else if ($password !== $confirmPassword) {
    $message = "<div class='alert alert-danger'>Mật khẩu xác nhận không khớp.</div>";
} else {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare the statement to check for existing email
        $check_query = "SELECT * FROM users WHERE Email=?";
        $stmt = mysqli_prepare($conn, $check_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $message = "<div class='alert alert-danger'>Email đã tồn tại.</div>";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Prepare the insert statement
                $insert_query = "INSERT INTO users (FullName, Email, PasswordHash, PhoneNumber, Address, Role) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($conn, $insert_query);
                $role = 'Customer'; // Default role

                if ($stmt_insert) {
                    mysqli_stmt_bind_param($stmt_insert, "ssssss", $fullName, $email, $hashed_password, $phone, $address, $role);
                    if (mysqli_stmt_execute($stmt_insert)) {
                        header("Location: login.html");
                        exit;
                    } else {
                        $message = "<div class='alert alert-danger'>Lỗi khi đăng ký: " . mysqli_error($conn) . "</div>";
                    }
                    mysqli_stmt_close($stmt_insert);
                } else {
                    $message = "<div class='alert alert-danger'>Lỗi chuẩn bị câu lệnh: " . mysqli_error($conn) . "</div>";
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "<div class='alert alert-danger'>Lỗi chuẩn bị câu lệnh: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Đăng ký</title>
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Kết quả đăng ký</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($message)) echo $message; ?>
                        <div class="text-center mt-3">
                            <a href="register.html" class="btn btn-secondary">← Quay lại form đăng ký</a>
                            <a href="login.html" class="btn btn-primary">Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>