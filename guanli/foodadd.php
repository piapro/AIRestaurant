<?php
	/**
	 *  food.php
	 */
	require_once("usercheck2.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script src="js/checkform.js" type="text/javascript"></script>
   <script type="text/javascript" src="js/upload.js"></script>
  <script type="text/javascript">
  <!--
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
				url:'food_picup.php',
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
  <title> 菜单添加 - 菜单管理 - 外卖点餐系统 </title>
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
					<h1><a href="food.php">菜单管理</a>&nbsp;&gt;&gt;&nbsp;菜单添加</h1>
					<div id="introAdd">
						<form method="post" action="shop_do.php?act=addfood" id="addForm" name="addForm">
						<p><label>菜的名称：</label><input  class="input input_87" type="text" name="name" id="name"/> <span >* </span></p>
						<p><label>菜的单价：</label><input  class="input input_87" type="text" name="price" id="price" onblur= "if(!/^[0-9\.]+$/.test(this.value))alert('菜的单价必须是数字! ')"/> 元 <span >* </span></p>
						<p>
							<label>菜的图片：</label><span id="loading" style="display:none;"><img src="../images/loading.gif" width="16" height="16" alt="loading" /></span><span id="upinfo" style="color:blue;"></span><input id="upfile1" name="upfile1" value="" type="hidden"/><input id="fileToUpload" type="file" name="fileToUpload" style="height:24px;"/> <input type="button" onclick="return ajaxFileUpload();" value="上传"/> 
						</p>
						<p style='margin-left:100px;'>图片尺寸130*130（注意：如果您选择的模板菜单没有图片，就不需要添加图片）</p>
						<p><label>上架：</label>
						<input type="radio" name="food_status" value="0" checked="checked" />是
						<input type="radio" name="food_status" value="1" />否
						</p>
						<p><label>菜的分类：</label>
						<select name="type" id="type">
						<?php
						//循环菜的大类	
						    $foodtype=$_GET['foodtype'];
							$sql_type = "select foodtype_id,foodtype_name from ".WIIDBPRE."_foodtype where foodtype_shop=".$QIYU_ID_SHOP;
							$res_type = mysql_query($sql_type);
							$numr= mysql_num_rows($res_type);							
							while($row_type = mysql_fetch_assoc($res_type)){
								if($foodtype==$row_type['foodtype_id']){
									$str='selected';
								}else{
									$str='';
								}
						?>
								<option value="<?php echo $row_type['foodtype_id']?>" <?php echo $str?>><?php echo $row_type['foodtype_name']?></option>
						<?php
							}
							
						?>
						</select>
						<?php
							if ($numr==0) echo " <a href='foodtype.php'>添加分类</a>";
						?>
						</p>
						<p><label>菜的说明：</label>
							<textarea id="intro" name="intro" rows="5" cols="30" style="resize:none;"></textarea>
						</p>
						
						<p><label>&nbsp;</label><input type="image" src="../images/button/submit_t.jpg" onClick="return checkFood()" /></p>
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
<script>
	function checkFood(){
		var name=$("#name").val();
		if (name==''){
			alert('菜的名称不能为空');
			$("#name").focus();
			return false;
		}else if(name.length>16){
			
			alert('菜的名称不能大于16个字符');
			$("#name").focus();
			return false;
		}
		if ($("#price").val()==''){
			alert('菜的单价不能为空');
			$("#price").focus();
			return false;
		}
		if ($("#price").val()==0 || $("#price").val()==0.00){
			if(confirm('菜的单价确定要设置为0吗？')){
				document.addForm.action='shop_do.php?act=addfood';
				document.addForm.submit();
			}
			return false;
		}
	}
</script>