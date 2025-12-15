<?php
session_start();
include 'connect.php'; // Nhớ tạo file connect.php

// --- GIẢ LẬP ĐĂNG NHẬP (ĐỂ TEST) ---
// Tạm thời set cứng ID = 1 (Admin)
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['admin_id'] = 1; 
}
$admin_id = $_SESSION['admin_id'];

// --- XỬ LÝ CẬP NHẬT THÔNG TIN ---
$message = "";

if (isset($_POST['btn_save'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    
    // 1. Xử lý Upload Ảnh (Nếu có chọn file)
    $avatar_sql_part = ""; // Đoạn SQL cho avatar
    $upload_ok = true;
    
    if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] != "") {
        $target_dir = "../image";
        // Đặt tên file theo ID để tránh trùng (vd: admin_1.jpg)
        $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . "admin_" . $admin_id . "." . $imageFileType;
        
        // Kiểm tra định dạng ảnh
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                // Lưu tên file vào biến để lát update vào DB
                $avatar_name = "admin_" . $admin_id . "." . $imageFileType;
                $avatar_sql_part = ", avatar='$avatar_name'";
            } else {
                $message = "<script>alert('Lỗi khi upload ảnh!');</script>";
                $upload_ok = false;
            }
        } else {
            $message = "<script>alert('File không phải là ảnh!');</script>";
            $upload_ok = false;
        }
    }

    // 2. Xử lý thông tin chữ & Mật khẩu
    if ($upload_ok) {
        if ($new_pass != "" && $new_pass != $confirm_pass) {
            $message = "<script>alert('Mật khẩu xác nhận không khớp!');</script>";
        } else {
            // Xây dựng câu lệnh SQL động
            $sql_update = "UPDATE users SET fullname='$fullname', email='$email', username='$username' $avatar_sql_part";
            
            // Nếu có nhập pass mới thì thêm vào SQL
            if ($new_pass != "") {
                $sql_update .= ", password='$new_pass'";
            }
            
            $sql_update .= " WHERE id=$admin_id";

            if ($conn->query($sql_update) === TRUE) {
                $message = "<script>alert('Cập nhật thông tin thành công!');</script>";
            } else {
                $message = "<script>alert('Lỗi: " . $conn->error . "');</script>";
            }
        }
    }
}

// --- LẤY DỮ LIỆU HIỂN THỊ ---
$sql = "SELECT * FROM users WHERE id = $admin_id";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();

// Xử lý hiển thị ảnh: Nếu trong DB chưa có ảnh thì dùng ảnh mặc định
$avatar_src = "../image/avt/defaultavt.jpg";
if (!empty($admin['avatar'])) {
    $avatar_src = "../image" . $admin['avatar'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Admin - StreetVibe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_detail.css">
</head>
<body>
    <?php echo $message; ?>

    <div class="sidebar">
        <h2 class="brand">
            <img src="../image/logo.png" alt="StreetVibe Logo">
            StreetVibe
        </h2>
        <ul class="menu">
            <li onclick="location.href='admin.php'"><i class="fa-solid fa-chart-line"></i> Dashboard</li>
            <li onclick="location.href='admin_product.php'"><i class="fa-solid fa-shoe-prints"></i> Sản phẩm</li>
            <li onclick="location.href='admin_order.php'"><i class="fa-solid fa-box"></i> Đơn hàng</li>
            <li onclick="location.href='admin_user.php'"><i class="fa-solid fa-users"></i> Người dùng</li>
            <li class="active" onclick="location.href='admin_detail.php'"><i class="fa-solid fa-user-gear"></i> Tài khoản admin</li>
            <li onclick="location.href='../login.php'"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Thông tin quản trị</h1>
            <p>Chỉnh sửa thông tin cá nhân của bạn</p>
        </div>

        <div class="panel edit-panel">
            <form class="form" method="POST" action="" enctype="multipart/form-data">
                
                <div class="avatar-box">
                    <img src="<?php echo $avatar_src; ?>" alt="Avatar" id="preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                    <label class="upload-btn">
                        <i class="fa-solid fa-camera"></i>
                        <input type="file" name="avatar" accept="image/*" id="avatarInput">
                    </label>
                </div>

                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="fullname" value="<?php echo $admin['fullname']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email đăng nhập</label>
                    <input type="email" name="email" value="<?php echo $admin['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label>User name</label>
                    <input type="text" name="username" value="<?php echo $admin['username']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="new_password" placeholder="Để trống nếu không muốn đổi">
                </div>

                <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới">
                </div>

                <button type="submit" name="btn_save" class="save-btn">Lưu thay đổi</button>
            </form>
        </div>
    </div>

    <script src="../js/admin_detail.js"></script>
</body>
</html>