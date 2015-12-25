<?php
	/**
	 *  shopaccount.php  
	 */
	require_once("usercheck2.php");
	$searchType=empty($_GET['type'])?0:sqlReplace(trim($_GET['type']));
	$start=empty($_GET['start'])?'':sqlReplace(trim($_GET['start']));
	$end=empty($_GET['end'])?'':sqlReplace(trim($_GET['end']));
	$url="?type=".$searchType."&start=".$start."&end=".$end;
	$searchType1=empty($_GET['type1'])?0:sqlReplace(trim($_GET['type1']));
	$start1=empty($_GET['start1'])?'':sqlReplace(trim($_GET['start1']));
	$end1=empty($_GET['end1'])?'':sqlReplace(trim($_GET['end1']));
	$url1="?type1=".$searchType1."&start1=".$start1."&end1=".$end1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title> 营业额查询 - 外卖点餐系统 </title>
 </head>
 <body>
 <script type="text/javascript">
 <!--
	$(function(){
		 $("input[name='type']").click(function(){
					if ($(this).val()=='0')
						$("#time").hide();
					else
						$("#time").show();

			 })
	})
				 $(function(){
		 $("input[name='type1']").click(function(){
					if ($(this).val()=='0')
						$("#time1").hide();
					else
						$("#time1").show();

			 })
	})
	function excel(id){
		var type=$("input[name='type']:checked").val();
		var start=$("#start").val();
		var end=$("#end").val();
		$.post("shop.ajax.php", { 
			'type'      :  type,
			'start' :  start,
			'end' :  end,
			'act'     : 'excel'
			}, function (data, textStatus){
				if (data=="S"){
					alert('导出成功');
				}else
					alert('修改失败');
						
		});
	 }

	 function excelOrder(id){
		var type=$("input[name='type1']:checked").val();
		var start=$("#start1").val();
		var end=$("#end1").val();
		$.post("shop.ajax.php", { 
			'type'      :  type,
			'start' :  start,
			'end' :  end,
			'act'     : 'excelOrder'
			}, function (data, textStatus){
				if (data=="S"){
					alert('导出成功');
				}else
					alert('修改失败');
						
		});
	 }
 //-->
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
					<h1>营业额查询</h1>
					
					<div class="topBox">
						<div class="top_h1">查询您的餐厅在<?php echo $SHOP_NAME?>上产生的订单</div>
						<div class="top_main">
						<form method="get" action="shopturnover.php">
							
						
							<div class="t_left settle">
								<input type="radio" name="type" value="1" /> 查询一定时间段内营业总额 <input type="radio" name="type" value="0" checked/> 查询每日营业额明细
								<p id="time" style="display:none;">查询时间范围：从 <input type="text" id="start" name="start" class="input116"/> 到 <input type="text" id="end" name="end" class="input116" /> 如:2010-8-7</p>
							</div>	
							<div class="t_right">
								<p style="margin-top:10px;"><input type="image" src="../images/button/search1.gif" /></p>
								<p style="margin-top:10px;"><img src="../images/button/export.gif" alt="" onClick="excel(<?php echo $QIYU_ID_SHOP?>)"/></p>
							</div>
						</form>
							<div class="clear"></div>
							<div class="moneyTable">
								<table>
									<tr>
										<td width="89" class='center'>日期</td>
										<td width="85" class='center'>订单数量</td>
										<td width="85" class='center'>订单总额</td>
										<td width="85" class='center'>收入现金</td>
										<td width="85" class='center'>收入饭点</td>
										<td width="85" class='center'>支出饭点</td>
										<td width="85" class='center'>饭点结算</td>
									</tr>
								<?php
									$where='';
									
									$orderCountTotal=empty($_GET['CountTotal'])?0:sqlReplace(trim($_GET['CountTotal']));
									$orderALLTotal=empty($_GET['ALLTotal'])?0:sqlReplace(trim($_GET['ALLTotal']));
									$orderMoneyTotal=empty($_GET['MoneyTotal'])?0:sqlReplace(trim($_GET['MoneyTotal']));
									$getvalueTotal=empty($_GET['valueTotal'])?0:sqlReplace(trim($_GET['valueTotal']));
									$spendvalueTotal=empty($_GET['spendvalueTotal'])?0:sqlReplace(trim($_GET['spendvalueTotal']));
									$scoreTotal=empty($_GET['scoreTotal'])?0:sqlReplace(trim($_GET['scoreTotal']));

									$pagesize=20;
									$startRow=0;
									if ($searchType=='1'){
										if (!(empty($start) || empty($end)))
											 $where.=" and date(order_addtime) >= '".$start."' and date(order_addtime) <= '".$end."'";
										elseif (!empty($start) && empty($end))
											$where.=" and date(order_addtime) >= '".$start."'";
										elseif (empty($start) && !empty($end))
											$where.=" and date(order_addtime) <= '".$end."'";
									}
									$sql="select count(order_id) as cOrder  from qiyu_order where order_shop='".$SHOP_ID2."' ".$where." and order_status='4' group by date(order_addtime)";
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
									
									$sql="select count(order_id) as cOrder,sum(order_totalprice) as total,order_addtime  from qiyu_order where order_shopid='".$QIYU_ID_SHOP."' ".$where." and order_status='4' group by date(order_addtime) order by order_id desc limit $startRow,$pagesize";
									$rs=mysql_query($sql);
									if ($rscount==0){ 
										
										echo "<tr><td colspan='7' class='center'>暂无信息</td></tr>";
									}
									$i=0;
									while($rows=mysql_fetch_assoc($rs)){
										$orderCountTotal+=$rows['cOrder'];
										$orderALLTotal+=$rows['total'];
										

										$sqlStr="select sum(rscore_spendvalue) as s,sum(rscore_getvalue) as g from qiyu_rscore where rscore_shopid='".$QIYU_ID_SHOP."'  and DATEDIFF('".$rows['order_addtime']."',rscore_addtime)";
										$rs_r=mysql_query($sqlStr);
										$row=mysql_fetch_assoc($rs_r);
										if ($row){
											$spendvalue=$row['s'];
											$getvalue=$row['g'];
										}else{
											$spendvalue=0;
											$getvalue=0;
										}
										
										$subtractScore=$getvalue-$spendvalue;
										$moeny=$rows['total']-$spendvalue;
										$scoreTotal+=$subtractScore;
										$orderMoneyTotal+=$moeny;
										$getvalueTotal+=$getvalue;
										$spendvalueTotal+=$spendvalue;
								?>
									<tr>
										<td><?php echo substr($rows['order_addtime'],0,10)?></td>
										<td class='center'><?php echo $rows['cOrder']?></td>
										<td  class='center'><?php echo $rows['total']?></td>
										<td  class='center'><?php echo $moeny?></td>
										<td class='center'><?php echo $getvalue?></td>
										<td  class='center'><?php echo $spendvalue?></td>
										<td  class='center'><?php echo $subtractScore?></td>
									</tr>
								 <?php
									}
									if ($page==$pagecount){
								?>
									
									<tr>
										<td>总计</td>
										<td class='center'><?php echo $orderCountTotal?></td>
										<td  class='center'><?php echo $orderALLTotal?></td>
										<td  class='center'><?php echo $orderMoneyTotal?></td>
										<td class='center'><?php echo $getvalueTotal?></td>
										<td  class='center'><?php echo $spendvalueTotal?></td>
										<td  class='center'><?php echo $scoreTotal?></td>
									</tr>
								<?php
									}		
								?>
								</table>
								<?php
									if ($pagecount>1)
										echo showPage("shopturnover.php?CountTotal=".$orderCountTotal."&ALLTotal=".$orderALLTotal."&MoneyTotal=".$orderMoneyTotal."&valueTotal=".$getvalueTotal."&spendvalueTotal=".$spendvalueTotal."&scoreTotal=".$scoreTotal.$url,$page,$pagesize,$rscount,$pagecount);
								?>
							</div>
						</div>
					</div><!--topBox完-->


					<div class="topBox">
						<div class="top_h1">查询您的餐厅在<?php echo $SHOP_NAME?>上产生的订单</div>
						<div class="top_main">
						<form method="get" action="shopturnover.php">
							
						
							<div class="t_left settle">
								<input type="radio" name="type1" value="1" /> 查询一定时间段内营业总额 <input type="radio" name="type1" value="0" checked/> 查询每日营业额明细
								<p id="time1" style="display:none;">查询时间范围：从 <input type="text" id="start1" name="start1" class="input116"/> 到 <input type="text" id="end1" name="end1" class="input116" /></p>
							</div>	
							<div class="t_right">
								<p style="margin-top:10px;"><input type="image" src="../images/button/search1.gif" /></p>
								<p style="margin-top:10px;"><img src="../images/button/export.gif" alt="" onClick="excelOrder(<?php echo $QIYU_ID_SHOP?>)"/></p>
							</div>
						</form>
							<div class="clear"></div>
							<div class="moneyTable">
								<table>
									<tr>
										<td width="89" class='center'>序号</td>
										<td width="89" class='center'>订单时间</td>
										<td width="85" class='center'>订单号</td>
										<td width="85" class='center'>用户名</td>
										<td width="85" class='center'>订单详情</td>
										<td width="85" class='center'>送餐费</td>
										<td width="85" class='center'>订单总额</td>
										<td width="85" class='center'>现金支付</td>
										<td width="85" class='center'>饭点支付</td>
										<td width="85" class='center'>订单返点</td>
									</tr>
								<?php
									$where1='';
									
									$orderDeliverTotal=empty($_GET['DeliverTotal'])?0:sqlReplace(trim($_GET['DeliverTotal']));//送餐费
									$orderALLTotal1=empty($_GET['ALLTotal1'])?0:sqlReplace(trim($_GET['ALLTotal1']));//订单总额
									$orderMoneyTotal1=empty($_GET['MoneyTotal1'])?0:sqlReplace(trim($_GET['MoneyTotal1'])); //现金
									$getvalueTotal1=empty($_GET['valueTotal1'])?0:sqlReplace(trim($_GET['valueTotal1']));//得到返点
									$spendvalueTotal1=empty($_GET['spendvalueTotal1'])?0:sqlReplace(trim($_GET['spendvalueTotal1'])); //消费饭点
									//$scoreTotal=empty($_GET['scoreTotal'])?0:sqlReplace(trim($_GET['scoreTotal']));

									$pagesize=20;
									$startRow=0;
									if ($searchType1=='1'){
										if (!(empty($start1) || empty($end1)))
											 $where1.=" and date(order_addtime) >= '".$start1."' and date(order_addtime) <= '".$end1."'";
										elseif (!empty($start1) && empty($end1))
											$where1.=" and date(order_addtime) >= '".$start1."'";
										elseif (empty($start1) && !empty($end1))
											$where1.=" and date(order_addtime) <= '".$end1."'";
									}
									$sql="select order_id  from qiyu_order  where order_shopid='".$QIYU_ID_SHOP."' ".$where1." and order_status='4'";
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
									
									$sql="select order_id  from qiyu_order  where order_shopid='".$QIYU_ID_SHOP."' ".$where1." and order_status='4'  order by order_id desc limit $startRow,$pagesize";
									$rs=mysql_query($sql);
									if ($rscount==0){ 
										
										echo "<tr><td colspan='10' class='center'>暂无信息</td></tr>";
									}
									$i=0;
									while($rows=mysql_fetch_assoc($rs)){
										$orderDeliverTotal+=$rows['order_deliverprice'];
										$orderALLTotal1+=$rows['order_totalprice'];
										

										$sqlStr="select * from qiyu_rscore where rscore_order='".$rows['order_id2']."'";
										$rs_r=mysql_query($sqlStr);
										$row=mysql_fetch_assoc($rs_r);
										if ($row){
											$spendvalue=$row['rscore_spendvalue'];
											$getvalue=$row['rscore_getvalue'];
										}else{
											$spendvalue=0;
											$getvalue=0;
										}
										
										$moeny=$rows['order_totalprice']-$spendvalue;
										$orderMoneyTotal1+=$moeny;
										$getvalueTotal1+=$getvalue;
										$spendvalueTotal1+=$spendvalue;
								?>
									<tr>
										<td><?php echo $rows['order_id']?></td>
										<td><?php echo $rows['order_addtime']?></td>
										<td class='center'><?php echo $rows['order_id2']?></td>
										<td  class='center'><?php echo $rows['order_username']?></td>
										<td >
								<?php
									$cartCount=0;
									$cartAll=0;
									$sql_cart="select * from qiyu_cart inner join qiyu_food on food_id=cart_food and cart_status='1' and cart_order='".$rows['order_id2']."'";	
									$rs_cart=mysql_query($sql_cart);
									while ($rows_cart=mysql_fetch_assoc($rs_cart)){
										$cartCount+=1;
										$cartAll+=$rows_cart['cart_count']*$rows_cart['cart_price'];
										echo "<p>".$rows_cart['food_name']." ".$rows_cart['cart_count']."*".$rows_cart['cart_price']."</p>";
									}
									if ($cartCount>0) echo "总额:".$cartAll;
								?>		
										
										
										</td>
										<td class='center'><?php echo $rows['order_deliverprice']?></td>
										<td  class='center'><?php echo $rows['order_totalprice']?></td>
										<td  class='center'><?php echo $moeny?></td>
										<td  class='center'><?php echo $spendvalue?></td>
										<td  class='center'><?php echo $getvalue?></td>
									</tr>
								 <?php
									}
									if ($page==$pagecount){
								?>
									
									<tr>
										<td>总计</td>
										<td class='center'></td>
										<td class='center'></td>
										<td  class='center'></td>
										<td  class='center'></td>
										<td class='center'><?php echo $orderDeliverTotal?></td>
										<td  class='center'><?php echo $orderALLTotal1?></td>
										<td  class='center'><?php echo $orderMoneyTotal1?></td>
										<td  class='center'><?php echo $spendvalueTotal1?></td>
										<td  class='center'><?php echo $getvalueTotal1?></td>
									</tr>
								<?php
									}		
								?>
								</table>
								<?php
									if ($pagecount>1)
										echo showPage("shopturnover.php?DeliverTotal=".$orderDeliverTotal."&ALLTotal1=".$orderALLTotal1."&MoneyTotal1=".$orderMoneyTotal1."&valueTotal1=".$getvalueTotal1."&spendvalueTotal1=".$spendvalueTotal1.$url1,$page,$pagesize,$rscount,$pagecount);
								?>
							</div>
						</div>
					</div><!--topBox完-->
					
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
