<?php
include("conn.php");
include("setup.php");
?>
<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>���׵��ϵͳ</title>
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

//��¼����
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
		echo "<script> alert('��½�ɹ�!'); location.href='/'</script>"; 
	}else{
		echo "<script> alert('�������!'); location.href='/'</script>"; 
	}
}

//�˳���¼
if($m=="out"){ 
	//session_unset();
	//session_destroy();
	unset ($_SESSION['login']);
	echo "<script> alert('���˳���½!'); location.href='/'</script>"; 
}

//��Ӽ�¼
if($m=="add"){ 
	$user=$_POST['user']; 
	$num=$_POST['num']; 
	$bz=$_POST['bz']; 
	if($bz=='���������仰')$bz='';
	if($user=="" || $num==""){
		echo"<script> alert('����ȷ��д������'); location.href='/'</script>"; 
		exit();
	}
	$_SESSION["user"]=$user;
	$sql="select count(*) as c from sj WHERE isdel=0 and to_days(times)=to_days(now()) and user='$user' group by user";
	$query=mysql_query($sql); 
	$rs=mysql_fetch_array($query); 
	if($rs['c']>0){
		echo"<script> alert('".$user."�����Ѿ�����ͣ���Ҫ�޸�����ϵ���ܣ�'); location.href='/'</script>"; 
		exit();
	}
	$sql = "INSERT INTO `sj`(`user`, `num`, `bz`) VALUES ('$user',$num,'$bz')";
	mysql_query($sql); 
	echo"<script> alert('��ͳɹ���������Ϣ:".$user."��".$num."�ݣ�'); location.href='/'</script>"; 
}

//ɾ����¼
if($m=="del"){ 
	$id=$_GET['id']; 
	$sql="update sj set isdel=1 where id='$id'"; 
	mysql_query($sql); 
	echo "<script> alert('ɾ���ɹ�!".$id."'); location.href='/'</script>"; 
}

//�޸ļ�¼
if($m=="up"){ 
	$id=$_POST['id']; 
	$user=$_POST['user']; 
	$num=$_POST['num']; 
	$bz=$_POST['bz']; 
	$sql="update sj set user='$user',num='$num',bz='$bz' where id='$id'"; 
	mysql_query($sql); 
	echo "<script> alert('�޸ĳɹ�!������Ϣ:".$user."��".$num."�ݣ�'); location.href='/'</script>"; 
}
?>
	<h1>���׵��ϵͳ</h1>
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
			����:
			<input name="user" type="text" value="<?php echo $rs['user']?>" class="user">
			����:
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
			<input type="submit" value="�����޸�">
		</p>
	</form>
<?php } else { ?>
	<form action="?m=add" method="post">
		<p> ����:
			<input type="text" name="user" value='<?php echo $_SESSION["user"]; ?>' onfocus='if(this.value=="<?php echo $_SESSION["user"]; ?>")this.value=""' onBlur='if(this.value=="")this.value="<?php echo $_SESSION["user"]; ?>"' class="user"/>
			����:
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
			<input type="text" name="bz" value="���������仰"  class="bz" onfocus='if(this.value=="���������仰")this.value=""' onBlur='if(this.value=="")this.value="���������仰"'/>
			<input type="submit" value="�������">
		</p>
	</form>
<?php
} 
echo "<h3>".date('Y��m��d��')."��".weekday(date('Y-m-d'))."������б�</h3>\r\n";
?>
	<table border="0" cellspacing="0" cellpadding="0" id="todaytb">
		<tbody>
			<tr class="tit">
				<td width="70">����</td>
				<td width="50">����</td>
				<td>����</td>
				<td width="120">ʱ��</td>
<?php
if(isset($_SESSION["login"])){
?>
				<td width="100">����</td>
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
	echo "				<td>".$row['num']."��</td>\r\n";
	echo "				<td>".$row['bz']."</td>\r\n";
	echo "				<td>".date('H:i:s', strtotime($row['times']))."</td>\r\n";
	if(isset($_SESSION["login"])){
		echo "				<td><a href='?m=edit&id=".$row['id']."'>�޸�</a> <a href='?m=del&id=".$row['id']."'>ɾ��</a></td>\r\n";
	}
	echo "			</tr>\r\n";
	$nums=$nums+$row['num'];
	$xx=$xx+1;
}
?>
			<tr class="dtr">
				<td>�ϼ�</td>
				<td><?php echo $nums;?>��</td>
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
	<p>��ӭ���������棡<a href="?m=out">�˳���¼</a></p>
<?php
}else{
?>
	<form action="?m=login" method="post">
		<p>
			��������:
			<input type="password" name="password">
			<input type="submit" value="��¼����">
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
mysql_close($con);//�ر����ݿ�����
?>