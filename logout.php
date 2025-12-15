<?php
session_start(); // 1. Bắt buộc phải có dòng này đầu tiên để lấy được Session hiện tại

// 2. Xóa sạch các biến trong Session
unset($_SESSION['user_id']);
unset($_SESSION['fullname']);
unset($_SESSION['email']);
unset($_SESSION['cart']); // Tùy chọn: Nếu bạn muốn đăng xuất là xóa luôn giỏ hàng thì giữ dòng này, không thì xóa đi.

// Hoặc xóa toàn bộ mảng Session cho chắc ăn
$_SESSION = [];

// 3. Hủy phiên làm việc trên Server
session_destroy();

// 4. Chuyển hướng về trang chủ hoặc trang đăng nhập
header("Location: index.php"); 
exit();
?>