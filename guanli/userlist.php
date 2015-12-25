<?php
	/**
	 *  food.php  
	 */
	require_once("usercheck2.php");
	$tel=empty($_GET['tel'])?'':sqlReplace(trim($_GET['tel']));
	$username=empty($_GET['username'])?'':sqlReplace(trim($_GET['username']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style.css" type="text/css"/>
<script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../js/tree.js" type="text/javascript"></script>
<script type="text/javascript" src="js/upload.js"></script>
<title>用户列表 - 外卖点餐系统</title>
<script type="text/javascript">  
function check_all(obj,cName){  
    var checkboxs = document.getElementsByName(cName);  
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}  
}  
</script>
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
					<h1>用户列表</h1>
					<div id="introAdd">
						
						<form method="get" action="userlist.php">
							<p style="margin-left:-25px;float:left;"><label>用户姓名</label><input type="text" name="username" class="input"/></p>
							<p style="float:left;margin-left:10px;"><label>手机号</label><input type="text" name="tel" class="input"/></p>
							<p style="float:left;margin-left:10px;"><input  type="submit" value="搜索"/></p>
						</form><br/>
						<form id="listForm" name="listForm" method="post" >
							<div class="moneyTable feeTable" style="width:668px;">
								<table width="100%">
									<tr>
									    <td style="width:8%;text-align:left; padding:6px 1%;" class="center">
										    <input type="checkbox" value="全选"  onclick="check_all(this,'idlist[]')">全选
										</td>
										<td class="center">用户姓名</td>
										<td class="center">手机号</td>
										<td class="center">登陆次数</td>
										<td class="center">查看订单</td>
										<td class="center">查看详细</td>
										<td class="center">删除</td>
									</tr>
									<?php
										$pagesize=20;
										$startRow=0;
										$where='';
										if (!empty($tel)){
											$where=" and user_phone='".$tel."'";
										}
										if (!empty($username)){
											$where=" and user_phone='".$username."' or user_name='".$username."'";
										}
										$sql="select * from ".WIIDBPRE."_user where 1=1".$where;
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
										
										$sql="select user_id,user_name,user_phone,user_score,user_logincount from ".WIIDBPRE."_user where 1=1".$where." order by user_time desc limit $startRow,$pagesize";
										$rs=mysql_query($sql);
										if ($rscount==0){ 
											echo "<tr><td colspan='7' align='center'>暂无信息</td></tr></table>";
										}else{

											while($rows=mysql_fetch_assoc($rs)){
											
										?>
									<tr>
										<td class="center"><input type="checkbox" class="ipt" name="idlist[]" id="idlist[]" value="<?php echo $rows["user_id"]?>" ?></td> 
										<td class="center" name="user_name"><a href="userintro.php?id=<?php echo $rows['user_id']?>&tel=<?php echo $tel?>&page=<?php echo $page?>"><?php echo $rows['user_name']?></a></td>
										<td class="center" name="user_phone"><?php echo $rows['user_phone']?></td>
										<td class="center"><?php echo $rows['user_logincount']?></td>
										<td class="center"><a href="userorder.php?uid=<?php echo $rows['user_id']?>&key=all">查看</a></td>
										<td class="center"><a href="userintro.php?id=<?php echo $rows['user_id']?>">查看</a></td>
										<td class="center" style='padding:5px 0;'><a href="javascript:if(confirm('您确定要删除吗？')){location.href='user_do.php?act=del&id=<?php echo $rows['user_id'];?>'}">删除</a>
										</td>
									</tr>
										<?php
												}
										}
										?>	
										
										
								</table>
							
								
							</div>
							<?php if($rscount>=1){?>
							<p style="margin-right:20px;margin-left:15px;float:left;">							 
							  <a href="javascript:if(confirm('您确定要删除吗？')){document.listForm.action='user_do.php?&act=xxdel';document.listForm.submit();}"   title="删除"><img  src="../images/button/delete.gif" name="btnSave" /></a>
						    </p>
							<p style="float:left;">
						      <a href="javascript:if(confirm('您确定要发短信吗？')){location.href='sendsms.php'}"  title="发短信"><input type="image" src="../images/button/sms.gif" name="btnSave" value="发短信"  onclick="sms();"></a>			
						    </p><br/>	
							<?php }?>
							
						</form>
						<script type="text/javascript">
								function del(){
									document.listForm.action="user_do.php?act=xxdel"
									document.listForm.submit()
								}


								function sms(){
									document.listForm.action="sendsms.php?act=yes"
									document.listForm.submit()
								}
                            </script>
							<?php 
								if ($rscount>=1){
									echo showPage_admin('userlist.php',$page,$pagesize,$rscount,$pagecount);
								}
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
