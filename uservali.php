<?php
	
	require_once("usercheck.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<script src="js/slide.js" type="text/javascript"></script>
<script src="js/scale.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<script src="js/userreg.js" type="text/javascript"></script>
<title> 手机验证 - 用户注册 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
<body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div id="shadow"><img src="images/shadow.gif" width="955" height="9" alt="" /></div>
		<div id="tab5">
			<ul>
				<li id="t1"><img src="images/tab_reg.gif" alt="" /></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="main_content main_content_r">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="tab_box_r" class="inforBox">
				<form method="post" action="uservali2.php">
					
				
					<div style="padding-top:30px;">
						<div class="addList" style="margin-top:0;padding-top:10px;height:40px;
						line-height:40px;">
							<label style="margin:-0;"><img src="images/icon2.gif" alt="" /></label> <span class="red" style="font-size:18px;margin-left:10px;">我们已将验证码发送到您的手机上!</span>
						</div>
						<div class="addList addList_r"><label>&nbsp;</label><input type="text" id="code" class="input" name="code" value="输入验证码" onFocus="this.value='';"/> <span><a href="#" class="gray">还未收到验证码</a></span>
						
						</div>
						
						<div class="addList">
							<label>&nbsp;</label> <input type="image" src="images/button/vali.gif" id="send" class="valiButton"/>
						</div>
						<div class="addList">
							<label>&nbsp;</label> <span style="margin-left:230px;">等不及了，<a href="index.php" class="gray">先去点餐</a></span>
						</div>
						<div class="clear"></div>
					</div><!--tab1-->
					</form>
				</div><!--tab_box_r-->
				
				
			</div>
			<div class="main_bottom"></div>
		</div><!--main_content完-->
		<?php
			require_once('about.inc.php');
		?>
	
	</div>
	
	<?php
		require_once('footer.php');
	?>
 </div>
 <script type="text/javascript">
//<![CDATA[
	$(function(){
	   $("#area").change(function(){
		   var area=$("#area").val();
			$.post("area.ajax.php", { 
						'area_id' :  area,
							'act':'circle'
					}, function (data, textStatus){
							if (data==""){
								$("#circle").html("<option value=''>没有商圈</option>")
							}else
								$("#circle").html("<option value=''>请选择</option>"+data);
					});
	   })
	})

	$(function(){
	   $("#circle").change(function(){
		   var circle=$("#circle").val();
			$.post("area.ajax.php", { 
						'circle_id' :  circle,
						'act':'spot'
					}, function (data, textStatus){
							if (data==""){
								$("#spot").html("<option value=''>没有地标</option>")
							}else
								$("#spot").html(data);
						
					});
	   })
	})
//]]>
</script>

 </body>
</html>
