<?php
	/**
	 *  usercheck2.php
	 */
	require('include/dbconn.php');
	$QIYU_USER_ACCOUNT='';
	if(!empty($_SESSION['qiyu_uid'])){
		$QIYU_ID_USER=$_SESSION['qiyu_uid'];
	}else if(!empty($_COOKIE['QIYUUSER'])){
		$temp_user=sqlReplace($_COOKIE['QIYUUSER']);
		$temp_pwd=empty($_COOKIE['QIYUVERD'])?'':sqlReplace($_COOKIE['QIYUVERD']);
		$sqlStr="select user_id,user_password from qiyu_user where user_account='".$temp_user."'";
		$result = mysql_query($sqlStr);
		$row=mysql_fetch_assoc($result);
		if($row){
			if (!empty($temp_pwd)){
				if($temp_pwd==$row['user_password']){
					$_SESSION['qiyu_uid']=$row['user_id'];
					$QIYU_ID_USER=$row['user_id'];
				}else{
					$QIYU_ID_USER="";			
				}
			}else{
				$QIYU_USER_ACCOUNT=$temp_user;
			}
		}else
			$QIYU_ID_USER="";
	}else{
		$QIYU_ID_USER="";
	}
	if (!empty($shopID))
		if(empty($QIYU_ID_USER)) Header("Location: userquickreg.php?shopID=".$shopID);
	else
		if(empty($QIYU_ID_USER)) alertInfo("请先登录或注册","userlogin.php",0);
	//$sqlStr="select * from qiyu_user where user_id=".$QIYU_ID_USER." and user_status='1'";
	$sqlStr="select * from qiyu_user where user_id=".$QIYU_ID_USER."";
	$result = mysql_query($sqlStr);
	$row=mysql_fetch_assoc($result);
	if($row){
		$USER_SCORE=$row['user_score'];
		$USER_PHONE=$row['user_phone'];
		$USER_SALT=$row['user_salt'];
	}else{
		setcookie("QIYUUSER","",time()-1);
		setcookie("QIYUVERD","",time()-1);
		session_unset();
		session_destroy();
		alertInfo("出错","",1);
		//Header("Location: index.php");
	}
?>