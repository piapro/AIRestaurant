<?php
	/**
	 *  userquickreg.php 
	 */
	require_once("usercheck.php");
	$shopID=sqlReplace(trim($_GET['shopID']));
	$sql="select * from qiyu_shop where shop_id=".$shopID." and shop_status='1'";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if (!$rows){
		alertInfo("错误","index.php",0);	
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="style.css" type="text/css"/>
  <script src="js/jquery-1.3.1.js" type="text/javascript"></script>
  <title> 快速注册 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
 </head>
 <body>
 <script type="text/javascript">
//<![CDATA[
$(function(){
         //文本框失去焦点后
	    $('.input').blur(function(){
			 var $parent = $(this).parent();
			 if( $(this).is('#phone') ){
					if( this.value=="" || this.value.length < 11 ||  this.value.length > 11){
					    var errorMsg = '请输入正确的手机号.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError');
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError');
						
					}
			 }
			  if( $(this).is('#name') ){
					if( this.value==""){
					    var errorMsg = '姓名不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError');
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError');
					}
			 }
			 if ($(this).is("#area")){
				if( this.value==""){
					    var errorMsg = '区域不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError');
				}
			 }

			  if( $(this).is('#address') ){
					if( this.value==""){
					    var errorMsg = '地址不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError');
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError');
					}
			 }
		}).keyup(function(){
		   $(this).triggerHandler("blur");
		}).focus(function(){
	  	   $(this).triggerHandler("blur");
		});//end blur

		
		//提交，最终验证。
		 $('#send').click(function(){
				$("form :input.required").trigger('blur');
				var numError = $('form .onError').length;
				if(numError){
					return false;
				} 

				if($("#area").val()==""){
						var $parent = $("#area").parent();
						var errorMsg = '区域不能为空.';
                        $parent.find('.red').text(errorMsg);
	
					    return false;
				}
				if($("#circle").val()==""){
						var $parent = $("#circle").parent();
						var errorMsg = '商圈不能为空.';
                        $parent.find('.red').text(errorMsg);
	
					    return false;
				}
				if($("#spot").val()==""){
						var $parent = $("#spot").parent();
						var errorMsg = '地标不能为空.';
                        $parent.find('.red').text(errorMsg);
	
					    return false;
				}
		 });

		
})

$(function(){
	   $("#area").change(function(){
		   var area=$("#area").val();
			$.post("area.ajax.php", { 
						'area_id' :  area,
							'act':'circle'
					}, function (data, textStatus){
							if (data==""){
								$("#circle").html("<option value=''>没有商圈</option>")
							}else
								$("#circle").html("<option value=''>请选择</option>"+data);
					});
	   })
	})

	$(function(){
	   $("#circle").change(function(){
		   var circle=$("#circle").val();
			$.post("area.ajax.php", { 
						'circle_id' :  circle,
						'act':'spot'
					}, function (data, textStatus){
							if (data==""){
								$("#spot").html("<option value=''>没有地标</option>")
							}else
								$("#spot").html(data);
						
					});
	   })
	})
//]]>
</script>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div id="shadow"><img src="images/shadow.gif" width="955" height="9" alt="" /></div>
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="tab_box_r" class="inforBox">
				<div class="big_title">登录或直接下单</div>
					<div id="loginLeft">
					<form method="post" action="userquickreg_do.php?shopID=<?php echo $shopID?>">
						
					
						<div class="addList addList_r loginlist" style="margin-left:38px;margin-bottom:30px;">
							<p style="color:#000000;">现在不想注册?直接下单:</p>
							<p><span>如果您没有旗鱼账号但是想以后再注册，可以直接下单，只需填写您的送餐地址和手机号。</span></p>
						</div>
						<div class="addList addList_r loginlist" style="margin-top:0;padding-top:10px;">
							<label>您的手机号：</label><input type="text" name="phone" id="phone" class="input"/> <span class="red"></span>
						</div>
						<div class="addList loginlist">
							<label>&nbsp;</label> <span>手机号将用于您登录本站、取回密码以及送餐联系，<br/>请填 写您常用的手机号。</span>
						</div>
						
						<div class="addList addList_r loginlist"><label>您的姓名：</label><input type="text" id="name" name="name" class="input"/> <span class="red"></span>
						
						</div>
						<div class="addList addList_r loginlist">
							<label>您的地址：</label>北京市 <select id="area" name="area" class="select">
							<option value="">请选择</option>
							<?php
								$sql_area = "select * from ".WIIDBPRE."_area";
								$rs_area = mysql_query($sql_area);
								while($row_area = mysql_fetch_assoc($rs_area)){
									echo '<option value="'.$row_area['area_id'].'">'.$row_area['area_name'].'</option>';
								}
							?>
							</select> 区 <select id="circle" name="circle" class="select">
								<option value="">请选择</option>
							</select> 商圈 <span class="red"></span>
						</div>
						<div class="addList addList_r loginlist">
							<label>&nbsp;</label>选择距离您最近的地标 <select id="spot" class="select" name="spot">
									<option value="">请选择</option>
								</select> <span class="red"></span>
						</div>
						<div class="addList addList_r loginlist">
							<label>您的详细地址：</label><input type="text" id="address" name="address" class="input"/> <span class="red"></span>
						</div>
						<div class="addList loginlist">
							<label>&nbsp;</label> <span>请填写您的准确地址，以便及时收到餐点。<br/> 例如：西四北大街888号11层1102室</span>
						</div>
					
						<div class="addList loginlist">
							<input type="image" src="images/sure.gif" style="margin-left:199px;" id="send"/>
						</div>
						</form>
					</div><!--leftwan-->
					<div id="loginRight">
						<p>已经注册了旗鱼点餐网账号？ <a href="userlogin.php">立刻登录</a></p>
						<p style="margin-top:50px;">还没有旗鱼点餐网账号？ <a href="userreg.php">马上注册一个</a></p>
						<p style="margin-top:5px;"><span>注册旗鱼点餐网账号，即可体验快捷点餐<br/>的便利， 享受网站的各项优惠折扣。</span></p>
					</div>
					<div class="clear"></div>
				</div><!--tab_box_r-->
				
				
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
