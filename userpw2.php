<?php
	/**
	 *  userpw2.php 
	 */
	require_once("usercheck.php");
	$phone= sqlReplace($_POST['phone']);
	
	
	if($phone=='')
		alertInfo("非法操作","",1);
	if ($site_sms=='1'){
		$code= sqlReplace($_POST['code']);
		$s_code=$_SESSION['sms_code'];
		if($code=='') alertInfo("非法操作","",1);
	
		if ($s_code!=$code){
			
			alertInfo("验证码不匹配","userpw.php",0);
		}
		$_SESSION['sms_code']='';
		$_SESSION['sms_sendTime']='';
	}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/userpw.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<title> 找回密码 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
 <body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="orderBox" class="loginBox">
					<div class="order_title login_title">找回密码</div>
					<form method="post" action="userpw_do.php?act=update">
					
				
					<div style="padding-top:30px;padding-bottom:50px;">
						<div class="addList" >
							<div class="tip tip_r">
								<span>设置新的登录密码</span>
								<p>您申请了修改密码，为保护您的账号安全，请立即修 改为您常用的新的密码。</p>
							</div>
						</div><input type="hidden" name="phone" value="<?php echo $phone?>"/>
						<div class="addList addList_r forget"><label>新密码：</label><input type="password" id="pw" class="input" name="pw" /> 
						<span class="errormt"></span> 
						</div>
						<div class="addList addList_r forget"><label>再次确认密码：</label><input type="password" id="repw" class="input" name="repw" /> 
						<span class="errormt"></span> 
						</div>
						<div class="addList">
							<label>&nbsp;</label> <input type="image" src="images/button/submit5.gif" id="send" onClick="return checkPWD();"/>
						</div>
						
						<div class="clear"></div>
					</div><!--tab1-->
					</form>
				</div>
			</div>
			<div class="main_bottom"></div>
		</div><!--main_content完-->
		
	
	</div>
	
	<?php
		include("footer.php");
	?>
 </div>
 </body>
</html>
