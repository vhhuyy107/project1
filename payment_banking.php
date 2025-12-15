<?php
// --- CẤU HÌNH TÀI KHOẢN NGÂN HÀNG CỦA BẠN TẠI ĐÂY ---
$MY_BANK_ID = "VCB"; // Ví dụ: MB, VCB, ACB, TPB, VPB... (Mã ngân hàng)
$MY_ACCOUNT_NO = "9962739043"; // Số tài khoản của bạn
$MY_ACCOUNT_NAME = "THAI VAN HUY"; // Tên chủ tài khoản (Viết hoa không dấu)
// -----------------------------------------------------

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 'Unknown';
$amount = isset($_GET['amount']) ? $_GET['amount'] : 0;
$content = "Thanh toan don hang $order_id"; // Nội dung chuyển khoản

// Tạo link QR VietQR tự động (API miễn phí)
$qr_url = "https://img.vietqr.io/image/" . $MY_BANK_ID . "-" . $MY_ACCOUNT_NO . "-compact.jpg";
$qr_url .= "?amount=" . $amount;
$qr_url .= "&addInfo=" . urlencode($content); 
$qr_url .= "&accountName=" . urlencode($MY_ACCOUNT_NAME);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển khoản Ngân hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/payment_banking.css"> 
</head>
<body>

    <div class="payment-container">
        <h3 class="text-center mb-4">Thanh toán chuyển khoản</h3>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="bank-info">
                    <h5 class="mb-3">Thông tin chuyển khoản</h5>
                    
                    <div class="mb-3">
                        <label class="text-muted">Ngân hàng:</label>
                        <p class="fw-bold"><?php echo $MY_BANK_ID; ?> Bank</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">Chủ tài khoản:</label>
                        <p class="fw-bold"><?php echo $MY_ACCOUNT_NAME; ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">Số tài khoản:</label>
                        <div class="d-flex align-items-center">
                            <p class="fw-bold mb-0" id="tk_so"><?php echo $MY_ACCOUNT_NO; ?></p>
                            <span class="copy-btn" onclick="copyText('tk_so')"><i class="fa-regular fa-copy"></i> Sao chép</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">Số tiền:</label>
                        <p class="amount-text"><?php echo number_format($amount, 0, ',', '.'); ?>đ</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">Nội dung chuyển khoản:</label>
                        <div class="d-flex align-items-center">
                            <p class="fw-bold mb-0 text-danger" id="nd_ck"><?php echo $content; ?></p>
                            <span class="copy-btn" onclick="copyText('nd_ck')">Sao chép</span>
                        </div>
                    </div>
                    
                    <small class="text-muted fst-italic">* Vui lòng nhập đúng nội dung chuyển khoản để đơn hàng được xử lý nhanh nhất.</small>
                </div>
            </div>

            <div class="col-md-6 qr-section">
                <p class="fw-bold">Quét mã QR để thanh toán nhanh</p>
                <img src="<?php echo $qr_url; ?>" class="qr-img" alt="Mã QR Chuyển khoản">
                <p class="mt-2"><i class="fa-solid fa-camera"></i> Mở App Ngân hàng để quét</p>
            </div>
        </div>

        <a href="confirm_payment.php?order_id=<?php echo $order_id; ?>" class="btn btn-finish">HOÀN TẤT ĐẶT HÀNG</a>
    </div>

    <script>
        function copyText(elementId) {
            var text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(function() {
                alert('Đã sao chép: ' + text);
            }, function(err) {
                console.error('Lỗi sao chép: ', err);
            });
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</body>
</html>