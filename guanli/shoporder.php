<?php
	/**
	 *  shoporder.php  
	 */
	require_once("usercheck2.php");
	$key=sqlReplace(trim($_GET['key']));
	$keyword=empty($_GET['keyword'])?'':sqlReplace(trim($_GET['keyword']));
	$start=empty($_GET['start'])?'':sqlReplace(trim($_GET['start']));
	$end=empty($_GET['end'])?'':sqlReplace(trim($_GET['end']));
	$url="?key=".$key."&keyword=".$keyword."&start=".$start."&end=".$end;
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
 <script type="text/javascript">
 <!--
	function updateOrder(orderID){
		var content="<tr id='update'"+orderID+" class='addtr'><td colspan='8' class='border_left border_bottom border_right order1' style='padding:10px;'><textarea name=\"content\" style=\"width:350px;height:100px;\" id='orderIntro'></textarea> <p><a href='javascript:void();' onClick=\"addOrderIntro("+orderID+")\"><img src=\"../images/button/update.jpg\" /></a></p></td></tr>";
		$('.addtr').remove();
		$(content).insertAfter('#table'+orderID);
	}

	function addOrderIntro(id){
		var intro=$("#orderIntro").val();
		$.post("shop.ajax.php", { 
			'id'      :  id,
			'content' :  intro,
			'act'     : 'addOrderIntro'
			}, function (data, textStatus){
				if (data=="S"){
					alert('修改成功');
				}else
					alert('修改失败');
						
		});
	}
	function addOrderText(id){
		var intro=$("#orderIntro").val();
		$.post("shop.ajax.php", { 
			'id'      :  id,
			'content' :  intro,
			'act'     : 'addOrderText'
			}, function (data, textStatus){
				if (data=="S"){
					alert('添加成功');
					location.reload();
				}else
					alert('修改失败');
						
		});
	}


	function orderText(orderID){
		var content="<tr id='update'"+orderID+" class='addtr'><td colspan='8' class='border_left border_bottom border_right order1' style='padding:10px;'><textarea name=\"content\" style=\"width:350px;height:100px;\" id='orderIntro'></textarea> <p><a href='javascript:void();' onClick=\"addOrderText("+orderID+")\"><img src=\"../images/button/update.jpg\" /></a></p></td></tr>";
		$('.addtr').remove();
		$(content).insertAfter('#table'+orderID);
	}
 //-->
 </script>

 <script type="text/javascript" >
		msg();
	　var int=self.setInterval("msg()",5000);
		function msg(){
			$.ajax({
			   type: "POST",
			   url: "msg.php",
			   data: "",
			   success: function(msg){
					if(msg){
						$("#countspan").html("("+msg+")");
					}else{
						$("#countspan").html("(0)");
					}
			   }
			});
		}
	
