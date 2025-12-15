<?php
session_start();

// --- 1. KẾT NỐI DATABASE ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_streetvibesneaker";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// --- 2. LẤY THÔNG TIN USER ĐỂ ĐIỀN TỰ ĐỘNG ---
// Khởi tạo biến rỗng mặc định
$user_info = [
    'fullname' => '',
    'email' => '',
    'phone' => '',
    'address' => ''
];

// Nếu đã đăng nhập, query vào DB lấy thông tin mới nhất
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT * FROM users WHERE id = $user_id";
    $result_user = $conn->query($sql_user);
    if ($result_user->num_rows > 0) {
        $db_user = $result_user->fetch_assoc();
        // Gán dữ liệu vào biến (ưu tiên dữ liệu trong DB)
        $user_info['fullname'] = $db_user['fullname'];
        $user_info['email'] = $db_user['email'];
        $user_info['phone'] = $db_user['phone'];     // Nếu DB chưa có thì nó sẽ rỗng
        $user_info['address'] = $db_user['address']; // Nếu DB chưa có thì nó sẽ rỗng
    }
}

// --- 3. XỬ LÝ DỮ LIỆU GIỎ HÀNG ---
$cart_display = [];
$total_price = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $product_ids = [];
    foreach ($_SESSION['cart'] as $key => $item) {
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
                    $combined_item['buy_size'] = isset($item['size']) ? $item['size'] : 'Free Size';
                    
                    $subtotal = $combined_item['price'] * $combined_item['buy_qty'];
                    $total_price += $subtotal;
                    $combined_item['subtotal'] = $subtotal;

                    $cart_display[] = $combined_item;
                }
            }
        }
    }
} else {
    header('Location: store.php');
    exit();
}

// --- 4. XỬ LÝ KHI BẤM NÚT ĐẶT HÀNG ---
// --- 4. XỬ LÝ KHI BẤM NÚT ĐẶT HÀNG ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_order'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $payment_method = $_POST['payment']; 

    $user_id_save = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';

    // LOGIC TRẠNG THÁI BAN ĐẦU
    // - Nếu COD: Coi như xong luôn -> 'shipping'
    // - Nếu Online: Chưa xong -> 'pending' (Chờ thanh toán)
    $initial_status = ($payment_method == 'COD') ? 'shipping' : 'pending';

    // Thêm status vào câu lệnh INSERT
    $sql_order = "INSERT INTO orders (user_id, fullname, phone, address, note, total, payment_method, order_date, status) 
                  VALUES ($user_id_save, '$fullname', '$phone', '$address', '$note', '$total_price', '$payment_method', NOW(), '$initial_status')";

    if ($conn->query($sql_order)) {
        $order_id = $conn->insert_id;

        foreach ($cart_display as $item) {
            $p_id = $item['id'];
            $qty = $item['buy_qty'];
            $price = $item['price'];
            // Nếu bảng order_items của bạn có cột size thì thêm vào đây, nếu không thì bỏ
            // $size = $item['buy_size']; 
            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                         VALUES ('$order_id', '$p_id', '$qty', '$price')";
            $conn->query($sql_item);
        }

        // --- PHÂN CHIA LUỒNG XỬ LÝ ---
        
        if ($payment_method == 'COD') {
            // COD: Xóa giỏ hàng ngay lập tức
            unset($_SESSION['cart']);
            echo "<script>alert('Đặt hàng thành công! Đơn hàng đang được vận chuyển.'); window.location.href='order_history.php';</script>";
        } 
        elseif ($payment_method == 'momo') {
            // Online: KHÔNG XÓA GIỎ HÀNG, chuyển sang trang thanh toán
            header("Location: payment_momo.php?order_id=$order_id&amount=$total_price");
        } 
        elseif ($payment_method == 'banking') {
            // Online: KHÔNG XÓA GIỎ HÀNG, chuyển sang trang thanh toán
            header("Location: payment_banking.php?order_id=$order_id&amount=$total_price");
        }
        
        exit();
    } else {
        echo "<script>alert('Lỗi hệ thống: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Thanh Toán - StreetVibe</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/checkout.css">
    
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
                    <li><a href="login.php">Đăng nhập</a></li>
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

    <section id="page-header" class="about-header" style="background-image: url('image/banner/b1.jpg');">
        <h2>#checkout</h2>      
        <p>Hoàn tất đơn hàng và nhận hàng sớm nhất</p>
    </section>

    <section id="cart" class="section-p1">
        <form action="" method="POST">
            <div id="checkout-container">
                
                <div class="checkout-form">
                    <h3>Thông tin giao hàng</h3>
                    <br>
                    <label>Họ và tên người nhận</label>
                    <input type="text" name="fullname" placeholder="Nhập họ tên đầy đủ" 
                           value="<?php echo $user_info['fullname']; ?>" required>

                    <label>Email</label>
                    <input type="email" name="email" placeholder="Nhập email" 
                           value="<?php echo $user_info['email']; ?>" required>

                    <label>Số điện thoại</label>
                    <input type="text" name="phone" placeholder="Ví dụ: 0912345678" 
                           value="<?php echo $user_info['phone']; ?>" required>

                    <label>Địa chỉ nhận hàng</label>
                    <input type="text" name="address" placeholder="Số nhà, đường, phường, quận..." 
                           value="<?php echo $user_info['address']; ?>" required>

                    <label>Ghi chú đơn hàng (Tùy chọn)</label>
                    <textarea name="note" rows="4" placeholder="Ví dụ: Giao hàng giờ hành chính"></textarea>
                </div>

                <div class="checkout-summary">
                    <h3>Đơn hàng của bạn</h3>
                    <br>
                    <?php foreach ($cart_display as $item): 
                        $img_path = "image/" . $item['brand'] . "/" . $item['image'];
                        if (empty($item['image']) || !file_exists($img_path)) {
                            $img_path = "https://placehold.co/50x50?text=No+Image";
                        }
                    ?>
                        <div class="order-item">
                            <div style="display: flex; align-items: center;">
                                <img src="<?php echo $img_path; ?>" alt="" style="width: 50px; border-radius: 4px;">
                                <div>
                                    <h5 style="margin: 0; font-size: 14px;"><?php echo $item['name']; ?></h5>
                                    <small style="color: #777;">Size: <?php echo $item['buy_size']; ?> x <?php echo $item['buy_qty']; ?></small>
                                </div>
                            </div>
                            <span><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>₫</span>
                        </div>
                    <?php endforeach; ?>

                    <div class="order-total">
                        <span>Tổng cộng</span>
                        <span style="color: #ef3636;"><?php echo number_format($total_price, 0, ',', '.'); ?>₫</span>
                    </div>

                    <div style="margin-top: 30px;">
                        <h4 style="margin-bottom: 15px;">Phương thức thanh toán</h4>
                        
                        <div class="payment-option">
                            <input type="radio" id="cod" name="payment" value="COD" checked>
                            <label for="cod"><i class="fa-solid fa-money-bill-wave" style="color: #088178;"></i> Thanh toán khi nhận hàng (COD)</label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="momo" name="payment" value="momo">
                            <label for="momo">
                                <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="MoMo" style="width: 25px; vertical-align: middle;"> Ví MoMo
                            </label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="banking" name="payment" value="banking">
                            <label for="banking"><i class="fa-solid fa-building-columns" style="color: #088178;"></i> Chuyển khoản Ngân hàng</label>
                        </div>
                    </div>

                    <button type="submit" name="btn_order" class="normal" style="width: 100%; margin-top: 20px;">XÁC NHẬN ĐẶT HÀNG</button>
                </div>
            </div>
        </form>
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
            <a href