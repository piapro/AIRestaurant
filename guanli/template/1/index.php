<?php
	/**
	 *  首页
	 *
	 * @version       v0.01
	 * @create time   2012-11-10
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
	$sql="update ".WIIDBPRE."_shop set shop_visit=shop_visit+1 where shop_id=".$shopID;//商家浏览量+1
	$rs=mysql_query($sql);
	$activeID=empty($lableID2)?(empty($ftID2)?'':$ftID2):$lableID2;
	$lableID=empty($_GET['lableID'])?0:sqlReplace(trim($_GET['lableID']));
	$ftID=empty($_GET['ftID'])?0:sqlReplace(trim($_GET['ftID']));
	$browse=empty($_GET['see'])?'':sqlReplace(trim($_GET['see'])); //商家在置顶管理浏览的标示
	$isFirst=empty($_GET['first'])?'':sqlReplace(trim($_GET['first'])); //是否点击左边的分类的标示
	$ftID=empty($_GET['ftID'])?0:sqlReplace(trim($_GET['ftID']));  //菜的大类id
	//检查是否有推荐菜
	$isRMD=getShopRmd($browse,$shopID);
	$deliverfee='';
	$sendfee='';
	$deliverfee_r='';
	$sendfee_r='';

	$cur_cart_array = empty($_COOKIE['qiyushop_cart'])?'':$_COOKIE['qiyushop_cart'];
	$_SESSION['user_url']=getUrl();
	$sql="select * from ".WIIDBPRE."_shop where shop_id=".$shopID." and shop_status='1'";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$shop_name=$rows['shop_name'];
		$shop_id2=$rows['shop_id2'];
		$tel=$rows['shop_tel'];
		$deliverscope=HTMLDecode($rows['shop_deliverscope']);
		$intro=$rows['shop_intro'];
		$headpic2=$rows['shop_headpic2'];
		$mainfood=$rows['shop_mainfood'];
		$prefer=$rows['shop_prefer'];
		$shop_address=$rows['shop_address'];
		$lng=$rows['shop_lng'];
		$discount=$rows['shop_discount'];
		$away=$rows['shop_istakeaway'];
		
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
	if($title=='')
		$title=$shop_name;
	//得到当前位置
	$area_id='';
	$circle_id='';
	if (!empty($spotID)){
		$sql="select circle_name,spot_name,circle_id from qiyu_spot,qiyu_circle where circle_id=spot_circle and spot_id=".$spotID;
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		if ($rows){
			$circle_name=$rows['circle_name'];
			$spot_name=$rows['spot_name'];
			$circle_id=$rows['circle_id'];
			$a_sql="select * from qiyu_areacircle,qiyu_area where areacircle_area=area_id and areacircle_circle=".$circle_id;
			$a_rs=mysql_query($a_sql);
			$a_row=mysql_fetch_assoc($a_rs);
			if ($a_row){
				$area_id=$a_row['areacircle_area'];
			}
		}
	}
	/*
	if(empty($icon)){
		$imgstr2='images/icon_default.jpg';
	}else{
		$imgstr2=$icon;
	}*/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<script type="text/javascript" src="js/bxCarousel.js"></script>
<script src="js/easySlider1_left.js" type="text/javascript"></script>
<!--[if IE 6]> 
<script src="js/jquery.pngFix.js" type="text/javascript"></script>
<![endif]-->
<title> <?php echo $title?> - <?php echo $powered?> </title>
<script src="js/TINYBox.js" type="text/javascript" language="javascript"></script>
<link rel="stylesheet" href="js/TINYBox.css" type="text/css"/>
<style type="text/css">
  #slider{
	 width:4500px;
	position:absolute;
	z-index:30;
  }
	#slider ul, #slider li,
	#slider2 ul, #slider2 li{
		margin:0;
		padding:0;
		list-style:none;
	}
	#slider li, #slider2 li{ 
		/* 
			define width and height of list item (slide)
			entire slider area will adjust according to the parameters provided here
		*/ 
		width:275px;
		height:215px;
		overflow:hidden; 
		float:left;
	}	

	ol#controls{
		position:absolute;
		right:4px;
		top:197px;
		z-index:500;
	}
	ol#controls li{
		float:left;
		width:15px;
		height:15px;
		background:none;
		background-color:#3e3e3e;
		color:#ffffff;
		font-size:12px;
		line-height:15px;
		text-align:center;
		margin-left:5px;
		display:inline;
		
		
	}
	ol#controls li a{
		float:left;
		height:15px;
		line-height:15px;
		background:none;
		background-color:#3e3e3e;
		padding:0 5px;
		color:#ffffff;
		text-decoration:none;
	}
	ol#controls li.current a{
		background:none;
		background-color:#620607;
		color:#000000;
	}
