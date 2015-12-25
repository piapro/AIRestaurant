<?php
	/**
	 *  shopverifyphone.php
	 */
	require_once("usercheck2.php");
	$phone=sqlReplace(trim($_POST['phone']));
	checkData($phone,'手机号',1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title> 验证手机号 - 外卖点餐系统 </title>
 </head>
 <body>
 <script type="text/javascript">
 <!--
	function sendCode(){
		var phone=$('#phone').val();
		$.post("shop.ajax.php", { 
			'phone'      :  phone,
			'act'     : 'sendcode'
			}, function (data, textStatus){
				if (data=="S"){
					alert('验证码已发送到手机，请注意查收');
				}else
					alert('发送失败');
						
		});
	 }

 //-->
 </script>
 <div id="container">
	<?php
		require_once('header.php');
	?>
	<div id="main">
		<div class="main_content main_content_r">
			<div class="main_top"></div>
			<div class="main_center main_center_r">
				<div id="shopLeft">
					<?php
						require_once('left.inc.php');
					?>
				</div>
				<div id="shopRight">
					<h1>修改手机号</h1>
					<div id="introAdd">
					<form method="post" action="shop_do.php?act=updatePhone">
						
					
						<p><label class="label_214">您的手机号：</label><input type="text" id="phone" name="phone" value="<?php echo $phone?>" style="background-color:#e4e4e4;" class="input input179" readonly/> <a href="shopupdatephone.php" class="blue">更换手机号</a></p>
						<p><label class="label_214">&nbsp;</label><img src="../images/button/getcode.gif" alt="" onClick="sendCode()"/></p>
						<p><label class="label_214">您收到的验证码：</label><input type="text" name="code"   class="input input179" /></p>
						<p><label class="label_214">&nbsp;</label>3分钟还没收到验证码？<a href="javascript:void();" class="blue" onClick="sendCode()">重新获取验证码</a></p>
						<p><label class="label_214">&nbsp;</label><input type="image" src="../images/button/verify.gif" /></p>
					</form>
					</div>	
				</div>
				<div class="clear"></div>
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
