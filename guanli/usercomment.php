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
  <title>用户评论 - 外卖点餐系统</title>
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
					<h1>用户评论</h1>
					<div id="introAdd">
						<form  name="listForm" method="post" action="" id="listForm">
						<div class="moneyTable feeTable" style="width:668px;margin-top:0px;padding-top:0" >
						<p style="color:red;">小提示：</p>
						<p style="color:red;margin-left:30px;margin-top:10px;">1、可以在“网站设置”里设置前台是否显示评论。</p>
						<p style="margin-bottom:30px;color:red;margin-left:30px;margin-top:10px;">2、用户评论时间可自主编辑，编辑完成后点击下面“保存时间”按钮即可。</p>
							<table width="100%">
								<tr>
									<td class='center'>用户</td>
									<td class='center'>内容</td>
									<td class='center'>时间</td>
									<td class='center'>状态</td>
									<td class='center'>操作</td>
								</tr>
								<?php
									$pagesize=10;
										$startRow=0;
										$sql="select * from qiyu_comment,qiyu_user where comment_user=user_id";
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
										
										$sql="select * from qiyu_comment,qiyu_user where comment_user=user_id  order by comment_addtime desc limit $startRow,$pagesize";
										$rs=mysql_query($sql);
										if ($rscount==0){ 
											echo "<tr><td colspan='5' class='center'>暂无信息</td></tr></table>";
										}else{
											$i=0;
											while($rows=mysql_fetch_assoc($rs)){
												$i++;
												$type=$rows['comment_type'];
												if($type=='0'){
													$type='未审核';
													$link='<a href="usercomment_do.php?act=type&id='.$rows['comment_id'].'">审核</a>';
												}
												if($type=='1'){
													$type='审核';
													//$link='<a href="comment_do.php?id='.$rows['comment_id'].'">未审核</a>';
													$link='';
												}
												
										
									?>
								<tr>
									<td class='center'><a href="userintro.php?id=<?php echo $rows['user_id']?>"><?php echo $rows['user_name']?></a></td>
									<td ><?php echo $rows['comment_content']?></td>
									<td class='center'>
											<input name="id<?php echo $i;?>" type="hidden" value="<?php echo $rows["comment_id"];?>" />
											<input name="time<?php echo $i;?>" type="text" size="20" value="<?php echo $rows["comment_addtime"];?>" />
									</td>
									<td  class='center'><?php echo $type?></td>
									<td class='center' style='padding:5px 0;'> <a href="javascript:if(confirm('您确定要删除吗？')){location.href='usercomment_do.php?act=del&id=<?php echo $rows['comment_id'];?>'}">删除</a>&nbsp;&nbsp;<?php echo $link?></td>
								</tr>
									<?php
											}
									}
									?>					
							</table>
							<p style="margin-bottom:10px;">
								<a href="javascript:document.listForm.action='usercomment_do.php?act=savetime';document.listForm.submit();"><img src="../images/button/timeadd.jpg" alt="" /></a>
							</p>
							<input name="i" type="hidden" value="<?php echo $i;?>">
						<?php 
							if ($rscount>=1){
								echo showPage_admin('usercomment.php',$page,$pagesize,$rscount,$pagecount);
							}
						?>
							
						</div>
						</form>
						
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
