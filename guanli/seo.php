<?php
	/**
	 *  shopadd.php 
	 */
	require_once("usercheck2.php");
	$sql="select * from qiyu_seo where seo_type=1";
	$rs=mysql_query($sql);
	$count=mysql_num_rows($rs);
	$i=0;
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$title=$rows['seo_title'];
		$keywords=HTMLDecode($rows['seo_keywords']);
		$description=HTMLDecode($rows['seo_description']);
	}
	if($title=='') $title='<?php echo $SHOP_NAME?> - 让外卖如约而至';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <script type="text/javascript" src="js/shopadd.js"></script>
  <title>SEO优化 - 外卖点餐系统</title>
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
					<h1>SEO优化</h1>
					
					
					<div id="introAdd">
						
						<form method="post" action="seo_do.php?act=index">
							
						
						<p><label>网站标题:</label><input type="text" id="name" name="title" class="input input270" value="<?php echo $title?>" /><span class="start"> * 建议少于80字符</span></p>
						<p><label>网站关键字:</label><textarea name="keywords" style='width:270px;height:50px;resize:none;'><?php echo $keywords?></textarea><span class="start"> * 建议少于100字符</span></p>
						<p id="pic1">
						<p><label>网站描述:</label><textarea name="description" style='width:270px;height:120px;resize:none;'><?php echo $description?></textarea><span class="start"> * 建议少于200字符</span></p>
						<p><label>&nbsp;</label><input type="image" src="../images/button/submit_t.jpg"/></p>
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
</html>
