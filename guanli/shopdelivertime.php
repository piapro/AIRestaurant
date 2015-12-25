<?php
	/**
	 *  shopspotadd.php
	 */
	require_once("usercheck2.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title>送餐时间段 - 外卖点餐系统</title>
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
					<h1>送餐时段</h1>
					<div id="introAdd">
						<form method="post" action="shop_do.php?act=addtime">
						<p style="margin-left:12px;margin-bottom:10px;color:red;">小提示：设置送餐时段，用户下订单时就可以选择送餐时间。</p>
						<p><label>时间段名称：</label><input type="text" name="name" id="name" class="input input_87"/> (如:上午)</p>
						<p  class="clear"><label>时间段：</label> 
						<select name="t1" class="input input_87">
							<?php
								for($i=0;$i<=23;$i++){
									if ($i<10) $i="0".$i;
									echo "<option value='".$i."'>".$i."</option>";
								}
							?>
							</select> 点  
							<select name="s1" class="input input_87">
							<?php
								for($i=0;$i<=59;$i++){
									if ($i<10) $i="0".$i;
									echo "<option value='".$i."'>".$i."</option>";
								}
							?>
							</select> 分 到 <select name="t2" class="input input_87">
							<?php
								for($i=0;$i<24;$i++){
									if ($i<10) $i="0".$i;
									echo "<option value='".$i."'>".$i."</option>";
								}
							?>
							</select> 点  
							<select name="s2" class="input input_87">
							<?php
								for($i=0;$i<=59;$i++){
									if ($i<10) $i="0".$i;
									echo "<option value='".$i."'>".$i."</option>";
								}
							?>
							</select> 分
						</p>
						<p class="clear"><label>&nbsp;</label><input type="image" src="../images/button/timeadd.gif" onClick="return check()" /></p>
						</form>
						<div class="moneyTable feeTable" style="width:668px;">
							<table width="100%">
								<tr>
									<td class="center">时间段名称</td>
									<td class="center">时间段</td>
									<td class="center">操作</td>
								</tr>
						<?php 
							$sql="select * from qiyu_delivertime where delivertime_shop=".$QIYU_ID_SHOP;
							$rs=mysql_query($sql);
							$num=mysql_num_rows($rs);
							if($num<=0){
								echo "<tr><td colspan='3' class='center'>亲，还没有添加送餐时间段，赶紧添加吧！</td></tr>";
							}else{
						
						?>
						
						<?php
							while ($rows=mysql_fetch_assoc($rs)){
						?>
								<tr>
									<td class="center"><?php echo $rows['delivertime_name']?></td>
									<td class="center"><?php echo  substr($rows['delivertime_starttime'],0,5)." - ".substr($rows['delivertime_endtime'],0,5)?></td>
									<td class="center"><a href="javascript:void();" onClick="delShopTime(<?php echo $rows['delivertime_id']?>)">删除</a></td>
								</tr>
						<?php
							}
						?>
							
						
						<?php 
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
  <script type="text/javascript">
//<![CDATA[
	

	function check(){
		if ($("#name").val()==''){
			alert('时间段名称不能为空');
			return false;
		}
		
	}
	function delShopTime(id){
		$.post("shop.ajax.php", { 
			'timeid' :  id,
			'act':'delTime'
		}, function (data, textStatus){
							
			location.reload();
		});
	}
//]]>
</script>

</html>
