<?php
$host = "localhost"; 
$user = "root";      
$pass = "";          
$db   = "db_streetvibesneaker"; // đổi thành tên DB của bạn

$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8");

?>
