<?php
	/**
	 *  index.php 
	 */
	require_once("usercheck.php");
	if(!empty($QIYU_ID_SHOP)) Header("Location: shopadd.php");
	$url=str_replace('/index.php','',getUrl());
	$n=strrpos($url,'/');
	$url=substr($url,0,$n);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/shopreg.js" type="text/javascript"></script>
  <title>商家登陆 - 外卖点餐系统</title>
 </head>
 <body>
 <div id="container">
	<?php
		require_once('header.php');
	?>
	<div id="main">
		
		<div class="main_content main_content_r">
			<div class="main_top"></div>
			<div class="main_center main_center_r" style="padding-bottom:30px;padding-top:50px;">
				<div id="shoplogin">
				<form method="post" action="shoplogin_do.php?act=login">
					<p style="padding-top:43px;margin:0"><label>账户名：</label><input type="text" name='account' id="account1" class="input"/> <span class="red">*</span></p>
					<p><label>密码：</label><input type="password" name="pw" id="pw1" class="input"/> <span class="red">*</span></p>
					<p><label>验证码：</label><input type="text" id="imgcode" name='imgcode' class="input" style="width:70px;"/> <img src="../include/imgcode.php" name="codeimage" id="codeimage" onclick="this.src='../include/imgcode.php?'+Math.random(1);" style="cursor:pointer;"> <a href="javascript:void();" onclick="codeimage.src='../include/imgcode.php?'+Math.random(1);" style="color:#3a3737;">换一张</a> <span class="red">*</span></p>
					<p class="submit"><input type="image" src="../images/button/login_red.gif" onClick="return checkReg();"/></p>
				</form>
				</div>
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
