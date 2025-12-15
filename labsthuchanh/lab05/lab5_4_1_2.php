<?php
function getIndex($index, $value="")
{
	if (!isset($_GET[$index]))	return $value;
	return $_GET[$index];
}
$id = getIndex("id");
   echo "Id tuong ung la: ".$id;
?>  