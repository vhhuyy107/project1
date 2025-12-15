<?php
session_start();
include 'admin/connect.php'; // Kết nối nếu cần xử lý form sau này
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Liên hệ - StreetVibe</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="image/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="store.php">Cửa hàng</a></li>
                <li><a class="active" href="contact.php">Liên hệ</a></li>
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

    <section id="page-header" class="about-header" style="background-image: url('image/about/banner.png');">
        <h2>#TellUs</h2>      
        <p>Hãy để lại lời nhắn, chúng tôi rất hân hạnh!</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>LIÊN LẠC</span>
            <h2>Ghé thăm 1 trong những cửa hàng của chúng tôi hoặc liên hệ cho chúng tôi ngay!</h2>
            <h3>Trụ sở chính</h3>
            <div>
                <li>
                    <i class="fa-solid fa-map"></i>
                    <p>Cau Dat Da Lat Lam Dong</p>
                </li>
                <li>
                    <i class="fa-regular fa-envelope"></i>
                    <p>streetvibe@gmail.com</p>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <p>0912345678</p>
                </li>
                <li>
                    <i class="far fa-clock"></i>
                    <p>Mon - Sat 8:00 đến 17:00</p>
                </li>
            </div>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3903.2877902405385!2d108.44201621480836!3d11.954565639612173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317112d959f88991%3A0x9c66baf1767356fa!2zQ2hvIMSQw6AgTGF0!5e0!3m2!1svi!2s!4v1678112285435!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section id="form-details">
        <form action="">
            <span>ĐỂ LẠI LỜI NHẮN</span>
            <h2>Chúng tôi rất cần bạn nhận xét</h2>
            <input type="text" placeholder="Tên của bạn">
            <input type="text" placeholder="Email">
            <input type="text" placeholder="Chủ đề">
            <textarea name="" id="" cols="30" rows="10" placeholder="Tin nhắn của bạn"></textarea>
            <button class="normal">Gửi</button>
        </form>

        <div class="people">
            <div>
                <img src="image/people/1.png" alt="">
                <p><span>SawakoC</span> Quản lý tiếp thị cấp cao <br> Điện thoại: 0987 654 321 <br>Email: sawakc@gmail.com</p>
            </div>
            <div>
                <img src="image/people/2.png" alt="">
                <p><span>Ryu</span> Quản lý tiếp thị cấp cao <br> Điện thoại: 0987 654 321 <br>Email: sawakc@gmail.com</p>
            </div>
            <div>
                <img src="image/people/3.png" alt="">
                <p><span>Huy</span> Quản lý tiếp thị cấp cao <br> Điện thoại: 0987 654 321 <br>Email: sawakc@gmail.com</p>
            </div>
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