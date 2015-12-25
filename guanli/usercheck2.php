<?php
	/**
	 *  usercheck2.php
	 */
	require('../include/dbconn.php');
	require('inc.function.php');
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

	if(empty($QIYU_ID_SHOP)) alertInfo("请先登录或注册","index.php",0);
	$sqlStr="select * from qiyu_shop where shop_id=".$QIYU_ID_SHOP."";
	$result = mysql_query($sqlStr);
	$SHOP_INFOS=mysql_fetch_assoc($result);
	if($SHOP_INFOS){
		$SHOP_ACCOUNT=$SHOP_INFOS['shop_account'];
		//$SHOP_NAME=$SHOP_INFOS['shop_name'];
		$SHOP_ID2=$SHOP_INFOS['shop_id2'];
		$SHOP_CERTPIC=$SHOP_INFOS['shop_certpic'];
		$SHOP_LICENSEPIC=$SHOP_INFOS['shop_licensepic'];
		$SHOP_CERTTIME=$SHOP_INFOS['shop_certtime'];
		$SHOP_LICENSETIME=$SHOP_INFOS['shop_licensetime'];
		$SHOP_PHONE=$SHOP_INFOS['shop_phone'];
	}else{
		alertInfo("非法","index.php",0);
	}
?>