<?php
/**
 * 短信群发 sendsms_do.php
 */ 
	require_once("usercheck2.php");
	require_once("inc/function.php");
	require_once("../include/function_common.php");
	$o = new AppException();
	//require_once('user_sendsms_page.php');
	
	 if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) ||  $site_sms!='1')){
		
		//	检测微云码与账号是否正确
		$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
		$r_status=$result[0]->status;
		if ($r_status!='no'){
			$userID2=$result[0]->id2;//用户ID2
			
			$sms=$o->getSMS($userID2);
			$s_status=$sms[0]->status;	
			$smsCount=$sms[0]->count_m;
		}	
		
	}  

	if (empty($userID2)){
		alertInfo('短信未配置，请配置',"site_sms.php",0);
	}

	$tags=sqlReplace(trim($_POST['receiver']));//收件人
	$tags=str_replace('；',';',$tags);
	$tags=str_replace('#','',$tags);
	$tags=str_replace('$','',$tags);
	//$total=sqlReplace(trim($_GET['total']));//此次发送的数量
	
	$emailstr=sqlReplace(trim($_POST['receiver']));//收件人
	
	$emailstr=str_replace('；',';',$emailstr);
	
	$content=sqlReplace(trim($_POST['fbContent']));//短信内容

	checkData($emailstr,'收件人',1);
	checkData($content,'短信内容',1);
	//对收件人$emailstr进行处理
	$alltel='';
	$tgs='';
	if($emailstr){
		$emailarr=explode(';',$emailstr);
		$i=0;
		$j=0;
		$total=0;
		foreach($emailarr as $t){
			if($t){
				
				$email='';
				$tg='';
				//if(preg_match('/#(.*?)#/',$t,$info)){
				$substr_t=substr($t,0,1);
				
				if($substr_t=='#'){
					
				}else{
					$j++;
					$email.=$t.';';
				}
				$alltel.=$email;
			}
		}
		$total=$i+$j;
	}
	if ($smsCount>=$total)
		$c=$total;
	else
		$c=$smsCount;
	
	$salt=volemail_random(4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> 短信群发 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Jiangting@WiiPu -- http://www.wiipu.com" />
<link rel="stylesheet" href="../style.css" type="text/css"/>
<script type="text/javascript" src="js/jquery-1.6.min.js"></script>
<script src="js/sendsms.js" type="text/javascript"></script>
<script src="../js/tree.js" type="text/javascript"></script>
<script type="text/javascript" src="js/upload.js"></script>
<title> 短信群发 - 外卖点餐系统 </title>
</head>

 <body>
 <div id="container">  
	<?php
		require_once('header.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center main_center_r">
				<div id="shopLeft">
				    
					<?php
						require_once('left.inc.php');
					?>
				</div>

				   <div class="bgintor">
					  <h1>群发短信</h1>
					<div class="listintor">							
						</div>
						<div class="fromcontent" style="text-align:center;height:500px;">
							<p>此次共发送短信：<span id="realspan">0/</span><?php echo $total?> 条</p>
							<p>
							   <span id="redcount" style="color:red;">
							      <img src="../images/loading.gif" width="16" height="16" alt="" />开始发送短信
							   </span> 
							   <span class="red" id="error_mm" style='display:none;'>以下
							      <span id="error_email"></span>
								  发送失败
							   </span>
							</p>
							<div class="btn">
								<br/><a href="userlist.php"><img src="../images/button/goback.gif" /></a>
							</div>
						</div>
					</div>
				   </div>
            </div>
        </div>
    </div>
 </div>
 </div>
   <script type="text/javascript">
		var tel_str='<?php echo $alltel?>';
		var content='<?php echo $content?>';
		var k=0;
		var x=1;//发送到第m条
		var err='';
		var tel_str=tel_str.replace('；',';');//中文；号替换成英文;号
		var tel_str=tel_str.split(";"); //字符分割
		var c='<?php echo $total?>';//
		var t='<?php echo $c?>';//可以发送的数量
		var tag='<?php echo $tags?>';
		var salt='<?php echo $salt?>';
		act();
 //-->

 </script>
 </body>
</html>