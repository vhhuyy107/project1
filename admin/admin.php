<?php
session_start();
include 'connect.php';

// --- KIỂM TRA ĐĂNG NHẬP ---
if (!isset($_SESSION['admin_id'])) {
    // Nếu chưa đăng nhập thì set tạm (hoặc chuyển hướng về login)
    $_SESSION['admin_id'] = 1; 
}
$admin_id = $_SESSION['admin_id'];

// Lấy thông tin Admin để hiện tên "Xin chào..."
$sql_admin = "SELECT fullname FROM users WHERE id = $admin_id";
$res_admin = $conn->query($sql_admin);
$admin_name = ($res_admin->num_rows > 0) ? $res_admin->fetch_assoc()['fullname'] : "Admin";


// --- 1. THỐNG KÊ SỐ LƯỢNG SẢN PHẨM ---
$sql_prod = "SELECT COUNT(*) as count FROM products";
$res_prod = $conn->query($sql_prod);
$count_products = $res_prod->fetch_assoc()['count'];


// --- 2. THỐNG KÊ ĐƠN HÀNG MỚI (Trạng thái Pending) ---
$sql_orders = "SELECT COUNT(*) as count FROM orders WHERE status = 'pending'";
$res_orders = $conn->query($sql_orders);
$count_new_orders = $res_orders->fetch_assoc()['count'];


// --- 3. TÍNH TỔNG DOANH THU (Chỉ tính đơn đã Giao thành công - Success) ---
$sql_revenue = "SELECT SUM(total) as total FROM orders WHERE status = 'success'";
$res_revenue = $conn->query($sql_revenue);
$row_revenue = $res_revenue->fetch_assoc();
$total_revenue = $row_revenue['total'] ? $row_revenue['total'] : 0; // Nếu null thì bằng 0


// --- 4. THỐNG KÊ KHÁCH HÀNG (Role = Customer) ---
$sql_users = "SELECT COUNT(*) as count FROM users WHERE role = 'customer'";
$res_users = $conn->query($sql_users);
$count_users = $res_users->fetch_assoc()['count'];


// --- 5. HOẠT ĐỘNG GẦN ĐÂY (Lấy 5 đơn hàng mới nhất) ---
$sql_activity = "SELECT orders.id, users.fullname, orders.order_date, orders.total, orders.status 
                 FROM orders 
                 JOIN users ON orders.user_id = users.id 
                 ORDER BY orders.order_date DESC, orders.id DESC 
                 LIMIT 5";
$res_activity = $conn->query($sql_activity);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - StreetVibe Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    
    
</head>
<body>

    <div class="sidebar">
        <h2 class="brand">
            <img src="../image/logo.png" alt="StreetVibe Logo">
            StreetVibe
        </h2>

        <ul class="menu">
            <li class="active" onclick="location.href='admin.php'"><i class="fa-solid fa-chart-line"></i> Dashboard</li>
            <li onclick="location.href='admin_product.php'"><i class="fa-solid fa-shoe-prints"></i> Sản phẩm</li>
            <li onclick="location.href='admin_order.php'"><i class="fa-solid fa-box"></i> Đơn hàng</li>
            <li onclick="location.href='admin_user.php'"><i class="fa-solid fa-users"></i> Người dùng</li>
            <li onclick="location.href='admin_detail.php'"><i class="fa-solid fa-user-gear"></i> Tài khoản admin</li>
            <li onclick="location.href='../logout.php'"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</li>
        </ul>
    </div>

    <div class="main-content">

        <div class="header">
            <h1>Dashboard quản trị</h1>
            <p>Xin chào, <b><?php echo $admin_name; ?></b> 👋</p>
        </div>

        <div class="stats">
            <div class="card" onclick="location.href='admin_product.php'" style="cursor: pointer;">
                <i class="fa-solid fa-shoe-prints"></i>
                <h3><?php echo $count_products; ?></h3>
                <p>Tổng sản phẩm</p>
            </div>

            <div class="card" onclick="location.href='admin_order.php'" style="cursor: pointer;">
                <i class="fa-solid fa-box"></i>
                <h3><?php echo $count_new_orders; ?></h3>
                <p>Đơn chờ xử lý</p>
            </div>

            <div class="card">
                <i class="fa-solid fa-money-bill-trend-up"></i>
                <h3><?php echo number_format($total_revenue, 0, ',', '.'); ?>₫</h3>
                <p>Doanh thu thực tế (Đã giao)</p>
            </div>

            <div class="card" onclick="location.href='admin_user.php'" style="cursor: pointer;">
                <i class="fa-solid fa-users"></i>
                <h3><?php echo $count_users; ?></h3>
                <p>Khách hàng</p>
            </div>
        </div>

        <div class="panel">
            <h2>Đơn hàng gần đây</h2>
            <ul class="activity">
                <?php
                if ($res_activity->num_rows > 0) {
                    while($row = $res_activity->fetch_assoc()) {
                        // Xác định class màu sắc
                        $statusClass = $row['status']; // pending, success, cancel
                        
                        // Format ngày
                        $date = date('d/m/Y', strtotime($row['order_date']));
                        
                        // Text trạng thái
                        $statusText = ($row['status'] == 'pending') ? 'Mới đặt' : (($row['status'] == 'success') ? 'Đã giao' : 'Đã hủy');
                ?>
                    <li class="<?php echo $statusClass; ?>">
                        <div>
                            <b>#<?php echo $row['id']; ?></b> – 
                            <?php echo $row['fullname']; ?> – 
                            <span style="font-weight: bold; color: #d32f2f;"><?php echo number_format($row['total'], 0, ',', '.'); ?>₫</span>
                        </div>
                        <span class="time-ago">
                            <?php echo $statusText; ?> • <?php echo $date; ?>
                        </span>
                    </li>
                <?php 
                    }
                } else {
                    echo "<p style='text-align:center; color:#777;'>Chưa có hoạt động nào.</p>";
                }
                ?>
            </ul>
        </div>

    </div>

</body>
</html>