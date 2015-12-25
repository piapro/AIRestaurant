<?php
	/**
	 *  shoptop.php
	 */

	require_once("usercheck2.php");
	$id=sqlReplace(trim($_GET['id']));
	$sql="select * from qiyu_food where food_id=".$id." and food_shop=".$QIYU_ID_SHOP;
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$name=$rows['food_name'];
		$price2=$rows['food_price'];
		$price1=$rows['food_oldprice'];
		$pic=$rows['food_pic'];
	}else{
		alertInfo("非法","",1);
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/shoptop.js"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <title>推荐模块 - 外卖点餐系统</title>
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
					<h1><a href="shoptop.php">推荐菜管理</a> &gt;&gt; 修改推荐菜</h1>
					<div id="introAdd">
						
						<form method="post" action="shop_do.php?act=topedit&id=<?php echo $id?>" id="form1">
							<p><label>名称:</label><input type="text" id="name" name="name" class="input input179" value="<?php echo $name?>"/> *</p>
							<p><label>原价:</label><input type="text" id="price1" name="price1" value="<?php echo $price1?>" class="input input179"/>元 *</p>
							<p><label>优惠价:</label><input type="text" id="price2" value="<?php echo $price2?>" name="price2" class="input input179"/>元 *</p>
							<p><label>图片1:</label><span id="loading" style="display:none;"><img src="../images/loading.gif" width="16" height="16" alt="loading" /></span><span id="upinfo" style="color:blue;"></span><input id="upfile1" name="upfile1" value="<?php echo $pic?>" type="hidden"/><input id="fileToUpload" type="file" name="fileToUpload" style="height:24px;"/> <input type="button" onclick="return ajaxFileUpload();" value="上传"/> * 大小186*125</p>
							<p style="margin-left:94px;" id="pic1"><img src="../<?php echo $pic?>" width="186" height="125" alt="" /></p>
							<p><label>&nbsp;</label><input type="image" src="../images/button/edit2.gif" onClick="return check();"/> <input type="image" src="../images/button/preview.gif" onclick="return browse();"/></p>
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
 <script type="text/javascript">
 <!--
	function browse(){
		$.post("shop.ajax.php", { 
						'id' :  <?php echo $id?>,
						'name' :  $('#name').val(),
						'price1' :  $('#price1').val(),
						'price2' :  $('#price2').val(),
						'pic'    :  $('#upfile1').val(),
						'act':'browse'
					}, function (data, textStatus){
						if (data=="S")
							window.open('../shop.php?see=ok&id=<?php echo $QIYU_ID_SHOP?>');
						else
							alert('意外出错');
						
					});
			return false;
	}
 //-->
 </script>
 </body>
</html>
