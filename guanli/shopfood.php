<?php
	/**
	 *  shopfood.php
	 */
	require_once("usercheck2.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title>订单管理 - 外卖点餐系统</title>
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
					<h1>编辑餐厅菜单信息</h1>
					<div id="process">
						<img src="../images/shop/1_2.jpg" alt="" />
						<img src="../images/shop/2_1.jpg"  alt="" />
						<img src="../images/shop/3_0.gif" alt="" />
						<div class="clear"></div>
					</div>
					<div id="introAdd">
						<h1 class="h1">添加一个大类</h1>
						<p><input type="text" id="name" name="name" class="input input179"/></p>
						<p><img src="../images/button/sure.jpg" width="98" height="23" alt="" /></p>
						<div class="red" style="margin-top:30px;font-size:14px;">添加菜单分类后</div>
						<div class="moneyTable" >
							<table border='0'  style="border:1px #000 solid; background-color:#e4e4e4;">
								<tr height="30">
									<td width="110" class="noBorder" style="padding-left:10px;">凉菜</td>
									<td width="80" class="noBorder"><img src="../images/button/update.jpg" alt="" /></td>	
									<td width="80" class="noBorder"><img src="../images/button/del.jpg" alt="" /></td>
									<td width="110" class="noBorder"><img src="../images/button/addnew.jpg" alt="" /></td>
								</tr>
								<tr height="30">
									<td width="110" class="noBorder" style="padding-left:10px;">凉菜</td>
									<td width="80" class="noBorder"><img src="../images/button/update.jpg" alt="" /></td>	
									<td width="80" class="noBorder" ><img src="../images/button/del.jpg" alt="" /></td>
									<td width="110" class="noBorder"><img src="../images/button/addnew.jpg" alt="" /></td>
								</tr>
								<tr height="30">
									<td width="110" class="noBorder" style="padding-left:10px;">凉菜</td>
									<td width="80" class="noBorder"><img src="../images/button/update.jpg" alt="" /></td>	
									<td width="80" class="noBorder" ><img src="../images/button/del.jpg" alt="" /></td>
									<td width="110" class="noBorder"><img src="../images/button/addnew.jpg" alt="" /></td>
								</tr>
							</table>
							<table border='0' style="border:0">
								<tr height="30">
									<td width="100" class="noBorder">菜名</td>
									<td width="80" class="noBorder">价格</td>	
									<td width="80" class="noBorder">标签</td>
									<td width="100" class="noBorder">状态</td>
								</tr>
								<tr height="30">
									<td width="100" class="noBorder"><input type="text" id="" class="input input_79"/></td>
									<td width="100" class="noBorder"><input type="text" id="" class="input input_79"/></td>	
									<td width="100" class="noBorder" ><select id="" class="input input_79">
										<option value="" selected="selected"></option>
										<option value=""></option>
									</select></td>
									<td width="100" class="noBorder"><select id="" class="input input_79">
										<option value="" selected="selected"></option>
										<option value=""></option>
									</select></td>
								</tr>
								<tr height="30">
									<td width="100" class="noBorder"><input type="text" id="" class="input input_79"/></td>
									<td width="100" class="noBorder"><input type="text" id="" class="input input_79"/></td>	
									<td width="100" class="noBorder" ><select id="" class="input input_79">
										<option value="" selected="selected"></option>
										<option value=""></option>
									</select></td>
									<td width="100" class="noBorder"><select id="" class="input input_79">
										<option value="" selected="selected"></option>
										<option value=""></option>
									</select></td>
								</tr>
							</table>
							<p><img src="../images/button/sure.jpg" width="98" height="23" alt="" /></p>
						</div>
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
