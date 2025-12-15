<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lab 3_4</title>
</head>

<body>
<?php
//Kết hợp hàm và vòng lặp
function kiemtranguyento($x)//Kiểm tra 1 số có nguyên tố hay không
{
	if($x<2)
		return false;
	if($x==2)
		return true;
    $i=2;
    do {
        if ($x%$i==0) {
            return false;
        }
        $i++;
    } while ($i>=sqrt($x));
	// for($i=2;$i<=sqrt($x);$i++)
	// 	if($x%$i==0)
	// 		return false;
	return true;
}
function xuatSoNguyenTo($n) {
   echo $n." số nguyên tố đầu tiên là <br/>";
    $dem=0;
    $i=2;
    do {
        if (kiemtranguyento($i)) {
            echo $i. '<br/>'; 
            $dem++;
        }
        $i++;
    } while ($dem < $n);
}
xuatSoNguyenTo(4);
	
?>
</body>
</html> 