<?php
	require_once("usercheck.php");
	$p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	$shopID=empty($_GET['shopID'])?'0':sqlReplace(trim($_GET['shopID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['shopCircle'])?'0':sqlReplace(trim($_GET['shopCircle']));
	if(empty($_SESSION['phone'])||empty($_SESSION['pw']))
		alertInfo("非法操作","index.php",0);
	$reginfo=array();
	$sessreg=empty($_SESSION['reginfo2'])?'':$_SESSION['reginfo2'];
	if($sessreg){
		$reginfo=explode(',',$_SESSION['reginfo2']);
	}else{
		$reginfo[0]='';
		$reginfo[1]='';
		$reginfo[2]='';
		$reginfo[3]='';
		$reginfo[4]='';
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
<script src="js/tab.js" type="text/javascript"></script>
<script src="js/slide.js" type="text/javascript"></script>
<script src="js/scale.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<script src="js/userreg3.js" type="text/javascript"></script>
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
					<div id="regPointer"><img src="images/regflow/2.jpg" alt="" /></div>
					<div class="regH1">填写您的送餐地址:</div>
					<form method="post" action="userreg_do2.php?p=<?php echo $p?>&shopID=<?php echo $shopID?>&shopSpot=<?php echo $shopSpot?>&shopCircle=<?php echo $shopCircle?>">
					<div class="regBox">
						
						
						
						<div class="addList addList_r addList_reg">
							<label>您的详细地址：</label><input type="text" id="address" name="address" class="input" style="width:232px;" value="<?php if($reginfo[4]) echo $reginfo[4]?>" /> <span class="errormt red">*</span>
						</div>
						<div class="addList addList_reg">
							<label>&nbsp;</label> <span>请填写您的准确地址，以便及时收到餐点。<br/>例如：西四北大街888号11层1103室。</span>
						</div>
						<div class="addList addList_r addList_reg" style="margin-top:19px;">
							<label>怎么称呼您：</label><input type="text" id="name" name="name" style="width:232px;" class="input" value="<?php if($reginfo[0]) echo $reginfo[0]?>" /> <span class="errormt red">*</span>
						</div>
					</div>
					<div class="center_button"><input type="image" src="images/button/regFinish.jpg" onClick="return checkReg();" alt="提交" id="finishButton"/>
					</div>
					<div class="botton_bg">
						<img src="images/b_bg.jpg" width="308" height="88" alt="" class="pic_bg"/>
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
 <script type="text/javascript">
//<![CDATA[
	$(function(){
	   $("#area").change(function(){
		   var area=$("#area").val();
			$.post("area.ajax.php", { 
						'area_id' :  area,
						'act'     : 'circle'
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
								$("#spot").html("<option value=''>请选择</option>"+data);
						
					});
	   })
	})
//]]>
</script>
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
})

$(function(){				
			$("#finishButton").hover(function(){
							 $(this).attr('src','images/button/regFinish_1.jpg');
					 },function(){
							 $(this).attr('src','images/button/regFinish.jpg');
			});
			$("#finishButton").mousedown(function(){
			  $(this).attr('src','images/button/regFinish_2.jpg');
			  
			});
		})

</script>