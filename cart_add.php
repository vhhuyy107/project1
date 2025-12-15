<?php
session_start();

// 1. Thêm từ trang chi tiết (POST)
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $size = isset($_POST['size']) ? $_POST['size'] : 'Free';
    
    // Tạo Key duy nhất: ID_SIZE (Ví dụ: 10_39)
    $key = $id . '_' . $size;

    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }

    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['qty'] += $quantity;
    } else {
        // Lưu đầy đủ thông tin để cart.php dễ lấy
        $_SESSION['cart'][$key] = array(
            'id' => $id,
            'qty' => $quantity, 
            'size' => $size
        );
    }
    
    header("Location: product_detail.php?id=$id&status=success");
    exit();
}

// 2. Thêm nhanh từ trang chủ (GET)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $size = '39'; // Size mặc định
    $key = $id . '_' . $size;

    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }

    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['qty']++;
    } else {
        $_SESSION['cart'][$key] = array(
            'id' => $id,
            'qty' => 1, 
            'size' => $size
        );
    }
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>