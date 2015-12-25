<?php
	require_once("usercheck.php");
	$shopID=sqlReplace(trim($_GET['shopID']));
	$sql="select * from qiyu_shop where shop_id=".$shopID." and shop_status='1'";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if (!$rows){
		alertInfo("错误","index.php",0);	
	}
	if (!empty($QIYU_ID_USER)){
		$sqlStr="select * from qiyu_user where user_id=".$QIYU_ID_USER;
		$result = mysql_query($sqlStr);
		$row=mysql_fetch_assoc($result);
		if($row){
			$user_phone=$row['user_phone'];
		}
	}else{
		$user_phone=$_SESSION['user_phone'];
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="style.css" type="text/css"/>
  <script src="js/jquery-1.3.1.js" type="text/javascript"></script>
  <title> 验证手机号 - <?php echo $SHOP_NAME?> - <?php echo $powered?></title>
 </head>
 <body>
 <script type="text/javascript">
//<![CDATA[

function sendcode(){
		 $.get("userpw_do.php", { 
							'act'   :  "send",
							'phone' :  $('#phone').val()
							}, function (data, textStatus){
									if (data=="S")
									{
										$("#codeTip").css('display','block');
									}else{
										 var errorMsg = '手机号不存在';
										$parent.find('.red').text(errorMsg);
										$parent.find('.red').addClass('onError');
									}
									
									
		});
	 }



	
//]]>
</script>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div id="shadow"><img src="images/shadow.gif" width="955" height="9" alt="" /></div>
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="tab_box_r" class="inforBox">
				<div class="big_title">验证手机号</div>
					<div id="loginLeft">
					<form method="post" action="userpw_do.php?shopID=<?php echo $shopID?>&act=vali">
						
					
						
						<div class="addList addList_r loginlist" style="margin-top:0;padding-top:10px;">
							<label>您的手机号：</label><input type="text" name="phone" id="phone" class="input" style="background-color:#e7e7e7;" readonly value="<?php echo $user_phone?>"/> 
						</div>
						<div class="addList loginlist">
							<label>&nbsp;</label> <span><img src="images/button/sendvali.gif" alt="" onClick="sendcode()"/></span>
						</div>
						<div class="addList loginlist" id="codeTip" style="display:none;">
							<label>&nbsp;</label> <span class="habebg red">验证码已发送，请注意查收！</span>
						</div>
						<div class="addList addList_r loginlist" style="margin-top:0;padding-top:10px;">
							<label>验证码：</label><input type="text" name="code" id="code" class="input" /> 
						</div>
						
					
						<div class="addList loginlist">
							<input type="image" src="images/sure.gif" style="margin-left:199px;" id="send"/>
						</div>
						</form>
					</div><!--leftwan-->
					<div id="loginRight" class="loginRight_r">
						<p>已经注册了<?php echo $SHOP_NAME?>账号？ <a href="userlogin.php">立刻登录</a></p>
						<p style="margin-top:50px;">还没有<?php echo $SHOP_NAME?>账号？ <a href="userreg.php">马上注册一个</a></p>
						<p style="margin-top:5px;"><span>注册<?php echo $SHOP_NAME?>账号，即可体验快捷点餐<br/>的便利， 享受网站的各项优惠折扣。</span></p>
					</div>
					<div class="clear"></div>
				</div><!--tab_box_r-->
				
				
			</div>
			<div class="main_bottom"></div>
		</div><!--main_content完-->
		
	
	</div>
	
	<?php
		require_once('footer.php');
	?>
	
 </div>
 </body>
</html>
