<?php
	/**
	 * userquickreg_do.php 快速注册操作
	 */
	require('include/dbconn.php');
	$shopID = sqlReplace($_GET['shopID']);
	$name = sqlReplace($_POST['name']);
	$area = sqlReplace($_POST['area']);
	$circle = sqlReplace($_POST['circle']);
	$spot = sqlReplace($_POST['spot']);
	$phone = sqlReplace($_POST['phone']);
	$address = sqlReplace($_POST['address']);
	$sinaUid=empty($_SESSION['sinaUid'])?'':sqlReplace($_SESSION['sinaUid']);
	$sinaNick=empty($_SESSION['sinaNick'])?'':sqlReplace($_SESSION['sinaNick']);
	checkData($phone,'手机号',1);
	checkData($name,'用户姓名',1);
	checkData($area,'地区',1);
	checkData($circle,'商圈',1);
	checkData($spot,'地标',1);
	checkData($address,'详细地址',1);


	$pw1=getRndCode(6);  //随即生成的密码

	$ip=$_SERVER['REMOTE_ADDR'];
	$logincount = 1;
	$vercode=getRndCode(6);
	$pw=md5(md5($pw1.$vercode));
	//检查用户名的存在
	$sqlStr="select user_id from qiyu_user where user_account='".$phone."'";
	$rs=mysql_query($sqlStr);
	$row=mysql_fetch_assoc($rs);
	if ($row){
		alertInfo("手机号已注册","userquickreg.php?shopID=".$shopID,0);
	}
	$sql = "insert into qiyu_user(user_account,user_password,user_logintime,user_loginip,user_logincount,user_phone,user_time,user_name,user_salt,user_status,user_sinauid,user_sinanick) values('".$phone."','".$pw."',now(),'".$ip."','".$logincount."','".$phone."',now(),'".$name."','".$vercode."','0','".$sinaUid."','".$sinaNick."')";
	if(mysql_query($sql)){
		$id = mysql_insert_id();
		$address_sql = "insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_area,useraddr_spot,useraddr_circle,useraddr_address,useraddr_name) values (".$id.",'".$phone."',".$area.",".$spot.",".$circle.",'".$address."','".$name."')";
		mysql_query($address_sql);
		$_SESSION['qiyu_uid']=$id;
		$_SESSION['user_phone']=$phone;
		//把密码发给此用户
		$content="您在<?php echo $SHOP_NAME?>网站的注册密码是".$pw1;
		//sendCode($phone,$content);
		header("location:userorder.php?shopID=".$shopID);
		//header("location:uservali3.php?shopID=".$shopID);
	}else{
		alertInfo("注册失败","userquickreg.php?shopID=".$shopID,0);
	}
?>