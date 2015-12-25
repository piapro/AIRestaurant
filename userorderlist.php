<?php
	/**
	 *  usercenter.php  
	 */
	require_once("usercheck2.php");
	$tabShow=empty($_GET['tab'])?'1':sqlReplace(trim($_GET['tab']));
	$_SESSION['order_url']=getUrl();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<script src="js/userorder.js" type="text/javascript"></script>
<title> 用户中心 - <?php echo $SHOP_NAME?> - <?php echo $powered?> </title>
 </head>
 <body>
 <div id="container">
	<?php
		require_once('header_index.php');
	?>
	<div id="main">
		<div id="shadow"><img src="images/shadow.gif" width="955" height="9" alt="" /></div>
		
		<div id="tab4">
			<ul>

				<li id="t2" <?php if ($tabShow=="2"){echo "class='selected'";} else{ echo "class='li'";}?>></li>
				
				<li id="t5" <?php if ($tabShow=="5"){echo "class='selected'";} else{ echo "class='li'";}?>></li>
				<li id="t6" <?php if ($tabShow=="6"){echo "class='selected'";} else{ echo "class='li'";}?>></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="main_content main_content_r">
			<div class="main_top"></div>
			<div class="main_center">
				<div id="tab_box_r" class="inforBox">
					
					<div <?php if ($tabShow!="2") echo "style='display:none;'"?>>
						<div class="big_title">所有历史订单</div>
						<div class="table table_gray">
							<table>
								<tr>
									<td width="140" class="meter">时间</td>
									<td width="183" class="meter">餐厅名称</td>
									<td width="174" class="meter">订单号</td>
									<td width="86" class="meter">金额</td>
									<td width="105" class="meter">状态</td>
									<td width="100" class="meter">操作</td>
								</tr>
							<?php
								$pagesize=1;
								$startRow=0;
								$sql="select order_id from qiyu_order,qiyu_shop where (shop_id2=order_shop or shop_id=order_shopid) and order_user=".$QIYU_ID_USER." and order_status not in (0,1,6,5)";
								$rs = mysql_query($sql) or die ("查询失败，请检查SQL语句。");
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
								$sql="select order_addtime,shop_name,order_totalprice,order_status,order_id,order_id2 from qiyu_order,qiyu_shop where (shop_id2=order_shop or shop_id=order_shopid) and order_user=".$QIYU_ID_USER." and order_status not in (0,1,6,5) order by order_addtime desc limit $startRow,$pagesize";
								$rs=mysql_query($sql);
								$j=0;
								while($rows=mysql_fetch_assoc($rs)){
							?>
								<tr>
									<td><?php echo substr($rows['order_addtime'],0,10)?></td>
									<td><?php echo $rows['shop_name']?></td>
									<td><?php echo $rows['order_id2']?></td>
									<td><?php echo $rows['order_totalprice']?>元</td>
									<td><?php echo $orderState[$rows['order_status']]?></td>
									<td style="padding:5px 0 5px 0"><a href="userorderintro.php?id=<?php echo $rows['order_id']?>" style="color:red;">查看订单详情</a><?php if ($rows['order_status']=='0'){?><a href="javascript:void()" onClick="orderCancel(<?php echo $rows['order_id']?>)">取消订单</a><?php }?> <?php if ($rows['order_status']=='4'){?><p><a href="usercenter_do.php?id=<?php echo $rows['order_id']?>&tab=2&act=delOrder">删除订单</a></p><?php }?></td>
								</tr>
							<?php
								}	
							?>
								
								<tr>
									<td colspan="6" style="text-align:center;border:0;padding-top:20px;">
									<?php 
										if ($pagecount>1)
											echo showPage('userorderlist.php?tab='.$tabShow,$page,$pagesize,$rscount,$pagecount)
									?>
									</td>
								</tr>
							</table>
						</div>

						
					</div><!--tab2-->
					
					<div <?php if ($tabShow!="5") echo "style='display:none;'"?>>
						<?php require_once('usercentertab4.inc.php');?>
					</div><!--tab5-->
					<div <?php if ($tabShow!="6") echo "style='display:none;'"?>>
						<?php require_once('usercentertab6.inc.php');?>
					</div><!--tab6完-->
				</div><!--tab_box_r-->
				<?php
					require_once('prefer.inc.php');
				?>
				
			</div>
			<div class="main_bottom"></div>
		</div><!--main_content完-->
		<?php
			require_once('about.inc.php');
		?>
	
	</div>
	
	<?php
		require_once('footer.php');
	?>
 </div>
 </body>
</html>
