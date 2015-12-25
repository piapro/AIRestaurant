<?php
	require_once("usercheck.php");

	//if( isset($_SESSION['last_key']) ) header("Location: weibolist.php");
	$p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	$shopID=empty($_GET['shopID'])?'0':sqlReplace(trim($_GET['shopID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['shopCircle'])?'0':sqlReplace(trim($_GET['shopCircle']));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<script type="text/javascript" src="js/bxCarousel.js"></script>
<title> 用户登录 -<?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
 <script type="text/javascript">
	function login(){
		var user_account = $("#z_phone").val();
		var pw = $("#pw").val();
		if (user_account==''){
			TINY.box.show('手机号不能为空。',0,160,60,0,10);
			$("#z_phone").focus();
			return false;
		}
		if (pw==''){
			TINY.box.show('密码不能为空。',0,160,60,0,10);
			$("#pw").focus();
			return false;
		}
	}
	$(function(){				
			$("#loginButton").hover(function(){
							 $(this).attr('src','images/button/login_1.gif');
					 },function(){
							 $(this).attr('src','images/button/login.gif');
			});
			$("#loginButton").mousedown(function(){
			  $(this).attr('src','images/button/login_2.gif');
			  
			});
		})
		$(function(){				
			$("#regButton").hover(function(){
							 $(this).attr('src','images/button/reg_1.gif');
					 },function(){
							 $(this).attr('src','images/button/reg.gif');
			});
			$("#regButton").mousedown(function(){
			  $(this).attr('src','images/button/reg_2.gif');
			  
			});
		})
		$(function(){				
			$("#sina_button").hover(function(){
							 $(this).attr('src','images/button/sina_1.jpg');
					 },function(){
							 $(this).attr('src','images/button/sina.jpg');
			});
			$("#sina_button").mousedown(function(){
			  $(this).attr('src','images/button/sina_2.jpg');
			  
			});
		})
</script>
 <body>
 <div id="container">
	<?php
		include("header_index.php");
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="orderBox" class="loginBox">
					<div class="order_title login_title" style='margin-bottom:100px;'><?php if (!empty($p)) echo "亲 需要登陆才能继续点餐哦！";else echo "登陆"?></div>
					<div id="left_new" >
						<form method="post" action="userlogin_do.php?p=<?php echo $p?>&shopID=<?php echo $shopID?>&shopSpot=<?php echo $shopSpot?>&shopCircle=<?php echo $shopCircle?>">
						<div class="addList" style="margin-top:19px;"><label>手机号：</label><input type="text" id="z_phone" name="z_phone" class="input"  value="<?php echo $QIYU_USER_ACCOUNT?>" /><span id="prompt" style="color:red;position:absolute;left:210px;top:150px;"></span></div>
						<div class="addList"><label>密码：</label><input type="password" id="pw" name="pw" class="input"/> <a href="userpw.php" class="red">忘记密码</a></div>

						<div class="addList"><label>&nbsp;</label><input type="checkbox"  name="re_name" id="re_name" value="yes" checked/> 记住用户名 <input type="checkbox"  name="cookie" id="cookie" value="yes" checked /> 自动登录</div>
						<div class="send"><input type="image" id="loginButton"  src="images/button/login.gif" alt="登录" onclick="return login();" hidefocus="true" style="outline:none;"/></div>

					</div><!--leftwan-->
					<div id="right_new" style='height:450px;'>
						<p class="center" style="margin-top:0;"><img src="images/ask.jpg"  alt="" /></p>
						<p class="center"><a href="userreg.php?p=<?php echo $p?>&shopID=<?php echo $shopID?>&shopSpot=<?php echo $shopSpot?>&shopCircle=<?php echo $shopCircle?>" hidefocus="true" style="outline:none;"><img src="images/button/reg.gif" alt="注册" id="regButton" /></a></p>
						<p style="text-align:center;">注册以后，就可以在网上订想吃的外卖了!</p>
					</div>
					<div class="clear"></div>
					<div class="botton_bg">
						<img src="images/b_bg.jpg" width="308" height="88" alt="" class="pic_bg"/>
					</div>
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
