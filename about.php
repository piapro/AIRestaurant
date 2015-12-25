<?php
	/**
	 *  service.php  
	 */
	require_once("usercheck.php");
	$id=sqlReplace(trim($_GET['id']));
	checkData($id,"ID",0);
	$sql="select * from ".WIIDBPRE."_about where about_id=".$id;
	$result=mysql_query($sql);
	$row=mysql_fetch_assoc($result);
	if(!$row){
		alertInfo('非法操作','index.php',0);
	}else{
		$title = $row['about_title'];
		$type = $row['about_type'];
		$content = $row['about_content'];
	}	
	

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
<title> <?php echo $title?> - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
 <body>
 <div id="container">
	<?php
		include("header_index.php");
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="about_title">
					<span class="yellow"><?php echo $title?>
				</div>	
				<div id="service_right">
					
					<div id="text">
						<?php echo $content?>
					</div>
				</div>
				<div id="service_left">
					<div class="opentime">
						<h3><?php echo date('H:i',strtotime($SHOP_OPENSTARTTIME))." - ".date('H:i',strtotime($SHOP_OPENENDTIME));?></h3>
					</div>
					<div class="telphone">
						<h3><?php echo $SHOP_TEL;?></h3>
					</div>
				</div>
				<div class="clear"></div>
				
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
