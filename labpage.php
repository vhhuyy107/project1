<?php
session_start();
include 'admin/connect.php'; // Kết nối để header hoạt động trơn tru
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Các bài Labs - StreetVibe</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Labs.css">
    
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="image/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="store.php">Cửa hàng</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <li><a href="aboutus.php">Về chúng tôi</a></li>
                <li><a class="active" href="labpage.php">Các bài Labs</a></li>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    
                    <li id="lg-user"> 
    <a href="user_detail.php" style="color: #088178; font-weight: bold; cursor: pointer;"> 
        <i class="fa-solid fa-user"></i> Xin chào, <?php echo $_SESSION['fullname']; ?> 
        <i class="fa-solid fa-caret-down"></i> </a>

    <ul class="dropdown-menu">
        <li>
            <a href="user_detail.php"><i class="fa-solid fa-id-card"></i> Thông tin tài khoản</a>
        </li>
        <li>
            <a href="order_history.php"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử đơn hàng</a>
        </li>
        <li>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
        </li>
    </ul>
</li>
                
                    <?php else: ?>
                    <li id="lg-user"><a href="login.php"><i class="fa-solid fa-user"></i> Đăng nhập</a></li>
                <?php endif; ?>

                <li id="lg-bag"> <a href="cart.php"> <i class="fa-solid fa-cart-shopping"></i></a></li>
                <a href="#" id="close"> <i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="page-header" class="about-header" style="background-image: url('image/banner/b16.jpg');"> 
        <h2>#labs</h2>      
        <p>Danh sách các bài thực hành Web & Ứng dụng</p>
    </section>

    <section id="product1" class="section-p1">
        
    
    
    <div class="pro-container">
    <?php 
    $path = './labsthuchanh/'; // Nhớ có dấu / ở cuối
    
    // Lấy danh sách thư mục
    $labs = glob($path . 'lab*', GLOB_ONLYDIR);

    if ($labs) {
        foreach($labs as $index => $labPath) {
            $folderName = basename($labPath);
            $labNumber = (int) filter_var($folderName, FILTER_SANITIZE_NUMBER_INT);
            
            // --- LOGIC MỚI: Lấy danh sách file bên trong folder lab ---
            // Tìm tất cả file .php trong folder này
            $files = glob($labPath . '/*.php');
            ?>

            <div class="pro" onclick="toggleLab('list-<?php echo $index; ?>')">
                
                <div style="width: 100%; text-align: center;">
                    <i class="fa-solid fa-code lab-icon"></i>
                    <div class="des">
                        <span>Bài tập thực hành</span>
                        <h5 style="font-size: 18px; margin: 10px 0;">Bài Lab số <?php echo $labNumber; ?></h5>
                        <h6 style="color: #666; font-size: 12px;">(Nhấn để xem bài tập con)</h6>
                        
                        <div class="ranking">
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <ul id="list-<?php echo $index; ?>" class="file-list" onclick="event.stopPropagation()">
                    <?php 
                    if ($files) {
                        foreach($files as $filePath) {
                            $fileName = basename($filePath);
                            
                            // Bỏ qua các file không cần thiết (tùy chọn)
                            // Ví dụ: Bỏ qua file connect.php hoặc file ẩn
                            if ($fileName == 'connect.php') continue; 
                            ?>
                            <li>
                                <a href="<?php echo $filePath; ?>" target="_blank">
                                    <i class="fa-regular fa-file-code"></i> 
                                    <?php echo $fileName; ?>
                                </a>
                            </li>
                            <?php 
                        }
                    } else {
                        echo "<li style='padding:10px; color:red;'>Chưa có file nào</li>";
                    }
                    ?>
                </ul>
                
                <div style="width:100%; text-align: right; padding-top: 10px;">
                   <i class="fa-solid fa-chevron-down" style="color: #088178;"></i>
                </div>
            </div>
            <?php 
        } 
    } else {
        echo "<p>Chưa có bài Lab nào trong thư mục labsthuchanh.</p>";
    }
    ?>
</div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Đăng Kí Để Nhận Thông Báo</h4>
            <p>Nhận thông báo khi có bài Lab mới <span>ngay hôm nay</span></p> 
        </div>
        <div class="form">
            <input type="text" placeholder="Email của bạn">
            <button class="normal">Đăng ký</button>
        </div>
    </section>

    <footer id="section-p1">
        <div class="col">
            <img class="logo" src="image/logo.png">
            <h4>Thông tin liên hệ</h4>
            <p><strong>Địa chỉ: </strong>DaLat - VietNam</p>
            <p><strong>SĐT: </strong>+84123456789</p>
            <p><strong>Giờ: 8:00 - 17:00, Mon - Sat</strong></p>
            <div class="follow">
                <h4>Theo dõi chúng tôi:</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>Liên Hệ</h4>
            <a href="aboutus.php">Về chúng tôi</a>
            <a href="#">Thông tin giao hàng</a>
            <a href="#">Chính sách bảo mật</a>
            <a href="#">Điều khoản</a>
            <a href="contact.php">Liên hệ chúng tôi</a>
        </div>

        <div class="col">
            <h4>Tài khoản của tôi</h4>
            <a href="login.php">Đăng nhập</a>
            <a href="cart.php">Xem giỏ hàng</a>
            <a href="#">Sản phẩm yêu thích</a>
            <a href="#">Theo dõi đơn hàng</a>
            <a href="#">Hỗ trợ</a>
        </div>

        <div class="col install">
            <h4>Tải ứng dụng</h4>
            <p>Từ AppStore hoặc GooglePlay</p>
            <div class="row">
                <img src="image/pay/app.jpg" alt="">
                <img src="image/pay/play.jpg" alt="">
            </div>
            <p>Cổng thanh toán</p>
            <img src="image/pay/pay.png" alt="">
        </div>
        <div class="copyright">
            <p>CopyRight 2025, StreetVibe</p>
        </div>
    </footer>
    <script src="./js/labspage.js"></script>
</body>
</html>