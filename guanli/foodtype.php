<?php
	/**
	 *  foodtype.php
	 */
	require_once("usercheck2.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title>菜单分类设置 - 外卖点餐系统</title>
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
					<h1>菜单分类管理</h1>
					<div id="introAdd">
						<form method="post" action="shop_do.php?act=addfoodtype">
						
						<p style='position:relative;'><label>分类名称：</label><input type="text" id="foodtype" name="foodtype" class="input input_87"/><span>&nbsp;(如：凉菜、热菜)</span> <input type="image" src="../images/button/addtype.jpg" onClick="return check()" style="position:absolute;left:310px;"/></p>
						</form>
						<div class="moneyTable feeTable" style="width:668px;">
							<form name="listForm" id="listForm" method="post" action="shop_do.php?act=savefoodtype">
							<table>
								<tr>
									<td class='center'>分类名称</td>
									<td class="center">排序</td>
									<td  class='center'>操作</td>
								</tr>
						<?php
						$sql="select * from ".WIIDBPRE."_foodtype where foodtype_shop=".$QIYU_ID_SHOP." order by foodtype_order asc,foodtype_id desc";
						$rs=mysql_query($sql);
						$count=mysql_num_rows($rs);
						if($count=='0'){
							echo '<tr><td colspan="3"  class="center">暂无信息</td></tr></table>';
						}else{
							$i=0;
							while($rows=mysql_fetch_assoc($rs)){
								$i++;
						?>
							<tr>
								<input type="hidden"  name="id<?php echo $i?>" value="<?php echo $rows['foodtype_id']?>" />
								<td class="center"><input type="text" name="foodtypename<?php echo $i?>" value="<?php echo $rows['foodtype_name']?>" /></td>
								<td class="center"><input type="text" size="4" name="order<?php echo $i?>" value="<?php echo $rows['foodtype_order']?>" /></td>
								<td class="center" style='padding:5px 0;'><a href="food.php?foodtype=<?php echo $rows['foodtype_id']?>">查看菜单</a>&nbsp;&nbsp;<a href="javascript:if(confirm('您确定要删除吗？')){location.href='shop_do.php?act=delfoodtype&id=<?php echo $rows['foodtype_id'];?>'}">删除</a></td>
							</tr>
						<?php
							}
						?>
						
						</table><input name="i" type="hidden" value="<?php echo $i ?>">
						<?php
						}	
						?>
						<p><input type="image" src="../images/button/edit2.gif"/></a></p>
						</form>
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
	function check(){
		var f=$('#foodtype').val();
		if(f=="")
		{
			alert('分类名称不能为空');
			$('#foodtype').focus();
			return false;
		}
	}
</script>

</html>
