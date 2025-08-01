<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả các phòng - LuxStay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Montserrat', sans-serif; scroll-behavior: smooth; }
        .room-card:hover .room-img { transform: scale(1.05); }
        .room-img { transition: transform 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="main.php" class="text-2xl font-bold text-amber-600 flex items-center">
                    <i class="fas fa-hotel mr-2"></i>
                    LuxStay
                </a>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="main.php" class="text-gray-800 hover:text-amber-600 font-medium">Trang chủ</a>
                <a href="main.php#rooms" class="text-gray-800 hover:text-amber-600 font-medium">Phòng</a>
                <a href="main.php#amenities" class="text-gray-800 hover:text-amber-600 font-medium">Tiện ích</a>
                <a href="main.php#about" class="text-gray-800 hover:text-amber-600 font-medium">Giới thiệu</a>
                <a href="main.php#contact" class="text-gray-800 hover:text-amber-600 font-medium">Liên hệ</a>
            </nav>
            <div class="flex items-center space-x-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="hidden md:flex items-center space-x-2">
                        <span class="text-gray-800">Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="logout.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Đăng xuất</a>
                    </div>
                <?php else: ?>
                    <a href="register/login.html" class="hidden md:block px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition">Đăng nhập</a>
                <?php endif; ?>
                <button class="md:hidden text-gray-800 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- All Rooms Section -->
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tất cả các loại phòng</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Danh sách đầy đủ các loại phòng tại LuxStay, cập nhật mới nhất từ hệ thống</p>
            </div>
            <?php
            include_once "connect.php";
            $sql = "SELECT * FROM rooms ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0):
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while($room = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden room-card">
                    <div class="overflow-hidden">
                        <img src="<?php echo htmlspecialchars($room['image_url']); ?>" alt="<?php echo htmlspecialchars($room['room_name']); ?>" class="w-full h-64 object-cover room-img">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($room['room_name']); ?></h3>
                            <span class="text-amber-600 font-bold"><?php echo number_format($room['price']); ?>đ</span>
                        </div>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($room['short_description']); ?></p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <div class="mb-4 text-sm text-gray-500 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-amber-500"></i>
                                <?php echo htmlspecialchars($room['address'] ?? ''); ?>
                            </div>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded"><?php echo $room['capacity']; ?> người</span>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded"><?php echo $room['size']; ?>m²</span>
                            <?php if($room['has_wifi']): ?><span class="text-xs bg-gray-100 px-2 py-1 rounded">Wifi</span><?php endif; ?>
                            <?php if($room['has_bathtub']): ?><span class="text-xs bg-gray-100 px-2 py-1 rounded">Bồn tắm</span><?php endif; ?>
                            <?php if($room['has_balcony']): ?><span class="text-xs bg-gray-100 px-2 py-1 rounded">Ban công</span><?php endif; ?>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex text-amber-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <a href="#" class="text-amber-600 hover:text-amber-700 font-medium flex items-center">Đặt ngay <i class="fas fa-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
                <div class="text-center text-gray-500">Hiện chưa có phòng nào trong hệ thống.</div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">© 2023 LuxStay. Bảo lưu mọi quyền.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('.md\\:hidden').addEventListener('click', function() {
            const nav = document.querySelector('nav');
            nav.classList.toggle('hidden');
            nav.classList.toggle('flex');
            nav.classList.toggle('flex-col');
            nav.classList.toggle('absolute');
            nav.classList.toggle('top-16');
            nav.classList.toggle('left-0');
            nav.classList.toggle('right-0');
            nav.classList.toggle('bg-white');
            nav.classList.toggle('p-4');
            nav.classList.toggle('shadow-md');
        });
    </script>
</body>
</html>
