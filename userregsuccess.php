<?php
	
	require_once("usercheck2.php");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<title> 用户注册 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
<body>
 <script type="text/javascript">
 <!--
	setTimeout("location.href='index.php'",5000);
 //-->
 </script>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="orderBox">
					<div class="order_title">注册成功</div>
					<div class="success">
						<p><img src="images/ok.jpg" width="28" height="25" alt="" /> 您已成功注册。</p>
						
						<p><a href="index.php">进入首页</a></p>
					</div>
				</div>
				
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
