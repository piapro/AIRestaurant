<?php
	/**
	 *  网站基本设置 
	 */
	require_once("usercheck2.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <script>
	function ajaxFileUpload()
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'logo_picup.php',
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
						document.getElementById('upfile1').value=info[1];
						$('#logo_img').attr('src','../'+info[1]);
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
	$(function(){
		 $("input[type='radio'][name='protocol_status']").click(function(){
			var show=$(this).val();
			if (show=='1'){
				$('#protocol').show();
			}else if (show=='2'){
				$('#protocol').hide();
			}
			
		 });
	 });

</script>

<script type="text/javascript">
function ajaxFileUpload2()
	{
		$("#loading2")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'icon_picup.php',
				secureuri:false,
				fileElementId:'fileToUpload2',
				dataType: 'json',
				//data:{name:'logan', id:'id'},
				success: function (data, status)
				{				
					data=data.replace('<pre>','');
					data=data.replace('</pre>','');
					var info=data.split('|');
					if(info[0]=="E")
						alert(info[1]);
					else{
						document.getElementById('upinfo2').innerHTML=info[1];
						document.getElementById('upfile2').value=info[1];
						$('#icon_img').attr('src','../'+info[1]);
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

	$(function(){
		 $("input[type='radio'][name='protocol_status']").click(function(){
			var show=$(this).val();
			if (show=='1'){
				$('#protocol').show();
			}else if (show=='2'){
				$('#protocol').hide();
			}
			
		 });
	 });
	
	
 </script>
  <title>网站设置 - 外卖点餐系统</title>
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
					<h1>网站设置</h1>
					<div id="introAdd"  style="position: absolute;">
						<form method="post" action="site_do.php?act=base">
							<p>
								<label>餐厅评论：</label>
								<input type="radio" name="comment_status" value="1" <?php if($site_isshowcomment=='1') echo 'checked';?>>&nbsp;显示&nbsp;&nbsp;<input type="radio" name="comment_status" value="2" <?php if($site_isshowcomment=='2') echo 'checked';?>>&nbsp;不显示
							</p>
							<p class="clear">
								<label>注册协议：</label>
								<input type="radio" name="protocol_status" value="1" <?php if($site_isshowprotocol=='1') echo 'checked';?>>&nbsp;显示&nbsp;&nbsp;<input type="radio" name="protocol_status" value="2" <?php if($site_isshowprotocol=='2') echo 'checked';?>>&nbsp;不显示
							</p>	
							<p class="clear">
								<label style='width:170px;margin-left:17px;'>前台底部是否显示后台管理：</label>
								<input type="radio" name="admin" value="1" <?php if($site_isshowadminindex=='1') echo 'checked';?>>&nbsp;显示&nbsp;&nbsp;<input type="radio" name="admin" value="2" <?php if($site_isshowadminindex=='2') echo 'checked';?>>&nbsp;不显示
							</p>
							<p class="clear">
								<label>餐厅证照：</label>
								<input type="radio" name="card" value="1" <?php if($site_isshowcard=='1') echo 'checked';?>>&nbsp;显示&nbsp;&nbsp;<input type="radio" name="card" value="2" <?php if($site_isshowcard=='2') echo 'checked';?>>&nbsp;不显示
							</p>
							<p class='clear'>
								<label style="margin-left:10px;" >网站LOGO：</label>
								<span id="loading" style="display:none;">
								  <img src="../images/loading.gif" width="16" height="16" alt="loading" />
								</span>
								<span id="upinfo" style="color:blue;"></span>
								<input id="upfile1" name="upfile1" value="<?php echo $logo?>" type="hidden"/>
								<input id="fileToUpload" type="file" name="fileToUpload" style="height:24px;"/> 
								<input type="button" onclick="return ajaxFileUpload();" value="上传"/> * 图片尺寸178*54
							</p>
							<?php
								if(empty($logo)){
									$imgstr='images/logo_default.jpg';
								}else{
									$imgstr=$logo;
								}
							?>
							<p class="clear" style='margin-left:95px;'><img src='../<?php echo $imgstr?>' style="width:178px;"  id='logo_img'/></p>
							<p class='clear'>
							   <label style="margin-left:10px;">网站ICON：</label>
							   <span id="loading2" style="display:none;">
							      <img src="../images/loading.gif" width="16" height="16" alt="loading" />
							   </span>
							   <span id="upinfo2" style="color:blue;"></span>
							   <input id="upfile2" name="upfile2" value="<?php echo $icon?>" type="hidden"/>
							   <input id="fileToUpload2" type="file" name="fileToUpload2" style="height:24px;"/> 
							   <input type="button" onclick="return ajaxFileUpload2();" value="上传"/> * 图片尺寸16*16,32*32,64*64，仅限png格式
							</p>
							<?php
								if(empty($icon)){
									$imgstr2='images/icon_default.png';
								}else{
									$imgstr2=$icon;
								}
							?>
							<p class="clear" style='margin-left:95px;'><img src='../<?php echo $imgstr2?>' style="width:58px;"  id='icon_img'/></p>			
							
							<p class="clear"><label>版权信息：</label><input type="text" id="icp" name="icp" value="<?php echo $site_icp?>" class="input input270"/>  (Copyright © *** 京ICP***)</p>							
							<?php if($site_isshowprotocol=='1'){?>
							<div id='protocol'>
								<p class="clear">协议内容：</p>
								<p >
									<?php   include("fckeditor/fckeditor.php");
												$oFCKeditor = new FCKeditor('intro') ;
												$oFCKeditor->BasePath	= "fckeditor/" ;
												$oFCKeditor->Value		= $site_protocol ;
												$oFCKeditor->Width		= '680px' ;
												$oFCKeditor->ToolbarSet		= 'Basic' ;
												$oFCKeditor->Create() ;
										?>
								</p>
							</div>
							<?php
								}				
							?>
							<p><label >&nbsp;</label><input type="image" src="../images/button/submit_t.jpg"  /></p>
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
</script>

</html>
