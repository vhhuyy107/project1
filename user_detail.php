<?php
session_start();
// Kết nối database (Thay đổi đường dẫn nếu file connect.php nằm chỗ khác)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_streetvibesneaker";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra: Phải đăng nhập mới được vào trang này
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// --- XỬ LÝ CẬP NHẬT THÔNG TIN ---
if (isset($_POST['btn_update'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];       // Mới thêm
    $address = $_POST['address'];   // Mới thêm
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. Xử lý Avatar (Nếu có chọn ảnh)
    $avatar_sql = "";
    if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] != "") {
        $target_dir = "image/avt/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $img_name = time() . "_" . basename($_FILES["avatar"]["name"]);
        $target_file = $target_dir . $img_name;
        
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $avatar_sql = ", avatar='$img_name'";
        }
    }

    // 2. Xử lý Mật khẩu
    $pass_sql = "";
    if (!empty($new_pass)) {
        if ($new_pass == $confirm_pass) {
            $pass_sql = ", password='$new_pass'";
        } else {
            $message = "<script>alert('Mật khẩu xác nhận không khớp!');</script>";
        }
    }

    // 3. Cập nhật vào Database (Thêm phone và address)
    if ($message == "") {
        $sql_update = "UPDATE users 
                       SET fullname='$fullname', email='$email', phone='$phone', address='$address' $avatar_sql $pass_sql 
                       WHERE id=$user_id";
        
        if ($conn->query($sql_update) === TRUE) {
            $_SESSION['fullname'] = $fullname; // Cập nhật session tên
            $message = "<script>alert('Cập nhật thông tin thành công!');</script>";
        } else {
            $message = "<script>alert('Lỗi: " . $conn->error . "');</script>";
        }
    }
}

// --- LẤY THÔNG TIN USER HIỆN TẠI ---
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Xử lý hiển thị avatar
$avatar_url = "image/avt/" . $user['avatar'];
if (empty($user['avatar']) || !file_exists($avatar_url)) {
    $avatar_url = "https://cdn-icons-png.flaticon.com/512/149/149071.png";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản - StreetVibe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* CSS FORM USER */
        .account-container { padding: 50px 0; display: flex; justify-content: center; background: #f4f4f4; }
        .account-box {
            width: 50%; 
            background: #fff; 
            padding: 40px;
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        }
        .account-header { text-align: center; margin-bottom: 30px; }
        .account-header h2 { color: #222; margin-bottom: 10px; }
        
        /* Avatar */
        .avt-wrapper { position: relative; width: 120px; height: 120px; margin: 0 auto 20px; }
        .avt-wrapper img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .upload-icon {
            position: absolute; bottom: 5px; right: 5px;
            background: #088178; color: #fff; width: 32px; height: 32px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            cursor: pointer; border: 2px solid #fff;
        }

        /* Input Fields */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #444; font-size: 14px; }
        .form-group input {
            width: 100%; padding: 10px 15px; 
            border: 1px solid #ddd; border-radius: 6px; outline: none;
            font-size: 15px; transition: 0.3s;
        }
        .form-group input:focus { border-color: #088178; }

        /* Nút Save đẹp hơn, nhỏ hơn */
        .btn-save {
            display: block;
            width: auto;
            min-width: 150px;
            margin: 30px auto 0;
            padding: 10px 30px; 
            background: #088178; 
            color: #fff;
            border: none; 
            border-radius: 30px; 
            font-size: 15px; 
            font-weight: 700; 
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(8, 129, 120, 0.2);
        }
        .btn-save:hover { 
            background: #066c65; 
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(8, 129, 120, 0.3);
        }

        /* Mobile */
        @media (max-width: 768px) {
            .account-box { width: 90%; padding: 20px; }
        }
    </style>
</head>
<body>
    <?php echo $message; ?>

    <section id="header">
        <a href="index.php"><img src="image/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="store.php">Cửa hàng</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <li><a href="aboutus.php">Về chúng tôi</a></li>
                <li><a href="labpage.php">Các bài Labs</a></li>
                
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

                <li id="lg-bag"> <a href="cart.php"> <i class="fa-solid fa-cart-shopping"></i></a></li>
                <a href="#" id="close"> <i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section class="account-container">
        <div class="account-box">
            <div class="account-header">
                <h2>Hồ sơ cá nhân</h2>
                <p style="font-size: 14px; color: #777;">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="avt-wrapper">
                    <img src="<?php echo $avatar_url; ?>" id="preview">
                    <label for="file-input" class="upload-icon"><i class="fa-solid fa-camera"></i></label>
                    <input type="file" id="file-input" name="avatar" accept="image/*" style="display: none;">
                </div>

                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" value="<?php echo $user['username']; ?>" disabled style="background: #e9ecef; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" value="<?php echo isset($user['phone']) ? $user['phone'] : ''; ?>" placeholder="Thêm số điện thoại...">
                </div>

                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" value="<?php echo isset($user['address']) ? $user['address'] : ''; ?>" placeholder="Thêm địa chỉ giao hàng...">
                </div>

                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
                
                <div class="form-group">
                    <label>Đổi mật khẩu (Để trống nếu không đổi)</label>
                    <input type="password" name="new_password" placeholder="Mật khẩu mới...">
                </div>

                <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới...">
                </div>

                <button type="submit" name="btn_update" class="btn-save">Lưu thay đổi</button>
            </form>
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
<script src="./js/user_detail.js"></script>
</body>
</html>