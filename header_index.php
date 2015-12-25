<?php
	/**
	 *  header.php
	 */
	 $p=empty($_GET['p'])?'':sqlReplace(trim($_GET['p'])); //从订单页来的标示
	 if (!empty($p))
		$regUrl="userreg.php?p=".$p."&shopID=".$shopID."&shopSpot=".$shopSpot;
	 else
		$regUrl="userreg.php";
	
?>
 <!--[if IE 6]> 
  <script src="js/jquery.pngFix.js" type="text/javascript"></script>
  <![endif]-->
	<div id="hearderBox" style="height:90px;">
		<div id="header" <?php if (!empty($_SESSION['qiyu_uid'])) echo "class='loginHeader'"?> style="height:90px;">
			<?php
				if(empty($logo)){
					$imgstr='images/logo_default.jpg';
				}else{
					$imgstr=$logo;
				}
			?>
			<a href="index.php"><img src="<?php echo $imgstr?>" style="width:178px; height:54px;" alt="餐厅logo" id="logo" /></a>
			
			<div id="login">
				<ul>
					<li class="login_li">
					   <a href="index.php">首页</a>&nbsp;&nbsp;&nbsp;
				       <?php if(is_dir('mobile')){?>	
					   <a href="mobile/index.php" target="_blank">手机版</a>
					   <?php }?>
					</li>
					
		<?php
			if (empty($_SESSION['qiyu_uid'])){
		?>
				<li class="login_li" ><a href="userlogin.php" >登录</a><!-- <a href="<?=$aurl?>"><img src="images/sina.jpg"  alt="" id="sina"/></a><div id="sinaLogin" style="display:none;"><img src="images/gt.gif" alt="" class="arrow"/><div class="instrBox" style="width:145px;text-align:left;margin:0;font-size:12px;padding:8px 8px 8px 12px;">使用您的新浪微博账号登陆</div></div>--></li>  <li class="login_li no_bg"><a href="<?php echo $regUrl?>"   id="reg">快速注册<div id="hide" style="display:none;"><img src="images/gt.gif" alt="" class="arrow"/><div class="instrBox" style="width:128px;text-align:left;margin:0;font-size:12px;padding-left:15px;">加入<?php echo $SHOP_NAME?> 享受属于您的外卖生活</div></div></a></li>
				
				
		<?php
			}else{
			    
				$sql="select * from ".WIIDBPRE."_user where user_id=".$_SESSION['qiyu_uid'];
				$rs=mysql_query($sql);
				$row=mysql_fetch_assoc($rs);
				if ($row){
		?>
					<li class="login_li"><span style='color:#f9b3b3;margin-right:10px;'><?php if (empty($_SESSION['sinaNick'])) echo $row['user_name']; else{ echo $_SESSION['sinaNick'];}?></span> <a href="usercenter.php?tab=2">我的订单</a></li> <li class="login_li" id="top_user" style="padding-right:0px;padding-left:8px;"><a href="usercenter.php?tab=2"  >个人中心 <img src="images/down.jpg"  alt="" id="icon"/></a><div id="user_select" style="display:none;">
					
					<p style="margin-top:5px;"><a href="usercenter.php?tab=2">我的订单</a></p>
					<p><a href="usercenter.php?tab=5">我的信息</a></p>
					<p><a href="usercenter.php?tab=6">修改密码</a></p>
					</div></li> <li class="login_li no_bg"><a href="userquit.php" >退出</a> </li><br/>
					<!---->
					
		<?php
					
				}
			}
		
			
		?>
				
				</ul>
				
			</div>
		</div>
		
	</div>