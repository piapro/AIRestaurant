<?php
	require_once("usercheck.php");
	$reginfo=array();
	$sessreg=empty($_SESSION['reginfo1'])?'':$_SESSION['reginfo1'];
	if($sessreg){
		$reginfo1=explode(',',$_SESSION['reginfo1']);
	}else{
		$reginfo1[0]='';
		$reginfo1[1]='';
	}
	$p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	$shopID=empty($_GET['shopID'])?'0':sqlReplace(trim($_GET['shopID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['shopCircle'])?'0':sqlReplace(trim($_GET['shopCircle']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<script src="js/slide.js" type="text/javascript"></script>
<script src="js/scale.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<script src="js/userreg2.js" type="text/javascript"></script>
<script src="js/TINYBox.js" type="text/javascript" language="javascript"></script>
<link rel="stylesheet" href="js/TINYBox.css" type="text/css"/>
<title> 用户注册 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
 </head>
 <body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="orderBox" class="loginBox">
					<div class="order_title login_title">新人注册</div>
					<div id="regPointer"><img src="images/regflow/1.jpg" alt="" /></div>
					<div class="regH1">填写您的注册信息:</div>
					<form method="post" action="userreg_do.php?p=<?php echo $p?>&shopID=<?php echo $shopID?>&shopSpot=<?php echo $shopSpot?>&shopCircle=<?php echo $shopCircle?>">
					
					<div class="regBox">
						<div class="addList addList_r addList_reg">
							<label>您的手机号：</label><input type="text" id="phone" name="phone" class="input" value="<?php if($reginfo1[0]) echo $reginfo1[0]?>" /> <span class="errormt red" id='phoneTip'>*</span>
						</div>
						
						<div class="addList addList_reg addList_reg">
							<label>&nbsp;</label> <span>您的手机号就是您在<?php echo $SHOP_NAME?>的登录账号。请填<br/>写您常用的手机号，以便送餐员联系您。</span>
						</div>
						<div class="addList addList_r addList_reg">
							<label>设置您的密码：</label><input type="password" id="pw" name="pw" class="input"/> <span class="errormt red">*</span>
						</div>
						<div class="addList addList_reg">
							<label>&nbsp;</label> <span>请输入6-10位密码。</span>
						</div>
						<div class="addList addList_r addList_reg">
							<label>再次输入密码：</label><input type="password" id="repw" name="repw" class="input"/> <span class="errormt red">*</span>
						</div>
						<!--
						<div class="addList addList_reg" style="position:relative;">
							<label style="color:#404040;">手机验证码：</label><input type="text" id="vcode" name="vcode" class="input" style="width:82px;"/> <img src="images/button/getcode.gif" alt="获取" onclick="sendcode()"id="codeimg" style="position:absolute;left:270px;_left:90px;top:3px;*top:5px;cursor:pointer;" /><input type="hidden" id="a" name="a" value="" />
						</div>-->
						<div class="addList addList_r addList_reg" id="codeTip" style="display:none;">
							<label>&nbsp;</label> <span class="habebg red" id='code_html'></span>
						</div>

						<div class="addList addList_r addList_reg" style="position:relative;">
							<label style="color:#404040;">验证码：</label><input type="text" id="vcode" name="vcode" class="input" style="width:82px;"/> <img src="include/imgcode.php" id='code_img' alt="点击更新验证码" style="position:absolute;left:270px;_left:90px;top:3px;*top:5px;cursor:pointer;" onClick='updateCode();'/>
						</div>
						
						<?php
							if ($site_isshowprotocol=='1'){
						?>
						<div class="addList addList_reg">
							<label>&nbsp;</label> <span><input type="checkbox" name="agree" checked/> 我已经看过并同意</span><span id="spandiv">《<?php echo $SHOP_NAME?>用户服务协议》</span>
						</div>
						<div class="addList addList_reg" style="margin-left:45px; display:none;" id="hiddendiv">
						  <div id=""  class="protocol">
							<?php echo $site_protocol?>
						  </div>
						</div>
					<?php
						}
					?>
						
					</div>
					<div class="center_button"><input type="image" src="images/button/regButton.gif" onClick="return checkReg1();" alt="提交" id="regButton"/>
						<!--<img src="images/button/regButton.gif" onClick="alerterr();" alt="提交" />-->
					</div>
					<div class="botton_bg">
						<img src="images/b_bg.jpg" width="308" height="88" alt="" class="pic_bg" />
						<input type="hidden" id="isshowprotocol" value="<?php echo $site_isshowprotocol?>"/>
					</div>
					</form>
				</div>
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
 <SCRIPT LANGUAGE="JavaScript">
<!--
	function updateCode(){
		$("#code_img").attr('src','include/imgcode.php?'+Math.random(1));
	}
	function sendcode(){
		var phone=$("#phone").val();
		if(phone==''){
			$("#phoneTip").html("手机号码不能为空");
			return false;
		}else{
			$("#codeTip").css('display','block');
			var reg=/^1[358]\d{9}$/;
			if(phone.match(reg)){
				 $.get("userpw_do.php", { 
							'act'   :  "regCheckPhone",
							'phone' :  phone
							}, function (data, textStatus){
								
									var rel=data.split("|");
									if (rel[0]=="S")
									{
										$("#phoneTip").html("手机号已存在");
										$("#codeTip").css('display','none');
										return false;
									}else if(rel[0]=="H"){
										$("#code_html").html('获取验证码失败!');
										$("#codeTip").css('display','block');
										return false;
									}else{
										$("#code_html").html('验证码已发送，请注意查收！');
										$("#a").val(rel[1]);
										$("#codeTip").css('display','block');
										return false;
									}
							});
			}else{
				$("#phoneTip").html("手机号码格式不正确");
				$("#codeTip").css('display','none');
				return false;
			}
		}

	}

	function checkReg1(){
		//var code=$("#a").val();
		var vcode=$("#vcode").val();
		var isshowprotocol=$("#isshowprotocol").val();
		$(".input").trigger('blur');
		var numError = $('.onError').length;
		if(numError){
			return false;
		} 
		
		if (!$('[name=agree]:checkbox').attr("checked") && isshowprotocol=='1')
		{
			TINY.box.show('请选择同意协议复选框!',0,160,60,0,10);
			return false;
		}
		if (vcode==''){
			TINY.box.show('验证码不能为空!',0,160,60,0,10);
			return false;
		}
		/*
		if (code!=vcode){
			TINY.box.show('验证码错误!',0,160,60,0,10);
			return false;
		}*/

	}
//-->
</SCRIPT>


<script type="text/javascript">
	/*$(function(){
		$("#spandiv").click(function(){
		$("#hiddendiv").css('display','block');
		})
	})*/
$(function(){
	$("#spandiv").toggle(
	  function () {
	    $("#hiddendiv").css('display','block');
	  },
	  function () {
	    $("#hiddendiv").css('display','none');
	  }
	);
	
	$("#regButton").hover(function(){
					 $(this).attr('src','images/button/regButton_1.gif');
			 },function(){
					 $(this).attr('src','images/button/regButton.gif');
	});
	$("#regButton").mousedown(function(){
	  $(this).attr('src','images/button/regButton_2.gif');
	  
	});
	
	
})

</script>