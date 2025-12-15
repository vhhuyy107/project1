<?php
session_start();

// --- SỬA LỖI KẾT NỐI ---
include 'admin/connect.php'; 

// --- 1. LẤY SẢN PHẨM NỔI BẬT ---
$sql_featured = "SELECT * FROM products ORDER BY RAND() LIMIT 8";
$res_featured = $conn->query($sql_featured);

// --- 2. LẤY SẢN PHẨM MỚI ---
$sql_new = "SELECT * FROM products ORDER BY id DESC LIMIT 8";
$res_new = $conn->query($sql_new);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>StreetVibe - Sneaker4UrLife</title>
    <link rel="stylesheet" href="./css/style.css"> 
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="./image/logo.png" class="logo"></a>
        <div>
            <h1>Chiều thứ 2 ca 3</h1>
            <h1>Chiều thứ 2 ca 3</h1>
            <ul id="navbar">
                <li><a class="active" href="index.php">Trang chủ</a></li>
                <li><a href="store.php">Cửa hàng</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <li><a href="aboutus.php">Về chúng tôi</a></li>
                <li><a href="labpage.php">Các bài Labs</a></li>
                
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

    <section id="hero">
        <h4>Giao dịch ưu đãi</h4>
        <h2>Ưu đãi cực giá trị</h2>
        <h1>Trên tất cả sản phẩm</h1>
        <p>Tiết kiệm nhiều hơn với phiếu giảm giá tới 70%!</p>
        <button onclick="window.location.href='store.php';">Mua ngay!</button>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box"><img src="image/features/f1.png"><h6>Miễn phí vận chuyển</h6></div>
        <div class="fe-box"><img src="image/features/f2.png"><h6>Đặt hàng trực tuyến</h6></div>
        <div class="fe-box"><img src="image/features/f3.png"><h6>Tiết kiệm</h6></div>
        <div class="fe-box"><img src="image/features/f4.png"><h6>Khuyễn mãi lớn</h6></div>
        <div class="fe-box"><img src="image/features/f6.png"><h6>Hỗ trợ 24/7</h6></div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Sản Phẩm Nổi Bật</h2>
        <p>Hè đã đến gần lắm rồi!!</p>

        <div class="pro-container">
            <?php
            if ($res_featured && $res_featured->num_rows > 0) {
                while($row = $res_featured->fetch_assoc()) {
                    $img_path = "image/" . $row['brand'] . "/" . $row['image'];
                    if (empty($row['image']) || !file_exists($img_path)) {
                        $img_path = "https://placehold.co/500x500?text=No+Image";
                    }
            ?>
            <div class="pro" onclick="window.location.href='product_detail.php?id=<?php echo $row['id']; ?>';">
                <img src="<?php echo $img_path; ?>" alt="">
                <div class="des">
                    <span><?php echo $row['brand']; ?></span>
                    <h5><?php echo $row['name']; ?></h5>
                    <div class="ranking">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</h4>
                </div>
                <a href="cart_add.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-cart-plus cart"></i></a>
            </div>
            <?php 
                }
            } else {
                echo "<p>Đang cập nhật sản phẩm...</p>";
            }
            ?>
        </div>
        <button onclick="window.location.href='store.php';" class="btn_xemtatca">Xem tất cả</button>
    </section>

    <section id="banner" class="section-m1">
        <h4>Vệ sinh và sửa chữa giày</h4>
        <h2>Lên đến <span>Giảm 70%</span> - Tất cả sản phẩm</h2>
        <button class="normal" onclick="window.location.href='store.php';">Tìm hiểu thêm</button>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrival</h2>
        <p>Thiết Kế Mới Lạ Và Thời Trang</p>

        <div class="pro-container">
            <?php
            if ($res_new && $res_new->num_rows > 0) {
                while($row = $res_new->fetch_assoc()) {
                    $img_path = "image/" . $row['brand'] . "/" . $row['image'];
                    if (empty($row['image']) || !file_exists($img_path)) {
                        $img_path = "https://placehold.co/500x500?text=No+Image";
                    }
            ?>
            <div class="pro" onclick="window.location.href='product_detail.php?id=<?php echo $row['id']; ?>';">
                <img src="<?php echo $img_path; ?>" alt="">
                <div class="des">
                    <span><?php echo $row['brand']; ?></span>
                    <h5><?php echo $row['name']; ?></h5>
                    <div class="ranking">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</h4>
                </div>
                <a href="cart_add.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-cart-plus cart"></i></a>
            </div>
            <?php 
                }
            }
            ?>
        </div>
    </section>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>Ưu Đãi Siêu Khổng Lồ</h4>
            <h2>Buy 1 get 1</h2>
            <span>Phong Cách Old School Chưa Bao Giờ Hết Hot!</span>
            <button class="white">Tìm hiểu thêm</button>
        </div>
        <div class="banner-box banner-box2">
            <h4>Skater?</h4>
            <h2>Phong cách</h2>
            <span>Về với OG</span>
            <button class="white">Tìm hiểu thêm</button>
        </div>
    </section>

    <section id="banner3">
        <div class="banner-box">
            <h2>MÙA GIẢM GIÁ</h2>
            <h3>Giảm 50%</h3>          
        </div>
        <div class="banner-box banner-box2">
            <h2>Thời trang những năm 70s</h2>
            <h3>Hoài niệm</h3>          
        </div>
        <div class="banner-box banner-box3">
            <h2>Bụi bặm</h2>
            <h3>Nhưng vẫn rất nhẹ nhàng</h3>          
        </div>
    </section>


    
    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Đăng Kí Để Nhận Thông Báo</h4>
            <p>Nhận những cập nhật qua Email về cửa hàng chúng tôi và <span>các ưu đãi đặc biệt</span></p> 
        </div>
        <div class="form">
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
</body>
</html>