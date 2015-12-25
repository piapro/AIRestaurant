<?php 
	/**
	 *  shop_do.php  
	 */
	require_once("usercheck2.php");
	$o = new AppException();
	$salt=sqlReplace(trim($_POST['salt']));
	$sms=sqlReplace(trim($_POST['sms']));
	$account=sqlReplace(trim($_POST['account']));
	$phone=sqlReplace(trim($_POST['phone']));
	checkData($account,"微云账号",1);
	checkData($salt,"微云码",1);
	checkData($phone,"手机",1);

	//检查这个码是否存在
	$result=$o->checkWiiyunSalt($salt,$account);
	$s_status=$result[0]->status;
	if ($s_status=='no'){
		alertInfo('账号与微云码不匹配','',1);
		exit;
	}else{
		$sql="update qiyu_shop set shop_phone='".$phone."'  where shop_id=".$QIYU_ID_SHOP."";
		mysql_query($sql);
		$sql="update ".WIIDBPRE."_site set site_wiiyunsalt='".$salt."',site_wiiyunaccount='".$account."',site_sms='".$sms."'";
		if (mysql_query($sql)){
			alertInfo('操作成功','',1);
		}else{
			alertInfo('出错','',1);
		}
	}

	
	
	

	
?>