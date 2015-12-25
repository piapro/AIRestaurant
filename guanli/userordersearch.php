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
  <script type="text/javascript" src="js/shoptop.js"></script>
  <title> 订单搜索 - 外卖点餐系统 </title>
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
					<h1>订单搜索</h1>
					<div id="introAdd">
						<form  name="listForm" method="get" action="userorder.php"  id="listForm">
							<p><label>起始时间</label> <input type="text" name="start"  class="in1"/> 格式为：2012-09-12</p>
							<p><label>结束时间</label> <input type="text" name="end"  class="in1"/> 格式为：2012-09-12</p>
							<p><label>用户姓名</label> <input type="text" name="name"  class="in1"/></p>
							<p><label>用户手机</label> <input type="text" name="phone"  class="in1"/></p>
							<p><label>订单号</label> <input type="text" name="order"  class="in1"/></p>
							<p><label>订单状态</label> <select name="key">
								<option value="all">全部</option>
								<option value="0">未确认</option>
								<option value="1">已确认</option>
								<option value="2">商家取消</option>
								<option value="3">用户取消</option>
								<option value="4">已完成</option>
								<option value="5">已修改</option>
							</select></p>
							<p style="margin-left:94px;"><input type="image" src="../images/button/search.gif" /></p>
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
