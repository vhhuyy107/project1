<?php
session_start();
// Kết nối database (File connect nằm trong folder admin)
include 'admin/connect.php'; 

$error_message = "";

// Kiểm tra nếu người dùng bấm nút Đăng nhập
if (isset($_POST['btn_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Xử lý chuỗi để tránh lỗi SQL Injection cơ bản
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Tìm user trong database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu (So sánh trực tiếp vì trong DB của bạn đang lưu pass thường)
        // Nếu sau này bạn mã hóa md5 hoặc password_hash thì sửa đoạn này nhé
        if ($password == $row['password']) {
            
            // --- ĐĂNG NHẬP THÀNH CÔNG ---
            // Lưu thông tin vào Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // 'admin' hoặc 'customer'
            $_SESSION['fullname'] = $row['fullname'];

            // Kiểm tra quyền để chuyển hướng
            if ($row['role'] == 'admin') {
                // Nếu là Admin -> Vào trang quản trị
                // Vì file này ở root, admin ở folder admin nên đường dẫn là:
                header("Location: admin/admin.php");
            } else {
                // Nếu là Customer -> Về trang chủ
                header("Location: index.php");
            }
            exit();

        } else {
            $error_message = "Mật khẩu không đúng!";
        }
    } else {
        $error_message = "Tên đăng nhập không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - StreetVibe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/login.css"> <style>
        /* CSS bổ sung để hiện thông báo lỗi đẹp hơn */
        .error-msg {
            color: #d9534f;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            
            <img src="image/logo.png" alt="StreetVibe Logo" class="logo">

            <h2>Đăng nhập</h2>

            <?php if(!empty($error_message)): ?>
                <div class="error-msg">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Tên đăng nhập (username)" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>

                <button type="submit" name="btn_login" class="btn-login">Đăng nhập</button>

                <p class="signup-link">
                    Chưa có tài khoản?
                    <a href="register.php">Đăng ký ngay</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>