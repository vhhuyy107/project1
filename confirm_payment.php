<?php
session_start();
include 'admin/connect.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // 1. Cập nhật trạng thái đơn hàng thành 'shipping' (Đã thanh toán & Đang vận chuyển)
    $sql_update = "UPDATE orders SET status = 'shipping' WHERE id = $order_id";
    
    if ($conn->query($sql_update) === TRUE) {
        // 2. Xóa giỏ hàng (Chỉ xóa khi đã xác nhận thanh toán thành công)
        unset($_SESSION['cart']);

        // 3. Thông báo và chuyển về lịch sử đơn hàng
        echo "<script>
                alert('Xác nhận thanh toán thành công! Đơn hàng đang được vận chuyển.');
                window.location.href = 'order_history.php';
              </script>";
    } else {
        echo "Lỗi cập nhật: " . $conn->error;
    }
} else {
    header("Location: store.php");
}
?>