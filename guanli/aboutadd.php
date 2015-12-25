<?php
	/**
	 *  shopadd.php 
	 */
	require_once("usercheck2.php");
	//var_dump($SHOP_INFOS);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style.css" type="text/css"/>
<script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../js/tree.js" type="text/javascript"></script>
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript" src="js/shopadd.js"></script>
<title>添加底部链接 - 外卖点餐系统</title>
<script type="text/javascript">
	function radioShow(){
		var myradio=document.getElementsByName("about_type");  //
		var div=document.getElementById("about").getElementsByTagName("div");
		for(i=0;i<div.length;i++){
			if(myradio[i].checked){
				div[i].style.display="block";
			}else{
				div[i].style.display="none";
			}
		}
	}
</script>
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
					<h1><a href="about.php">底部链接</a> &gt;&gt; 添加底部链接</h1>
					<div id="introAdd">
						<form method="post" action="about_do.php?act=add">
						<p>标题：<input type="text" id="title" name="title" class="input input270"  /> *</p>
						<p>类型：<input type="radio" name="about_type" value="1" checked onclick="radioShow();" />内容   
						         <input type="radio" name="about_type" value="2" onclick="radioShow();" />链接 
						</p>
						<div id="about">
						    <div class="about1" name="about" >
								<p>内容：</p>
								<p style='margin-top:20px;'>
									<?php   include("fckeditor/fckeditor.php");
										$oFCKeditor = new FCKeditor('content') ;
										$oFCKeditor->BasePath	= "fckeditor/" ;
										$oFCKeditor->Value		= '' ;
										$oFCKeditor->Width		= '680px' ;
										$oFCKeditor->ToolbarSet		= 'Basic' ;
										$oFCKeditor->Create() ;
								 ?>
								</p>
						    </div>

							<div class="about2"  name="about" style="display:none;" >
								<p>链接：<input type="text" name="about_href" width="220" value="http://">(http://开头)</p>
						    </div>
						</div>
						
						<p style='text-align:center'><input type="image" src="../images/button/submit_t.jpg" onClick="return check_about();"/></p>
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
