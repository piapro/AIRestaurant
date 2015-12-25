<?php
	/**
	 * userpw_do.php 注册操作
	 */
	 header("Content-type: text/html; charset=utf-8");
	require('include/dbconn.php');
	$o = new AppException();
	$act = sqlReplace($_GET['act']);
	
	switch ($act){
		case "send":
			$phone= sqlReplace($_GET['phone']);
			
			$vercodePhone=getRndCode_r(6);
			$_SESSION['sms_code']=$vercodePhone;
			$content=$SHOP_NAME."提示您，您的验证码是".$vercodePhone.",请在网站输入完成验证，有效期20分钟";
			$sql="select * from qiyu_user where user_phone='".$phone."'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				//发送验证码
				if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) || empty($phone) || $site_sms!='1')){
					$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
					$r_status=$result[0]->status;
					if ($r_status!=='no'){
						$userID2=$result[0]->id2;//用户ID2
						$sms=$o->getSMS($userID2);
						$s_status=$sms[0]->status;
						if ($s_status=='noBuy'){
							//echo "<a href='http://www.wiiyun.com' target='_blank'>还没有使用群发短信应用,请您先购买</a>";
						}else{
							//发送短信
							$data=array('reciver'=>$phone,'content'=>$content,'userID2'=>$userID2);
							$result=$o->sendSMS($userID2,$data);
							$time=date('Y-m-d H:i:s');
							$_SESSION['sms_sendTime']=$time;
							if ($result!='S'){
								echo "E";
								exit;
							}
							
						}
					}else{
						echo "E";
						exit;
					}
				}else{
					echo "E";
					exit;
				}
				echo "S";
				

			}else{
				echo "E";
			}
		break;
		case "check":
			$phone= sqlReplace($_GET['phone']);
			$sql="select * from qiyu_user where user_phone='".$phone."'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				echo "S";
			}else{
				echo "E";
			}
		break;
		case "regCheckPhone":
			$phone= sqlReplace($_GET['phone']);
			$sql="select * from qiyu_user where user_phone='".$phone."'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				echo "S|";
			}else{
				$vercodePhone=getRndCode_r(6);
				$content=$SHOP_NAME."提示您，您的注册验证码是".$vercodePhone;

				//sendCode($phone,$content);
				if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) || empty($phone) || $site_sms!='1')){
					$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
					$r_status=$result[0]->status;
					if ($r_status!=='no'){
						$userID2=$result[0]->id2;//用户ID2
						$sms=$o->getSMS($userID2);
						$s_status=$sms[0]->status;
						if ($s_status=='noBuy'){
							echo "H";
							exit;
						}else{
							//发送短信
							$data=array('reciver'=>$phone,'content'=>$content,'userID2'=>$userID2);
							$result=$o->sendSMS($userID2,$data);
							if ($result!='S'){
								echo "H";
								exit;
							}else{
								echo "E|".$vercodePhone;
							}
							
						}
					}else{
						echo "H";
						exit;
					}
				}else{
					echo "H";
					exit;
				}
				//echo "E|".$vercodePhone;
				
			}
		break;
		case "update":
			$phone= sqlReplace($_POST['phone']);
			$pw= sqlReplace($_POST['pw']);
			$pw2= sqlReplace($_POST['repw']);
			checkData($pw,'新密码',1);
			checkData($pw2,'确认密码',1);
			if ($pw!=$pw2){
				alertInfo("两次输入的密码不同","",1);
			}
			$sql="select * from qiyu_user where user_phone='".$phone."'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$vercode=getRndCode(6);
				$pw=md5(md5($pw.$vercode));
				$sqlStr="update qiyu_user set user_password='".$pw."',user_salt='".$vercode."' where user_phone='".$phone."'";
				mysql_query($sqlStr);
				alertInfo("修改成功，请登录","userlogin.php",0);
			}else{
				alertInfo("手机号不存在","userpw.php",0);
			}
		break;
		case "vali":
			$shopID=sqlReplace($_GET['shopID']);
			$phone=sqlReplace($_POST['phone']);
			$code=sqlReplace($_POST['code']);
			$sql="select * from qiyu_user where user_phone='".$phone."'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				if ($code==$rows['user_vcode']){
					$sqlStr="update qiyu_user set user_vcode='',user_status='1' where user_phone='".$phone."'";
					mysql_query($sqlStr);
					Header("Location: userorder.php?shopID=".$shopID);
				}else{
					alertInfo("验证码错误","",1);
				}
			}else{
				alertInfo("手机号不存在","",1);
			}
		break;
		case "checkCodeTime":
			$sendTime=$_SESSION['sms_sendTime'];
			$time=date('Y-m-d H:i:s');
			if (!empty($sendTime)){
				if (round((strtotime($time)-strtotime($sendTime))/60)>20){
					$_SESSION['sms_sendTime']='';
					$_SESSION['sms_code']='';
					echo '<label>&nbsp;</label><img src="images/button/getcode.gif" alt="获取" onclick="sendcode()" />';
				}else
					echo '<label>&nbsp;</label><img src="images/button/getcode_r.gif" alt=""  style="cursor:auto;"/>';
			}else{
				echo '<label>&nbsp;</label><img src="images/button/getcode.gif" alt="获取" onclick="sendcode()" />';
			}
		break;
	}
	
	
?>