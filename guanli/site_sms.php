<?php
	/**
	 *  网站基本设置 
	 */
	require_once("usercheck2.php");
	$o = new AppException();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <script src="js/checkform.js" type="text/javascript"></script>
  
  <title> 短信设置 - 外卖点餐系统 </title>
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
					<h1>短信设置</h1>
					<div id="introAdd">
					</form>
						<form method="post" action="sitesms_do.php">
						    <p class="clear">
							   <label>短信接口： </label>
							   <input type="radio" name="sms" value="1" <?php if($site_sms=='1') echo 'checked';?>>&nbsp;开启&nbsp;&nbsp;
							   <input type="radio" name="sms" value="2" <?php if($site_sms=='2') echo 'checked';?>>&nbsp;关闭
							</p>
							
							<p style="margin-bottom:10px;margin-top:10px;margin-left:30px;lien-height:20px;color:red">
								如果你想使用短信通知，请<!--在“网站设置”里-->开启短信接口，接下来请到<a href="http://www.wiiyun.com" target='_blank' style='text-decoration:underline;color:red;'>微云网</a>上登录（注册）、购买群发短信。
							</p>
							<p style="margin-top:10px;color:red;margin-left:30px;">微云码可在“我的信息 —> 微云码”处查看。</p>
							<p style="margin-bottom:10px;margin-top:10px;margin-left:30px;color:red">短信在以下模块中使用：</p>
							<p style="margin-top:10px;margin-left:50px;color:red">1、找回密码</p>
							<p style="margin-top:10px;margin-left:50px;color:red">2、用户下订单时通知商家</p>
							<?php
								
								//如果填写了账号跟微云码把短信条数写出来
								if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount))){
									$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
									$r_status=$result[0]->status;
									if ($r_status!=='no'){
										$userID2=$result[0]->id2;//用户ID2
										$sms=$o->getSMS($userID2);
										$s_status=$sms[0]->status;
										if ($s_status=='noBuy'){
											echo "<a href='http://www.wiiyun.com' target='_blank'>还没有使用群发短信应用,请您先购买</a>";
										}else{
											$message_totalcount=$sms[0]->totalcount;//总数量
											$message_count=$sms[0]->count_m;//剩余数量
											$message_usedcount=$sms[0]->usedcount;//使用了的数量
											echo "<p style='margin-left:30px;'>可发送的短信数量：".$message_count."条</p>";
										}
									}else{
										//
									}
								}
							?>
						
							<p><label>微云账号：</label><input type="text" id="account" name="account" value="<?php echo $site_wiiyunaccount?>" class="input input270"/> *</p>
							<p><label>微云码：</label><input type="text" id="salt" name="salt" value="<?php echo $site_wiiyunsalt?>" class="input input270"/> * </p>
							<p><label>手机号：</label><input type="text" name="phone" id="phone" class="input input179" value="<?php echo $SHOP_PHONE?>"/> * （用户下订单给商家发送短信的手机号）</p>
							<p><label>&nbsp;</label><input type="image" src="../images/button/submit_t.jpg"  onClick="return checkSms();"/></p>
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
	function checkSms(){
		//验证非空
		var account=$("#account").val();//微云账号
		var salt=$("#salt").val();  //微云码
		if(account==''){
			alert("微云账号不能为空！");
			$("#account").focus();
			return false;
		}
		if(salt==''){
			alert("微云码不能为空！");
			$("#salt").focus();
			return false;
		}
	}
</script>

</html>
