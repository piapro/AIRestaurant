<?php
	/**
	 * userlogin_do.php 登录操作
	 */
	require('include/dbconn.php');
	$user_account=sqlReplace(trim($_POST['z_phone']));
	$loginUrl=$_SESSION['login_url'];
	$pw=sqlReplace(trim($_POST['pw']));
	$cookie=empty($_POST['cookie'])?"":sqlReplace($_POST['cookie']);
	$re_name=empty($_POST['re_name'])?"":sqlReplace($_POST['re_name']);
	$sinaUid=empty($_SESSION['sinaUid'])?'':sqlReplace($_SESSION['sinaUid']);
	$sinaNick=empty($_SESSION['sinaNick'])?'':sqlReplace($_SESSION['sinaNick']);
	$p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	$shopID=empty($_GET['shopID'])?'0':sqlReplace(trim($_GET['shopID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['shopCircle'])?'0':sqlReplace(trim($_GET['shopCircle']));
	checkData($user_account,'手机号',1);
	checkData($pw,'密码',1);
	$sqlStr="select * from ".WIIDBPRE."_user where user_account='".$user_account."'";
	$result = mysql_query($sqlStr) or die ("查询失败，请检查SQL语句。");
	$row=mysql_fetch_assoc($result);
	if($row){
		$ip=$_SERVER['REMOTE_ADDR'];
		$pwd=md5(md5($pw.$row['user_salt']));
		$sql="select * from qiyu_user where user_account='".$user_account."' and user_password='".$pwd."'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		if ($rows){
            $sql2="update qiyu_user set user_experience=user_experience+".expUserLogin." where  user_account='".$user_account."' and user_password='".$pwd."'";
			mysql_query($sql2);
			date_default_timezone_set('PRC');
			$time=date('Y-m-d H:i:s');
			if (!empty($sinaUid)){
				$sql_update="update qiyu_user set user_logintime='".$time."',user_loginip='".$ip."',user_logincount=user_logincount+1,user_sinanick='".$sinaNick."',user_sinauid='".$sinaUid."' where user_account='".$user_account."' and user_password='".$pwd."'";
			}else{
				$sql_update="update qiyu_user set user_logintime='".$time."',user_loginip='".$ip."',user_logincount=user_logincount+1 where user_account='".$user_account."' and user_password='".$pwd."'";
			}
			mysql_query($sql_update);
			if($cookie=="yes"){//自动登录
				setcookie("QIYUUSER",$rows['user_account'],time()+60*60*24*7);
				setcookie("QIYUVERD",$pwd,time()+60*60*24*7);
			}else{
				setcookie("QIYUCHECK",'no',time()+60*60*24*7);
			}
			if($re_name=="yes"){//记住帐号
				setcookie("QIYUCHECK",'yes',time()+60*60*24*7);
				setcookie("QIYUUSER",$rows['user_account'],time()+60*60*24*7);
			}
			//记录Session
			$_SESSION['qiyu_uid']=$rows['user_id'];
			//alertInfo("登录成功","index.php",0);
			$geturl=getDefaultAddress($rows['user_id']);
			$cName=getCircleByID($geturl['circle']);
			if (!empty($p)){
				Header("Location: userorder.php?shopID=".$shopID."&shopSpot=".$shopSpot."&circleID=".$shopCircle);
			}else if($cName=='大望路'){
				Header("Location: spot.php?spotID=".$geturl['spot']."&circleID=".$geturl['circle']);
			}else if(empty($loginUrl)){
				Header("Location: index.php");
			}else{
				Header("Location: ".$loginUrl);
			}
		}else{
			alertInfo("您输入的密码不正确","userlogin.php?shopID=".$shopID."&shopSpot=".$shopSpot."&circleID=".$shopCircle,0);
		}
		
		
	}else{
		alertInfo("手机号不存在","userlogin.php?shopID=".$shopID."&shopSpot=".$shopSpot."&circleID=".$shopCircle,0);

	}

?>