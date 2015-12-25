<?php
	/**
	 *  usercenter.php  
	 */
	require_once("usercheck2.php");
	$_SESSION['qiyu_orderType']='';
	$POSITION_HEADER="用户中心";
	$orderid=empty($_GET['orderid'])?'':sqlReplace(trim($_GET['orderid']));//当前的订单id(order_id)
	$tabShow=empty($_GET['tab'])?'1':sqlReplace(trim($_GET['tab']));
	$key=empty($_GET['key'])?'all':sqlReplace(trim($_GET['key']));
	//得到用户的所有订单数
	$orderAllCount=getOrderCountByUid($QIYU_ID_USER);
	if (getBengUserOrderCount($QIYU_ID_USER)==0) $key="all";
	$_SESSION['order_url']=getUrl();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
<script src="js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<script src="js/userorder.js" type="text/javascript"></script>
<script src="js/userreg.js" type="text/javascript"></script>
<script src="js/chage1.js" type="text/javascript"></script>
<title> 用户中心 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
<script src="js/TINYBox.js" type="text/javascript" language="javascript"></script>
<link rel="stylesheet" href="js/TINYBox.css" type="text/css"/>
</head>
<body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
			<div class="main_top order_top"></div>
			<div class="main_center order_center">
				<div id="order_left">
					<div id="tab4">
						<ul>
							<li id="t2" <?php if ($tabShow=="2"){echo "class='selected'";}?>></li>
							<li id="t5" <?php if ($tabShow=="5"){echo "class='selected'";}?>></li>
							<li id="t6" <?php if ($tabShow=="6"){echo "class='selected'";}?>></li>
						</ul>
						<div class="clear"></div>
					</div>
				</div>
				<div id="order_right">
					
					<div <?php if ($tabShow!="2") echo "style='display:none;'"?>>
						<?php require_once('usercentertab2.inc.php');?>
					</div><!--tab2wan-->
					
					
					<div <?php if ($tabShow!="5") echo "style='display:none;'"?>>
						<?php require_once('usercentertab5.inc.php');?>
					</div><!--tab5完-->
					<div <?php if ($tabShow!="6") echo "style='display:none;'"?>>
						<?php require_once('usercentertab6.inc.php');?>
					</div><!--tab6完-->
				</div>
				
				<div class="clear"></div>
				
			</div>
			<div class="main_bottom order_bottom"></div>
		</div><!--main_content完-->
		
	
	</div>
	
	<?php
		require_once('footer.php');
	?>
 </div>
 </body>
</html>
<script type="text/javascript">
	function alertadd(act){//添加地址
		var phone=$("#phone").val();
		var name=$("#name").val();
		
		var address=$("#address").val();
		
		$(".input").trigger('blur');
				var numError = $('.onError').length;
				if(numError){
					return false;
				} 
		$.ajax({
		   type: "POST",
		   url: "usercenter_do.php?act="+act,
		   data: "phone="+phone+"&name="+name+"&address="+address,
		   success: function(msg){
			 TINY.box.show(msg,0,160,60,0,10);
			 //setTimeout("location.reload()",1000);
			 
			 location.href='usercenter.php?tab=5';
		   }
		});
	}
</script>

<script type="text/javascript">
	function updateusername(){//修改姓名
		var user_name=$("#user_name").val();
		if(user_name==''){
			$('.errormt2').html('姓名不能为空');
			return false;
		}
		$.ajax({
		   type: "POST",
		   url: "usercenter_do.php?act=updateusername",
		   data: "user_name="+user_name,
		   success: function(msg){
			 TINY.box.show(msg,0,160,60,0,10);
			 //setTimeout("location.reload()",1000);
			 
			 location.href='usercenter.php?tab=5';
		   }
		});
	}
</script>

<script type="text/javascript" >
		//getstatus();
	　var int=self.setInterval("getstatus()",15000);
		function getstatus(){
			var orderid=$("#orderid").val();
			var orderkey=$("#orderkey").val();
			$.ajax({
			   type: "GET",
			   url: "getstatus.php?key="+orderkey+"&id="+orderid+"&url=intro",
			   data: "",
			   success: function(msg){
				   var content=msg.split("||||||");
					$("#order").html(content[0]);
					$("#orderChangList").html(content[1]);
					$("#intro_r").html(content[2]);
			   }
			});
		}
	
</script>
