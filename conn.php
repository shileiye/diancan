<?php
//数据连接
$con = mysql_connect("localhost","root","root");
if (!$con)
{
	die('数据连接出错: ' . mysql_error());
}
mysql_select_db("dc", $con);
?>