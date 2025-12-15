<?php
session_start();
include 'admin/connect.php'; // Kết nối database

$message = "";

if (isset($_POST['btn_register'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Kiểm tra xác nhận mật khẩu
    if ($password != $confirm_password) {
        $message = "Mật khẩu xác nhận không khớp!";
    } else {
        // 2. Kiểm tra xem Username hoặc Email đã tồn tại chưa
        $check_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $check_res = $conn->query($check_sql);

        if ($check_res->num_rows > 0) {
            $message = "Tên đăng nhập hoặc Email đã tồn tại!";
        } else {
            // 3. Thêm vào Database (Mặc định role là customer)
            // Lưu ý: Mật khẩu đang lưu dạng thường để khớp với hệ thống hiện tại của bạn.
            $sql_insert = "INSERT INTO users (fullname, username, email, password, role) 
                           VALUES ('$fullname', '$username', '$email', '$password', 'customer')";
            
            if ($conn->query($sql_insert) === TRUE) {
                // Đăng ký thành công -> Báo & Chuyển sang login
                echo "<script>
                        alert('Đăng ký tài khoản thành công! Hãy đăng nhập ngay.');
                        window.location.href='login.php';
                      </script>";
            } else {
                $message = "Lỗi hệ thống: " . $conn->error;
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
    <title>Đăng ký - StreetVibe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/register.css"> 
    
    <style>
        /* CSS cho thông báo lỗi */
        .error-msg {
            color: #d9534f;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="register-box">

            <img src="image/logo.png" alt="StreetVibe Logo" class="logo">

            <h2>Tạo tài khoản</h2>

            <?php if($message != ""): ?>
                <div class="error-msg">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">

                <div class="input-group">
                    <i class="fa-solid fa-id-card"></i>
                    <input type="text" name="fullname" placeholder="Họ và tên" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Tên đăng nhập" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                </div>

                <button type="submit" name="btn_register" class="btn-register">Đăng ký</button>

                <p class="login-link">
                    Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
                </p>

            </form>

        </div>
    </div>

</body>
</html>