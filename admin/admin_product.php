<?php
session_start();
include 'connect.php'; 

// --- 1. XỬ LÝ THÊM SẢN PHẨM ---
if (isset($_POST['btn_add'])) {
    $name = $_POST['name'];
    $brand = $_POST['brand']; 
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    
    // Upload vào folder theo tên Hãng
    $target_dir = "../image/" . $brand . "/"; 
    // Kiểm tra folder nếu chưa có thì tạo (tùy chọn)
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($image_tmp, $target_file)) {
        $sql_insert = "INSERT INTO products (name, brand, price, quantity, description, image) 
                       VALUES ('$name', '$brand', '$price', '$quantity', '$description', '$image')";
        $conn->query($sql_insert);
        echo "<script>alert('Thêm thành công!'); window.location.href='admin_product.php';</script>";
    } else {
        echo "<script>alert('Lỗi upload ảnh!');</script>";
    }
}

// --- 2. XỬ LÝ CẬP NHẬT (SỬA) SẢN PHẨM ---
if (isset($_POST['btn_update'])) {
    $id = $_POST['edit_id']; // Lấy ID từ input hidden
    $name = $_POST['edit_name'];
    $brand = $_POST['edit_brand'];
    $price = $_POST['edit_price'];
    $quantity = $_POST['edit_quantity'];
    $description = $_POST['edit_description'];

    // Logic xử lý ảnh:
    // Nếu người dùng chọn ảnh mới -> Upload ảnh mới và cập nhật tên file
    // Nếu không chọn ảnh -> Giữ nguyên tên file cũ trong database
    if (isset($_FILES['edit_image']) && $_FILES['edit_image']['name'] != "") {
        $image = $_FILES['edit_image']['name'];
        $image_tmp = $_FILES['edit_image']['tmp_name'];
        $target_dir = "../image/" . $brand . "/";
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
        $target_file = $target_dir . basename($image);
        
        move_uploaded_file($image_tmp, $target_file);
        
        $sql_update = "UPDATE products SET name='$name', brand='$brand', price='$price', quantity='$quantity', description='$description', image='$image' WHERE id=$id";
    } else {
        // Không đổi ảnh
        $sql_update = "UPDATE products SET name='$name', brand='$brand', price='$price', quantity='$quantity', description='$description' WHERE id=$id";
    }

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='admin_product.php';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật: " . $conn->error . "');</script>";
    }
}

// --- 3. XỬ LÝ XÓA SẢN PHẨM ---
if (isset($_POST['btn_delete'])) {
    $id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Đã xóa sản phẩm!'); window.location.href='admin_product.php';</script>";
    } else {
        echo "<script>alert('Lỗi xóa: " . $conn->error . "');</script>";
    }
}

