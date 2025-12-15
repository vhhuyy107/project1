<?php
session_start();
include 'connect.php'; 

// --- 1. XỬ LÝ XÓA USER ---
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    
    // Kiểm tra: Không cho phép tự xóa chính mình (Admin đang đăng nhập)
    if (isset($_SESSION['admin_id']) && $id == $_SESSION['admin_id']) {
        echo "<script>alert('Không thể tự xóa tài khoản đang đăng nhập!'); window.location.href='admin_user.php';</script>";
    } else {
        $sql_delete = "DELETE FROM users WHERE id = $id";
        if ($conn->query($sql_delete) === TRUE) {
            echo "<script>alert('Đã xóa người dùng!'); window.location.href='admin_user.php';</script>";
        } else {
            echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
        }
    }
}

// --- 2. XỬ LÝ CẬP NHẬT USER (TỪ MODAL) ---
if (isset($_POST['btn_update_user'])) {
    $id = $_POST['edit_id'];
    $fullname = $_POST['edit_fullname'];
    $email = $_POST['edit_email'];
    $role = $_POST['edit_role'];
    $new_password = $_POST['edit_password'];

    // Câu lệnh Update cơ bản
    $sql_update = "UPDATE users SET fullname='$fullname', email='$email', role='$role'";

    // Nếu có nhập mật khẩu mới thì cập nhật, không thì thôi
    if (!empty($new_password)) {
        $sql_update .= ", password='$new_password'";
    }

    $sql_update .= " WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='admin_user.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
    }
}

// --- 3. LẤY DANH SÁCH USER ---
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng - StreetVibe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin_user.css">

    <style>
        /* CSS cho Avatar tròn */
        .avatar-img {
            width: 50px; height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        
        /* Màu sắc Role */
        .role { padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }
        .role.admin { background-color: #ffcccc; color: #d32f2f; }
        .role.customer { background-color: #cce5ff; color: #004085; }

        /* Modal Styles (Giống trang sản phẩm) */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
        .modal-content { background-color: #fff; margin: 10% auto; padding: 25px; border-radius: 10px; width: 450px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative; animation: slideDown 0.3s ease-out; }
        @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .close-btn { position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #aaa; }
        .close-btn:hover { color: #000; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn-submit { width: 100%; padding: 10px; background-color: #ff9800; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background-color: #e68a00; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2 class="brand">
            <img src="../image/logo.png" alt="StreetVibe Logo">
            StreetVibe
        </h2>
        <ul class="menu">
            <li onclick="location.href='admin.php'"><i class="fa-solid fa-chart-line"></i> Dashboard</li>
            <li onclick="location.href='admin_product.php'"><i class="fa-solid fa-shoe-prints"></i> Sản phẩm</li>
            <li onclick="location.href='admin_order.php'"><i class="fa-solid fa-box"></i> Đơn hàng</li>
            <li class="active" onclick="location.href='admin_user.php'"><i class="fa-solid fa-users"></i> Người dùng</li>
            <li onclick="location.href='admin_detail.php'"><i class="fa-solid fa-user-gear"></i> Tài khoản admin</li>
            <li onclick="location.href='../login.php'"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Quản lý người dùng</h1>
            <p>Danh sách tài khoản đã đăng ký</p>
        </div>

        <div class="user-header">
            <h2>Danh sách người dùng</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên hiển thị</th>
                    <th>Username</th> <th>Email</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Xử lý đường dẫn Avatar
                        $avatar_url = "../hinhanh/" . $row['avatar'];
                        if (empty($row['avatar']) || !file_exists($avatar_url)) {
                            $avatar_url = "../hinhanh/defaultavt.jpg"; // Ảnh mặc định
                        }

                        // Class CSS cho Role
                        $role_class = ($row['role'] == 'admin') ? 'admin' : 'customer';
                ?>
                <tr>
                    <td><img src="<?php echo $avatar_url; ?>" class="avatar-img"></td>
                    
                    <td style="font-weight: 600;"><?php echo $row['fullname']; ?></td>
                    
                    <td><?php echo $row['username']; ?></td>
                    
                    <td><?php echo $row['email']; ?></td>
                    
                    <td><span class="role <?php echo $role_class; ?>"><?php echo ucfirst($row['role']); ?></span></td>
                    
                    <td class="actions">
                        <button class="edit" onclick="openEditUserModal(
                            '<?php echo $row['id']; ?>',
                            '<?php echo $row['fullname']; ?>',
                            '<?php echo $row['email']; ?>',
                            '<?php echo $row['role']; ?>'
                        )">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        
                        <a href="admin_user.php?delete_id=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa user: <?php echo $row['fullname']; ?>?');">
                            <button class="lock" title="Xóa người dùng"><i class="fa-solid fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='6' style='text-align:center'>Không có người dùng nào.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="document.getElementById('editUserModal').style.display='none'">&times;</span>
            <h2 style="text-align: center; margin-bottom: 20px;">Cập nhật User</h2>
            
            <form action="" method="POST">
                <input type="hidden" id="edit_id" name="edit_id">
                
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" id="edit_fullname" name="edit_fullname" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="edit_email" name="edit_email" required>
                </div>

                <div class="form-group">
                    <label>Vai trò</label>
                    <select id="edit_role" name="edit_role">
                        <option value="customer">Customer (Khách hàng)</option>
                        <option value="admin">Admin (Quản trị viên)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Đặt lại mật khẩu (Để trống nếu không đổi)</label>
                    <input type="password" name="edit_password" placeholder="Nhập mật khẩu mới...">
                </div>

                <button type="submit" name="btn_update_user" class="btn-submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>

    <script src="../js/admin_user.js">
</script>

</body>
</html>