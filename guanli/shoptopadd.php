<?php
	/**
	 *  shopadd.php  
*/
	require_once("usercheck2.php");
	//$id=
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style.css" type="text/css"/>
<script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../js/tree.js" type="text/javascript"></script>
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript" src="js/shoptop.js"></script>
<title> 添加推荐菜 - 外卖点餐系统 </title>
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
				<div id="shopRight">
					<h1><a href="shoptop.php">推荐菜管理</a>&nbsp;&gt;&gt;&nbsp;添加推荐菜</h1>
					<div id="introAdd">
						<p style="margin-left:43px;color:red;">小提示：将您餐厅的招牌菜设置推荐,将在首页餐厅推荐的位置显示。</p>
						<form method="post" action="shop_do.php?act=topadd" >	
							<p><label>名称:</label><input type="text" id="name" name="name" class="input input179"/> *</p>
							<p><label>原价:</label><input type="text" id="price1" name="price1" class="input input179"/>元 *</p>
							<p><label>优惠价:</label><input type="text" id="price2" name="price2" class="input input179"/>元 *</p>
							<p><label>图片:</label><span id="loading" style="display:none;"><img src="../images/loading.gif" width="16" height="16" alt="loading" /></span><span id="upinfo" style="color:blue;"></span><input id="upfile1" name="upfile1" value="" type="hidden"/><input id="fileToUpload" type="file" name="fileToUpload" style="height:24px;"/> <input type="button" onclick="return ajaxFileUpload();" value="上传"/> * 大小186*125</p>
							<p id="pic1" style="margin-left:94px;"></p>
							<p><label>&nbsp;</label><input type="image" src="../images/button/submit_t.jpg" onClick="return check();"/></p>
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
