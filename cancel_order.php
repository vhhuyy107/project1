<?php
session_start();
include 'admin/connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Chỉ cho phép hủy nếu đơn hàng đó thuộc về user này VÀ đang ở trạng thái 'pending'
    $sql = "UPDATE orders SET status = 'cancel' WHERE id = $order_id AND user_id = $user_id AND status = 'pending'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Đã hủy đơn hàng thành công!'); window.location.href='order_history.php';</script>";
    } else {
        echo "<script>alert('Lỗi: Không thể hủy đơn hàng này.'); window.location.href='order_history.php';</script>";
    }
} else {
    header("Location: order_history.php");
}
?>