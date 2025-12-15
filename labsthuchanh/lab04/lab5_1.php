<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        function ShowArray($arr)
        {
            echo "<table border=1>
                    <tr>
                        <th>Index</th>
                        <th>Value</th>
                    </tr>";
                    foreach ($arr as $key => $value) {
                        echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
                    }
                    echo "</table>";
        }
        $b = array(1, 3, 5);
        ShowArray($b);  
    ?>
</body>
</html>