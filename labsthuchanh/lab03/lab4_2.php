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
        $n=0;
        while ($s<1000) {
            $n++;
            $s+=$n;
            echo $s."_ ".$n .'<br/>';
            
            
        }
        echo "n nhỏ nhất đển tổng từ 1 đến n là: ".$n.'<br/>';

        $sum=0;
        $i=0;
        do {
            $i++;
            $sum+=$i;
            echo $sum."_ ".$i.'<br/>';
        } while ($sum<1000);
        echo "n nhỏ nhất đển tổng từ 1 đến n là: ".$i;
    ?>
</body>
</html>