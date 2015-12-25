<?php
	
	require_once("usercheck2.php");
	$POSITION_HEADER="修改密码";
	$key=empty($_GET['key'])?'new':sqlReplace(trim($_GET['key']));
	$_SESSION['order_url']=getUrl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<title> 修改密码 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
 <body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="orderBox" class="loginBox">
					<div class="order_title login_title">修改密码</div>
					<form method="post" action="userupdatepw_do.php" id="doForm" name="doForm">
					
				
					<div style="padding-top:30px;padding-bottom:50px;">
						<div class="addList" >
							
						</div>
						<div class="addList addList_r forget"><label>原密码：</label><input type="password" id="pw" class="input" name="pw" /> <span class="errormt"></span></div>
						<div class="addList addList_r forget"><label>新密码：</label><input type="password" id="newpw" class="input" name="newpw" /> <span class="errormt"></span></div>
						<div class="addList addList_r forget"><label>确认密码：</label><input type="password" id="repw" class="input" name="repw" /> <span class="errormt"></span></div>
						<div class="addList">
							<label>&nbsp;</label> <input type="image" src="images/button/submit3.gif" id="send" onClick="return check();"/>
						</div>
						
						<div class="clear"></div>
					</div><!--tab1-->
					</form>
				</div>
			</div>
			<div class="main_bottom"></div>
		</div><!--main_content完-->
		
	
	</div>
	
	<?php
		include("footer.php");
	?>
 </div>
 </body>
</html>
<script type="text/javascript">
					function check(){
						var f=document.getElementById('doForm');
						if(f.pw.value=="")
						{
							alert('密码不能为空');
							f.pw.focus();
							return false;
						}
						if(f.newpw.value=='')
						{
							alert('新密码不能为空');
							f.newpw.focus();
							return false;
						}
						if(f.repw.value=='')
						{
							alert('确认密码不能为空');
							f.repw.focus();
							return false;
						}
						if(f.newpw.value!=f.repw.value)
						{
							alert('两次密码不一致');
							f.repw.focus();
							return false;
						}
					}
</script>
