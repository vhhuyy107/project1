<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <fieldset class="form-control" style= "width:auto">
        <legend>Tìm kiếm sản phẩm</legend>
        <br>
        <form action="" method="get">
        <div>
        <label for="sp" style="display: inline-block">Nhập tên sản phẩm: </label> &nbsp;
        <input type="text" class="form-control" name="ten" id="sp" style="width:auto; display: inline-block;"><br>
        </div>
        <br>
        <div>
            <label class="form-check-label" for="">Cách tìm</label> &nbsp;
            <input class="form-check-input" type="radio" name="ct" value="gandung">Gần đúng &nbsp;
            <input class="form-check-input" type="radio" name="ct" id="chinhxac">Chính xác
        </div>
        <br>
        <div>
            <label class="form-check-label" for="">Loại sản phẩm</label> <br>
            <input class="form-check-input" type="checkbox" name="loai[]" value="loai1">Loại 1 <br>
            <input class="form-check-input" type="checkbox" name="loai[]" value="loai2">Loại 2 <br>
            <input class="form-check-input" type="checkbox" name="loai[]" value="loai3">Loại 3 <br>
            <input class="form-check-input" type="checkbox" name="loai[]" value="tatca">Tất cả <br>

        </div>
        <br>
        <input class="btn btn-primary" type="submit" value="Tìm">
        </form>
    </fieldset>
    <?php
if(isset($_GET['ten'])){
    echo "Tên sản phẩm vừa nhập: " . htmlspecialchars($_GET['ten']);
    echo "<br>";
}
if(isset($_GET['ct'])){
    echo "Cách tìm: " . htmlspecialchars($_GET['ct']);
    echo "<br>";
}
if(isset($_GET['loai'])){
    echo "Loại sản phẩm: ";
    if(is_array($_GET['loai'])){
        echo implode(", ",$_GET['loai']); 
        //implode: Nối các giá trị trong mảng loai[] thành một chuỗi, ngăn cách nhau bằng dấu phẩy.
    }
} else {
    echo "Chưa chọn loại. ";
}
echo "<hr>";
    print_r($_GET);
?>
</body>
</html>