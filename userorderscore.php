<?php
	/**
	 *  usercenter.php
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
					<div class="order_title  login_title" style="margin-top:26px;"><img src="images/s_h1.jpg"  alt="" /></div>
					<div class="contact"><span class="blank">总体满意度：</span>（对本次订单的整体满意度进行评价）</div>
					<form method="post" action="usercenter_do.php?act=scoreAdd&id=<?php echo $id?>">
					<div class="contact scoreList">
						<input type="radio" name="total" value="10" checked/> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" />  非常满意
					</div>
					<div class="contact scoreList">
						<input type="radio" name="total" value="8" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  比较满意
					</div>
					<div class="contact scoreList">
						<input type="radio" name="total" value="6" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  一般
					</div>
					<div class="contact scoreList">
						<input type="radio" name="total" value="4" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  不太满意
					</div>
					<div class="contact scoreList">
						<input type="radio" name="total" value="2" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  很不满意
					</div>
					<div class="contact" style="border-top:1px #dcdcdc solid;margin-top:35px;padding-top:13px;"><span class="blank">餐点品质：</span>（对本次订单中餐点的口味、分量等进行评价）</div>
					<div class="contact scoreList">
						<input type="radio" name="test" value="10" checked/> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" />  非常好吃，分量也足够
					</div>
					<div class="contact scoreList">
						<input type="radio" name="test" value="8" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  味道不错，分量够了
					</div>
					<div class="contact scoreList">
						<input type="radio" name="test" value="6" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  味道一般，量也一般
					</div>
					<div class="contact scoreList">
						<input type="radio" name="test" value="4" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  不太好吃，或者量不太够
					</div>
					<div class="contact scoreList">
						<input type="radio" name="test" value="2" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  难吃，或者量很少
					</div>
					<div class="contact" style="border-top:1px #dcdcdc solid;margin-top:35px;padding-top:13px;">
						<span class="blank">送餐速度：</span>
					</div>
					<div class="contact scoreList">
						<input type="radio" name="speed" value="10" checked/> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" />  非常快
					</div>
					<div class="contact scoreList">
						<input type="radio" name="speed" value="8"/> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  挺快的
					</div>
					<div class="contact scoreList">
						<input type="radio" name="speed" value="6" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  速度一般
					</div>
					<div class="contact scoreList">
						<input type="radio" name="speed" value="4" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  不太快
					</div>
					<div class="contact scoreList">
						<input type="radio" name="speed" value="2" /> <img src="images/star_1_1.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" /> <img src="images/star_1_0.gif" alt="" />  很慢
					</div>
					<div class="center_button"><input type="image" src="images/button/score.jpg" /></div>
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
