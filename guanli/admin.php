<?php
	/**
	 *  管理首页
	 */
	require_once("usercheck2.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <title> 管理首页 - 外卖点餐系统 </title>
  <style>
	#main #introAdd li{
		width:100%;
		margin-left:20px;
	}
	#main #introAdd li a{
		color:#000;
	}
	#main #introAdd li span{
		position:absolute;
		left:550px;
		top:0;

	}
  </style>
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
					<h1>管理首页</h1>
					
					<div id="introAdd">
					
							<?php
								$isShow=false;
								if (empty($SHOP_NAME) || empty($SHOP_TEL) || empty($SHOP_OPENSTARTTIME) || empty($SHOP_OPENENDTIME) || empty($SHOP_MAINFOOD) || empty($SHOP_ADDRESS)){
									$isShow='true';
								}
								if (!$isShow && empty($logo)){
									$isShow='true';
								}
								if (!$isShow){
									$sql1="select * from  qiyu_delivertime";
									$rs=mysql_query($sql1);
									$rows=mysql_fetch_assoc($rs);
									if (!$rows){
										$isShow='true';
									}
								}
								if (!$isShow){
									if ((empty($site_wiiyunsalt) || empty($site_wiiyunaccount) || empty($SHOP_PHONE)) && $site_sms=='1'){
										$isShow='true';
									}
								}

								if ($isShow){
							?>
									<h2 class='h2_small warning'>必须做完以下操作网站才能正常使用！</h2>
							
							<?php
								}
								if (empty($SHOP_NAME) || empty($SHOP_TEL) || empty($SHOP_OPENSTARTTIME) || empty($SHOP_OPENENDTIME) || empty($SHOP_MAINFOOD) || empty($SHOP_ADDRESS)){
									echo "<p><a href='shopadd.php'>设置餐厅基本信息</a></p>";
								}
								if (empty($logo)){
									echo "<p><a href='site.php'>设置网站LOGO</a></p>";
								}
								$sql1="select * from  qiyu_delivertime";
								$rs=mysql_query($sql1);
								$rows=mysql_fetch_assoc($rs);
								if (!$rows){
									echo "<p><a href='shopdelivertime.php'>设置送餐时段</a></p>";
								}
								if ((empty($site_wiiyunsalt) || empty($site_wiiyunaccount) || empty($SHOP_PHONE)) && $site_sms=='1'){
									echo "<p><a href='site_sms.php'>短信设置</a></p>";
								}
							?>

                            

							<h2 class='h2_small' style='margin:50px auto 20px;'>快速搜索</h2>							  
							  <form  name="listForm" method="get" action="userlist.php"  id="listForm">
							      <input name="username" class="in1" type="text" style="width:190px; height:16px; color:#DFDFDF;margin-bottom:5px;float:left" value="请输入用户姓名或手机号" onfocus="if(this.value=='请输入用户姓名或手机号'){this.value=''};this.style.color='black';" 
								  onblur="if(this.value==''||this.value=='请输入用户姓名或手机号'){this.value='请输入用户姓名或手机号';this.style.color='#DFDFDF';}">
								  <input style="margin-left:10px;float:left;" type="image" src="../images/button/search.gif" />	  
							  </form><br/><br/>

                              <form  name="listForm" method="get" action="userorder.php"  id="listForm">
							      <input name="order" class="in1" type="text" style="width:190px; height:16px; color:#DFDFDF;float:left;" value="请输入用户订单号" onfocus="if(this.value=='请输入用户订单号'){this.value=''};this.style.color='black';" onblur="if(this.value==''||this.value=='请输入用户订单号'){this.value='请输入用户订单号';this.style.color='#DFDFDF';}">
								  <p style="display:none">								   
								    <select name="key" style="display:none">
										<option value="all">全部</option>
										<option value="0">未确认</option>
										<option value="1">已确认</option>
										<option value="2">商家取消</option>
										<option value="3">用户取消</option>
										<option value="4">已完成</option>
										<option value="5">已修改</option>
							        </select>
									</p>
								  <input style="margin-left:10px;mrgin-top:-10px;float:left;" type="image" src="../images/button/search.gif" />		  
							  </form>

							<h2 class='h2_small' style='margin-top:50px;'>统计</h2>
							<p><a href="userorder.php?key=0">新订单(<?php echo getOrderNewCountByState(0);?>)</a></p>
							<p><a href="subscribe.php">预约订单(<?php echo getSubscribeCount()?>)</a></p>
							<h2 class='h2_small' style='margin-top:50px;'>系统信息</h2>
							<p>版本号：<?php echo $version.'('.$subversion.')'?></p>
							<p>更新时间：<?php echo $updateTime?></p>
							<h2 class='h2_small' style='margin-top:50px;'>软件动态</h2>
							<ul>
								<script language='javascript' src="http://www.wiipu.com/news/diancan.php"></script>
							</ul>
							
						
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
