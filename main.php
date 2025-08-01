<?php
session_start();
// Lấy dữ liệu từ GET, nếu không có thì để rỗng
$username = isset($_GET['username']) ? $_GET['username'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$confirm_password = isset($_GET['confirm_password']) ? $_GET['confirm_password'] : '';
if ($username == '' || $password == '' || $email == '') {
echo "";
} elseif ($password == $confirm_password) {
echo "check your password";
} else {
    header("location: html/login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay - Đặt phòng khách sạn cao cấp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            scroll-behavior: smooth;
        }
        
        .room-card:hover .room-img {
            transform: scale(1.05);
        }
        
        .room-img {
            transition: transform 0.3s ease;
        }
        
        .testimonial-card {
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .amenity-icon {
            transition: transform 0.3s ease;
        }
        
        .amenity-item:hover .amenity-icon {
            transform: scale(1.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="#" class="text-2xl font-bold text-amber-600 flex items-center">
                    <i class="fas fa-hotel mr-2"></i>
                    LuxStay
                </a>
            </div>
            
            <nav class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-800 hover:text-amber-600 font-medium">Trang chủ</a>
                <a href="#rooms" class="text-gray-800 hover:text-amber-600 font-medium">Phòng</a>
                <a href="#amenities" class="text-gray-800 hover:text-amber-600 font-medium">Tiện ích</a>
                <a href="#about" class="text-gray-800 hover:text-amber-600 font-medium">Giới thiệu</a>
                <a href="#contact" class="text-gray-800 hover:text-amber-600 font-medium">Liên hệ</a>
            </nav>
            
            <div class="flex items-center space-x-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="hidden md:flex items-center space-x-2">
                        <span class="text-gray-800">Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="logout.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                            Đăng xuất
                        </a>
                    </div>
                <?php else: ?>
                    <a href="register/login.html" class="hidden md:block px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition">
                        Đăng nhập
                    </a>
                <?php endif; ?>
                <button class="md:hidden text-gray-800 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative h-[600px] bg-gray-900 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-50 z-10"></div>
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c706fb32-e012-4fdd-bb1c-1d5009237075.png" alt="Khu nghỉ dưỡng sang trọng với hồ bơi vô cực nhìn ra biển và dãy núi phía xa" class="w-full h-full object-cover">
        
        <div class="absolute inset-0 flex items-center z-20">
            <div class="container mx-auto px-4">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Kỳ nghỉ hoàn hảo bắt đầu tại LuxStay</h1>
                    <p class="text-gray-200 text-lg mb-8">Khám phá những trải nghiệm nghỉ dưỡng đẳng cấp với dịch vụ 5 sao và tiện nghi hiện đại</p>
                </div>
                
                <!-- Search Form -->
                <div class="bg-white rounded-lg shadow-xl p-6 max-w-4xl mt-8">
                    <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4" id="searchForm">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Địa điểm</label>
                            <div class="relative">
                                <input type="text" name="location" placeholder="Thành phố, địa điểm..." value="<?php echo htmlspecialchars($_GET['location'] ?? ''); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-map-marker-alt absolute right-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nhận phòng</label>
                            <div class="relative">
                                <input type="date" name="check_in" value="<?php echo htmlspecialchars($_GET['check_in'] ?? ''); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Trả phòng</label>
                            <div class="relative">
                                <input type="date" name="check_out" value="<?php echo htmlspecialchars($_GET['check_out'] ?? ''); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Khách</label>
                            <div class="relative">
                                <select name="guests" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <?php for($i=1;$i<=5;$i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if(isset($_GET['guests']) && $_GET['guests']==$i) echo 'selected'; ?>><?php echo $i; ?> khách</option>
                                    <?php endfor; ?>
                                    <option value="6" <?php if(isset($_GET['guests']) && $_GET['guests']==6) echo 'selected'; ?>>5+ khách</option>
                                </select>
                            </div>
                        </div>
                        <div class="md:col-span-4">
                            <button type="submit" class="w-full mt-2 bg-amber-600 text-white py-3 px-6 rounded-md hover:bg-amber-700 transition font-medium">
                                Tìm phòng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/fa662589-43d8-41b0-9f93-1b238831fd6f.png" alt="Sảnh tiếp tân sang trọng của khách sạn LuxStay với kiến trúc hiện đại và ánh sáng ấm áp" class="rounded-lg shadow-lg w-full">
                </div>
                
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Khách sạn LuxStay - Đẳng cấp và tiện nghi</h2>
                    <p class="text-gray-600 mb-6">Khách sạn LuxStay mang đến cho bạn trải nghiệm nghỉ dưỡng đẳng cấp với hệ thống phòng ốc tiện nghi, dịch vụ chu đáo và không gian sang trọng. Chúng tôi cam kết mang đến sự thoải mái và tiện nghi nhất cho quý khách.</p>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start">
                            <div class="bg-amber-100 p-3 rounded-full mr-4">
                                <i class="fas fa-concierge-bell text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Dịch vụ 24/7</h4>
                                <p class="text-gray-600 text-sm">Đội ngũ nhân viên luôn sẵn sàng phục vụ</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-amber-100 p-3 rounded-full mr-4">
                                <i class="fas fa-wifi text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Wifi tốc độ cao</h4>
                                <p class="text-gray-600 text-sm">Kết nối internet không giới hạn</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-amber-100 p-3 rounded-full mr-4">
                                <i class="fas fa-utensils text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Nhà hàng đa dạng</h4>
                                <p class="text-gray-600 text-sm">Ẩm thực phong phú, đa dạng</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-amber-100 p-3 rounded-full mr-4">
                                <i class="fas fa-swimming-pool text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Hồ bơi ngoài trời</h4>
                                <p class="text-gray-600 text-sm">Hồ bơi vô cực view thành phố</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#rooms" class="inline-block px-6 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition font-medium">
                        Tìm hiểu thêm
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Các loại phòng</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">LuxStay cung cấp các loại phòng đa dạng từ phòng tiêu chuẩn đến suite cao cấp, đáp ứng mọi nhu cầu của quý khách</p>
            </div>
            
            <?php
            include_once "connect.php";
            // Xử lý tìm kiếm phòng
            $where = ["available=1"];
            $searchByAddress = false;
            if (!empty($_GET['location'])) {
                $loc = mysqli_real_escape_string($conn, $_GET['location']);
                // Nếu nhập địa chỉ, ưu tiên tìm theo address
                $where[] = "(address LIKE '%$loc%' OR room_name LIKE '%$loc%' OR short_description LIKE '%$loc%')";
                $searchByAddress = true;
            }
            if (!empty($_GET['guests'])) {
                $guests = intval($_GET['guests']);
                if ($guests <= 5) {
                    $where[] = "capacity >= $guests";
                } else {
                    $where[] = "capacity >= 5";
                }
            }
            $sql = "SELECT * FROM rooms WHERE " . implode(' AND ', $where) . " ORDER BY id DESC";
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
                        <div class="flex flex-wrap gap-2 mb-2">
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
                            <a href="booking.php" class="text-amber-600 hover:text-amber-700 font-medium flex items-center">
                                Đặt ngay <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php elseif (!empty($_GET['location'])): ?>
                <div class="text-center text-red-500 font-semibold py-8">Hiện không còn phòng trống tại địa chỉ này.</div>
            <?php endif; ?>
            
            <div class="text-center mt-12">
                <a href="allroom.php" class="inline-block px-6 py-3 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition font-medium">
                    Xem tất cả các phòng
                </a>
            </div>
        </div>
    </section>

    <!-- Amenities Section -->
    <section id="amenities" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tiện ích & Dịch vụ</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">LuxStay mang đến hệ thống tiện ích cao cấp giúp bạn có những trải nghiệm nghỉ dưỡng hoàn hảo nhất</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Amenity 1 -->
                <div class="bg-gray-50 p-6 rounded-lg text-center amenity-item">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-utensils text-amber-600 text-2xl amenity-icon"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Nhà hàng</h3>
                    <p class="text-gray-600">3 nhà hàng phục vụ ẩm thực đa dạng từ Á đến Âu</p>
                </div>
                
                <!-- Amenity 2 -->
                <div class="bg-gray-50 p-6 rounded-lg text-center amenity-item">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-spa text-amber-600 text-2xl amenity-icon"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Spa & Massage</h3>
                    <p class="text-gray-600">Dịch vụ spa cao cấp giúp thư giãn và tái tạo năng lượng</p>
                </div>
                
                <!-- Amenity 3 -->
                <div class="bg-gray-50 p-6 rounded-lg text-center amenity-item">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-dumbbell text-amber-600 text-2xl amenity-icon"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Phòng gym</h3>
                    <p class="text-gray-600">Phòng tập hiện đại với đầy đủ trang thiết bị</p>
                </div>
                
                <!-- Amenity 4 -->
                <div class="bg-gray-50 p-6 rounded-lg text-center amenity-item">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-swimming-pool text-amber-600 text-2xl amenity-icon"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Hồ bơi</h3>
                    <p class="text-gray-600">Hồ bơi vô cực với view toàn cảnh thành phố</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-amber-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Khách hàng nói gì về chúng tôi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Những phản hồi chân thực từ khách hàng đã trải nghiệm dịch vụ tại LuxStay</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/5ec10ff5-bc38-43d0-ada8-327707a8de10.png" alt="Chân dung người đàn ông trung niên, cười tươi, mặc vest" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Anh Nguyễn Văn A</h4>
                            <div class="flex text-amber-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Khách sạn tuyệt vời với dịch vụ chu đáo. Phòng ốc sạch sẽ, tiện nghi đầy đủ. Nhân viên nhiệt tình và chuyên nghiệp. Chắc chắn sẽ quay lại!"</p>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/6db89997-e2c7-4dea-9d11-b775f4173b29.png" alt="Chân dung phụ nữ trẻ, tóc dài, mỉm cười, trong không gian thư giãn" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Chị Trần Thị B</h4>
                            <div class="flex text-amber-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Lần đầu trải nghiệm dịch vụ tại LuxStay và thực sự ấn tượng. Nhà hàng ngon, hồ bơi đẹp. Đặc biệt view từ phòng suite thật tuyệt vời vào buổi tối!"</p>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/fb7c7ac5-19c1-4944-828f-c50ea1631682.png" alt="Người đàn ông lớn tuổi, vẻ mặt hài lòng, trong bối cảnh sang trọng" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Ông Lê Văn C</h4>
                            <div class="flex text-amber-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Đã sử dụng nhiều khách sạn 5 sao nhưng LuxStay thực sự nổi bật. Dịch vụ spa tuyệt hảo, phòng rộng rãi, êm ái. Rất đáng để trải nghiệm!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-900">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Sẵn sàng cho kỳ nghỉ tuyệt vời?</h2>
            <p class="text-gray-300 max-w-2xl mx-auto mb-8">Đặt phòng ngay hôm nay để nhận ưu đãi đặc biệt và trải nghiệm dịch vụ đẳng cấp từ LuxStay</p>
            <a href="allroom.php" class="inline-block px-8 py-3 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition font-medium text-lg">
                Đặt phòng ngay
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-hotel mr-2"></i> LuxStay
                    </h3>
                    <p class="text-gray-400 mb-4">LuxStay - Đẳng cấp trong từng chi tiết, sang trọng trong từng khoảnh khắc</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Liên kết nhanh</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Về chúng tôi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Dịch vụ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Phòng</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Tin tức</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Liên hệ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Dịch vụ</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Đặt phòng</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Spa & Massage</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Nhà hàng</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Sự kiện</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Ưu đãi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Liên hệ</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-amber-400"></i>
                            <span class="text-gray-400">Số 123, Đường ABC, Quận XYZ, TP. Hồ Chí Minh</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-2 text-amber-400"></i>
                            <span class="text-gray-400">0123 456 789</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-amber-400"></i>
                            <span class="text-gray-400">info@luxstay.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>© 2023 LuxStay. Bảo lưu mọi quyền.</p>
            </div>
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

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Form validation for booking
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkIn = this.querySelector('input[type="date"]');
            const today = new Date().toISOString().split('T')[0];
            if (checkIn.value < today) {
                e.preventDefault();
                alert('Vui lòng chọn ngày nhận phòng từ hôm nay trở đi');
                checkIn.focus();
            }
        });

        // Scroll to rooms section after search submit
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            setTimeout(function() {
                const roomsSection = document.getElementById('rooms');
                if (roomsSection) {
                    roomsSection.scrollIntoView({ behavior: 'smooth' });
                }
            }, 100); // delay to allow page reload with results
        });
    </script>

</body>
</html>
