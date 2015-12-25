<?php
	/**
	 *  userintro.php
	 */
	require_once("usercheck2.php");
	$id=sqlReplace(trim($_GET['id']));
	$tel=empty($_GET['tel'])?'':sqlReplace(trim($_GET['tel']));
	$page=empty($_GET['page'])?'':sqlReplace(trim($_GET['page']));
	$id=checkData($id,"ID",0);
	$sql="select * from ".WIIDBPRE."_user where user_id=".$id;
	$result=mysql_query($sql);
	$row=mysql_fetch_assoc($result);
	if(!$row){		
		alertInfo('该用户已经不存在','',1);
	}else{
		$account=$row['user_account'];
		$name=$row['user_name'];
		$mail=$row['user_mail'];
		$type=$row['user_type'];
		$logintime=$row['user_logintime'];
		$loginip=$row['user_loginip'];
		$logincount=$row['user_logincount'];
		$phone=$row['user_phone'];
		$time=$row['user_time'];
		$score=$row['user_score'];
		$experience=$row['user_experience'];
	}
	//原版
	//$url="&start=".$start."&end=".$end."&name=".$name."&phone=".$phone."&order=".$order."&uid=".$id;
	$url="&name=".$name."&phone=".$phone."&uid=".$id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../style.css" type="text/css"/>
  <script src="../js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="../js/tree.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/upload.js"></script>
  <script type="text/javascript" src="js/shopadd.js"></script>
  <title>用户详情 - 外卖点餐系统</title>
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

					<h1><a href="userlist.php?tel=<?php echo $tel?>&page=<?php echo $page?>">用户列表</a> &gt;&gt; 用户详情</h1>

					<div id="introAdd">
						<p>用户帐号：<?php echo $account?></p>
						<p>用户姓名：<?php echo $name?></p>
						<p>用户邮箱：<?php echo $mail?></p>
						<p>用户积分：<?php echo $score?> </p>
						<p>用户经验值：<?php echo $experience?> </p>
						<p>用户注册时间：<?php echo $time?></p>
						<p>最后一次登陆IP：<?php echo $loginip?> </p>
						<p>最后一次登陆时间：<?php echo $logintime?> </p>
						<p>登陆次数：<?php echo $logincount?> </p>
						<p>所有的订单：</p>
						<p><a href="userorder.php?uid=<?php echo $id?>&key=all"><img src="../images/button/look_order.jpg"  alt="" /></a> <img src="../images/button/return.jpg" alt="返回" style='cursor:pointer' onClick="javascript:history.back();"/></p>
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
