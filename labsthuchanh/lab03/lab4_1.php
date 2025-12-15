<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $s=0;
        for ($i=2; $i < 101; $i++) { 
                if ($i%2==0) {
                    $s+=$i;
                }
        }
        echo "Tổng các số chẵn từ 2 đến 100 là: ".$s;
    ?>
</body>
</html>