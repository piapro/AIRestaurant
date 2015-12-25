<?php
	require_once("include/dbconn.php");
	$loginUrl=empty($_SESSION['login_url'])?'':$_SESSION['login_url'];
	$geturl=getDefaultAddress($_SESSION['qiyu_uid']);
	$cName=getCircleByID($geturl['circle']);
	$p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	$shopID=empty($_GET['shopID'])?'0':sqlReplace(trim($_GET['shopID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['shopCircle'])?'0':sqlReplace(trim($_GET['shopCircle']));
	if (!empty($p)){
			Header("Location: userorder.php?shopID=".$shopID."&shopSpot=".$shopSpot."&circleID=".$shopCircle);
			exit;
	}else if($cName=='大望路'){
		$url="spot.php?spotID=".$geturl['spot']."&circleID=".$geturl['circle'];
	}else if(empty($loginUrl)){
		$url="index.php";
	}else{
		$url=$loginUrl;
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
<script src="js/userreg2.js" type="text/javascript"></script>
<script src="js/TINYBox.js" type="text/javascript" language="javascript"></script>
<link rel="stylesheet" href="js/TINYBox.css" type="text/css"/>
<title> 用户注册 - <?php echo $SHOP_NAME?> - <?php echo $powered?></title>
 </head>
  <script type="text/javascript">
 <!--
	setTimeout("location.href='<?php echo $url?>'",5000);
 //-->
 </script>
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
					<div id="regFinish">
						<img src="images/ok1.jpg" alt="" class="ok"/>
						<div id="finish"><span>恭喜您！</span>注册已成功。</div>
						<p>系统将在 <span>5</span> 秒后自动返回到当前页<a href="<?php echo $url?>">返回</a></p>
					</div>

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
								$("#spot").html(data);
						
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

</script>