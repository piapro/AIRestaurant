<?php
	/**
	 *  food.php
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
  <title>用户登录分析 - 外卖点餐系统</title>
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
						echo "用户登录分析";

					?>
					</h1>
					<div id="introAdd">
						<div class="moneyTable feeTable" style="width:668px;">
							<table width="100%"><p style="color:red;margin-bottom:10px;">此处显示前50名用户</p>
								<tr>
									<td class="center" width='10%' height="30px;">用户姓名</td>
									<td class="center" width='10%'>用户手机</td>
									<td class="center" width='5%'>最后一次登陆时间</td>
									<td class="center" width='5%'>登录次数</td>
									<td class="center" width='5%'>最后一次登陆IP</td>
								</tr>
								<?php
									$where='';
									$pagesize=20;
									$startRow=0;
									
									$sql="select * from qiyu_user";
									
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
									
									$sql="select * from qiyu_user order by user_id desc limit $startRow,50";
									
									$rs=mysql_query($sql);
									if ($rscount==0){ 
										echo "<tr><td colspan='8' class='center'>暂无信息</td></tr>";
									}else{
										while($rows=mysql_fetch_assoc($rs)){
											
										
									?>
								<tr>
								<td class="center"><a href="userintro.php?id=<?php echo $rows['user_id']?>&tel=<?php echo $tel?>&page=<?php echo $page?>"><?php echo $rows['user_name']?></a></td>
								<td class="center" style="height:30px;"><?php echo $rows['user_account']?></td>
								<td class="center"><?php echo $rows['user_logintime']?></td>
								<td class="center"><?php echo $rows['user_logincount']?></td>
								<td class="center"><?php echo $rows['user_loginip']?></td>
								
								</tr>
									<?php
											}
									}
									?>					
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
