<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lab8_2 - PDO - MySQL - select - insert - parameter</title>
</head>

<body>
    <form action="lab8_2.php" method="get">
        <input type="text" name="book_name" placeholder="Tìm sách..." value="<?php echo isset($_GET['book_name']) ? $_GET['book_name'] : '' ?>">
        <input type="submit" name="find" value="Tìm kiếm">
    </form>
    <br>
    <?php
    // ------------------- KẾT NỐI CSDL -------------------
    try {
        // Tạo đối tượng PDO kết nối đến database 'bookstore' với user 'root'
        $pdh = new PDO("mysql:host=localhost; dbname=bookstore", "root", "");
        // Thiết lập bộ mã UTF-8 để hiển thị tiếng Việt đúng
        $pdh->query("set names 'utf8'");
    } catch (Exception $e) {
        // Nếu kết nối thất bại thì báo lỗi và dừng chương trình
        echo $e->getMessage();
        exit;
    }

    // // ------------------- TRUY VẤN SELECT -------------------
    // $search = "a"; // từ khóa tìm kiếm
    // $sql = "select * from publisher where pub_name like :ten"; // câu lệnh SQL có tham số
    // $stm = $pdh->prepare($sql); // chuẩn bị câu lệnh
    // $stm->bindValue(":ten", "%$search%"); // gán giá trị cho tham số :ten
    // $stm->execute(); // thực thi câu lệnh
    // $rows = $stm->fetchAll(PDO::FETCH_ASSOC); // lấy tất cả kết quả dưới dạng mảng kết hợp

    // // In kết quả ra màn hình
    // echo "<pre>";
    // print_r($rows); // hiển thị mảng kết quả
    // echo "</pre>";
    // echo "<hr>";

    // // ------------------- TRUY VẤN INSERT -------------------
    // $ma = "LS1";       // mã loại sách
    // $ten = "Lịch sử"; // tên loại sách
    // $sql = "insert into category(cat_id, cat_name) values(:maloai, :tenloai)"; // câu lệnh SQL có tham số
    // $arr = array(":maloai" => $ma, ":tenloai" => $ten); // mảng ánh xạ tham số với giá trị

    // $stm = $pdh->prepare($sql); // chuẩn bị câu lệnh
    // $stm->execute($arr);        // thực thi với mảng tham số
    // $n = $stm->rowCount();      // số dòng bị ảnh hưởng (số bản ghi thêm được)
    // In thông báo kết quả
    //  echo "Đã thêm $n loại sách";
    if (isset($_GET["find"]) || isset($_GET["page"])) {

        $searchBook = isset($_GET["book_name"]) ? $_GET["book_name"] : "";
        $itemsPerPage = 10;
    
        // Lấy trang hiện tại
        $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
        if ($page < 1) $page = 1;
    
        // Tính dòng bắt đầu
        $start = ($page - 1) * $itemsPerPage;
    
        // Tổng số dòng
        $sqlCount = "SELECT COUNT(*) FROM book WHERE book_name LIKE :ten";
        $stmCount = $pdh->prepare($sqlCount);
        $stmCount->bindValue(":ten", "%$searchBook%");
        $stmCount->execute();
        $totalRows = $stmCount->fetchColumn();
        $totalPages = ceil($totalRows / $itemsPerPage);
    
        // Lấy dữ liệu cho trang hiện tại
        $sql = "SELECT * FROM book WHERE book_name LIKE :ten LIMIT :start, :limit";
        $stm = $pdh->prepare($sql);
        $stm->bindValue(":ten", "%$searchBook%", PDO::PARAM_STR);
        $stm->bindValue(":start", $start, PDO::PARAM_INT);
        $stm->bindValue(":limit", $itemsPerPage, PDO::PARAM_INT);
        $stm->execute();
    
        $rowsBook = $stm->fetchAll(PDO::FETCH_ASSOC);
    
        // ------------ HIỂN THỊ BẢNG 10 SÁCH ------------
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>ID</th>
                <th>Tên sách</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>NXB</th>
                <th>Thể loại</th>
              </tr>";
    
        foreach ($rowsBook as $row) {
            echo "<tr>";
            echo "<td>{$row['book_id']}</td>";
            echo "<td>{$row['book_name']}</td>";
            echo "<td>Để trống</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>{$row['img']}</td>";
            echo "<td>{$row['pub_id']}</td>";
            echo "<td>{$row['cat_id']}</td>";
            echo "</tr>";
        }
    
        echo "</table>";
    
        // ------------------- NÚT PHÂN TRANG -------------------
        echo "<div style='margin-top: 20px;'>";
    
        // Trang trước
        if ($page > 1) {
            echo "<a href='lab8_2.php?page=".($page - 1)."&book_name=$searchBook&find=1'>Trang trước</a> | ";
        }
    
        // Danh sách trang
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='lab8_2.php?page=$i&book_name=$searchBook&find=1'>$i</a> ";
        }
    
        // Trang sau
        if ($page < $totalPages) {
            echo "| <a href='lab8_2.php?page=".($page + 1)."&book_name=$searchBook&find=1'>Trang sau</a>";
        }
    
        echo "</div>";

        // $sql = "select * from book where book_name like :ten";
        // $stm=$pdh->prepare($sql);
        // $stm->bindValue(":ten", "%$searchBook%");
        // $stm->execute();
        // $rowsBook=$stm->fetchAll(PDO::FETCH_ASSOC);
        // foreach($rowsBook as $row)
        // {
        //     echo "<br/>". $row["book_id"]."-".$row["book_name"]."-".$row["description"]."-".$row["price"]."-".$row["img"]."-".$row["pub_id"]."-".$row["cat_id"];
        // }
    }

    ?>

</body>

</html>