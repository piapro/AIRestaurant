<?php
	/**
	 *  usercheck.php  
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
				$QIYU_ID_USER="";
			}
		}else
			$QIYU_ID_USER="";
	}else{
		$QIYU_ID_USER="";
	}
	if (!empty($QIYU_ID_USER)){
		$sqlStr="select * from qiyu_user where user_id=".$QIYU_ID_USER."";
		$result = mysql_query($sqlStr);
		$row=mysql_fetch_assoc($result);
		if(!$row){
			
			setcookie("QIYUUSER","",time()-1);
			setcookie("QIYUVERD","",time()-1);
			session_unset();
			session_destroy();
			//Header("Location: index.php");
		}
	}

?>