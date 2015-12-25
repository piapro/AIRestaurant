<?php 
	/**
	 *  shopreg_do.php 
	 */
	require_once("../include/dbconn.php");
	$act=sqlReplace(trim($_GET['act']));
	switch ($act){
		case "login":
			$account=sqlReplace(trim($_POST['account']));
			$pwd=sqlReplace(trim($_POST['pw']));
			checkData($account,'用户名',1);
			checkData($pwd,'密码',1);
			$code=sqlReplace(trim($_POST["imgcode"]));//验证码
			if(empty($code)){
				alertInfo('验证码不能为空',"",1);
			}
			if($code!=$_SESSION['imgcode']){
				alertInfo('验证码不正确，请检查！',"",1);
			}

			$sql="select * from qiyu_shop where shop_account='".$account."'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$salt=$rows['shop_salt'];
				$pw=md5(md5($pwd).$salt);
				$sqlStr="select * from qiyu_shop where shop_account='".$account."' and shop_password='".$pw."'";
				$rs_r=mysql_query($sqlStr);
				$row=mysql_fetch_assoc($rs_r);
				if ($row){
					setcookie("QIYUSHOP",$rows['shop_account'],time()+60*60*24*7);
					setcookie("QIYUSHOPVERD",md5($pw.$salt),time()+60*60*24*7);
					$_SESSION['qiyu_shopID']=$rows['shop_id'];
					Header("Location: admin.php");
				}else{
					alertInfo("密码错误","",1);
				}
			}else{
				alertInfo("用户名不存在","",1);
			}
		break;
		
	}
	

	
?>