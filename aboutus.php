<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Về chúng tôi - StreetVibe</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="image/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="store.php">Cửa hàng</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <li><a class="active" href="aboutus.php">Về chúng tôi</a></li>
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

    <section id="page-header" class="about-header" style="background-image: url('image/about/banner.png');">
        <h2>#aboutus</h2>
        <p>StreetVibe</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="image/about/a6.jpg" alt="">       
        <div>
            <h2>Chúng tôi là ai?</h2>
            <p>StreetVibe chuyên bán sneaker</p>
            <p style="line-height: 24px;">
                Chào mừng bạn đến với StreetVibe - Sneaker4UrLife! Đây là một trang web demo được phát triển như một đề tài thực hành cho môn học Nhập môn Web và Ứng dụng.
                <br><br>
                Trang web được xây dựng bởi sinh viên <strong>Thái Văn Huy - DH52200802</strong> Khoa Công nghệ Thông tin từ Đại học Công nghệ Sài Gòn. Mục tiêu của đề tài là vận dụng kiến thức về HTML, CSS và Javascript để tạo ra một giao diện website bán hàng trực tuyến chuyên về giày sneaker.
                <br><br>
                Trong quá trình phát triển, chúng tôi chú trọng vào việc thiết kế giao diện hiện đại, năng động, phù hợp với phong cách đường phố của giới trẻ. Trang web có tính responsive, dễ sử dụng trên nhiều thiết bị khác nhau. Các chức năng cơ bản như hiển thị sản phẩm, tìm kiếm, và giỏ hàng (demo) đã được tích hợp nhằm mô phỏng trải nghiệm mua sắm thực tế.
                <br><br>
                Chúng tôi hy vọng StreetVibe - Sneaker4UrLife sẽ là một ví dụ minh họa sinh động cho việc ứng dụng kiến thức đã học và đồng thời truyền tải niềm đam mê công nghệ cũng như thời trang đường phố đến với mọi người.
            </p>
            <br>
            <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">From Thái Văn Huy with loveee</marquee>
        </div>
    </section>

    <section id="about-app" class="section-p1">
        <h1>Tải xuống <a href="#">ứng dụng</a> của chúng tôi</h1>
        <div class="video">
            <video src="image/about/1.mp4" autoplay muted loop></video>
        </div>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="image/features/f1.png">
            <h6>Miễn phí vận chuyển</h6>
        </div>
        <div class="fe-box">
            <img src="image/features/f2.png">
            <h6>Đặt hàng trực tuyến</h6>
        </div>
        <div class="fe-box">
            <img src="image/features/f3.png">
            <h6>Tiết kiệm</h6>
        </div>
        <div class="fe-box">
            <img src="image/features/f4.png">
            <h6>Khuyễn mãi lớn</h6>
        </div>
        <div class="fe-box">
            <img src="image/features/f6.png">
            <h6>Hỗ trợ 24/7</h6>
        </div>
    </section>
        
    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Đăng Kí Để Nhận Thông Báo</h4>
            <p>Nhận những cập nhật qua Email về cửa hàng chúng tôi và <span>các ưu đãi đặc biệt</span></p> 
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
</body>
</html>