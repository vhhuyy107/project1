<?php
session_start();
include 'admin/connect.php';

// 1. KIỂM TRA ĐĂNG NHẬP
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. LẤY DANH SÁCH ĐƠN HÀNG
$sql_orders = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng - StreetVibe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .history-container { padding: 40px 0; background: #f9f9f9; min-height: 600px;}
        .container { width: 80%; margin: 0 auto; }
        
        .order-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid #eee;
        }
        
        .order-header {
            background: #fdfdfd;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .order-id { font-weight: bold; color: #333; }
        .order-date { font-size: 14px; color: #777; margin-left: 10px; border-left: 1px solid #ccc; padding-left: 10px;}
        
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .bg-pending { background: #fff3cd; color: #856404; }
        .bg-shipping { background: #cce5ff; color: #004085; }
        .bg-success { background: #d4edda; color: #155724; }
        .bg-cancel { background: #f8d7da; color: #721c24; }

        .order-body { padding: 20px; }
        .item-row { display: flex; align-items: center; border-bottom: 1px solid #f1f1f1; padding-bottom: 15px; margin-bottom: 15px; }
        .item-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .item-img { width: 70px; height: 70px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd; margin-right: 15px; }
        .item-info { flex: 1; }
        .item-name { font-weight: 600; font-size: 15px; color: #333; margin-bottom: 5px; display: block;}
        .item-price { font-weight: bold; color: #088178; }

        .order-footer {
            padding: 15px 20px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between; /* Đẩy nội dung sang 2 bên */
            align-items: center;
        }
        .total-price { font-size: 18px; font-weight: bold; color: #ef3636; }
        
        /* Button styles */
        .btn-action { text-decoration: none; padding: 8px 15px; border-radius: 4px; font-size: 13px; font-weight: bold; margin-left: 10px; display: inline-block; }
        .btn-pay { background: #088178; color: white; border: 1px solid #088178; }
        .btn-pay:hover { background: #066c65; color: white; }
        .btn-cancel { background: white; color: #d9534f; border: 1px solid #d9534f; }
        .btn-cancel:hover { background: #d9534f; color: white; }

        @media (max-width: 768px) {
            .container { width: 95%; }
            .order-header, .order-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
            .order-footer { align-items: flex-end; }
        }
    </style>
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="image/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="store.php">Cửa hàng</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <li><a href="aboutus.php">Về chúng tôi</a></li>
                
                <li id="lg-user"> 
                    <a href="user_detail.php" style="color: #088178; font-weight: bold; cursor: pointer;"> 
                        <i class="fa-solid fa-user"></i> Xin chào, <?php echo $_SESSION['fullname']; ?> 
                        <i class="fa-solid fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="user_detail.php"><i class="fa-solid fa-id-card"></i> Thông tin tài khoản</a></li>
                        <li><a href="order_history.php"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử đơn hàng</a></li>
                        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
                    </ul>
                </li>
                
                <li id="lg-bag"> <a href="cart.php"> <i class="fa-solid fa-cart-shopping"></i></a></li>
                <a href="#" id="close"> <i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section class="history-container">
        <div class="container">
            <h2 style="margin-bottom: 30px;">Lịch sử đơn hàng của bạn</h2>

            <?php if ($result_orders->num_rows > 0): ?>
                
                <?php while($order = $result_orders->fetch_assoc()): ?>
                    <?php 
                        $status_class = 'bg-pending';
                        $status_text = 'Đang xử lý';
                        if($order['status'] == 'success') { $status_class = 'bg-success'; $status_text = 'Thành công'; }
                        elseif($order['status'] == 'shipping') { $status_class = 'bg-shipping'; $status_text = 'Đang giao hàng'; }
                        elseif($order['status'] == 'cancel') { $status_class = 'bg-cancel'; $status_text = 'Đã hủy'; }
                    ?>

                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <span class="order-id">Đơn hàng #<?php echo $order['id']; ?></span>
                                <span class="order-date"><?php echo date("d/m/Y H:i", strtotime($order['order_date'])); ?></span>
                            </div>
                            <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                        </div>

                        <div class="order-body">
                            <?php 
                                $order_id = $order['id'];
                                $sql_items = "SELECT oi.*, p.name, p.image, p.brand 
                                              FROM order_items oi 
                                              JOIN products p ON oi.product_id = p.id 
                                              WHERE oi.order_id = $order_id";
                                $result_items = $conn->query($sql_items);
                                
                                while($item = $result_items->fetch_assoc()):
                                    $img_path = "image/" . $item['brand'] . "/" . $item['image'];
                                    if (!file_exists($img_path)) $img_path = "https://placehold.co/70x70?text=No+Image";
                            ?>
                                <div class="item-row">
                                    <img src="<?php echo $img_path; ?>" class="item-img" alt="">
                                    <div class="item-info">
                                        <span class="item-name"><?php echo $item['name']; ?></span>
                                        <span class="item-meta">Số lượng: <?php echo $item['quantity']; ?></span>
                                    </div>
                                    <div class="item-price">
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?>₫
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="order-footer">
                            <div class="payment-info" style="font-size: 13px; color: #555;">
                                Thanh toán: <b><?php echo strtoupper($order['payment_method']); ?></b>
                                <br>
                                Tổng tiền: <span class="total-price"><?php echo number_format($order['total'], 0, ',', '.'); ?>₫</span>
                            </div>

                            <div class="action-buttons">
                                <?php if($order['status'] == 'pending'): ?>
                                    
                                    <a href="cancel_order.php?id=<?php echo $order['id']; ?>" class="btn-action btn-cancel" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">Hủy đơn</a>

                                    <?php 
                                        $pay_url = "#";
                                        if($order['payment_method'] == 'momo') {
                                            $pay_url = "payment_momo.php?order_id=" . $order['id'] . "&amount=" . $order['total'];
                                        } elseif($order['payment_method'] == 'banking') {
                                            $pay_url = "payment_banking.php?order_id=" . $order['id'] . "&amount=" . $order['total'];
                                        }
                                        
                                        // Chỉ hiện nút thanh toán nếu không phải COD
                                        if($order['payment_method'] != 'COD'):
                                    ?>
                                        <a href="<?php echo $pay_url; ?>" class="btn-action btn-pay">Thanh toán ngay</a>
                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

            <?php else: ?>
                <div style="text-align: center; padding: 50px;">
                    <h3>Bạn chưa có đơn hàng nào!</h3>
                    <a href="store.php" class="normal" style="margin-top: 20px; display: inline-block; background: #088178; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Mua sắm ngay</a>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <footer id="section-p1">
        <div class="col">
            <img class="logo" src="image/logo.png">
            <h4>Thông tin liên hệ</h4>
            <p><strong>Địa chỉ: </strong>DaLat - VietNam</p>
            <p><strong>SĐT: </strong>+84123456789</p>
            <div class="copyright">
                <p>CopyRight 2025, StreetVibe</p>
            </div>
        </div>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>