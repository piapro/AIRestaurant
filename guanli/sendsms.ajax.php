<?php
/**
 * sendsms.ajax.php  

 */

require_once("usercheck2.php");
require_once("inc/function.php");
$o = new AppException();

 if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) ||  $site_sms!='1')){
		
		//	检测微云码与账号是否正确
		$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
		$r_status=$result[0]->status;
		if ($r_status!='no'){
			$userID2=$result[0]->id2;//用户ID2		
		}	
		
	}  

if (empty($userID2)){
	alertInfo('短信未配置，请配置',"site_sms.php",0);
}

$content=sqlReplace(trim($_POST['content']));
$tel=sqlReplace(trim($_POST['tel']));
$tag=sqlReplace(trim($_POST['tag']));
//$salt=sqlReplace(trim($_POST['salt']));

//发送短信
$err_str='';//错误信息

//发短信 sendCode($phone,$content)
//sendCode($tel,$content);
$data=array('reciver'=>$tel,'content'=>$content,'userID2'=>$userID2);
if($site_sms=='1'){
    $result=$o->sendSMS($userID2,$data);
	echo $result;
 }else{
	alertInfo('短信功能未开启，请配置',"site_sms.php",0);
    
 }

?>