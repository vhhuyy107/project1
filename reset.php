<?php
session_start();
session_unset();
session_destroy();
echo "<h1>Đã xóa sạch dữ liệu lỗi!</h1>";
echo "<a href='index.php'>Bấm vào đây để quay lại trang chủ và mua hàng lại</a>";
?>