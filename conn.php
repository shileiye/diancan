<?php
//数据连接
$con = mysql_connect("10.4.12.173","uYy2CW73bLT29","pYjulV5VB5dCk");
if (!$con)
{
	die('数据连接出错: ' . mysql_error());
}
mysql_select_db("d22d95f26d16b4162aa180f94cca4b541", $con);
?>