</script>
 <div id="container">
	<?php
		require_once('header.php');
	?>
	<div id="main">
		<div id="shadow"><img src="../images/shadow.gif" width="955" height="9" alt="" /></div>
		<div class="main_content main_content_r">
			<div class="main_top"></div>
			<div class="main_center main_center_r">
				<div id="shopLeft">
					<?php
						require_once('left.inc.php');
					?>
				</div>
				<div id="shopRight">
					<h1>订单管理</h1>
					<form method="get" action="shoporder.php">
						
					
					<div class="search_box" style="margin-top:30px;">
						<select name="key" class="input select_237">
							<option value="all" >全部</option>
							<option value="0" <?php if($key=='0'){echo 'selected';}?> >新订单</option>
							<option value="1" <?php if($key=='1'){echo 'selected';}?> >已确定</option>
							<option value="2" <?php if($key=='2'){echo 'selected';}?> >商家取消</option>
							<option value="3" <?php if($key=='3'){echo 'selected';}?> >用户取消</option>
							<option value="4" <?php if($key=='4'){echo 'selected';}?> >订单完成</option>
							<option value="5" <?php if($key=='5'){echo 'selected';}?> >备餐</option>
						</select><a href="shoporder.php?key=0" style="margin-left:30px;">新订单<span id="countspan" class="red">(0)</span></a>
					</div>
					<div class="search_box">
						订单号、手机号或用户名：<input type="text" name="keyword" class="input input_87"/>
					</div>
					<div class="search_box search_box_r">
						订单时间范围：<input type="text" name="start" class="input input_87"/> 到 <input type="text" name="end" class="input input_87"/> <input type="image" src="../images/button/search.gif" class="searchButton"/>
					</div>
					</form>
					<div class="orderTable">
					
						<table  height="303" border="1" cellpadding="0" cellspacing="0" style="border:1px #000000 solid;"> 
						  <tr>
							<td width="121" align="center" class="meter">确认或修改订单</td>
							<td width="85" class="meter" align="center">餐厅名称</td>
							<td width="68" class="meter">单价</td>
							<td width="59" class="meter">份数</td>
							<td width="91" class="meter" align="center">顾客要求</td>
							<td width="80" class="meter" align="center">订单总价</td>
							<td width="80" class="meter" align="center">订单状态</td>
							<td width="80" class="meter" align="center">其他操作</td>
						  </tr>
					<?php
						$where='';
						if ($key!="all")
							$where=" and order_status='".$key."'";
						if (!empty($keyword))
							$where.=" and (order_username='".$keyword."' or order_id2 = '".$keyword."' or order_userphone='".$keyword."')";
						if (!(empty($start) || empty($end)))
							 $where.=" and date(order_addtime) >= '".$start."' and date(order_addtime) <= '".$end."'";
						elseif (!empty($start) && empty($end))
							$where.=" and date(order_addtime) >= '".$start."'";
						elseif (empty($start) && !empty($end))
							$where.=" and date(order_addtime) <= '".$end."'";
	
						$pagesize=20;
						$startRow=0;
						$sql="select * from  qiyu_order  where order_shopid='".$QIYU_ID_SHOP."' ".$where;
						$rs = mysql_query($sql) or die ("查询失败，请检查SQL语句。");
						$rscount=mysql_num_rows($rs);
						if ($rscount%$pagesize==0)
							$pagecount=$rscount/$pagesize;
						else
							$pagecount=ceil($rscount/$pagesize);

						if (empty($_GET['page'])||!is_numeric($_GET['page']))
							$page=1;
						else{
							$page=$_GET['page'];
							if($page<1) $page=1;
							if($page>$pagecount) $page=$pagecount;
							$startRow=($page-1)*$pagesize;
						}
						
						$sql="select * from  qiyu_order,qiyu_shop  where shop_id=order_shopid and order_shopid='".$QIYU_ID_SHOP."' ".$where." order by order_id desc limit $startRow,$pagesize";
						$rs=mysql_query($sql);
						if ($rscount==0){ 
							
							echo "<tr><td colspan='8' align='center'>暂无信息</td></tr>";
						}
						$i=0;
						while($rows=mysql_fetch_assoc($rs)){
							$i++;
							$state=$rows['order_status'];
							$shopType=$rows['shop_type'];
							$totalprice=$rows['order_totalprice'];
							
					?>

						  <tr >
							<td colspan="8" class="border_left border_bottom border_right order1">
								<p>订单号:<?php echo $rows['order_id2']?> 订单时间:<?php echo substr($rows['order_addtime'],0,10)?> 用户姓名：<?php echo $rows['order_username']?> 订单类型：外卖订单</p>
								<p>地址：<?php echo $rows['order_address']?> 手机：<?php echo $rows['order_userphone']?></p>
							</td>
						  </tr>
						  <tr id="table<?php echo $rows['order_id']?>">
							<td height="128" class="border_left border_bottom" align="center">
							<?php if ($state=='0' || $state=='6'){?>
									<a href="shoporder_do.php<?php echo $url?>&act=sure&id=<?php echo $rows['order_id']?>"><img src="../images/button/sureorder.gif" alt="" /></a>
							<?php
								 }  
								 if ($state=='0' || $state=='1' || $state=='6'){
							?>
									<p><a href="javascript:void();" onClick="updateOrder(<?php echo $rows['order_id']?>)">修改订单</a></p>
							<?php
								 }  
							?>
							&nbsp;
							</td>
							<td colspan="3" class="border_left border_bottom"><table cellspacing="0" cellpadding="0">
							<?php
									$sql_cart="select c.*,food_name from qiyu_cart as c inner join qiyu_food as f on food_id=cart_food and cart_order='".$rows['order_id2']."' and cart_shop='".$SHOP_ID2."' and cart_status='1' order by cart_id desc";
									$rs_cart=mysql_query($sql_cart);
									while ($row_cart=mysql_fetch_assoc($rs_cart)){
							?>
									  <tr>
											<td width="71" height="25" class="noBorder"><?php echo $row_cart['food_name']?></td>
											<td width="75" class="noBorder">单价：<?php echo $row_cart['cart_price']?></td>
											<td width="88" class="noBorder">份数：<?php echo $row_cart['cart_count']?></td>
									  </tr>
							 <?php
									}	
							?>
							
							  
							</table></td>
							<td class="border_left border_bottom" align="center"><?php echo $rows['order_text']?></td>
							<td class="border_left border_bottom" style="padding-left:5px;">
								送餐费：<?php echo $rows['order_deliverprice']?>元
								<p>总价：<?php echo $totalprice?>元</p>
							<?php
								//消费的积分
								$sql_score="select * from qiyu_rscore where rscore_order='".$rows['order_id2']."'";
								$rs_score=mysql_query($sql_score);
								$rows_score=mysql_fetch_assoc($rs_score);
								if ($rows_score){
									$score=$rows_score['rscore_spendvalue'];
								}
								else
									$score=0;	
							?>


								<p>使用饭点：<?php echo $score?></p>
								<p>应收金额：<?php echo $totalprice-$score?></p>
							</td>
							<td class="border_left border_bottom" align="center"><span class="red"><?php echo $orderState[$rows['order_status']]?></span></td>
							<td class="border_left border_bottom border_right" align="center">
							<?php if ($state=='0' || $state=='1' || $state=='6'){?>	<a href="shoporder_do.php<?php echo $url?>&act=qx&id=<?php echo $rows['order_id']?>">取消订单</p><?php }?><?php if ($state=='1'){?><a href="shoporder_do.php<?php echo $url?>&act=bc&id=<?php echo $rows['order_id']?>">开始备餐</a><?php }?><?php if ($state=='5'){?><a href="shoporder_do.php<?php echo $url?>&act=finish&id=<?php echo $rows['order_id']?>">订单完成</a><?php }?>
								<?php if (!($state=='2' || $state=='3' || $state=='4')){?>
								<p><a href="javascript:void();" onClick="orderText(<?php echo $rows['order_id']?>)">添加备注</a></p>
								<?php }?>
								&nbsp;
							</td>
						  </tr>

				 <?php
					}
				?>		
						 
						</table>
						<?php 
							if ($rscount>=1)
								echo showPage_admin("shoporder.php".$url,$page,$pagesize,$rscount,$pagecount);
						?>
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
