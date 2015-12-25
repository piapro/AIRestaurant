<?php 
header("Content-type: text/html; charset=utf-8");	
require('include/dbconn.php');
?>
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<?php
	
	$name = sqlReplace($_POST['name']);
	$address = sqlReplace($_POST['address']);
	$sinaUid=empty($_SESSION['sinaUid'])?'':sqlReplace($_SESSION['sinaUid']);
	$sinaNick=empty($_SESSION['sinaNick'])?'':sqlReplace($_SESSION['sinaNick']);
	$p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	$shopID=empty($_GET['shopID'])?'0':sqlReplace(trim($_GET['shopID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['shopCircle'])?'0':sqlReplace(trim($_GET['shopCircle']));
	$phone = $_SESSION['phone'];
	
	$pw = $_SESSION['pw'];
	$savesession=$name.','.$address;//存session
	$_SESSION['reginfo2']=$savesession;
	checkData($name,'用户姓名',1);
	checkData($address,'详细地址',1);
	checkData($pw,'密码',1);
	$ip=$_SERVER['REMOTE_ADDR'];
	$logincount = 1;
	$vercode=getRndCode(6);
	$vercodePhone=getRndCode_r(6);
	$content="验证码是".$vercodePhone;
	$_SESSION['Phone']=$phone;
	$pw=md5(md5($pw.$vercode));
	//检查手机的存在
	$sqlStr="select user_id from qiyu_user where user_phone='".$phone."'";
	$rs=mysql_query($sqlStr);
	$row=mysql_fetch_assoc($rs);
	if ($row){
		alertInfo("手机号已注册","",1);
	}
	
	
	$sql = "insert into qiyu_user(user_account,user_password,user_logintime,user_loginip,user_logincount,user_mail,user_phone,user_time,user_name,user_salt,user_status,user_vcode,user_sinauid,user_sinanick,user_regtype) values('".$phone."','".$pw."',now(),'".$ip."','".$logincount."','','".$phone."',now(),'".$name."','".$vercode."','0','".$vercodePhone."','".$sinaUid."','".$sinaNick."','0')";
	if(mysql_query($sql)){
		$id = mysql_insert_id();
		$address_sql = "insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_address,useraddr_name) values (".$id.",'".$phone."','".$address."','".$name."')";
		mysql_query($address_sql);
		//发送验证码
		//sendCode($phone,$content);
		//Header("Location: uservali.php");
		$_SESSION['qiyu_uid']=$id;
		$_SESSION['reginfo1']='';
		$_SESSION['reginfo2']='';
		Header("Location: userregfinish.php?p=".$p."&shopID=".$shopID."&shopSpot=".$shopSpot."&spotID=".$spot."&circleID=".$circle."&shopCircle=".$shopCircle);
	}else{
		alertInfo("注册失败","",1);
	}
?>