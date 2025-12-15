<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lab 3_5</title>
<style>
	#banco{border:solid; padding:15px; background:#E8E8E8}
	#banco .cellBlack{width:50px; height:50px; background:black; float:left; }
	#banco .cellWhite{width:50px; height:50px; background:white; float:left}
	.clear{clear:both}
</style>
</head>

<body>
<?php
    include('function.php');
    $n=6;
    $colorHead = "aqua";
    $color1="yellow";
    $color2="lime";

    $ar_function = [
        'BCC',
        'Banco'
    ];
    $result="";
    foreach($ar_function as $v){
        if (function_exists($v)) {
            $result.= $v($n,$colorHead,$color1,$color2);
        }
    }
?>
</body>
</html>