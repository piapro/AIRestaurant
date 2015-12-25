<?php
	/**
	 *  userpw3.php
	 */
	require_once("usercheck.php");
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
<title> 找回密码 - <?php echo $SHOP_NAME?> </title>
</head>
<body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div id="shadow"><img src="images/shadow.gif" width="955" height="9" alt="" /></div>
		<div id="tab5">
			<ul>
				<li id="t1"><img src="images/tab_reg.gif" alt="" /></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="main_content main_content_r">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="pointer">您现在的位置: <a href="index.php">首页</a> &gt;&gt; 找回密码</div>
				<div id="tab_box_r" class="inforBox" >
				<form method="post" action="userpw2.php">
					<div style="padding-top:30px;padding-bottom:50px;">
						<div class="addList" >
							<div class="tip"><img src="images/icon3.gif" alt="" />为了保护您的账户安全，请先进行手机验证。</div>
						</div>
						<div class="addList addList_r forget"><label>手机号：</label><input type="text" id="phone1" class="input" name="phone" /> 
						<span class="errormt"></span> 
						</div>
						<div class="addList">
							<label>&nbsp;</label> <img src="images/button/sendvali.gif" alt="" onClick="sendcode()"/>
						</div>
						<div class="addList" id="codeTip" style="display:none;">
							<label>&nbsp;</label> <span class="habebg red">验证码已发送，请注意查收！</span>
						</div>
						<div class="addList addList_r forget"><label>验证码：</label><input type="text" id="code" class="input" name="code" />
						
						</div>
						<div class="addList">
							<label>&nbsp;</label> <input type="image" src="images/button/submit3.gif" id="send"  onClick="return check();"/>
						</div>
						
						<div class="clear"></div>
					</div><!--tab1-->
					</form>
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
