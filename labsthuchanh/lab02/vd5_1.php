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
    <h1 class="text-primary">Chia lấy nguyên và lấy dư</h1> <br>
    <form action="" method="post" >
        <label class="form-label" for="a">Nhập a:</label>
        <input type="number" name="a" id="a" class="form-control" style="width: 400px; " placeholder="Nhập a"> <br>
        <label class="form-label" for="b">Nhập b:</label>
        <input type="number" name="b" id="b" class="form-control mt-3" style="width: 400px; " placeholder="Nhập b"> <br>
        <input type="submit" value="Tính" class=" btn btn-primary mt-3" > <br>
    </form>
    <div class="alert alert-info mt-3" style="width: 400px; ">
        <?php
        if (empty($_POST["a"]) && empty($_POST["b"])) {
            echo "Vui lòng nhập a và b!";
        }
        else if (empty($_POST["a"]) || empty($_POST["b"])) {
            echo "Vui lòng điền hết!";
        }
        else {
             $nguyen;
             $nguyen =intdiv( $_POST["a"],$_POST["b"]);
            $du = $_POST["a"]%$_POST["b"];
            echo "Phần nguyên của ".$_POST["a"]."/".$_POST["b"]." là: ".$nguyen;
            echo "<br/>";
            echo "Phần dư của ".$_POST["a"]."/".$_POST["b"]." là: ".$du;
        }
        ?>
    </div>
    </div>
</body>

</html>