<?php
// Lấy thông tin từ URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 'Unknown';
$amount = isset($_GET['amount']) ? $_GET['amount'] : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán MoMo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/payment_momo.css"> 
</head>
<body>

    <div class="payment-box">
        <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="MoMo" class="logo-momo">
        <h4>Thanh toán qua Ví MoMo</h4>
        <p>Mã đơn hàng: <strong>#<?php echo $order_id; ?></strong></p>
        
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=2|99|0912345678|TenNguoiNhan|email@gmail.com|0|0|<?php echo $amount; ?>|Thanh toan don hang <?php echo $order_id; ?>|transfer_myqr" class="qr-code" alt="QR MoMo">
        
        <p>Tổng tiền:</p>
        <div class="amount"><?php echo number_format($amount, 0, ',', '.'); ?>đ</div>
        <p class="mt-2 text-muted" style="font-size: 13px;">Quét mã bằng App MoMo để thanh toán</p>
        
        <a href="confirm_payment.php?order_id=<?php echo $order_id; ?>" class="btn btn-confirm">HOÀN TẤT ĐẶT HÀNG</a>
    </div>

</body>
</html>