<?php 
	require_once("usercheck.php");
?>
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<?php
	
	$phone = sqlReplace($_POST['phone']);
	$pw = sqlReplace($_POST['pw']);
	$repw = sqlReplace($_POST['repw']);
	$vCode = sqlReplace($_POST['vcode']);
	//$code = sqlReplace($_POST['a']);
	$agree=sqlReplace($_POST['agree']);
	$p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	$shopID=empty($_GET['shopID'])?'0':sqlReplace(trim($_GET['shopID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['shopCircle'])?'0':sqlReplace(trim($_GET['shopCircle']));
	$savesession=$phone.','.$agree;//存session
	$_SESSION['reginfo1']=$savesession;
	checkData($phone,'手机号',1);
	checkData($pw,'密码',1);
	checkData($repw,'确认密码',1);
	if ($pw!=$repw){
		alertInfo("两次输入的密码不同","userreg.php",0);
	}
	/*
	if ($vCode!=$code){
		alertInfo("验证码错误","",1);
	} */

	if ($vCode!=$_SESSION["imgcode"]){
		alertInfo("验证码错误","",1);
	}
	if (empty($agree) && $site_isshowprotocol=='1') alertInfo("请选择同意协议","",1);
	//检查手机的存在
	$sqlStr="select user_id from qiyu_user where user_phone='".$phone."'";
	$rs=mysql_query($sqlStr);
	$row=mysql_fetch_assoc($rs);
	if ($row){
		alertInfo("手机号已注册","",1);
	}
	$_SESSION['phone']=$phone;
	$_SESSION['pw']=$pw;
	Header("Location: userregnew2.php?p=".$p."&shopID=".$shopID."&shopSpot=".$shopSpot."&shopCircle=".$shopCircle);
?>