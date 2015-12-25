<?php
	/**
	 *  food.php 
	 */
	require_once("usercheck2.php");
	$type=sqlReplace($_GET['type']);
	if ($type=='1'){
		$title='营业执照';
	}else if ($type=='2'){
		$title='卫生许可证';
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <script type="text/javascript">
  <!--
	function ajaxFileUpload()
	{
		$.ajaxFileUpload
		(
			{
				url:'shop_cartpicup1.php',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					data=data.replace('<pre>','');
					data=data.replace('</pre>','');
					var info=data.split('|');
					if(info[0]=="E")
						alert(info[1]);
					else{
						
						document.getElementById('upinfo').innerHTML=info[1];
						document.getElementById('upfile').value=info[1];
						
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;
	}
  //-->
  </script>
  <title> 修改<?php echo $title?> - 餐厅证照 - 微普外卖点餐系统 </title>
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
					<h1><a href="shopcard.php">餐厅证照</a> &gt;&gt; 证照修改</h1>
					<div id="introAdd">
						<form method="post" action="shop_do.php?act=card<?php echo $type?>">
							<p>
								<label><?php echo $title?>：</label><span id="loading" style="display:none;"><img src="../images/loading.gif" width="16" height="16" alt="loading" /></span><span id="upinfo" style="color:blue;"><?php echo $SHOP_LICENSEPIC?></span> <input id="upfile" name="upfile" value="<?php echo $SHOP_LICENSEPIC?>" type="hidden"/><input id="fileToUpload" type="file" name="fileToUpload" style="height:24px;"/> <input type="button" onclick="return ajaxFileUpload();" value="上传"/>
							</p>
							<p style="margin-left:42px;margin-bottom:10px;color:red;">
								提示：图片格式只能为（jpg、gif、png），建议图片大小400px*300px，图片大小不超过2M。</p>
							<p><label>&nbsp;</label><input type="image" src="../images/button/submit_t.jpg" /></p>
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
