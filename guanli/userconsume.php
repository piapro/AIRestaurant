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
  <title>用户消费记录 - 外卖点餐系统</title>
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
						echo "用户消费记录";

					?>
					</h1>
					<div id="introAdd">
						<div class="moneyTable feeTable" style="width:668px;">
							<table width="100%">
								<tr>
									<td class="center" width='30%' height="30px;">用户姓名</td>
									<td class="center" width='20%' height="30px;">消费总金额</td>
									<td class="center" width='20%' height="30px;">总积分</td>					
									<td class="center" width='30%' height="30px;">订单总数</td>
								</tr>
								<?php
									$pagesize=20;
									$startRow=0;
									
									
									$sql="select user_id,user_name,user_score,order_id2,sum(order_totalprice) as z,count(order_id2) as d ,sum(user_score) as s  from qiyu_user join qiyu_order on user_id=order_user where  order_status=4 group by user_name order by z desc";
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
									
									
									$sql="select user_id,user_name,user_score,order_id2,sum(order_totalprice) as z,count(order_id2) as d ,sum(user_score) as s  from qiyu_user join qiyu_order on user_id=order_user where  order_status=4 group by user_name order by z desc limit $startRow,$pagesize";
									
									$rs=mysql_query($sql);
									if ($rscount==0){ 
										echo "<tr><td colspan='8' class='center'>暂无信息</td></tr>";
									}else{
										while($rows=mysql_fetch_assoc($rs)){
											
										
									?>
								<tr>
								<td class="center"><a href="userintro.php?id=<?php echo $rows['user_id']?>&tel=<?php echo $tel?>&page=<?php echo $page?>"><?php echo $rows['user_name']?></a></td>
								<td class="center" height="30px;"><?php echo $rows['z']?></td>
								<td class="center" height="30px;"><?php echo $rows['user_score']?></td>
								<td class="center" height="30px;"><?php echo $rows['d']?></td>
								
								
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