// --- 4. TÌM KIẾM & HIỂN THỊ ---
$search = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR brand LIKE '%$search%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - StreetVibe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin_product.css">
    
    <style>
        /* CSS Chung */
        .product-img { width: 80px; height: 80px; object-fit: contain; border-radius: 5px; border: 1px solid #ddd; background: #f9f9f9; }
        .low-stock { color: red; font-weight: bold; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        /* CSS Search Box */
        .search-box { display: flex; gap: 10px; }
        .search-box input { padding: 8px 15px; border: 1px solid #ddd; border-radius: 5px; width: 250px; outline: none; }
        .search-box button { padding: 8px 15px; background-color: #333; color: white; border: none; border-radius: 5px; cursor: pointer; }

        /* --- CSS CHO MODAL (POPUP) --- */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; top: 0;
            width: 100%; height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
            backdrop-filter: blur(4px); /* Làm mờ nền */
        }
        .modal-content {
            background-color: #fff;
            margin: 2% auto; /* Căn giữa */
            padding: 25px;
            border-radius: 10px;
            width: 500px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        
        .close-btn { position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #aaa; }
        .close-btn:hover { color: #000; }

        /* Form styling */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        
        .btn-submit { width: 100%; padding: 10px; background-color: #ff9800; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background-color: #e68a00; }
        
        .btn-danger { background-color: #d32f2f; margin-top: 10px; }
        .btn-danger:hover { background-color: #b71c1c; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2 class="brand"><img src="../image/logo.png" alt="Logo"> StreetVibe</h2>
        <ul class="menu">
            <li onclick="location.href='admin.php'"><i class="fa-solid fa-chart-line"></i> Dashboard</li>
            <li class="active" onclick="location.href='admin_product.php'"><i class="fa-solid fa-shoe-prints"></i> Sản phẩm</li>
            <li onclick="location.href='admin_order.php'"><i class="fa-solid fa-box"></i> Đơn hàng</li>
            <li onclick="location.href='admin_user.php'"><i class="fa-solid fa-users"></i> Người dùng</li>
            <li onclick="location.href='admin_detail.php'"><i class="fa-solid fa-user-gear"></i> Tài khoản admin</li>
            <li onclick="location.href='../login.php'"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Quản lý sản phẩm</h1>
            <p>Danh sách sản phẩm hiện có</p>
        </div>

        <div class="toolbar">
            <form class="search-box" method="GET">
                <input type="text" name="search" placeholder="Tìm tên giày hoặc thương hiệu..." value="<?php echo $search; ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Tìm</button>
                <?php if($search != "") { ?>
                    <button type="button" onclick="window.location.href='admin_product.php'" style="background:#999">Xóa lọc</button>
                <?php } ?>
            </form>

            <button class="btn-add" id="openAddModalBtn"><i class="fa-solid fa-plus"></i> Thêm sản phẩm</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thương hiệu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { 
                        $img_path = "../image/" . $row['brand'] . "/" . $row['image'];   
                        if (empty($row['image']) || !file_exists($img_path)) {
                            $img_path = "https://placehold.co/80x80?text=No+Image";
                        }
                        $quantity_class = ($row['quantity'] < 5) ? 'low-stock' : '';
                ?>
                <tr>
                    <td><img src="<?php echo $img_path; ?>" class="product-img"></td>
                    <td style="font-weight: 600; max-width: 250px;"><?php echo $row['name']; ?></td>
                    <td style="color: #d32f2f; font-weight: bold;"><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</td>
                    <td class="<?php echo $quantity_class; ?>"><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['brand']; ?></td>
                    <td class="actions">
                        <button class="edit" 
                                onclick="openEditModal(
                                    '<?php echo $row['id']; ?>',
                                    '<?php echo addslashes($row['name']); ?>',
                                    '<?php echo $row['brand']; ?>',
                                    '<?php echo $row['price']; ?>',
                                    '<?php echo $row['quantity']; ?>',
                                    '<?php echo addslashes($row['description']); ?>',
                                    '<?php echo $img_path; ?>'
                                )">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        
                        <button class="delete" onclick="openDeleteModal('<?php echo $row['id']; ?>')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center; padding:20px;'>Không tìm thấy sản phẩm.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addProductModal')">&times;</span>
            <h2 style="text-align: center; margin-bottom: 20px;">Thêm sản phẩm mới</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group"><label>Tên sản phẩm</label><input type="text" name="name" required></div>
                <div class="form-group"><label>Thương hiệu</label>
                    <select name="brand" required>
                        <option value="Nike">Nike</option><option value="Asics">Asics</option>
                        <option value="Converse">Converse</option><option value="Vans">Vans</option>
                    </select>
                </div>
                <div class="form-group" style="display: flex; gap: 10px;">
                    <div style="flex: 1;"><label>Giá</label><input type="number" name="price" required></div>
                    <div style="flex: 1;"><label>Số lượng</label><input type="number" name="quantity" value="10" required></div>
                </div>
                <div class="form-group"><label>Hình ảnh</label><input type="file" name="image" required accept="image/*"></div>
                <div class="form-group"><label>Mô tả</label><textarea name="description" rows="2"></textarea></div>
                <button type="submit" name="btn_add" class="btn-submit">Thêm ngay</button>
            </form>
        </div>
    </div>

    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('editProductModal')">&times;</span>
            <h2 style="text-align: center; margin-bottom: 20px;">Cập nhật sản phẩm</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="edit_id">
                
                <div class="form-group"><label>Tên sản phẩm</label><input type="text" id="edit_name" name="edit_name" required></div>
                <div class="form-group"><label>Thương hiệu</label>
                    <select id="edit_brand" name="edit_brand" required>
                        <option value="Nike">Nike</option><option value="Asics">Asics</option>
                        <option value="Converse">Converse</option><option value="Vans">Vans</option>
                    </select>
                </div>
                <div class="form-group" style="display: flex; gap: 10px;">
                    <div style="flex: 1;"><label>Giá</label><input type="number" id="edit_price" name="edit_price" required></div>
                    <div style="flex: 1;"><label>Số lượng</label><input type="number" id="edit_quantity" name="edit_quantity" required></div>
                </div>
                
                <div class="form-group" style="text-align: center;">
                    <label>Ảnh hiện tại</label>
                    <img id="current_img_preview" src="" style="width: 80px; height: 80px; object-fit: contain; border: 1px solid #ddd;">
                </div>

                <div class="form-group">
                    <label>Chọn ảnh mới (Nếu muốn thay đổi)</label>
                    <input type="file" name="edit_image" accept="image/*">
                </div>
                <div class="form-group"><label>Mô tả</label><textarea id="edit_description" name="edit_description" rows="2"></textarea></div>
                <button type="submit" name="btn_update" class="btn-submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>

    <div id="deleteProductModal" class="modal">
        <div class="modal-content" style="width: 350px; text-align: center;">
            <span class="close-btn" onclick="closeModal('deleteProductModal')">&times;</span>
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 50px; color: #d32f2f; margin-bottom: 15px;"></i>
            <h3>Bạn có chắc chắn muốn xóa?</h3>
            <p style="color: #666; margin-bottom: 20px;">Hành động này không thể hoàn tác.</p>
            
            <form action="" method="POST">
                <input type="hidden" id="delete_id" name="delete_id">
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="closeModal('deleteProductModal')" style="flex: 1; padding: 10px; border: 1px solid #ddd; background: #fff; border-radius: 5px; cursor: pointer;">Hủy</button>
                    <button type="submit" name="btn_delete" style="flex: 1; padding: 10px; background: #d32f2f; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Xóa luôn</button>
                </div>
            </form>
        </div>
    </div>
<script src="../js/admin_product.js"></script>
</body>
</html>