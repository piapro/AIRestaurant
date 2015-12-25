<?php
	/**
	 *  shoptop.php  
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
  <title>推荐菜管理 - 外卖点餐系统</title>
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
					<h1>推荐菜管理</h1>
						<p style="margin-bottom:10px;color:red;margin-top:10px;">小提示：1、推荐菜是在首页餐厅推荐的位置显示。</p>
						<p style="margin-bottom:10px;color:red;margin-top:10px;margin-left:48px;">2、最多推荐5个，前台显示最新推荐的的3个推荐菜。</p>
						<p style="margin-top:20px;"><a href='shoptopadd.php'><img src="../images/button/shoptopadd.jpg"></a></p>
					
					<?php
						$i=1;
						$sql="select * from qiyu_food where food_shop=".$QIYU_ID_SHOP." and food_special='1' and food_status='0' order by food_order asc,food_id desc limit 5";
						$rs=mysql_query($sql);
						$rows=mysql_fetch_assoc($rs);
						if ($rows){
							while ($rows){
								switch ($i){
									case "1":
										$str="一";
									break;
									case "2":
										$str="二";
									break;
									case "3":
										$str="三";
									break;
									case "4":
										$str="四";
									break;
									case "5":
										$str="五";
									break;
								}
								if ($rows['food_isshow']=='0')
									$state="显示";
								else
									$state="隐藏";
								if ($rows['food_check']=='0')
									$state.=" 已审核";
								elseif ($rows['food_check']=='1')
									$state.=" 未审核";
					?>
					<div class="topBox">
						<div class="top_h1">推荐菜<?php echo $str?></div>
						<div class="top_main">
							<div class="t_left">
								<div class="ll_left">
									<div class="pic"><img src="../<?php echo $rows['food_pic']?>" width="186" height="125" alt="" /></div>
								</div>
								<div class="ll_right">
									<p><?php echo $rows['food_name']?></p>
									<p>原价<?php echo $rows['food_oldprice']?>,现价<?php echo $rows['food_price']?>元</p>
								</div>
								<div class="clear"></div>
							</div>
							<div class="t_right">
								<p><a href="javascript:if(confirm('您确定要删除吗？')){location.href='shop_do.php?act=topdel&id=<?php echo $rows['food_id']?>'}"><img src="../images/button/delete.jpg" alt="删除" /></a></p>
								<p><a href="shoptopedit.php?id=<?php echo $rows['food_id']?>"><img src="../images/button/edit.gif" alt="" /></a></p>
				<?php
							if ($rows['food_isshow']=='0'){
				?>
								<p><a href="shop_do.php?act=hidetop&id=<?php echo $rows['food_id']?>"><img src="../images/button/hide.gif"  alt="" /></a></p>
				<?php
							}else{
				?>
								<p><a href="shop_do.php?act=showtop&id=<?php echo $rows['food_id']?>"><img src="../images/button/show.gif"  alt="" /></a></p>
				<?php
							}	
				?>
								<p><a href="../shop.php?id=<?php echo $QIYU_ID_SHOP?>&see=ok" target="_black"><img src="../images/button/preview.gif" alt="" /></a></p>
							</div>
							<div class="clear"></div>
						</div>
					</div><!--topBox完-->
				<?php
							$i+=1;
							$rows=mysql_fetch_assoc($rs);
						}
					}else{
						echo "<p>亲，您还没有推荐菜，现在就添加推荐菜。</p>";
					}	
				?>
						
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
