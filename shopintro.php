<?php 
	/**
	 *  index.php 
	 */
	require_once("usercheck.php");
	$id=sqlReplace(trim($_GET['id']));
	$sql="select * from qiyu_indexteachfood where teachfood_id=".$id;
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$title=$rows['teachfood_title'];
		$content=$rows['teachfood_content'];
		$addtime=$rows['teachfood_addtime'];
	}else{
		alertInfo('非法操作','index.php',0);
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/search.js" type="text/javascript"></script>
<script src="js/search_new.js" type="text/javascript"></script>
<script src="js/scroll.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>

   <!--[if IE 6]> 
  <script src="js/jquery.pngFix.js" type="text/javascript"></script>
  <![endif]-->
   
  <title> <?php echo $title?> - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
 </head>
 <body>
 	
 <div id="container">
	<?php
		require_once('header_index_white.php');		
	?>
	<div id="menu_white">
		<div id="menu_white_main">
			
		</div>
	</div>	
	<div id="introBox_main">
		<div class="content">
			<h1><?php echo $title?></h1>
			<p class="time"><?php echo substr($addtime,0,10)?></p>
			<div class="text">
				<?php echo $content?>

			</div>
		</div>
	</div>
	<div style="margin-top:20px;">
	<?php
		require_once('footer.php');
	?>
	</div>
 </div>
 </body>
  <script type="text/javascript">
 <!--
	getCount();
		self.setInterval("getCount()",3000);
		function getCount(){
			$.post("getcount.ajax.php", function (data, textStatus){
				$("#count").html(data);
									
											
			});
		}	
	
 //-->
 </script>

</html>