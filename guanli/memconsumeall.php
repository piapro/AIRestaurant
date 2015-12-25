<?php
	/**
	 * subscribe.php
	 */
	require_once("usercheck2.php");
	
	$tel=empty($_GET['tel'])?'':sqlReplace(trim($_GET['tel']));
	$ao=empty($_GET['ao'])?'':$_GET['ao'];
	$page=empty($_GET['page'])?'':$_GET['page'];

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <title>用户订单 - 外卖点餐系统</title>
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
					<h1>
					<?php
						echo "用户整体消费";

					?>
					</h1>
					<div id="introAdd">
						<div class="moneyTable feeTable" style="width:668px;">
							<table width="100%">
								<tr>
									<td class="center" width='10%'>用户名</td>
									<td class="center" width='10%'>消费总金额</td>
									<td class="center" width='5%'>总积分</td>									
									<td class="center" width='5%'>订单总数</td>
									<td class="center" width='40%'>操作</td>
								</tr>
								<?php
									$where='';
									$pagesize=20;
									$startRow=0;
									
									
									$sql="select qiyu_user.user_id,qiyu_user.user_name, qiyu_order.order_id2,sum(qiyu_order.order_totalprice) as z,count(qiyu_order.order_id2) as d ,sum(user_score) as s  FROM qiyu_user JOIN qiyu_order ON user_id=order_user where  order_status=4 group by user_name order by z desc";
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
									
									
									$sql="select qiyu_user.user_id,qiyu_user.user_name, qiyu_order.order_id2,sum(qiyu_order.order_totalprice) as z,count(qiyu_order.order_id2) as d ,sum(user_score) as s  FROM qiyu_user JOIN qiyu_order ON user_id=order_user where  order_status=4 group by user_name order by z desc limit $startRow,$pagesize";
									
									$rs=mysql_query($sql);
									if ($rscount==0){ 
										echo "<tr><td colspan='8' class='center'>暂无信息</td></tr>";
									}else{
										while($rows=mysql_fetch_assoc($rs)){
											
										
									?>
								<tr>
								<td class="center"><a href="userintro.php?id=<?php echo $rows['user_id']?>&tel=<?php echo $tel?>&page=<?php echo $page?>"><?php echo $rows['user_name']?></a></td>
								<td class="center"><?php echo $rows['z']?></td>
								<td class="center"><?php echo $rows['s']?></td>
								<td class="center"><?php echo $rows['d']?></td>
								<!---->
								<td class="center">
									<?php if ($state=='0' || $state=='1'){?><a href="javascript:if(confirm('您确定要取消该订单吗？')){location.href='userorder_subscribe_do.php?id=<?php echo $rows['order_id']?>&act=qx&ao=<?php echo $ao?>'}">取消订单</a><?php }?> 
									<?php if ($state=='0'){?><a href="userorder_subscribe_do.php?id=<?php echo $rows['order_id']?>&act=sure&ao=<?php echo $ao?>"><br/>订单确认</a><?php }?> <?php if ($state=='1'){?><a href="userorder_subscribe_do.php?id=<?php echo $rows['order_id']?>&act=bc&totalprice=<?php echo $rows['order_totalprice']?>&key=<?php echo $key?><?php echo $url?>">备餐订单</a><?php }?>
									<?php if ($state=='5'){?><a href="userorder_subscribe_do.php?id=<?php echo $rows['order_id']?>&act=finish&ao=<?php echo $ao?>"><br/>订单完成</a><?php }?><br/>
									<?php
										if ($state=='0' || $state=='4' || $state=='2' || $state=='3'){	
									?>
									<a href="javascript:if(confirm('您确定要删除吗？')){location.href='userorder_subscribe_do.php?id=<?php echo $rows['order_id']?>&act=del&ao=<?php echo $ao?>'}">删除</a> 
									<?php
										}	
									?>
								</td>
								</tr>
									<?php
											}
									}
									?>					
							</table>
						<?php 
							if ($rscount>=1){
								echo showPage_admin('subscribe.php?ao='.$ao,$page,$pagesize,$rscount,$pagecount);
							}
						?>
							
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
