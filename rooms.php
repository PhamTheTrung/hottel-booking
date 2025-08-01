<?php
include "connect.php";

$sql = "SELECT * FROM rooms";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách phòng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .card {
            background: #fff;
            width: 280px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 18px;
            margin: 0 0 10px;
            color: #007bff;
        }

        .card-text {
            font-size: 14px;
            margin-bottom: 15px;
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Danh sách phòng khách sạn</h2>

<div class="container">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="card">
            <?php if (!empty($row['image'])) { ?>
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Room Image">
            <?php } else { ?>
                <img src="default-room.jpg" alt="No Image">
            <?php } ?>
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['room_type']); ?></h5>
                <p class="card-text">Giá: <?php echo number_format($row['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                <a href="process_booking.php?room_id=<?php echo $row['id']; ?>" class="btn">Đặt phòng</a>
            </div>
        </div>
    <?php } ?>
</div>

</body>
</html>
