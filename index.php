<?php
include("conn.php");
include("setup.php");
?>
<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>简易点餐系统</title>
</head>
<style>
a, p, td, from, input {
	font-size: 12px;
}
a {
	color: #000;
	text-decoration: none;
}
a:hover {
	color: #585858;
}
input {
	border: #999 1px solid;
}
#body {
	width: 600px;
	margin: 20px auto;
	text-align: center;
}
#todaytb {
	width: 100%;
	border-right: 1px solid #999;
	border-bottom: 1px solid #999;
	text-align: center;
}
#todaytb td {
	border-left: 1px solid #999;
	border-top: 1px solid #999;
	height: 25px;
}
#todaytb .tit {
	height: 30px;
	background-color : #9CB5FF;
	font-weight: bold;
}
#todaytb .ctr {
	height: 25px;
	background-color : #FEFFC0;
}
#todaytb .dtr {
	height: 30px;
	background-color : #BDB4FF;
	font-weight: bold;
}
form .user {
	width: 50px;
}
form .bz {
	width: 180px;
}
</style>
<body>
<div id="body">
	<?php
if(isset($_GET['m'])){
	$m=$_GET['m'];
}else{
	$m="";
}

//登录处理
Session_Start();
$lifeTime = 30*24*3600;
session_set_cookie_params($lifeTime);

if(!isset($_SESSION["user"])){
	$_SESSION["user"]="";
}

if($m=="login"){ 
	$pass=$_POST['password']; 
	if($pass=="abc123"){
		$_SESSION["login"]=true;
		echo "<script> alert('登陆成功!'); location.href='/'</script>"; 
	}else{
		echo "<script> alert('密码错误!'); location.href='/'</script>"; 
	}
}

//退出登录
if($m=="out"){ 
	//session_unset();
	//session_destroy();
	unset ($_SESSION['login']);
	echo "<script> alert('已退出登陆!'); location.href='/'</script>"; 
}

//添加记录
if($m=="add"){ 
	$user=$_POST['user']; 
	$num=$_POST['num']; 
	$bz=$_POST['bz']; 
	if($bz=='给网管留句话')$bz='';
	if($user=="" || $num==""){
		echo"<script> alert('请正确填写姓名！'); location.href='/'</script>"; 
		exit();
	}
	$_SESSION["user"]=$user;
	$sql="select count(*) as c from sj WHERE isdel=0 and to_days(times)=to_days(now()) and user='$user' group by user";
	$query=mysql_query($sql); 
	$rs=mysql_fetch_array($query); 
	if($rs['c']>0){
		echo"<script> alert('".$user."今天已经点过餐，需要修改请联系网管！'); location.href='/'</script>"; 
		exit();
	}
	$sql = "INSERT INTO `sj`(`user`, `num`, `bz`) VALUES ('$user',$num,'$bz')";
	mysql_query($sql); 
	echo"<script> alert('点餐成功！您的信息:".$user."（".$num."份）'); location.href='/'</script>"; 
}

//删除记录
if($m=="del"){ 
	$id=$_GET['id']; 
	$sql="update sj set isdel=1 where id='$id'"; 
	mysql_query($sql); 
	echo "<script> alert('删除成功!".$id."'); location.href='/'</script>"; 
}

//修改记录
if($m=="up"){ 
	$id=$_POST['id']; 
	$user=$_POST['user']; 
	$num=$_POST['num']; 
	$bz=$_POST['bz']; 
	$sql="update sj set user='$user',num='$num',bz='$bz' where id='$id'"; 
	mysql_query($sql); 
	echo "<script> alert('修改成功!您的信息:".$user."（".$num."份）'); location.href='/'</script>"; 
}
?>
	<h1>简易点餐系统</h1>
<?php
if($m=="edit"){
	$id=$_GET['id']; 
	$sql="select * from sj where id='$id'"; 
	$query=mysql_query($sql); 
	$rs=mysql_fetch_array($query); 
?>
	<form action="?m=up" method="post">
		<p>
			<input type="hidden" name="id" value="<?php echo $id?>"/>
			姓名:
			<input name="user" type="text" value="<?php echo $rs['user']?>" class="user">
			份数:
			<select name="num" id="num">
<?php 
for($i = 1;$i <= 10; $i++){
	if($i==$rs['num']) {
		$selected='selected="selected"';
	}else{
		$selected="";
	}
	echo '<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
}
?>
			</select>
			<input type="text" name="bz" value="<?php echo $rs['bz']?>"  class="bz"/>
			<input type="submit" value="立即修改">
		</p>
	</form>
<?php } else { ?>
	<form action="?m=add" method="post">
		<p> 姓名:
			<input type="text" name="user" value='<?php echo $_SESSION["user"]; ?>' onfocus='if(this.value=="<?php echo $_SESSION["user"]; ?>")this.value=""' onBlur='if(this.value=="")this.value="<?php echo $_SESSION["user"]; ?>"' class="user"/>
			份数:
			<select name="num" id="num">
<?php 
for($i = 1;$i <= 10; $i++){
	if($i==1) {
		$selected='selected="selected"';
	}else{
		$selected="";
	}
	echo '<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
}
?>
			</select>
			<input type="text" name="bz" value="给网管留句话"  class="bz" onfocus='if(this.value=="给网管留句话")this.value=""' onBlur='if(this.value=="")this.value="给网管留句话"'/>
			<input type="submit" value="立即点餐">
		</p>
	</form>
<?php
} 
echo "<h3>".date('Y年m月d日')."（".weekday(date('Y-m-d'))."）点餐列表</h3>\r\n";
?>
	<table border="0" cellspacing="0" cellpadding="0" id="todaytb">
		<tbody>
			<tr class="tit">
				<td width="70">姓名</td>
				<td width="50">份数</td>
				<td>留言</td>
				<td width="120">时间</td>
<?php
if(isset($_SESSION["login"])){
?>
				<td width="100">操作</td>
<?php
}
?>
			</tr>
<?php
$result = mysql_query("SELECT * FROM sj where isdel=0 and to_days(times)=to_days(now()) order by times desc");
$nums=0;
$xx=1;
while($row = mysql_fetch_array($result)){
	if($xx%2==0){
		echo "			<tr class='ctr'>\r\n";
	}else{
		echo "			<tr>\r\n";
	}
	echo "				<td>".$row['user']."</td>\r\n";
	echo "				<td>".$row['num']."份</td>\r\n";
	echo "				<td>".$row['bz']."</td>\r\n";
	echo "				<td>".date('H:i:s', strtotime($row['times']))."</td>\r\n";
	if(isset($_SESSION["login"])){
		echo "				<td><a href='?m=edit&id=".$row['id']."'>修改</a> <a href='?m=del&id=".$row['id']."'>删除</a></td>\r\n";
	}
	echo "			</tr>\r\n";
	$nums=$nums+$row['num'];
	$xx=$xx+1;
}
?>
			<tr class="dtr">
				<td>合计</td>
				<td><?php echo $nums;?>份</td>
				<td></td>
				<td></td>
<?php
if(isset($_SESSION["login"])){
?>
				<td></td>
<?php
}
?>
			</tr>
		</tbody>
	</table>
<?php
if(isset($_SESSION["login"])){
?>
	<p>欢迎进入管理界面！<a href="?m=out">退出登录</a></p>
<?php
}else{
?>
	<form action="?m=login" method="post">
		<p>
			管理密码:
			<input type="password" name="password">
			<input type="submit" value="登录管理">
		</p>
	</form>
<?php
}
?>
	<br>
	<!--Author: shileiye--> 
</div>
</body>
</html>
<?php
mysql_close($con);//关闭数据库连接
?>