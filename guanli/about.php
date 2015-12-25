<?php
	/**
	 *  food.php
	 */
	require_once("usercheck2.php");
	$tel=empty($_GET['tel'])?'':sqlReplace(trim($_GET['tel']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <title> 底部链接 - 外卖点餐系统 </title>
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
					<h1>底部链接</h1>
					<div id="introAdd">
						<div class="moneyTable feeTable" style="width:668px;margin-top:-14px;">
						<form name="listForm" id="listForm" method="post" action="about_do.php?act=save">
							<p style="margin-bottom:10px;"><input type="image" src="../images/button/save.gif"/>&nbsp;&nbsp;<a href="aboutadd.php"><img src="../images/button/linkadd.jpg"></a></p>
							<table width="100%">
								<tr>
									<td class="center" width='70%'>标题</td>
									<td class="center" width='70%'>排序</td>
									<td class="center" width='30%'>操作</td>
								</tr>
								<?php
									
									$i=0;
									$sql="select * from ".WIIDBPRE."_about  order by about_order asc,about_id desc";
									$rs=mysql_query($sql);
									$rscount=mysql_num_rows($rs);
									if ($rscount==0){ 
										echo "<tr><td colspan='3' class='center'>暂无信息</td></tr></table>";
									}else{

										while($rows=mysql_fetch_assoc($rs)){
											$i++;
										
									?>
								<tr>
									<td class='padding-left'><?php echo $rows['about_title']?><input type="hidden"  name="id<?php echo $i?>" value="<?php echo $rows['about_id']?>" /></td>
									<td class="center"><input type="text" size="4" style='text-align:center;' name="order<?php echo $i?>" value="<?php echo $rows['about_order']?>" /></td>
									<td class="center" style='padding:5px 0;'><a href="aboutedit.php?id=<?php echo $rows['about_id']?>">修改&nbsp;&nbsp;</a> <a href="javascript:if(confirm('您确定要删除吗？')){location.href='about_do.php?act=del&id=<?php echo $rows['about_id'];?>'}">&nbsp;&nbsp;删除</a></td>
								</tr>
									<?php
											}
									}
									?>					
							</table><input name="i" type="hidden" value="<?=$i?>">
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
			alert('菜单大类不能为空');
			$('#foodtype').focus();
			return false;
		}
	}
</script>

</html>
