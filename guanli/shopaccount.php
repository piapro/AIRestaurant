<?php
	/**
	 *  shopaccount.php 
	 */
	require_once("usercheck2.php");
	$searchType=empty($_GET['type'])?0:sqlReplace(trim($_GET['type']));
	$start=empty($_GET['start'])?'':sqlReplace(trim($_GET['start']));
	$end=empty($_GET['end'])?'':sqlReplace(trim($_GET['end']));
	$url="?type=".$searchType."&start=".$start."&end=".$end;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title>结算查询 - 外卖点餐系统</title>
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
				alert(data);
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
					<h1>结算查询</h1>
					<div class="topBox">
						<div class="top_h1">贵餐厅与<?php echo $SHOP_NAME?>的月结金额</div>
						<div class="top_main">
							<div class="moneyTable">
								<table>
									<tr>
										<td width="98" class='center'>月份</td>
										<td width="156" class='center'>饭点总收入</td>
										<td width="156" class='center'>饭点总支出</td>
										<td width="97" class='center'>结算金额</td>
									</tr>
								<?php
									$sql="select rscore_addtime,sum(rscore_spendvalue) as s,sum(rscore_getvalue) as g from qiyu_rscore where rscore_shop='".$SHOP_ID2."' group by date_format(rscore_addtime,'%Y%m') order by rscore_addtime desc";
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
								?>
									<tr>
										<td><?php echo substr($rows['rscore_addtime'],0,7)?></td>
										<td class='center'><?php echo $rows['g']?></td>
										<td  class='center'><?php echo $rows['s']?></td>
										<td  class='center'><?php echo $rows['g']-$rows['s']?></td>
									</tr>
								<?php
									}	
								?>
									
								</table>
							</div>
							<div class="reminder">备注：饭点总收入为旗鱼要支付给贵餐厅的金额。饭点总支出为餐厅要支付给旗鱼的金额。</div>
						</div>
					</div><!--topBox完-->
					<div class="topBox">
						<div class="top_h1">结算明细查询</div>
						<div class="top_main">
						<form method="get" action="shopaccount.php">
							
						
							<div class="t_left settle">
								<input type="radio" name="type" value="1" /> 查询一定时间段内营业总额 <input type="radio" name="type" value="0" checked/> 查询每日营业额明细
								<p id="time" style="display:none;">查询时间范围：从 <input type="text" id="start" name="start" class="input116"/> 到 <input type="text" id="end" name="end" class="input116" /></p>
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
									$sql="select count(order_id) as cOrder  from qiyu_order where order_shopid='".$QIYU_ID_SHOP."' ".$where." and order_status='4' group by date(order_addtime)";
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
										

										$sqlStr="select sum(rscore_spendvalue) as s,sum(rscore_getvalue) as g from qiyu_rscore where rscore_shop='".$SHOP_ID2."'  and DATEDIFF('".$rows['order_addtime']."',rscore_addtime)=0";
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
										echo showPage("shopaccount.php?CountTotal=".$orderCountTotal."&ALLTotal=".$orderALLTotal."&MoneyTotal=".$orderMoneyTotal."&valueTotal=".$getvalueTotal."&spendvalueTotal=".$spendvalueTotal."&scoreTotal=".$scoreTotal.$url,$page,$pagesize,$rscount,$pagecount);
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
