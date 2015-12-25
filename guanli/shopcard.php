<?php
	/**
	 *  shopcard.php
	 */
	require_once("usercheck2.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title>证照信息上传 - 外卖点餐系统</title>
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
					<h1>餐厅证照</h1>

					<div id="introAdd">
						<div class="moneyTable feeTable" style="width:668px;margin-top:0px;padding-top:0">
							<p style="color:red;margin-top:20px;margin-bottom:20px;">小提示：可以在“网站设置”里设置前台是否显示餐厅证照。</p>
							<table width="100%">
								<tr>
									<td class="center" width='100'>名称</td>
									<td class="center"  width='468'>图片</td>
									<td class="center"  width='100'>操作</td>
								</tr>
										
								<tr>
									<td class="center">营业执照</td>
									<td class="center" style='padding:20px 0;'>
									<?php 
										if (empty($SHOP_CERTPIC)){
											echo "<img src='../images/default_cart1.jpg'/>";
										}else{
											echo "<img src='../userfiles/license/small/". $SHOP_CERTPIC."' width='200' height='150'/>";
										}
									?>
									</td>
									<td class="center">
										<a href="shopcardedit.php?type=1">修改</a> 
									</td>
								</tr>
								<tr>
									<td class="center">卫生许可证</td>
									<td class="center" style='padding:20px 0;'>
									<?php 
										if (empty($SHOP_LICENSEPIC)){
											echo "<img src='../images/default_cart2.jpg'/>";
										}else{
											 echo "<img src='../userfiles/license/small/". $SHOP_LICENSEPIC."' width='200' height='150'/>";
										}
									?>
									</td>
									<td class="center">
										<a href="shopcardedit.php?type=2">修改</a> 
									</td>
								</tr>
											
							</table>
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
