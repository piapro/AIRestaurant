<?php
	/**
	 *  userorderscore2.php
	 */
	require_once("usercheck2.php");
	$POSITION_HEADER="用户中心";
	$id=sqlReplace(trim($_GET['id']));
	checkData($id,'id',1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<title> 用户中心 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
<body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="orderBox">
					<div class="order_title login_title">订单评价</div>
					<div class="table">
							<table>
								<tr>
									<td width="135" class="metal">订单时间</td>
									<td width="185" class="metal borderLeft">餐厅名称</td>
									<td width="137" class="metal borderLeft">外卖菜品</td>
									<td width="180" class="metal borderLeft">订单号</td>
									<td width="100" class="metal borderLeft">金额</td>
									<td width="177" class="metal borderLeft">状态</td>
		
								</tr>
							<?php
								$sql="select * from qiyu_order,qiyu_shop where (shop_id2=order_shop or shop_id=order_shopid) and order_id=".$id;
								$rs=mysql_query($sql);
								$rows=mysql_fetch_assoc($rs);
								if ($rows){
									$order=$rows['order_id2'];
									$shop=$rows['shop_id'];
							?>
								<tr>
									<td class="borderBottom borderLeft" ><?php echo substr($rows['order_addtime'],0,10)?></td>
									<td class="borderBottom borderLeft"><?php echo $rows['shop_name']?></td>
									<td class="borderBottom borderLeft"><a href="userorderintro.php?id=<?php echo $rows['order_id']?>&key=new" class="red">查看详情</a></td>
									<td class="borderBottom borderLeft"><?php echo $rows['order_id2']?></td>
									<td class="borderBottom borderLeft"><?php echo $rows['order_totalprice']?></td>
									<td class="borderBottom borderRight borderLeft red">
										<?php echo $orderState[$rows['order_status']]?>
									</td>
									
								</tr>
							<?php
								}		
							?>
								
							</table>
					</div>
					<div class="success success_r" style="padding-bottom:100px;">
						<p><span class="red">亲爱的用户，您对本次订单的评价已成功提交！</span>感谢您的支持和反馈！ </p>
						<?php
							$sql="select * from qiyu_userscore where userscore_order='".$order."'";
							$rs=mysql_query($sql);
							$rows=mysql_fetch_assoc($rs);
							if ($rows){
								$total=$rows['userscore_total'];
								$test=$rows['userscore_test'];
								$speed=$rows['userscore_speed'];
							}
						?>
						<div class="grayBox">
							<p>总体满意度：<span><?php echo $SCORETOTAL[$total]?></span> 
							<?php
								for($i=0;$i<$total/2;$i++){
									echo "<img src=\"images/star_1_1.gif\" alt=\"\" /> ";
								}
								if ($total/2<5){
									$j=5-$i;
									for ($s=1;$s<=$j;$s++){
										echo "<img src=\"images/star_1_0.gif\" alt=\"\" /> ";
									}
								}
							?>
							</p>
							<p>餐点品质：<span><span><?php echo $SCORETEST[$test]?></span> 
							<?php
								for($i=0;$i<$test/2;$i++){
									echo "<img src=\"images/star_1_1.gif\" alt=\"\" /> ";
								}
								if ($test/2<5){
									$j=5-$i;
									for ($s=1;$s<=$j;$s++){
										echo "<img src=\"images/star_1_0.gif\" alt=\"\" /> ";
									}
								}
							?></p>
							<p>送餐速度：<span><?php echo $SCORESPEED[$speed]?></span> 
							<?php
								for($i=0;$i<$speed/2;$i++){
									echo "<img src=\"images/star_1_1.gif\" alt=\"\" /> ";
								}
								if ($speed/2<5){
									$j=5-$i;
									for ($s=1;$s<=$j;$s++){
										echo "<img src=\"images/star_1_0.gif\" alt=\"\" /> ";
									}
								}
							?>
							</p>
							<a href="#" style="" class="sina">微博晒订单</a><a href="fav_do.php?spid=<?php echo $shop?>&uid=<?php echo $QIYU_ID_USER?>&act=add"><img src="images/button/collect2.jpg" alt="" class="collect"/></a>
						</div>		
						
					</div>
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
