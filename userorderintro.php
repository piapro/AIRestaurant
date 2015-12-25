<?php
	/**
	 *  userorderintro.php  订单详情页
	 */
	require_once("usercheck2.php");
	$id=sqlReplace(trim($_GET['id']));
	$key=empty($_GET['key'])?'new':sqlReplace(trim($_GET['key']));
	$POSITION_HEADER="用户中心";
	$sql="select * from qiyu_shop,qiyu_order where (order_shop=shop_id2 or order_shopid=shop_id) and order_id=".$id;
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$shopName=$rows['shop_name'];
		$orderAddtime=$rows['order_addtime'];
		$orderStatus=$rows['order_status'];
		$order=$rows['order_id2'];
		$orderPriceAll=$rows['order_totalprice'];
		$orderTotal=$rows['order_price'];
		$deliverFee=$rows['order_deliverprice'];
		$orderInfor=$rows['order_infor'];
		$orderText=$rows['order_text'];
		$spot=$rows['order_spot'];
		$circle=$rows['order_circle'];
		$orderType=$rows['order_type'];
		$orderTime1=$rows['order_time1'];
		$orderTime2=substr($rows['order_time2'],0,5);
	}else{
		alertInfo('非法操作','index.php',0);
	}

	
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
<script src="js/userorder.js" type="text/javascript"></script>
<script src="js/userreg.js" type="text/javascript"></script>
<script src="js/chage1.js" type="text/javascript"></script>
<script src="js/TINYBox.js" type="text/javascript" language="javascript"></script>
<link rel="stylesheet" href="js/TINYBox.css" type="text/css"/>
<title> 订单详情 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
<script type="text/javascript" >
		//getstatus();
	　var int=self.setInterval("getstatus()",15000);
		function getstatus(){
			var orderid=$("#orderid").val();
			var orderkey=$("#orderkey").val();
			$.ajax({
			   type: "GET",
			   url: "getstatus.php?key="+orderkey+"&id="+orderid+"&url=intro",
			   data: "",
			   success: function(msg){
				   var content=msg.split("||||||");
					$("#order").html(content[0]);
					$("#orderChangList").html(content[1]);
					$("#intro_r_content").html(content[2]);
			   }
			});
		}
	
