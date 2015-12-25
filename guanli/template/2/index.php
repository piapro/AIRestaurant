<?php
	/**
	 *  shop.php 
	 *
	 * @version       v0.01
	 * @create time   2011-8-6
	 * @update time
	 * @author        lujiangxia
	 * @copyright     Copyright (c) 微普科技 WiiPu Tech Inc. (http://www.wiipu.com)
	 * @informaition
	 */
	require_once("usercheck.php");
	$_SESSION['login_url']=getUrl();
	$_SESSION['qiyu_orderType']='';
	$shopID=$SHOPID;
	$spotID=empty($_GET['spotID'])?'0':sqlReplace(trim($_GET['spotID']));
	$circleID=empty($_GET['circleID'])?'0':sqlReplace(trim($_GET['circleID']));
	$activeID=empty($lableID2)?(empty($ftID2)?'':$ftID2):$lableID2;
	$lableID=empty($_GET['lableID'])?0:sqlReplace(trim($_GET['lableID']));
	$ftID=empty($_GET['ftID'])?0:sqlReplace(trim($_GET['ftID']));
	$browse=empty($_GET['see'])?'':sqlReplace(trim($_GET['see'])); //商家在置顶管理浏览的标示
	$isFirst=empty($_GET['first'])?'':sqlReplace(trim($_GET['first'])); //是否点击左边的分类的标示
	$ftID=empty($_GET['ftID'])?0:sqlReplace(trim($_GET['ftID']));  //菜的大类id
	$isRMD=getShopRmd($browse,$shopID);
	$deliverfee='';
	$sendfee='';
	$deliverfee_r='';
	$sendfee_r='';
	$cur_cart_array = empty($_COOKIE['qiyushop_cart'])?'':$_COOKIE['qiyushop_cart'];
	$_SESSION['user_url']=getUrl();
	$sql="select * from qiyu_shop where shop_id=".$shopID." and shop_status='1'";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$shop_name=$rows['shop_name'];
		$shop_id2=$rows['shop_id2'];
		$tel=$rows['shop_tel'];
		$intro=$rows['shop_intro'];
		$headpic2=$rows['shop_headpic2'];
		$mainfood=$rows['shop_mainfood'];
		$prefer=$rows['shop_prefer'];
		$fact=$rows['shop_face'];
		$away=$rows['shop_istakeaway'];
		$shop_address=$rows['shop_address'];
	}else{
		alertInfo('非法操作','index.php',0);
	}
	
		$dFee=getDeliveFee();
		$deliverfee=$dFee['fee'];
		$deliverfee_r=$deliverfee;
		$sendfee=$dFee['minfee'];
		$delivertime=$dFee['deliverTime'];
		$sendfee_r=$sendfee;
		$deliver_isfee=$dFee['isFee'];
		
	if (empty($isFirst)){
		$sql_label="select foodtype_id from qiyu_foodtype where foodtype_shop=".$shopID." order by foodtype_order asc,foodtype_id desc limit 1";
		$rs_label=mysql_query($sql_label);
		$row_label=mysql_fetch_assoc($rs_label);
		if ($row_label) $ftID=$row_label['foodtype_id'];
	}
	//得到商家喜欢数
	$shop_prefer=getShopLike($shopID);
	$shop_prefer+=$prefer;
	//SEO优化
	$title='';
	$keywords='';
	$description='';
	$seosql="select * from qiyu_seo where seo_type=1";
	$seors=mysql_query($seosql);
	$seorow=mysql_fetch_assoc($seors);
	if ($seorow){
		$title=$seorow['seo_title'];
		$keywords=$seorow['seo_keywords'];
		$description=$seorow['seo_description'];
	}
	if($title==''){
		$title=$shop_name;
	}

    /*
	if(empty($icon)){
		$imgstr2='images/icon_default.jpg';
	}else{
		$imgstr2=$icon;
	}*/	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="<?php echo $keywords?>" />
  <meta name="description" content="<?php echo $description?>" />
  <link rel="stylesheet" href="style.css" type="text/css"/>
  <link rel="icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo $imgstr2;?>" type="image/x-icon" />
  <script src="js/jquery-1.3.1.js" type="text/javascript"></script>
  <script src="js/tab.js" type="text/javascript"></script>
  <script src="js/addbg.js" type="text/javascript"></script>
  <script src="js/slide.js" type="text/javascript"></script>
  <script src="js/scale.js" type="text/javascript"></script>
  <script src="js/scroll.js" type="text/javascript"></script>
  <script src="js/usercartdel.js" type="text/javascript"></script>
  <title> <?php echo $title?> - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
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
				<div id="good_shop">
					<h1><?php echo $shop_name?></h1>
					<?php
						$sql="select * from qiyu_shoppics where shoppics_shop=".$shopID." order by shoppics_order asc,shoppics_id desc limit 1";
						$rs=mysql_query($sql);
						$rows=mysql_fetch_assoc($rs);
						if($rows){
					?>
					<div class="pic_box"><img src="<?php echo $rows['shoppics_url']?>" width="221" height="96" alt="" /></div>
					<?php
						}else{
							echo '<div class="pic_box"><img src="images/shop_default.jpg" width="221" height="96" alt="" /></div>';
									
						}
					?>
					<div class="intro">
						<p style="margin-top:0;">
							餐厅主营：<?php echo $mainfood?>
						</p>
						<p>联系电话：<?php echo $tel;?></p>
						<p>送餐时段：
								<?php
									$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID;
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
								?>
									<span class="time"><?php echo substr($rows['delivertime_starttime'],0,5)."-".substr($rows['delivertime_endtime'],0,5)?></span>
								<?php
									}	
								?>
						
						</p>
							<p>起送费：<?php echo $sendfee;?>元<span style="margin-left:16px;">送餐费：<?php echo $deliverfee?>元</span>
							<?php if(!empty($site_onlinechat)){?>
							在线客服：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $site_onlinechat;?>&amp;site=qq&amp;menu=yes">
						     <img src="http://wpa.qq.com/pa?p=2:<?php echo $site_onlinechat;?>:41 &amp;r=0.9061154514854605" alt="点击QQ-联系客服" title="点击QQ-联系客服" border="0"></a>
							 <?php }?>
							 </p>
						</a>
					</div>
				</div>
		</div><!--main_content完-->
		<div id="tab3">
			<ul>
				<li class="selected">餐厅菜单</li>
				<li>餐厅信息</li>
			</ul>
		</div>
		<div id="tab_box_r">
			<div class="main_content main_content_r">
				<div class="main_top shop_top" id="main_top"></div>
				<div class="main_center">
					<div class="left_shop_new" id="left_shop_new">
					<div id="left" class="left_shop left_shop_r"> <!--class='left_shop' 是tab切换的页面标识-->
						<div>
							<div class="left_l">
								<div id="menu_top"><img src="images/menu_top.jpg"  alt="" /></div>
								<div id="menu_center">
								<ul>
								<?php
									$j=0;
									$sql="select * from qiyu_foodlable order by foodlable_order asc,foodlable_id desc";
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
										$labelcount=getfoodCountByLID($shopID,$rows['foodlable_id']);
										if($labelcount=='0'){
										
										}else{
											$j++;
											if($rows['foodlable_name']=='人气'){
												$lableID=$rows['foodlable_id'];
												$ftID='';
											}
								?>
										<li <?php if ($lableID==$rows['foodlable_id']) echo "class='active'"?> onClick="foodList(<?php echo $shopID?>,0,<?php echo $rows['foodlable_id']?>,<?php echo $spotID?>,'s',<?php echo $circleID?>)"><?php echo $rows['foodlable_name'];?> <span>(<?php echo $labelcount;?>)</span></li>
								<?php
										}
										
									}
									if ($j>0){
								?>
									<li class="img"><img src="images/m_line.jpg" alt="" /></li>
								<?php
									}
									$sql="select * from qiyu_foodtype where foodtype_shop=".$shopID." order by foodtype_order asc,foodtype_id desc";
									$rs=mysql_query($sql);
									$i=0;
									while ($rows=mysql_fetch_assoc($rs)){
										
										$ftcount=getfoodCountByID($rows['foodtype_id']);
										if($ftcount=='0'){
										}else{
											$i++;
											if($i=='1' && $lableID==''){
												$ftID=$rows['foodtype_id'];
											}
								?>
										<li <?php if ($ftID==$rows['foodtype_id']) echo "class='active'"?> onClick="foodList(<?php echo $shopID?>,<?php echo $rows['foodtype_id']?>,0,<?php echo $spotID?>,'s',<?php echo $circleID?>)"><?php echo $rows['foodtype_name']?><span> (<?php echo $ftcount;?>)</span>
											
										</li>
								<?php
										}
									}
								?>	
									<ul>
								</div>
								<div id="menu_bottom"></div>
							</div>
							
							<div class="left_c left_c_new" >
								<img src="images/pic9.jpg" alt="" />
								<ul style="position:relative;z-index:300;" id="foodBox">
							<?php
								$where='';
								$i=1;
	
									$sql_food="select food_id,food_name,food_price,food_intro,food_pic from  qiyu_food ";
									if (!empty($lableID)){
										
										$sql_food.=",qiyu_foodbylable";
										$where=" and foodbylable_food=food_id and foodbylable_foodlable=".$lableID;
									}
									$sql_food.=" where food_shop=".$shopID." and food_status='0' and food_special is null " ;
									if (empty($lableID) && !empty($ftID)) $sql_food.=" and food_foodtype=".$ftID;
									$sql_food.=$where;
									$sql_food.=" order by food_order asc,food_id desc";

									$rs_food=mysql_query($sql_food);
									while ($row=mysql_fetch_assoc($rs_food)){
										if ($i%3==0){
											$class="class='li_r'";
										}else{
											$class='';
										}
										$pic=$row['food_pic'];
										if (empty($pic)) $pic='images/default_food.jpg';
							?>
										<input type="hidden" id="foodName<?php echo $row['food_id']?>" value='<?php echo $row['food_name']?>'/>
										<input type="hidden" id="foodPrice<?php echo $row['food_id']?>" value='<?php echo $row['food_price']?>'/>

										<li <?php echo $class?>  <?php if ($site_iscartfoodtag=='1'){?>onClick="addCart(<?php echo $shopID?>,<?php echo $row['food_id']?>,<?php echo $spotID?>,<?php echo $circleID?>)"<?php }else{?>onClick="addCart_im(<?php echo $shopID?>,<?php echo $row['food_id']?>,<?php echo $spotID?>,<?php echo $circleID?>)"<?php }?>>
											<img src="<?php echo $pic;?>" width="130" height="130" alt="" class='foodPic'/>
											<?php echo $row['food_name'];?><span>￥<?php echo number_format($row['food_price'],2)?></span>
											<?php if (!empty($row['food_intro'])){?>
											<div class="flowdd" style="position:absolute;z-index:900;left:64px;display:none;top:145px;">
												<img src="images/gt.gif" alt="" class="arrow"/>
												<div class="instrBox" style="text-align:center"><?php echo $row['food_intro']?><br/><img src="<?php echo $row['food_pic'] ?>" alt="<?php echo $row['food_name'] ?>" style="width:155px;height:155px;margin-top:3px" /></div>
											</div>
										
										
										<?php }?>
										</li>
								
							<?php
										$i++;
									}
								
							?>
								<div class="clear"></div>
								</ul>
							</div>
							
							<div class="clear"></div>
						</div><!--tab1-->
						<div style="display:none;" style="padding-top:10px;">
							<div id="l_left">
								
								<div class="h2"><span><span>关于<?php echo $shop_name?>：</span></span></div>
								<div class="clear"></div>
								<div class="text">
									<?php echo $intro?>
								</div>
								
							</div><!--l_left完-->
							<div id="l_right">
								
								<div class="r_box r_box_r">
									<h1>送餐时间</h1>
								<?php
									$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID;
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
								?>
									<p class="r_list"><span><?php echo $rows['delivertime_name']?>：</span><?php echo substr($rows['delivertime_starttime'],0,5)."-".substr($rows['delivertime_endtime'],0,5)?></p>
								<?php
									}	
								?>
									
								</div><!--r_box完-->
								<div class="r_box r_box_r">
									<h1>送餐信息</h1>
									<p class="r_list">送餐费：<?php echo $deliverfee;?>元</p>
									<p class="r_list">起送金额：<?php echo $sendfee;?>元</p>
									 <p class="r_list">联系电话：<?php echo $tel;?></p>
									 <div class="r_list auto_height">
										<label>餐厅地址：</label><label class="content"><?php echo $shop_address;?></label>
										<div class="clear"></div>
									 </div>
									 
									<p class="r_list r_list_r auto_height"><label>主营食物：</label><label class="content"><?php echo $mainfood;?></label></p>
									<div class="clear"></div>
								</div><!--r_box完-->
							</div><!--l_right完-->
							<div class="claer"></div>
						</div><!--tab2-->
					</div>
					</div>
					<div id="right" style="margin-left:16px;">
						<div id="cart_result">
					<?php
							
							
						require_once('usercart.inc.php');
					?>
							
						
						</div>
					
					</div>
					<div class="clear"></div>
				</div>
				<div class="main_bottom main_bottom_shop">
					<div id="bottom_img"><img src="images/p_bg2.jpg" width="698" height="10" alt="" /></div>
				</div>
			</div><!--main_content完-->
			
		</div>
	</div>
	
	<?php
		require_once('footer.php');
	?>
	<div style="display:none"><?php echo $site_stat;?></script></div>
 </div>
 </body>
</html>
