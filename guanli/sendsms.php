<?php
/**
 * 群发短信 sendsms.php
 */
  
	require_once("usercheck2.php");
	require_once("inc/function.php");
	//require_once('user_sendsms_page.php');
	$o = new AppException();
	$list=getLastWiiyunAccount();
	//获取数据库里面最后一个微云账户
	$site_wiiyunaccount=$list['site_wiiyunaccount'];
	$site_wiiyunsalt=$list['site_wiiyunsalt'];
	if (empty($site_wiiyunsalt)||$site_sms!='1'){
		alertInfo('短信未配置或未开启，请配置',"site_sms.php",0);
	}

    if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) ||  $site_sms!='1')){
		//	检测微云码与账号是否正确
		$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
		$r_status=$result[0]->status;
		if ($r_status!=='no'){
			$userID2=$result[0]->id2;//用户ID2
			$sms=$o->getSMS($userID2);
			$s_status=$sms[0]->status;		
		}	
		
	}  


    $userID2=$result[0]->id2;
	$sms=$o->getSMS($userID2);
	$s_status=$sms[0]->status;
	$act=empty($_GET['act'])?'':sqlReplace(trim($_GET['act']));
	$telstr='';
	if($act=='yes'){
		if($site_sms=='2'){
			alertInfo('短信功能未开启，请配置',"site_sms.php",0);
		
		}
		if(empty($_POST["idlist"])){
			alertInfo('请选择群发项!',"",1);
		}
		$listall=$_POST["idlist"];
		foreach($listall as $listid){
			$sqlStr="select * from qiyu_user where user_id in($listid)";
			$result=mysql_query($sqlStr);
			$row=mysql_fetch_array($result);
			if(!$row){
				alertInfo('数据不存在','',1);
			}else{
				if(!empty($row['user_phone'])){
					$telstr.=$row['user_phone'].';';
				}
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> 群发短信 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Jiangting@WiiPu -- http://www.wiipu.com" />
<link rel="stylesheet" href="style2.css" type="text/css"/>
<link rel="stylesheet" href="../style.css" type="text/css"/>
<script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../js/tree.js" type="text/javascript"></script>
<script type="text/javascript" src="js/upload.js"></script>

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

				<div class="bgintor" id="shopRight">
						<h1><?php echo "群发短信";?></h1>
					<div class="listintor">
							
						</div>
						<div style="margin-left:50px;">
							<div class="fromcontent" style="height:800px;margin-top:20px;">
								<p style="margin-bottom:10px;">微云账户: <?php echo $site_wiiyunaccount;?></p>
								<?php
									if ($s_status=='noBuy'){
										echo "<p><a href='http://www.wiiyun.com' target='_blank'>还没有使用群发短信应用,请您先使用</a></p>";
										exit;
									}else{
										$message_totalcount=$sms[0]->totalcount;//总数量
										$message_count=$sms[0]->count_m;//剩余数量
										$message_usedcount=$sms[0]->usedcount;//使用了的数量
									
								?>
								<p>可发送的短信数量：<span class="start"><?php echo $message_count?></span> 条</p>
								<div style="width:500px;float:left;">
									<form id="listForm" name="listForm" method="post" action="sendsms_do.php?c=<?php echo $message_count?>">
										<p style="margin-top:10px;">收件人：<textarea style="border:1px solid #B3B8CE;width:450px;height:20px;" id="receiver" name="receiver"><?php echo $telstr;?></textarea></p><br/>
										<p><span class="start">收件人必须是手机号，多个用英文“;”隔开。</span></p><br/>
										<p>短信内容：<span class="start">(每条短信70个字符，超过70字符按多条短信收费)</span></p><br/>
										<p>
											<textarea name="fbContent" id="fbContent" style="width:498px;height:100px;"></textarea>
										</p>
										<div class="btn" >
											<br/>
											<input type="image" src="../images/button/sendsms.gif"  alt="发送" onclick="return checkinc(<?php echo $message_count?>);"/>
										</div>
									</form>
								</div>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>

				  </div>
  
            </div>
        </div>
    </div>
  </div>


 </body>
</html>
<script>
	function checkinc(count){
		//验证非空
		var emailurls=$("#receiver").val();//收件人
		var fckcontent=$("#fbContent").val();  //内容
		if(count<=0){
			alert('可发送的短信数量已用完，请到微云网购买！');
			return false;
		}
		if(emailurls==''){
			alert("收件人不能为空！");
			$("#receiver").focus();
			return false;
		}
		if(fckcontent==''){
			alert("短信内容不能为空！");
			$("#fbContent").focus();
			return false;
		}
	}
</script>