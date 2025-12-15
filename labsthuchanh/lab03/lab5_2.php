<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        function kiemTrachuoiDoiXung($str){
            $n=strlen($str);
            for ($i=0; $i < $n; $i++) { 
                if ($str[$i]!=$str[$n-$i-1]) {
                    return false;
                }
            }
            return true;
        }
        
        $str = 'abcdba';
        if (kiemTrachuoiDoiXung($str)) {
            echo $str.": là cuỗi đối xứng";
        }
        else {
            echo $str.": không phải là chuỗi đối xứng";
        }
    ?>
</body>
</html>