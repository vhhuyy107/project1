<?php
session_start();
include 'connect.php'; 

// --- TRUY VẤN DỮ LIỆU ĐƠN HÀNG ---
// Chỉ lấy đơn hàng của những người có role là 'customer'
$sql = "SELECT orders.*, users.fullname 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        WHERE users.role = 'customer' 
        ORDER BY orders.order_date DESC, orders.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - StreetVibe</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin_order.css">
</head>
<body>

    <div class="sidebar">
        <h2 class="brand">
            <img src="../image/logo.png" alt="StreetVibe Logo">
            StreetVibe
        </h2>

        <ul class="menu">
            <li onclick="location.href='admin.php'">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </li>

            <li onclick="location.href='admin_product.php'">
                <i class="fa-solid fa-shoe-prints"></i> Sản phẩm
            </li>

            <li class="active" onclick="location.href='admin_order.php'">
                <i class="fa-solid fa-box"></i> Đơn hàng
            </li>

            <li onclick="location.href='admin_user.php'">
                <i class="fa-solid fa-users"></i> Người dùng
            </li>

            <li onclick="location.href='admin_detail.php'">
                <i class="fa-solid fa-user-gear"></i> Tài khoản admin
            </li>

            <li onclick="location.href='../login.php'">
                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
            </li>
        </ul>
    </div>

    <div class="main-content">

        <div class="header">
            <h1>Quản lý đơn hàng</h1>
            <p>Danh sách đơn hàng của cửa hàng</p>
        </div>

        <div class="order-header">
            <h2>Danh sách đơn hàng</h2>
            </div>

        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Lặp qua từng đơn hàng trong database
                    while($row = $result->fetch_assoc()) {
                        
                        // Xử lý hiển thị trạng thái (Class CSS và Text tiếng Việt)
                        $statusClass = '';
                        $statusText = '';
                        
                        switch ($row['status']) {
                            case 'pending':
                                $statusClass = 'pending';
                                $statusText = 'Đang xử lý';
                                break;
                            case 'success':
                                $statusClass = 'success';
                                $statusText = 'Đã giao';
                                break;
                            case 'cancel':
                                $statusClass = 'cancel';
                                $statusText = 'Đã hủy';
                                break;
                            default:
                                $statusClass = '';
                                $statusText = $row['status'];
                        }
                ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        
                        <td><?php echo $row['fullname']; ?></td>
                        
                        <td><?php echo date('d/m/Y', strtotime($row['order_date'])); ?></td>
                        
                        <td><?php echo number_format($row['total'], 0, ',', '.'); ?>₫</td>
                        
                        <td><span class="status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                        
                        <td class="actions">
                            <button class="view" onclick="location.href='order_detail.php?id=<?php echo $row['id']; ?>'">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            
                            <button class="update" onclick="alert('Chức năng cập nhật trạng thái đang phát triển!')">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </td>
                    </tr>
                <?php 
                    } // Kết thúc vòng lặp while
                } else {
                    echo "<tr><td colspan='6' style='text-align:center'>Chưa có đơn hàng nào</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
<script src="../js/admin_order.js"></script>
</body>
</html>