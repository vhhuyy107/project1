<?php
session_start();
include 'admin/connect.php';

// Kiểm tra ID
if (!isset($_GET['id'])) {
    header("Location: store.php");
    exit();
}

$id = $_GET['id'];

// Lấy thông tin sản phẩm
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) { echo "Sản phẩm không tồn tại!"; exit(); }

// Xử lý ảnh
$img_path = "image/" . $product['brand'] . "/" . $product['image'];
if (empty($product['image']) || !file_exists($img_path)) {
    $img_path = "https://placehold.co/600x600?text=No+Image";
}

// Lấy ảnh liên quan
$brand = $product['brand'];
$sql_related_imgs = "SELECT * FROM products WHERE brand = '$brand' AND id != $id LIMIT 3";
$res_imgs = $conn->query($sql_related_imgs);

// Lấy gợi ý (New Arrival)
$sql_suggestion = "SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 4";
$res_suggestion = $conn->query($sql_suggestion);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title><?php echo $product['name']; ?> - StreetVibe</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <script>
            alert("✅ Đã thêm sản phẩm vào giỏ hàng thành công!");
            // Xóa param status trên URL để F5 không bị hiện lại thông báo
            window.history.replaceState(null, null, window.location.pathname + "?id=<?php echo $id; ?>");
        </script>
    <?php endif; ?>

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

    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="<?php echo $img_path; ?>" width="100%" id="MainImg" style="border: 1px solid #f0f0f0; border-radius: 20px;">
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="<?php echo $img_path; ?>" width="100%" class="small-img" onclick="changeImage(this)">
                </div>
                <?php 
                while($row_img = $res_imgs->fetch_assoc()){
                    $small_path = "image/" . $row_img['brand'] . "/" . $row_img['image'];
                    if(file_exists($small_path)) {
                        echo '<div class="small-img-col"><img src="'.$small_path.'" width="100%" class="small-img" onclick="changeImage(this)"></div>';
                    }
                } 
                ?>
            </div>
        </div>

        <div class="single-pro-details">
            <h6>Home / <?php echo $product['brand']; ?></h6>
            <h4><?php echo $product['name']; ?></h4>
            <h2><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</h2>
            
            <form action="cart_add.php" method="POST" style="display: inline-block;" onsubmit="return validateSize()">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                <select name="size" id="sizeSelect" style="display: block; padding: 5px 10px; margin-bottom: 10px;">
                    <option value="">Chọn size</option>
                    <option value="38">Size 38</option>
                    <option value="39">Size 39</option>
                    <option value="40">Size 40</option>
                    <option value="41">Size 41</option>
                    <option value="42">Size 42</option>
                </select>

                <input type="number" name="quantity" value="1" min="1" style="width: 50px; padding: 10px; margin-right: 10px;">
                <button type="submit" name="add_to_cart" class="normal">Thêm vào giỏ hàng</button>
            </form>

            <h4>Thông tin chi tiết sản phẩm</h4>
            <span><?php echo !empty($product['description']) ? nl2br($product['description']) : "Chất liệu cao cấp, thoáng khí."; ?></span>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Có thể bạn sẽ thích</h2>
        <p>Các mẫu giày hot nhất hiện nay</p>
        <div class="pro-container">
            <?php
            while($row = $res_suggestion->fetch_assoc()) {
                $s_img = "image/" . $row['brand'] . "/" . $row['image'];
                if (empty($row['image']) || !file_exists($s_img)) {
                    $s_img = "https://placehold.co/500x500?text=No+Image";
                }
            ?>
            <div class="pro" onclick="window.location.href='product_detail.php?id=<?php echo $row['id']; ?>';">
                <img src="<?php echo $s_img; ?>" alt="">
                <div class="des">
                    <span><?php echo $row['brand']; ?></span>
                    <h5><?php echo $row['name']; ?></h5>
                    <div class="ranking">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <h4><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</h4>
                </div>
                <a href="cart_add.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-cart-plus cart"></i></a>
            </div>
            <?php } ?>
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
                    <i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i class="fab fa-instagram"></i><i class="fab fa-pinterest-p"></i><i class="fab fa-youtube"></i>
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

    <script src="./js/product_detail.js"></script>
</body>
</html>