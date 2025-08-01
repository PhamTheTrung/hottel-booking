<?php
include "connect.php";

// Kiểm tra nếu là POST → xử lý đặt phòng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO bookings (fullname, email, phone, room_id, check_in, check_out, quantity) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssissi", $fullname, $email, $phone, $room_id, $check_in, $check_out, $quantity);
        if ($stmt->execute()) {
            echo "<script>alert('Đặt phòng thành công!'); window.location.href='rooms.php';</script>";
        } else {
            echo "Lỗi khi đặt phòng: " . $stmt->error;
        }
    } else {
        echo "Lỗi truy vấn SQL: " . $conn->error;
    }
} 
// Nếu là GET → hiển thị form đặt phòng
else if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    // Lấy thông tin phòng
    $sql = "SELECT * FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt phòng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Đặt phòng: <?php echo htmlspecialchars($room['room_type']); ?></h2>
    <form method="POST" action="process_booking.php">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
        <div class="form-group">
            <label>Họ và tên:</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Ngày nhận phòng:</label>
            <input type="date" name="check_in" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Ngày trả phòng:</label>
            <input type="date" name="check_out" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Số lượng phòng:</label>
            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
        </div>
        <button type="submit" class="btn btn-success">Xác nhận đặt phòng</button>
        <a href="rooms.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>
<?php
} else {
    // Nếu không có room_id hoặc không phải POST → quay lại danh sách phòng
    header("Location: rooms.php");
    exit();
}
?>
