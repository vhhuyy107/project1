<?php
session_start();
include 'admin/connect.php'; // Kết nối DB

// --- LOGIC PHÂN TRANG (PAGINATION) ---
$limit = 12; // Số sản phẩm trên 1 trang
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại (mặc định là 1)
$start = ($page - 1) * $limit; // Vị trí bắt đầu lấy trong DB

// Đếm tổng số sản phẩm để tính số trang
$sql_count = "SELECT COUNT(id) AS total FROM products";
$result_count = $conn->query($sql_count);
$total_products = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit); // Làm tròn lên

// Lấy danh sách sản phẩm theo trang
$sql = "SELECT * FROM products ORDER BY id DESC LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Cửa hàng - StreetVibe</title>
    <link rel="stylesheet" href="css/style.css"> <style>
        /* CSS cho phân trang */
        #pagination { text-align: center; margin-top: 20px; }
        #pagination a {
            text-decoration: none;
            background-color: #088178;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 600;
            margin: 0 5px;
        }
        #pagination a.active {
            background-color: #044e49; /* Màu đậm hơn cho trang hiện tại */
        }
    </style>
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="./image/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a class="active" href="store.php">Cửa hàng</a></li>
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

    <section id="page-header">
        <h2>#store</h2>
        <p>Tiết kiệm nhiều hơn với phiếu giảm giá lên đến 70%</p>
    </section>

    <section id="product1" class="section-p1">
        <div class="pro-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Xử lý ảnh
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
                echo "<p style='text-align:center; width:100%'>Không có sản phẩm nào.</p>";
            }
            ?>
        </div>
    </section>

    <section id="pagination" class="section-p1">
        <?php 
        // Hiển thị nút Trang trước
        if($page > 1){
            echo '<a href="store.php?page='.($page-1).'"><i class="fa fa-long-arrow-alt-left"></i></a>';
        }

        // Hiển thị các số trang
        for ($i = 1; $i <= $total_pages; $i++) {
            $activeClass = ($i == $page) ? 'class="active"' : '';
            echo "<a href='store.php?page=$i' $activeClass>$i</a>";
        }

        // Hiển thị nút Trang sau
        if($page < $total_pages){
            echo '<a href="store.php?page='.($page+1).'"><i class="fa fa-long-arrow-alt-right"></i></a>';
        }
        ?>
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