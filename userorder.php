<?php
	/**
	 *  userorder.php  购物车
	*/
	require_once("usercheck.php");
	//echo '<pre>';print_R($_POST);
	$shopID=sqlReplace(trim($_GET['shopID']));
	$userSpot=empty($_POST['spotID'])?'0':sqlReplace(trim($_POST['spotID']));
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$shopCircle=empty($_GET['circleID'])?'0':sqlReplace(trim($_GET['circleID']));

	$orderType=empty($_GET['ordertype'])?'':sqlReplace(trim($_GET['ordertype']));
	$orderGroup=empty($_GET['groupID'])?'':sqlReplace(trim($_GET['groupID']));
	$time1=empty($_POST['time1'])?'':sqlReplace($_POST['time1']);
	$time2=empty($_POST['time2'])?'':sqlReplace($_POST['time2']);
	$orderDesc=empty($_POST['desc'])?'':HTMLEncode($_POST['desc']);
	if (!empty($userSpot)) $shopSpot=$userSpot;
	
	if (!empty($_SESSION['qiyu_orderType'])){
		if ($orderType!=$_SESSION['qiyu_orderType']){
			$_SESSION['qiyu_orderType']=$orderType;
		
		}else{
			$orderType=$_SESSION['qiyu_orderType'];
		}
	}else{
		
		$_SESSION['qiyu_orderType']=$orderType;
	}
	if (!empty($_SESSION['qiyu_orderGroup'])){
		if ($_SESSION['qiyu_orderGroup']!=$orderGroup){
			$_SESSION['qiyu_orderGroup']=$orderGroup;
		}else{
			$orderGroup=$_SESSION['qiyu_orderGroup'];
		}
		
	}else{
		
		$_SESSION['qiyu_orderGroup']=$orderGroup;
	}
	
	if (!empty($_SESSION['qiyu_orderTime1'])){
		if ($_SESSION['qiyu_orderTime1']!=$time1){
			$_SESSION['qiyu_orderTime1']=$time1;
		}else{
			$time1=$_SESSION['qiyu_orderTime1'];
		}
	}else{
		
		$_SESSION['qiyu_orderTime1']=$time1;
	}
	if (!empty($_SESSION['qiyu_orderTime2'])){
		
		if ($_SESSION['qiyu_orderTime2']!=$time2){
			$_SESSION['qiyu_orderTime2']=$time2;
		}else{
			$time2=$_SESSION['qiyu_orderTime2'];
		}
	}else{
		
		$_SESSION['qiyu_orderTime2']=$time2;
	}
	if (!empty($_SESSION['qiyu_orderDesc'])) {
		if ($_SESSION['qiyu_orderDesc']!=$orderDesc){
			$_SESSION['qiyu_orderDesc']=$orderDesc;
		}else{
			$orderDesc=$_SESSION['qiyu_orderDesc'];
		}
	}else{
		
		$_SESSION['qiyu_orderDesc']=$orderDesc;
	}

	if (empty($QIYU_ID_USER)){
		Header("Location: userlogin.php?p=order&shopID=".$shopID."&shopSpot=".$shopSpot."&shopCircle=".$shopCircle);
		exit;
	}
	if (!empty($time2)){
		$time_now=time();
		$time_0_str=strtotime($time1.' '.$time2.':00');
		if($time_now>$time_0_str){
			alertInfo("亲，预约时间不能晚于现在时间","",1);	
		}
	}
	if (!empty($shopSpot)){
		$areaArray=getCircleBySpot($shopSpot);
	}
	$_SESSION['login_url']=getUrl();
	$POSITION_HEADER="提交订单";
	$sql="select * from qiyu_shop where shop_id=".$shopID." and shop_status='1'";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){	
		$shop_name=$rows['shop_name'];
		$shop_id2=$rows['shop_id2'];
		$payStr=explode("|",$rows['shop_pay']);
		$shop_pay="|".$rows['shop_pay']."|";
		$payCount=count($payStr);
		$shop_discount=$rows['shop_discount'];
			
	}else{
		alertInfo("非法操作");
	}
	$total=0;//菜总价
	$cur_cart_array = explode("///",$_COOKIE['qiyushop_cart']);
	foreach($cur_cart_array as $key => $goods_current_cart){
		$currentArray=explode("|",$goods_current_cart);
		$cookieShopID=$currentArray[0];
		$cookieFoodID=$currentArray[1];
		$cookieFoodCount=$currentArray[2];
		if ($shopID==$cookieShopID){
			$sql="select * from qiyu_food where food_id=".$cookieFoodID." and food_shop=".$cookieShopID;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				if ($orderType=='group')
					$total+=$rows['food_groupprice']*$cookieFoodCount;
				else
					$total+=$rows['food_price']*$cookieFoodCount;
			}

		}
	}
	if (empty($total)){
		alertInfo("您还没有添加餐品","index.php",0);
	}

	//$user_defaultAdd=empty($_POST['addressID'])?'0':sqlReplace($_POST['addressID']);
		
		//得到用户地标下的送餐费
		$sql="select * from qiyu_deliver";
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		if ($row){
			$isDFee=$row['deliver_isfee'];
			$sendfee=$row['deliver_minfee'];
			$sendfee_r=$sendfee;
			$deliverfee_r=$row['deliver_fee'];
			$deliver_t=true;
		}else{
			$deliver_t=false;
			$isDFee='';
			$sendfee='';
			$sendfee_r=$sendfee;
			$deliverfee_r='';

		}
		
		
		//判断是否满足商家设定的外送消费下限
		if ($total<$sendfee_r && $orderType!='group'){
		
			alertInfo("您的订单不够起送金额，请酌情增加。","index.php",0);
		}
		
		
		
		//检查是否是饭点商家
		$sqlStr="select * from qiyu_tag where tag_id=9";
		$rs_r=mysql_query($sqlStr);
		$rows=mysql_fetch_assoc($rs_r);
		if ($rows){
			
				$sql="select * from qiyu_shoptag where shoptag_shop=".$shopID." and shoptag_tag=9";
			
			
			$rs=mysql_query($sql);
			$row=mysql_fetch_assoc($rs);
			if ($row){
				$isFee=true;
			}else{
				$isFee=false;
			}
		}
		
		//如果>起送费并且 deliver_isfee 为1则免送餐费 
		if ($isDFee=='1' && $total>=$sendfee_r){  
			$deliverfee_r=0;						
		}
		
		//if ($shop_discount!="0.00"){
			//$total_discount=$total*($shop_discount/10);
			//$totalAll=$total_discount+$deliverfee_r;
		//}else{
			$totalAll=$total+$deliverfee_r;
	//	}

		$str= $deliverfee_r."元";


	if (!empty($QIYU_ID_USER)){
		$sqlStr="select * from qiyu_user where user_id=".$QIYU_ID_USER."";
		$result = mysql_query($sqlStr);
		$row=mysql_fetch_assoc($result);
		if($row){
			$USER_SCORE=$row['user_score'];
			$user_phone=$row['user_phone'];
		}
	}
	
	//查 地标下商圈 区域
	$area_id='';
	$circle_id='';
	$che_sql="select * from qiyu_spot,qiyu_circle where spot_circle=circle_id and spot_id=".$shopSpot;
	$che_rs=mysql_query($che_sql);
	$che_row=mysql_fetch_assoc($che_rs);
	if ($che_row){
		$circle_id=$che_row['circle_id'];
		$a_sql="select * from qiyu_areacircle,qiyu_area where areacircle_area=area_id and areacircle_circle=".$circle_id;
		$a_rs=mysql_query($a_sql);
		$a_row=mysql_fetch_assoc($a_rs);
		if ($a_row){
			$area_id=$a_row['areacircle_area'];
		}
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
<script src="js/address.js" type="text/javascript"></script>
<script src="js/tab.js" type="text/javascript"></script>
<script type="text/javascript" src="js/bxCarousel.js"></script>
<script src="js/addbg.js" type="text/javascript"></script>
<title> 提交订单 -<?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
</head>
<body>
  <script type="text/javascript">
 <!--
	function editTel(){
		$("#editTel").css("display","inline");
		$("#editAddress").css("display","inline");
	}
	function showTel(){
		var str="您的手机： <input type=\"text\" id=\"phone\" class=\"tel_input\"/><img src=\"images/modiPhone.gif\"  class=\"submit\" onClick=\"updatePhone()\"  style='cursor:pointer;' alt=\"\" />";
		$("#phoneDiv").html(str);
	}
	function updatePhone(){
		var tel=$("#phone").val();
		if (tel==''){
			alert('电话不能为空！');
			return false;
		}
		$.post("userorder.ajax.php", { 
			'tel' :  tel,
			'act' :  'editTel'
			}, function (data, textStatus){
				var post = data;
				if (data=='S'){
					$("#phoneDiv").html("您的手机： "+tel+"<input type=\"hidden\" phone=\""+tel+"\" />");
					return false;
				}else{
					alert('修改失败！');
					return false;
				}
							
		});

	}

	//单击添加新地址时显示添加表单
$(function(){
		 $("input:radio[name='addressList']").click(function(){
			 var $parent=$(this).parent();
			 var shopCircle=$("#shopCircle").val();
			 var pay=$("input:radio[name='pay']:checked").val();
			if (this.value=='0'){
				$("#addressNew").show();
				$("#submitType").val('2');
				$("#insert").val('1');
			}

					
		 });
});
//点击付款方式计算总金额
$(function(){
	 $("input:radio[name='pay']").click(function(){
			var address=$("input:radio[name='addressList']:checked").val();
			if (address=='0'){
				getPriceBySpot();
			}else{
				
				getPriceByAddress();
				
			}
	 
	 });
});

function getPriceBySpot()
{
			 var spot=$("#spot1").val();
		    var circle=$("#circle1").val();
			var shopCircle=$("#shopCircle").val();
			 var pay=$("input:radio[name='pay']:checked").val();
			$.post("userorder.ajax.php", { 
						'spot' :  spot,
						'circle' :  circle,
						'pay' :  pay,
						'shopCircle' : shopCircle,
						'shop'  : <?php echo $shopID?>,
						'act':'getFee'
					}, function (data, textStatus){
						
							var rs;
							rs=data.split('|');
							if (rs[0]=="N"){
								$('#tips1').hide();
								$("#selever").hide();
								$('#tips2').hide();
								TINY.box.show_spot('亲，您选择的地址不在此餐厅派 送范围内。查看可如约送达的餐 厅，请点击<a href="spot.php?spotID='+spot+'&circleID='+circle+'">这里</a>。',0,160,60,0,0);
							}else{
								$('#tips').show();
								$('#tips2').show();
								$("#selever").show().html(rs[1]);
								$("#rest").html(rs[2]);
							}
						
					});

}

function getPriceByAddress(){
	var shopCircle=$("#shopCircle").val();
	 var pay=$("input:radio[name='pay']:checked").val();
	var address=$("input:radio[name='addressList']:checked").val();
	$.post("userorder.ajax.php", { 
					'address' :  address,
					'shopID'  : <?php echo $shopID?>,
					'shopCircle' : shopCircle,
					'pay'        : pay,
					'act':  'getSpotByADD'			
					},function(data, textStatus){
						var rs;
							rs=data.split('|');
							if (rs[0]=="N"){
								$('#tips1').hide();
								$('#tips2').hide();
								$("#selever").hide();
								TINY.box.show_spot('亲，您选择的地址不在此餐厅派 送范围内。查看可如约送达的餐 厅，请点击<a href="spot.php?spotID='+rs[2]+'&circleID='+rs[1]+'">这里</a>',0,160,60,0,0);
							}else{
								$('#tips1').show();
								$('#tips2').show();
								$("#selever").show().html(rs[1]);
								$("#rest").html(rs[2]);
							}
					}
				);
}
	function showAddress(){
		$(".arBox").css("display","block");
		$("#addressIntro").html('详细地址：');
	}
	function addAddress(){
	
		var name=$("#name").val();
		var phone=$("#phone").val();
		var area=$("#area").val();
		var circle1=$("#circle").val();
		var spot=$("#spot").val();
		var address=$("#address").val();
		if (circle1==''){
			alert('商圈不能为空！');
			return false;
		}
		if (spot==''){
			alert('地标不能为空！');
			return false;
		}
		if (address==''){
			alert('地址不能为空！');
			return false;
		}
		$.post("userorder.ajax.php", { 
							'phone'   :  phone,
							'name'    :  name,
							'area'    :  area,
							'circle'  :  circle1,
							'spot'    :  spot,
							'address' :  address,
							'act'     :  'addAddress'
							}, function (data, textStatus){
							var post = data;
							if (data=='E')

								alert('添加失败！');
							else{
								
								location.reload();
								$("#ajaxAddress").html(data);
								$("#addressAdd").css("display","none");
							}
							
		});
	}
	//还需支付金额
	function rest(score,total){
		if ($("#fee").attr("checked") == true){
			if (score >=total){
				$("#rest").text('0元');
				$("#feeValue").text("饭点抵扣-"+total);
			}
			if (score<total){
				$("#rest").text(total-score+'元');
				$("#feeValue").text("饭点抵扣-"+score);
			}

		}else{
			$("#rest").text(total+'元')
		}
	}

function updateAddress(){
	$("#addressNew").show();
}

function checkIsDwliver(deliver,code){
	if (!code){
		alert("不在商家的送餐范围内，请您修改地址。");
		return false;
	}
	if (!deliver){
		TINY.box.show_spot('商家还没有设置该路标下的送餐费用，您暂时不能提交订单!',0,160,60,0,10);
		return false;
	}
}

	function checkOrder(){		
		if ($("#submitType").val()=='1'){
			var phone=$("#phone").val();
			var address=$("#address").val();
			if ($("#name").val()==''){
				TINY.box.show('姓名不能为空!',0,160,60,0,10);
				return false;
			}else{
				var name=$("#name").val();
				var reg=/^[\u0391-\uFFE5]+$/;
				 if(name.match(reg)){

					if (name.length>4){
						TINY.box.show('不能超过4个中文!',0,160,60,0,10);
						return false;
					 }
						
				}else{
					TINY.box.show('姓名只能是中文!',0,160,60,0,10);
					return false;
				}
				
			}

			if(phone==""){
				TINY.box.show('手机不能为空!',0,160,60,0,10);
				return false;
			}else{
				var reg=/^1[358]\d{9}$/;
				 if(!phone.match(reg)){
							
					TINY.box.show('格式不正确!',0,160,60,0,10);
					return false;
				}
			}
			if ($("#area").val()==''){
				TINY.box.show('请选择地区!',0,160,60,0,10);
				return false;
			}
			if ($("#circle").val()==''){
				TINY.box.show('请选择商圈!',0,160,60,0,10);
				return false;
			}
			if ($("#spot").val()==''){
				TINY.box.show('请您选择所处地标。',0,160,60,0,10);
				return false;
			}
			if(address==""){
				TINY.box.show('地址不能为空!',0,160,60,0,10);
				return false;
			}



		
		}else if ($("#submitType").val()=='2'){
			var phone1=$("#phone1").val();
		
			var address1=$("#address1").val();
	
			if(phone1==""){
				TINY.box.show('手机不能为空',0,160,60,0,10);
				return false;
			}else{
				var reg=/^1[358]\d{9}$/;
				 if(!phone1.match(reg)){
					TINY.box.show('格式不正确!',0,160,60,0,10);
					return false;
				}
			}
			if ($("#area").val()==''){
				TINY.box.show('请选择地区!',0,160,60,0,10);
				return false;
			}
			if ($("#circle").val()==''){
				TINY.box.show('请选择商圈!',0,160,60,0,10);
				return false;
			}
			if ($("#spot").val()==''){
				TINY.box.show('请您选择所处地标。',0,160,60,0,10);
				return false;
			}

			if(address1==""){
				TINY.box.show('地址不能为空!',0,160,60,0,10);
				return false;
			}
			

		} 
		/*
		alert('232');
		document.getElementById('ordertijiao').src='images/button/sure_order_0.jpg';        
		document.getElementById('ordertijiao').disabled='disabled';
		document.getElementById('submitForm').submit();
		*/

	}
 //-->
 </script>
 <script type="text/javascript">
//<![CDATA[
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
	   $("#area1").change(function(){
		   var area=$("#area1").val();
			$.post("area.ajax.php", { 
						'area_id' :  area,
							'act':'circle'
					}, function (data, textStatus){
							if (data==""){
								$("#circle1").html("<option value=''>没有商圈</option>")
							}else
								$("#circle1").html("<option value=''>请选择</option>"+data);
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

 $(function(){
	   $("#circle1").change(function(){
		   var circle=$("#circle1").val();
			$.post("area.ajax.php", { 
						'circle_id' :  circle,
						'act':'spot'
					}, function (data, textStatus){
							if (data==""){
								$("#spot1").html("<option value=''>没有地标</option>")
							}else
								$("#spot1").html("<option value=''>请选择</option>"+data);
						
					});
	   })
	})
	

	 $(function(){
		 
		$("#showIntro").hover(function(e){
			$("#cartBox").show();
		},function(){
			$("#cartBox").hide();
		
		});
		
	 });

	 $(function(){
	   $("#spot").change(function(){
		   var spot=$("#spot").val();
		    var circle=$("#circle").val();
			var shopCircle=$("#shopCircle").val();
			 var pay=$("input:radio[name='pay']:checked").val();
			$.post("userorder.ajax.php", { 
						'spot' :  spot,
						'circle' :  circle,
						'pay' :  pay,
						'shopCircle' : shopCircle,
						'shop'  : <?php echo $shopID?>,
						'act':'getFee'
					}, function (data, textStatus){
							var rs;
							rs=data.split('|');
							if (rs[0]=="N"){
								$('#tips1').hide();
								$('#tips2').hide();
								$("#selever").hide();
								TINY.box.show_spot('亲，您选择的地址不在此餐厅派 送范围内。查看可如约送达的餐 厅，请点击<a href="spot.php?spotID='+spot+'&circleID='+circle+'">这里</a>。',0,160,60,0,0);
							}else{
								$('#tips1').show();
								$('#tips2').show();
								$("#selever").show().html(rs[1]);
								$("#rest").html(rs[2]);
							}
						
					});
	   })
	})
	$(function(){
	   $("#spot1").change(function(){
		   var spot=$("#spot1").val();
		    var circle=$("#circle1").val();
			var shopCircle=$("#shopCircle").val();
			 var pay=$("input:radio[name='pay']:checked").val();
			$.post("userorder.ajax.php", { 
						'spot' :  spot,
						'circle' :  circle,
						'pay' :  pay,
						'shopCircle' : shopCircle,
						'shop'  : <?php echo $shopID?>,
						'act':'getFee'
					}, function (data, textStatus){
						
							var rs;
							rs=data.split('|');
							if (rs[0]=="N"){
								$('#tips1').hide();
								$("#selever").hide();
								$('#tips2').hide();
								TINY.box.show_spot('亲，您选择的地址不在此餐厅派 送范围内。查看可如约送达的餐 厅，请点击<a href="spot.php?spotID='+spot+'&circleID='+circle+'">这里</a>。',0,160,60,0,0);
							}else{
								$('#tips').show();
								$('#tips2').show();
								$("#selever").show().html(rs[1]);
								$("#rest").html(rs[2]);
							}
						
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
		<div class="main_content">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="orderBox">
					<div class="order_title">提交订单</div>
					<div class="table" style="position:relative;z-index:100;">
							<div class="returnCart"><a href="index.php">返回修改购物车</a></div>
							<table>
								<tr>
									<td width="135" class="metal">订单时间</td>
									<td width="365" class="metal borderLeft">餐厅名称</td>
									<td width="137" class="metal borderLeft">外卖菜品</td>
									<td width="100" class="metal borderLeft">金额</td>
									<td width="177" class="metal borderLeft">状态</td>
		
								</tr>
							<?php
								$time=date("Y-m-d");
								$sql="select shop_name from qiyu_shop where shop_id=".$shopID." and shop_status='1'";
								$rs=mysql_query($sql);
								$row=mysql_fetch_assoc($rs);
								if ($row){
							?>
								<tr>
									<td class="borderBottom borderLeft" ><?php echo $time?></td>
									<td class="borderBottom borderLeft"><?php echo $row['shop_name']?></td>
									<td class="borderBottom borderLeft"><a href="javascript:void();" id="showIntro" class="red" style="">查看详情
										<div class="cartBox" id="cartBox" style="display:none;position:absolute;left:440px;top:47px;z-index:500;">
											<div class="table">
												<table>
													<tr>
														<td width="168">菜品名</td>
														<td width="114">单价</td>
														<td width="66">份数</td>
													</tr>
													<?php
														$cur_cart_array = explode("///",$_COOKIE['qiyushop_cart']);

														foreach($cur_cart_array as $key => $goods_current_cart){
															$currentArray=explode("|",$goods_current_cart);
															$cookieShopID=$currentArray[0];
															$cookieFoodID=$currentArray[1];
															$cookieFoodCount=$currentArray[2];
															if ($shopID==$cookieShopID){
																$sql="select * from qiyu_food where food_id=".$cookieFoodID." and food_shop=".$cookieShopID;
																$rs=mysql_query($sql);
																$rows=mysql_fetch_assoc($rs);
																if ($rows){
																	if ($orderType=="group")
																		$foodPrice=$rows['food_groupprice'];
																	else
																		$foodPrice=$rows['food_price'];
													?>
																	<tr>
																		<td><?php echo $rows['food_name']?></td>
																		<td><?php echo $foodPrice?></td>
																		<td><?php echo $cookieFoodCount?></td>
																	</tr>
													<?php
																}

															}
														}
														
															
														
													?>
													
													<tr>
														
														<td colspan='3' style="border:0;text-align:right;"><a href="index.php">返回购物车</a></td>
													</tr>
												</table>
											</div>
										</div>
														
									
									</a></td>

									<td class="borderBottom borderLeft"><?php echo $total?></td>
									<td class="borderBottom borderRight borderLeft red">
										即将下单
									</td>
									
								</tr>
							<?php
								}		
							?>
								
							</table>
							
					</div>
					<form method="post" action="userorder_do.php?shopID=<?php echo $shopID?>&shopSpot=<?php echo $shopSpot?>&circleID=<?php echo $shopCircle?>" id="submitForm">
					<div class="order_title order_title_r" >您的送餐联系方式：</div>
					<div class="clear"></div>
					<?php
						if (!empty($QIYU_ID_USER) && empty($_SESSION['qiyu_temporary'])){
							
					?>
						<div id="ajaxAddress" >
						<?php
							
							$sql="select * from qiyu_useraddr where  useraddr_user =".$QIYU_ID_USER."  order by useraddr_type asc,useraddr_id desc";
							$rs=mysql_query($sql);
							$count=mysql_num_rows($rs);
							if($count>0){		
								while ($rows=mysql_fetch_assoc($rs)){
						?>
								<div class="order_infor arList"><input type="radio"  name="addressList" value="<?php echo $rows['useraddr_id']?>" <?php if ($rows['useraddr_type']=='0') echo "checked"?>/> <?php echo $rows['useraddr_address']?></div>
						<?php
								}	
							
						?>
						</div>
						<?php
							}else{//登陆后在该地标下无订餐时
								echo'<p style="color:red;margin-top:10px;margin-left:30px;">您的送餐地址记录</p>';
						?>
						<?php
							}
						?>
						<div class="order_infor arList"><input type="radio" name="addressList" value="0" /> 添加新地址</div>
						<div id="addressNew" style="display:none;margin-left:30px;" >
						<!--<div class="contact"><label>您的姓名：</label><input type="text" name="name1" id="name1" class="input" />
						</div>-->
						<div class="contact contact_r" >
								<label>您的手机：</label><input type="text" id="phone1" name="phone1" class="input" value="<?php echo $user_phone?>"/> <span>手机号将作为您登录<?php echo $SHOP_NAME?>网的用户名，请输入您的常用手机号</span>
						</div>
						
						<div class="contact"><label>详细地址：</label><input type="text" id="address1" name="address1" class="input input270"/></div>
						</div>
					<?php
						}else{	
					?>
						<!--一下是没登录的显示-->
						<div class="contact"><label>您的姓名：</label><input type="text" name="name" id="name" class="input"/></div>
						
						<div class="contact contact_r" >
							<label>您的手机：</label><input type="text" id="phone" name="phone" class="input"/> <span>手机号将作为您登录<?php echo $SHOP_NAME?>的用户名，请输入您的常用手机号</span>
						</div>
						
						<div class="clear"></div>
						<div class="contact"><label>详细地址：</label><input type="text" id="address" name="address" class="input input270"/></div>
					<?php
						}	
					?>
					<div class="clear"></div>
					<div class="order_title order_title_r" style="margin-top:30px">确认订单信息：</div>
					
					<div class="orderInfor" >外卖商品：<?php echo $total?>元 <span id='tips1' <?php if (empty($shopSpot) && empty($shopCircle)) echo "style='display:none;'"?>>|</span><span id="selever" >送餐费：<?php echo $str;?> </span><?php if (!empty($QIYU_ID_USER)){?><!--<span>|</span><span id="feeValue">饭点抵扣0 </span>--><?php }?><!-- <?php if (strpos($shop_pay,'|1|')!==false){?><span class="red">在线支付免送餐费</span><?php }?>--> </div>
					<!--
					<?php if ($shop_discount!='0.00'){?>
						<div class="orderInfor" >
							折扣后价格：<?php echo $total_discount?>元 <span style="margin-left:10px;">(饮料主食等部分餐品不参与折扣，最终价格以短信提示为准)</span>
						</div>
						
					<?php }?> -->
					<div class="orderInfor" id='tips2' >您本次点餐一共需要支付 : <b id="rest"><?php echo $totalAll;?>元</b>。</div>
					<!--<div class="orderInfor" >支付方式 <?php if (strpos($shop_pay,'|1|')!==false){?><input type="radio" name="pay" value='1' <?php if ($payCount==1  || strpos($shop_pay,"|1|")!==false) echo "checked"?>/> 在线支付<?php }?> <?php if (strpos($shop_pay,'|0|')!==false){?><input type="radio" name="pay" value='0' <?php if ($payCount==1) echo "checked"?>/> 货到付款<?php }?> </div> -->
					<div class="submit">
					<input type="image" id="ordertijiao" src="images/button/sure_order.jpg" OnClick="return checkOrder()"/>
					<input type="hidden" id="insert" name="insert" value="0" />
					<?php 
						if (empty($QIYU_ID_USER))
							echo "<input type=\"hidden\" id=\"submitType\" name=\"submitType\" value=\"1\" />";
						else
							echo "<input type=\"hidden\" id=\"submitType\" name=\"submitType\" value=\"0\" />";
					
					?>
					<input type="hidden" id="ddddddddddddddd" />
					<input type="hidden" id="shopCircle" name="shopCircle" value="<?php echo $shopCircle?>"  />
					</div>
					</form>
				</div>
				
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
<script type="text/javascript">
	$(function(){				
			$("#ordertijiao").hover(function(){
				//alert('23');
				$(this).attr('src','images/button/sure_order_1.jpg');
			 },function(){
				$(this).attr('src','images/button/sure_order.jpg');
		});
		$("#search_button").mousedown(function(){
			 $(this).attr('src','images/button/sure_order.jpg');			  
		});
		

		
})
</script>

