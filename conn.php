<?php
//��������
$con = mysql_connect("localhost","root","root");
if (!$con)
{
	die('�������ӳ���: ' . mysql_error());
}
mysql_select_db("dc", $con);
?>