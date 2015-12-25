<?php
	/**
	 *  usercheck.php  
	*/
	require('../include/dbconn.php');
	if(!empty($_SESSION['qiyu_shopID'])){
		$QIYU_ID_SHOP=$_SESSION['qiyu_shopID'];
	}else if(!empty($_COOKIE['QIYUSHOP'])){
		$temp_user=sqlReplace($_COOKIE['QIYUSHOP']);
		$temp_pwd=sqlReplace($_COOKIE['QIYUSHOPVERD']);
		$sqlStr="select shop_id,shop_password,shop_salt from qiyu_shop where shop_account='".$temp_user."'";
		$result = mysql_query($sqlStr);
		$row=mysql_fetch_assoc($result);
		if($row){

			if($temp_pwd==md5($row['shop_password'].$row['shop_salt'])){
				$_SESSION['qiyu_shopID']=$row['shop_id'];
				$QIYU_ID_SHOP=$row['shop_id'];
			}else{
				$QIYU_ID_SHOP="";			
			}
			
		}else
			$QIYU_ID_SHOP="";
	}else{
		$QIYU_ID_SHOP="";
	}


?>