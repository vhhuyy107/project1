<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        function tinhTongSoTrongchuoi($str) {
            $sum=0;
            for($i=0;$i<strlen($str);$i++) {
                if (is_numeric($str[$i])) {
                    $sum+=$str[$i];
                }
            }
            echo "Tổng các chữ số = ".$sum;
        }

        $str ="ngay15thang7nam2015";
        tinhTongSoTrongchuoi($str);
    ?>
</body>
</html>