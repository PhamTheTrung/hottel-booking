<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = trim($_POST["hoten"]);
    $loaiphong = $_POST["loaiphong"];
    $sodem = intval($_POST["sodem"]);
    $ghichu = $_POST["ghichu"];

    $giaPhong = [
        "standard" => 500000,
        "deluxe"   => 750000,
        "vip"      => 1000000
    ];

    // Kiểm tra hợp lệ
    $errors = [];

    if ($hoten == "") {
        $errors[] = "Họ tên không được để trống.";
    }
    if (!isset($giaPhong[$loaiphong])) {
        $errors[] = "Loại phòng không hợp lệ.";
    }
    if ($sodem < 1) {
        $errors[] = "Số đêm phải từ 1 trở lên.";
    }

    if (empty($errors)) {
        $dongia = $giaPhong[$loaiphong];
        $thanhtien = $dongia * $sodem;

        // Thêm phụ phí 5% nếu phòng VIP hoặc ở > 3 đêm
        if ($loaiphong == "vip" || $sodem > 3) {
            $phuphi = $thanhtien * 0.05;
        } else {
            $phuphi = 0;
        }

        $tong = $thanhtien + $phuphi;

        echo "<div class='result'>";
        echo "<h3>Hóa đơn đặt phòng</h3>";
        echo "Khách hàng: <strong>$hoten</strong><br>";
        echo "Loại phòng: <strong>$loaiphong</strong><br>";
        echo "Số đêm: <strong>$sodem</strong><br>";
        echo "Đơn giá: " . number_format($dongia, 0, ',', '.') . " VND<br>";
        echo "Thành tiền: " . number_format($thanhtien, 0, ',', '.') . " VND<br>";
        echo "Phụ phí: " . number_format($phuphi, 0, ',', '.') . " VND<br>";
        echo "<strong>Tổng cộng: " . number_format($tong, 0, ',', '.') . " VND</strong><br>";
        echo "Ghi chú: " . htmlspecialchars($ghichu);
        echo "</div>";
    } else {
        foreach ($errors as $err) {
            echo "<p style='color:red;text-align:center;'>$err</p>";
        }
    }
}
?>