</script>
 <body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top order_top"></div>
			<div class="main_center order_center">
				<div id="order_left">
					<div id="tab4">
						<ul>
							<li id="t2" class='selected'></li>
							<li id="t5"></li>
							<li id="t6"></li>
						</ul>
						<div class="clear"></div>
					</div>
				</div>
				<div id="order_right">
					
					<div>
						<input type="hidden" id="orderid" name="orderid" value="<?php echo $id?>" />
						<input type="hidden" id="orderkey" name="orderkey" value="<?php echo $key?>" />
						<h1 class="order_h1"><a href='usercenter.php?tab=2'>所有订单</a></h1>
						<div class="centerBorder"><img src="images/intro_bg.jpg" alt="" /></div>
						<div class="orderStateList">
						<div id="orderChangList">
						<?php 
								$i=1;
								$sql="select * from qiyu_orderchange where orderchange_order='".$order."'";
								$rs=mysql_query($sql);
								$reCount=mysql_num_rows($rs);
								while ($rows=mysql_fetch_assoc($rs)){
									
										$addTime=substr($rows['orderchange_addtime'],11);
										$intro=HTMLDecode($rows['orderchange_name']);
									
						?>
								<table border='0'>
								<tr>
									<td class='s_left' valign='top' width='63'><?php echo $addTime?></td>
									<td class='s_right' valign='top'><?php echo $intro?></td>
								</tr>
								</table>
								<table border='0'>
									<tr>
										<td style='padding:0'><img src="images/line_719.jpg"  alt="" /></td>
									</tr>
								</table>
						<?php
									if ($i==1 || $reCount==1){
									
												$addTime1='';
												$intro1="<span class=\"greenbg\"><span><span>小提示</span></span></span>您的订单进度会自动更新，请稍后.....
		";
											
						?>
										<table border='0'>
											<tr>
												<td class='s_left' valign='top' width='63'><?php echo $addTime1?></td>
												<td class='s_right' valign='top'><?php echo $intro1?></td>
											</tr>
											</table>
											<table border='0'>
												<tr>
													<td style='padding:0'><img src="images/line_719.jpg"  alt="" /></td>
												</tr>
											</table>
						<?php
						
									}
									$i++;
									
								}
							?>
							</div>
						</div>

						<div class="intro_l" id="intro_l">
							<div class="intro">
								<div class="top"><img src="images/order_intro.jpg" alt=""/></div>
								<p style="margin-top:0">订单号：<?php echo $order?> <span class="time">订单时间：<?php echo $orderAddtime?></span>
									<?php if ($orderType=='1') echo "<span class='time'>预约时间：".$orderTime1." ".$orderTime2."</span>"?>
								</p>
								<div class="table table_yellow">
									<table>
										<tr>

											<td class="meter" style="padding-left: 10px;" width="202"> 菜品名</td>
											<td class="meter" width="154">单价</td>
											<td class="meter" width="115">份数</td>
											<td class="meter" width="200">备注</td>
										</tr>
									<?php
										$total=0;
										$sql="select * from qiyu_cart inner join qiyu_food on food_id=cart_food and cart_order='".$order."' and cart_status='1'";
										$rs=mysql_query($sql);
										while ($rows=mysql_fetch_assoc($rs)){
											
									?>
										<tr>
											<td style="padding-left: 10px;"><?php echo $rows['food_name']?></td>
											<td><?php echo $rows['cart_price']?></td>
											<td><?php echo $rows['cart_count']?></td>
											<td><?php echo $rows['cart_desc']?></td>

										</tr>
									<?php
										}
											
												//消费的积分
												$sql="select * from qiyu_rscore where rscore_order='".$order."' and rscore_type='0'";
												
												$rs=mysql_query($sql);
												$rows=mysql_fetch_assoc($rs);
												if ($rows){
													$score=$rows['rscore_spendvalue'];
												}
												else
													$score=0;
									?>
										
															
										<tr>
											<td style="border:0" colspan="4">餐饮要求：<span class="red"><?php echo $orderText;?></span></td>
										</tr>
										<tr>
											<td style="border:0" colspan="4">订单备注：<span class="red"><?php echo $orderInfor;?></span></td>
										</tr>
										<tr>
											<td style="border:0" colspan="4">餐点总额：<span class="red"> <?php echo $orderTotal?>元 </span></td>
											
										</tr>
										<tr>
											<td style="border:0">送餐费：<span class="red"> <?php echo $deliverFee?>元 </span></td>
											<td colspan="3" style="border: 0px ;">
												<span class="red" style='font-size:24px;'>总计：<?php echo $orderPriceAll?>元</span>
											</td>
										</tr>
									</table>
									<?php if ($orderStatus=="1"){?><div id="intro_r_content"><p class='finishButton'><img src="images/button/finish.jpg" onClick="orderFinish(<?php echo $id?>)" alt="" class='finishButton' style='cursor:pointer;'/></p></div><?php }?>

								</div>
							</div><!--intro wan-->
						</div>
						
						
					</div><!--tab2wan-->

					<div style='display:none;'>
						<?php require_once('usercentertab5.inc.php');?>
					</div><!--tab5完-->
					<div style='display:none;'>
						<?php require_once('usercentertab6.inc.php');?>
					</div><!--tab6完-->
				</div>
				
				<div class="clear"></div>
				
			</div>
			<div class="main_bottom order_bottom"></div>
		</div><!--main_content完-->
		
	
	</div>
	
	<?php
		require_once('footer.php');
	?>
 </div>
 <script type="text/javascript">
	function alertadd(act){//添加地址
		var phone=$("#phone").val();
		var name=$("#name").val();
		
		var address=$("#address").val();
		
		$(".input").trigger('blur');
				var numError = $('.onError').length;
				if(numError){
					return false;
				} 
		$.ajax({
		   type: "POST",
		   url: "usercenter_do.php?act="+act,
		   data: "phone="+phone+"&name="+name+"&address="+address,
		   success: function(msg){
			 TINY.box.show(msg,0,160,60,0,10);
			 //setTimeout("location.reload()",1000);
			 
			 location.href='usercenter.php?tab=5';
		   }
		});
	}
</script>

<script type="text/javascript">
	function updateusername(){//修改姓名
		var user_name=$("#user_name").val();
		if(user_name==''){
			$('.errormt2').html('姓名不能为空');
			return false;
		}
		$.ajax({
		   type: "POST",
		   url: "usercenter_do.php?act=updateusername",
		   data: "user_name="+user_name,
		   success: function(msg){
			 TINY.box.show(msg,0,160,60,0,10);
			 //setTimeout("location.reload()",1000);
			 
			 location.href='usercenter.php?tab=5';
		   }
		});
	}
</script>
 </body>
</html>
