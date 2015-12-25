<?php
	/**
	 *  shopadd.php
	 */
	require_once("usercheck2.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <script type="text/javascript" src="js/shopadd.js"></script>
  <title> 餐厅信息管理 - 外卖点餐系统 </title>
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
					<h1>餐厅信息管理</h1>
					<div id="introAdd">
						
						<form method="post" action="shop_do.php?act=base">
						<p><label>餐厅名称:</label><input type="text" id="name" name="name" class="input input270" value="<?php echo $SHOP_INFOS['shop_name']?>" /> *</p>
						
						<p>
							<label>餐厅地址:</label>
							 <input type="text" id="address" name="address" class="input input270" value="<?php if(empty($SHOP_INFOS['shop_address'])){echo '请输入你的店铺地址';}else{echo $SHOP_INFOS['shop_address'];}?>"/> *
						</p>
						
						<p><label>餐厅电话:</label><input type="text" id="tel" name="tel" class="input input179" value="<?php echo $SHOP_INFOS['shop_tel']?>"/> *</p>
						<p><label>营业开始时间:</label><input type="text" id="opentime" name="opentime" class="input input179" value="<?php echo substr($SHOP_INFOS['shop_openstarttime'],0,5)?>"/> * (例如：09:00)</p>
						<p><label>营业结束时间:</label><input type="text" id="endtime" name="endtime" class="input input179" value="<?php echo substr($SHOP_INFOS['shop_openendtime'],0,5)?>"/> * (例如：22:30)</p>
						<p><label>主营食物：</label><input class="input input179" type="text" id="mainfood" name="mainfood" maxlength="16" value="<?php echo $SHOP_INFOS['shop_mainfood']?>"/> （最多16个字符）*</p>

						
						<p><label>餐厅介绍:</label><textarea id="intro" name="intro" class="input input578" style="height:53px;resize:none;"><?php if(empty($SHOP_INFOS['shop_intro'])){echo '200字以内';}else{echo $SHOP_INFOS['shop_intro'];}?></textarea> *</p>
						
						<p><label>&nbsp;</label><input type="image" src="../images/button/submit_t.jpg"  onClick="return check()"/></p>
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
