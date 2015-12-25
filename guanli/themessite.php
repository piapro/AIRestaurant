<?php
	/**
	 *  手机模板设置 
	*/
	require_once("usercheck2.php");
	require_once("inc/configue.php");
	require_once("style_default.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta name="Author" content="微普科技http://www.wiipu.com"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <link rel="stylesheet" href="style.css" type="text/css"/>
  <link rel="stylesheet" href="style2.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/lightbox/js/jquery.lightbox-0.5.js"></script>
  <script type="text/javascript" src="js/jscolor/jscolor.js"></script>
  <link rel="stylesheet" href="js/lightbox/css/jquery.lightbox-0.5.css" type="text/css" />
  <title> 手机模板设置 - 微普外卖点餐系统 </title>
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
		<div class="listintor">		
			<div class="header2"><span style="font-size:18px">手机模板设置</span>
			</div>
			<div class="fromcontent">
				<form id="form2" name="addForm" method="post" action="themessite_do.php" >
					<p><label>整站：</label>文字颜色 <input class="color" name="all_color"  value="<?php echo $all_color?>"> 说明性文字颜色 <input class="color" name="all_desColor" value="<?php echo $all_desColor?>"> 超链接颜色 <input class="color" name="all_aColor"  autocomplete="off" class="color" value="<?php echo $all_aColor?>">超链接用户名称颜色 <input class="color" name="all_aUcolor"  autocomplete="off" class="color" value="<?php echo $all_aUcolor?>"></p>					

					<p><label>一级标题：</label>背景色 <input class="color" name="h1_groundColor"  value="<?php echo $h1_groundColor?>"><!--  文字颜色 <input class="color" name="h1_color" value="<?php echo $h1_color?>"> --> 超链接颜色 <input class="color" name="h1_aColor"  autocomplete="off" class="color" value="<?php echo $h1_aColor?>"> 边框的颜色 <input class="color" name="h1_borderColor"  autocomplete="off" class="color" value="<?php echo $h1_borderColor?>"></p>

					<p><label>二级标题：</label>背景色 <input class="color" name="h2_groundColor"  value="<?php echo $h2_groundColor?>"><!--  文字颜色 <input class="color" name="h2_color" value="<?php echo $h2_color?>"> 超链接颜色 <input class="color" name="h2_aColor"  autocomplete="off" class="color" value="<?php echo $h2_aColor?>"> --> 边框的颜色 <input class="color" name="h2_borderColor"  autocomplete="off" class="color" value="<?php echo $h2_borderColor?>"></p>					

					<p><label>导航栏：</label>文字颜色 <input class="color" name="key_color"  value="<?php echo $key_color?>"> 超链接颜色 <input class="color" name="top_aColor"  autocomplete="off" class="color" value="<?php echo $top_aColor?>"></p>

					<p><label>头尾样式：</label>背景色 <input class="color" name="top_groundColor"  value="<?php echo $top_groundColor?>"> <!-- 文字颜色 <input class="color" name="top_color" value="<?php echo $top_color?>">  超链接颜色 <input class="color" name="top_aColor"  autocomplete="off" class="color" value="<?php echo $top_aColor?>">--></p>

					<p><label>提示文字：</label>文字颜色 <input class="color" name="point_color"  value="<?php echo $point_color?>"> 超链接 <input class="color" name="point_aColor"  value="<?php echo $point_aColor?>"></p>

					<p><label>分割线：</label>颜色 <input class="color" name="line_color"  value="<?php echo $line_color?>"> </p>

					<!--<p><label>整体：</label>背景色 <input class="color" name="3g_groundColor"  value="<?php echo $g_groundColor?>"> 字体颜色 <input class="color" name="3g_color"  value="<?php echo $g_color?>">  超链接 <input class="color" name="3g_aColor"  value="<?php echo $g_aColor?>"> </p>-->
					<!-- <p><label>评论页隔行变色：</label>背景色 <input class="color" name="row_groundColor"  value="<?php echo $row_groundColor?>"></p> -->

					<!-- <p><label>logo：</label>文字颜色 <input class="color" name="logo_color" value="<?php echo $logo_color?>"> 文字大小 <input style="width:30px" name="fontSize" value="<?php echo $fontSize?>"> px</p> -->
						
					<p><label>&nbsp;</label><input type="image" src="images/submit1.gif" width="56" height="20" alt="提交"/><a href=themessite_do.php?type=2><img src="images/reset1.gif" style="position:static;padding-left:10px" alt="提交"/></a>
					</p>					
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
	$(function() {
		$('#introAdd a').lightBox();
	});
</script>
</html>
