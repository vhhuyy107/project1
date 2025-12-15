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
    <div class="form-control">
        <h1 class="text-primary">Kiểm tra số nguyên hay thức</h1> <br>
        <form action="" method="post">
            <label class="form-label" for="a">Nhập a:</label>
            <input type="text" name="a" id="a" class="form-control" style="width: 400px; " placeholder="Nhập a"> <br>
            <input type="submit" value="Tính" class=" btn btn-primary mt-3"> <br>
        </form>
        <div class="alert alert-info mt-3" style="width: 400px; ">
            <?php
            if (empty($_POST["a"])) {
                echo "Vui lòng nhập a !";
            } else {
                if (!is_numeric($_POST["a"])) {
                    echo "Vui lòng chỉ nhập số!";
                } else {
                    if ($_POST["a"] % 1 != 0) {
                        echo $_POST["a"] . " là số thực!";
                    } else {
                        echo $_POST["a"] . " là số nguyên!";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>