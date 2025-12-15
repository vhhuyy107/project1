<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    function ShowArray($arr){
        echo "<table border=1>
        <tr><td>Stt</td><td>Mã sản phẩm</td><td>Tên sản phẩm</td></tr>";
        $i = 0;
        foreach ($arr as $a) {
            $i++;
            echo "<tr><td>$i</td>";
            echo "<td>".$a['id']."</td>";
            echo "<td>".$a['name ']."</td></tr>";
        }
           echo "</table>"; 
    }
    $arr= array();
    $r = array("id"=> "sp1", "name "=> "Sản phẩm 1 ");
    $arr[] = $r;
    $r = array("id"=> "sp2", "name "=> "Sản phẩm 2 ");
    $arr[] = $r;
    $r = array("id"=> "sp3", "name "=> "Sản phẩm 3 ");
    $arr[] = $r;
    ShowArray($arr);
    ?>
</body>
</html>