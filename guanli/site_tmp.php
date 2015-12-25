<?php
	/**
	 *  网站模板设置
	 */
	require_once("usercheck2.php");
	require_once("inc/configue.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <link rel="stylesheet" href="style.css" type="text/css"/>
  <link rel="stylesheet" href="style2.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/lightbox/js/jquery.lightbox-0.5.js"></script>
  <link rel="stylesheet" href="js/lightbox/css/jquery.lightbox-0.5.css" type="text/css" />
  <title>网站模板设置 - 点餐系统</title>
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
					<h1>网站模板设置</h1>					
					<div id="introAdd">
						<form method="post" action="site_do.php?act=tmp">
						<p style="margin-left:42px;color:red;">提示：
						
						</p>
						<p  style="margin-left:42px;color:red;">
							1、由于模板的差异，前台功能、图片显示可能有所变化，切换模板时可能导致图片的不正常显示。
						</p>
						<p  style="margin-left:42px;color:red;">
							2、不要过于频繁的更换模板，以防数据出现误差。
						</p>
						
							<?php 
								foreach ($templaleSortArray as $key => $tmp){
									if ($key>0){
							?>
										<div class='tmp_box'>
											<table><tr><td style='text-align:center;height:244px;width:234px;vertical-align:middle;'><a href="images/tmp/big/<?php echo $key?>.jpg"><img src="<?php echo $templaleImgArray[$key]?>" alt="" /></a></td></tr></table>
											<p><?php echo $templaleNameArray[$key]?> <input type="radio" name="tmp" value="<?php echo $key?>" <?php if ($site_tmp==$key) echo "checked"?>/></p>
										</div>
							<?php
									}
								}
							?>
							
							<div class="clear"></div>
							<p class="clear" style='margin-top:50px;text-align:center;'><label >&nbsp;</label><input type="image" src="../images/button/submit_t.jpg"  /></p>
						</form>						
					</div>					
					<div class="clear"></div>
						<p style="margin:10px 0;"><a href="themessite.php" style=" font-size:16px;font-family:Microsoft YaHei,宋体,Arial;text-decoration:none; color:#000; padding-bottom:2px;font-weight:bold">手机模板设置</a></p>
						<div style="margin-left:70px; margin-top:25px;">
						   <a href="themessite.php"><img alt="" src="images/tmp/mobile.jpg" style="width:234px" /></a>		
						</div>
						<p style="margin-left:120px;margin-top:20px;"><a href="themessite.php">手机版(设置界面风格)</a></p>
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
	$(function() {
		$('#introAdd a').lightBox();
	});
</script>
</html>
