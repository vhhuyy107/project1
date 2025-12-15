<?php
session_start();
include 'admin/connect.php'; 

// --- XỬ LÝ: XÓA SẢN PHẨM ---
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['key'])) {
    $key = $_GET['key'];
    unset($_SESSION['cart'][$key]); 
    header('Location: cart.php'); 
    exit();
}

// --- XỬ LÝ: CẬP NHẬT SỐ LƯỢNG ---
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $key => $qty) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$key]);
        } else {
            $_SESSION['cart'][$key]['qty'] = $qty;
        }
    }
}

// --- LẤY DỮ LIỆU HIỂN THỊ ---
$cart_display = [];
$total_price = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $product_ids = [];
    foreach ($_SESSION['cart'] as $key => $item) {
        // Kiểm tra kỹ để tránh lỗi
        if (is_array($item) && isset($item['id'])) {
            $product_ids[] = $item['id'];
        }
    }
    
    if (!empty($product_ids)) {
        $ids_str = implode(',', array_unique($product_ids));
        $sql = "SELECT * FROM products WHERE id IN ($ids_str)";
        $result = $conn->query($sql);
        
        $products_db = [];
        while ($row = $result->fetch_assoc()) {
            $products_db[$row['id']] = $row;
        }

        foreach ($_SESSION['cart'] as $key => $item) {
            if (is_array($item) && isset($item['id'])) {
                $id = $item['id'];
                if (isset($products_db[$id])) {
                    $combined_item = $products_db[$id]; 
                    $combined_item['cart_key'] = $key;
                    $combined_item['buy_qty'] = $item['qty'];
                    $combined_item['buy_size'] = $item['size'];
                    $cart_display[] = $combined_item;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Giỏ hàng - StreetVibe</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="./image/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Trang chủ</a></li>
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

                <li id="lg-bag"> <a class="active" href="cart.php"> <i class="fa-solid fa-cart-shopping"></i></a></li>
                <a href="#" id="close"> <i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a class="active" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="page-header" class="about-header" style="background-image: url('image/banner/b1.jpg');">
        <h2>#GiỏHàngCủaBạn</h2>      
        <p>Kiểm tra lại các sản phẩm yêu thích</p>
    </section>

    <section id="cart" class="section-p1">
        <?php if (empty($cart_display)): ?>
            <div style="text-align: center; padding: 50px;">
                <h3>Giỏ hàng đang trống!</h3>
                <button class="normal" onclick="window.location.href='store.php'" style="margin-top:20px">Quay lại mua sắm</button>
            </div>
        <?php else: ?>
            <form action="" method="POST">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>XÓA</td>
                            <td>HÌNH ẢNH</td>
                            <td>SẢN PHẨM</td>
                            <td>SIZE</td>
                            <td>GIÁ</td>
                            <td>SỐ LƯỢNG</td>
                            <td>TẠM TÍNH</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cart_display as $item) {
                            $subtotal = $item['price'] * $item['buy_qty'];
                            $total_price += $subtotal;

                            $img_path = "image/" . $item['brand'] . "/" . $item['image'];
                            if (empty($item['image']) || !file_exists($img_path)) {
                                $img_path = "https://placehold.co/100x100?text=No+Image";
                            }
                        ?>
                        <tr>
                            <td><a href="cart.php?action=remove&key=<?php echo $item['cart_key']; ?>"><i class="far fa-times-circle"></i></a></td>
                            
                            <td><img src="<?php echo $img_path; ?>" alt=""></td>
                            
                            <td style="font-weight: 600;"><?php echo $item['name']; ?></td>
                            
                            <td><span style="border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;"><?php echo $item['buy_size']; ?></span></td>
                            
                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</td>
                            
                            <td><input type="number" name="quantity[<?php echo $item['cart_key']; ?>]" value="<?php echo $item['buy_qty']; ?>" min="1"></td>
                            
                            <td><?php echo number_format($subtotal, 0, ',', '.'); ?>₫</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <button type="submit" name="update_cart" class="normal" style="margin-top: 10px;">Cập nhật giỏ hàng</button>
            </form>
        <?php endif; ?>
    </section>

    <?php if (!empty($cart_display)): ?>
    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Áp Dụng Phiếu Giảm Giá</h3>
            <div>
                <input type="text" placeholder="Nhập mã giảm giá">
                <button class="normal">Áp dụng</button>
            </div>
        </div>
        <div id="subtotal">
            <h3>Tổng Giỏ Hàng</h3>  
            <table>
                <tr>
                    <td>Tạm tính</td>
                    <td><?php echo number_format($total_price, 0, ',', '.'); ?>₫</td>
                </tr>
                <tr>
                    <td>Phí vận chuyển</td>
                    <td>Miễn phí</td>
                </tr>
                <tr>
                    <td><strong>Tổng cộng</strong></td>
                    <td><strong><?php echo number_format($total_price, 0, ',', '.'); ?>₫</strong></td>
                </tr>
            </table>
            <button class="normal" onclick="window.location.href='checkout.php';">Tiến hành thanh toán</button>
        </div>
    </section>
    <?php endif; ?>

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
</body>
</html>