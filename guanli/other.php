<?php
	/**
	 *  网站基本设置
	 */
	require_once("usercheck2.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style.css" type="text/css"/>
<script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../js/tree.js" type="text/javascript"></script>
<script type="text/javascript" src="js/upload.js"></script>
<title> 网站设置 - 外卖点餐系统 </title>
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
					<h1>网站设置</h1>
					<div id="introAdd" >
						<form method="post" action="site_do.php?act=other">
							
							<p class="clear">
								<label>客服QQ号码：</label>
								<input style="width:215px" type="text" id="icp" name="onlinechat" class="input input270" value="<?php echo $site_onlinechat?>"/> (输入在线客服QQ号码) &nbsp;&nbsp;
							</p>
							<p class="clear">
							   <label>站长统计：</label>
							   <textarea cols="23" rows="4" name="stat"><?php echo $site_stat?></textarea> (输入站长统计代码) 
							</p>
							<p style="margin-left:15px;">
							   开启添加购物车的餐品备注：
							   <input type="radio" name="iscartfoodtag" value="1" <?php if($site_iscartfoodtag=='1') echo 'checked';?>>&nbsp;是&nbsp;&nbsp;
							   <input type="radio" name="iscartfoodtag" value="2" <?php if($site_iscartfoodtag=='2') echo 'checked';?>>&nbsp;否
							</p>
							<p class="clear">
							   <label>餐品备注：(需要开启)</label>
							</p>
							<p><textarea name="cartfoodtag" cols="23" rows="4"><?php echo $site_cartfoodtag;?></textarea> (请用英文分号“;”隔开)</p>											
							<p><label >&nbsp;</label><input type="image" src="../images/button/submit_t.jpg"  /></p>
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