</style>

 </head>
 <body >
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div class="main_content">
				<div id='shop_main'>
					<div id="shop_left">
						<div id="s_left_top"></div>
						<div id="s_left_center">
							<h1><?php echo $shop_name?></h1>
							<div id="focus">
							<?php
									$sql="select * from qiyu_shoppics where shoppics_shop=".$shopID." order by shoppics_order asc,shoppics_id desc";
									$rs=mysql_query($sql);
									$f_count=mysql_num_rows($rs);
									if ($f_count>0){
								?>
										<script type="text/javascript">
										$(document).ready(function(){
											$("#slider").easySlider({
												auto: true, 
												continuous: true,
												numeric: true
											});
										});
										</script>
								<?php
									}
								?>
								<div id="slider">
								<ul>
								<?php
									$sql="select * from qiyu_shoppics where shoppics_shop=".$shopID." order by shoppics_order asc,shoppics_id desc";
									$rs=mysql_query($sql);
									if ($f_count>0){
									while ($rows=mysql_fetch_assoc($rs)){
								?>
									<li><img src="<?php echo $rows['shoppics_url']?>" width="275" height="215" alt="" /></li>
								<?php
									}
									}else{
										echo '<li><img src="images/shop_default.jpg" width="275" height="215" alt="" /></li>';
									}
								?>
									
								</ul>
								</div>
								
							</div>
							<div id="gray_top"></div>
							<div id="gray_center">
								<p style='margin-top:0;'><label>餐厅地址：</label><span class='content'><?php echo $shop_address?></span></p>
								<div class='clear'></div>
								<p><label>餐厅电话：</label><span class='content'><?php echo $tel?></span></p>
								<div class='clear'></div>
								<p><label>餐厅主营：</label><span class='content'><?php echo $mainfood?></span></p>
								<div class='clear'></div>
								<p>送餐时段：
								<?php
									$i=1;
									$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID;
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
								?>
									<span <?php if ($i=="1") echo "style='margin-right:20px;'"?>><?php echo substr($rows['delivertime_starttime'],0,5)."-".substr($rows['delivertime_endtime'],0,5)?></span>
								<?php
										$i++;
									}	
								?>
								</p>
								
									<p>起送费：<?php echo $sendfee;?>元<span style="margin-left:14px;">送餐费：<?php echo $deliverfee?>元</span></p>
									<?php if(!empty($site_onlinechat)){?>
									<p>在线客服：									   
									    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $site_onlinechat;?>&amp;site=qq&amp;menu=yes">
						                    <img src="http://wpa.qq.com/pa?p=2:<?php echo $site_onlinechat;?>:41 &amp;r=0.9061154514854605" alt="点击QQ-联系客服" title="点击QQ-联系客服" border="0">
									    </a>
										<?php }?>
									</p>
									<?php
										 if (!empty($delivertime)){
									?>
											<p>承诺送餐时间：<?php echo $delivertime?></p>
									<?php
										}	
									?>
								
							</div>
							<div id="gray_bottom"></div>
							<div class="shopContent">
								<?php echo $intro?>
							</div>
							<?php
								
								if($site_isshowcomment== '1'){
							?>
							<div class="like">
								<span class='count'>餐厅评论</span>
							</div>
							
							<p class="h1">输入评论<?php if (empty($QIYU_ID_USER)){?><span><a href="userlogin.php">登陆</a></span><?php }?></p>
							<textarea class="commentInput" id="commentInput" style="resize:none;"></textarea>
							<p class="h1 h1_r"><span><input type="image" src="images/button/submit_b.jpg" onClick="return addComment('<?php echo $QIYU_ID_USER?>','<?php echo $shopID?>')"/></span></p>
							<div id='comment'>
							<?php
								$i=1;
								$pagesize=6;
								$startRow=0;
								$sql="select user_name,comment_id,comment_addtime,comment_content,comment_addtime from qiyu_comment inner join qiyu_user on user_id=comment_user and comment_type='1' and comment_shop=".$shopID;
								$rs=mysql_query($sql) or die ("查询失败，请检查SQL语句。");
								$rscount=mysql_num_rows($rs);
								if ($rscount%$pagesize==0)
									$pagecount=$rscount/$pagesize;
								else
									$pagecount=ceil($rscount/$pagesize);

								if (empty($_GET['page'])||!is_numeric($_GET['page']))
									$page=1;
								else{
									$page=$_GET['page'];
									if($page<1) $page=1;
									if($page>$pagecount) $page=$pagecount;
									$startRow=($page-1)*$pagesize;
								}
								$sqlStr="select user_name,comment_id,comment_addtime,comment_content from qiyu_comment inner join qiyu_user on user_id=comment_user and comment_type='1' and comment_shop=".$shopID." order by comment_addtime desc,comment_id desc limit $startRow,$pagesize";
								$rs=mysql_query($sqlStr);
								$count=mysql_num_rows($rs);
								while ($rows=mysql_fetch_assoc($rs)){
									if ($i==1)
										$style="style='margin-top:11px;'";
									else
										$style='';
									if ($i==$count)
										$class="class='commentList last'";
									else
										$class="class='commentList'";
								?>
									<div <?php echo $class?> <?php echo $style?>>
										<p><?php echo $rows['user_name']?><span style='margin-left:8px;'><?php echo $rows['comment_addtime']?></span></p>
										<p><?php echo $rows['comment_content']?></p>
									</div>
								<?php
									$i++;
									}
								?>		
							<input type="hidden" id="shop_id" value="<?php echo $shopID?>"/>
							<p class="h1 h1_r c_page">评论数<?php echo $rscount?><?php if ($pagecount>1){?><span style='font-size:12px;'><?php commentPage($page,$pagecount);?></span><?php }?></p>
							</div>
							<?php }?>
						</div>
						<div id="s_left_bottom"></div>
					</div><!--left wan-->
					<div id="shop_right">
						<div id="right_top"></div>
						<div id="right_center">
							<div id="recomment" style='margin-left:5px;'>
							<?php
										if (empty($browse)){
											$sql_special = "select * from ".WIIDBPRE."_food where food_special='1' and food_isshow='0' and food_check='0' and food_shop=".$shopID." order by food_order asc,food_id desc limit 3";
										}else{
											$sql_special = "select * from ".WIIDBPRE."_food where food_special='1' and food_shop=".$shopID." order by food_order asc,food_id desc limit 3";
										}
										$rs_special = mysql_query($sql_special);
										$i=1;
										while($row_special = mysql_fetch_assoc($rs_special)){
											
						?>
												<input type="hidden" id="foodName<?php echo $row_special['food_id']?>" value='<?php echo $row_special['food_name']?>'/>
												<input type="hidden" id="foodPrice<?php echo $row_special['food_id']?>" value='<?php echo $row_special['food_price']?>'/>
												

												<div class='reBox'>
													<div class='reImg'>
														<img src="<?php echo $row_special['food_pic']?>" width="186" height="125" alt="" />
													</div>
													<p><?php echo $row_special['food_name']?> <span>优惠价：<?php echo $row_special['food_price']?></span></p>
													<p><a href="javascript:void();"  <?php if ($site_iscartfoodtag=='1'){?>onClick="addCart_new(<?php echo $shopID?>,<?php echo $row_special['food_id']?>,<?php echo $spotID?>,<?php echo $circleID?>)"<?php }else{?>onClick="addCart_im_new(<?php echo $shopID?>,<?php echo $row_special['food_id']?>,<?php echo $spotID?>,<?php echo $circleID?>)"<?php }?> hidefocus="true" style="outline:none;"><img src="images/button/cart_new_0.jpg" width="87" height="23" alt="" /></a></p>
												</div>
						<?php
											$i++;
										}
						?>



								
								<div class="clear"></div>
							</div>
							<div style='padding-top:5px;'><img src="images/food_top.jpg"  alt="" /></div>
							<div id="f_left">
								<div><img src="images/food_m_t.jpg" alt="" /></div>
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
										<li <?php if ($lableID==$rows['foodlable_id']) echo "class='active'"?> onClick="foodList_new(<?php echo $shopID?>,0,<?php echo $rows['foodlable_id']?>,<?php echo $spotID?>,'',<?php echo $circleID?>)"><?php echo $rows['foodlable_name'];?> <span>(<?php echo $labelcount;?>)</span></li>
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
										<li <?php if ($ftID==$rows['foodtype_id']) echo "class='active'"?> onClick="foodList_new(<?php echo $shopID?>,<?php echo $rows['foodtype_id']?>,0,<?php echo $spotID?>,'',<?php echo $circleID?>)"><?php echo $rows['foodtype_name']?><span> (<?php echo $ftcount;?>)</span>
											
										</li>
								<?php
										}
									}
								?>	
									<ul>
								</div>
								<div id="menu_bottom"></div>
							</div>
							<div id="f_center">
								<img src="images/pic7.jpg" alt="" />
								<ul style="position:relative;z-index:300" id="foodBox">
							<?php
								$where='';
								$i=1;
	
									$sql_food="select food_id,food_name,food_pic,food_price,food_intro from qiyu_food ";
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
							?>
										<input type="hidden" id="foodName<?php echo $row['food_id']?>" value='<?php echo $row['food_name']?>'/>
										<input type="hidden" id="foodPrice<?php echo $row['food_id']?>" value='<?php echo $row['food_price']?>'/>
										<li   <?php if($site_iscartfoodtag=='1'){?>onClick="addCart_new(<?php echo $shopID?>,<?php echo $row['food_id']?>,<?php echo $spotID?>,<?php echo $circleID?>)"<?php }else{ ?>onClick="addCart_im_new(<?php echo $shopID?>,<?php echo $row['food_id']?>,<?php echo $spotID?>,<?php echo $circleID?>)"<?php }?>><?php echo $row['food_name']?><span style="left:180px;">￥<?php echo number_format($row['food_price'],2)?></span>
										<?php if (!empty($row['food_intro'])){?>
										<div class="flowdd" style="position:absolute;z-index:600;left:124px;display:none;top:12px;">
											<img src="images/gt.gif" alt="" class="arrow"/>
											<div class="instrBox" style="text-align:center"><?php echo $row['food_intro']?><br/><img src="<?php echo $row['food_pic'] ?>" alt="<?php echo $row['food_name'] ?>" style="width:155px;height:155px;margin-top:3px" /></div>
										</div>
										
										
										<?php }?>
										</li>
								
							<?php
										$i++;
									}
								
							?>
								</ul>
							</div>
							<div id="f_right">
								<div id="cart_result">
							<?php
									//得到用户购物车物品数量
									
										require_once('usercart_new.inc.php');
							?>
									
								
								</div>
							</div>
							<div class="clear"></div>
						</div>
						<div id="right_bottom"></div>
					</div><!--right wan-->
					<div class="clear"></div>
				</div>
				
			
		</div>
	</div>
	
	<?php
		require_once('footer.php');
	?>
    <div style="display:none"><?php echo $site_stat;?></script></div>

 </div>
 </body>
</html>
