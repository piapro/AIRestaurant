<?php
	/**
	 *  userorder.ajax.php  修改默认地址 修改电话  添加新地址
	 */
	require_once("usercheck.php");
	$act=sqlReplace(trim($_POST['act']));
	date_default_timezone_set('PRC');
	switch ($act){
		case "editAddress": //修改默认地址
			$id=sqlReplace(trim($_POST['id']));
			
			$sql="update qiyu_useraddr set useraddr_type='1' where useraddr_user=".$QIYU_ID_USER." and useraddr_type='0'";
			mysql_query($sql);
			
			$sql="update  qiyu_useraddr set useraddr_type='0' where useraddr_user=".$QIYU_ID_USER." and useraddr_id=".$id;
			mysql_query($sql);
		break;
		case "editTel": //修改默认地址电话
			$tel=sqlReplace(trim($_POST['tel']));
			
			$sql="select * from qiyu_useraddr where useraddr_user=".$QIYU_ID_USER." and useraddr_type='0'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				
				$sqlStr="update qiyu_useraddr set useraddr_phone='".$tel."' where useraddr_user=".$QIYU_ID_USER." and useraddr_type='0'";
				mysql_query($sqlStr);
				echo "S";
			
			}else{
				echo "E";
			}
		break;
		case "addAddress": //添加新地址
			$phone=sqlReplace(trim($_POST['phone']));
			$name=sqlReplace(trim($_POST['name']));
			$area=sqlReplace(trim($_POST['area']));
			$circle=sqlReplace(trim($_POST['circle']));
			$spot=sqlReplace(trim($_POST['spot']));
			$address=sqlReplace(trim($_POST['address']));
			$nameList=getCircleBySpot($spot);
			$addressAll=$nameList['area_name'].$nameList['circle_name'].$nameList['spot_name'].$address;
			$address_sql = "insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_area,useraddr_spot,useraddr_circle,useraddr_address,useraddr_name,useraddr_totaladdr) values (".$QIYU_ID_USER.",'".$phone."',".$area.",".$spot.",".$circle.",'".$address."','".$name."','".$addressAll."')";
			mysql_query($address_sql);
			$id=mysql_insert_id();
			echo "<div class='haveAddress'>";
			echo "<p class='title'>您已经有的地址：</p>";
			$sql="select * from qiyu_useraddr where useraddr_user=".$QIYU_ID_USER." and useraddr_spot=".$spot." order by useraddr_id desc";
			$rs=mysql_query($sql);
			$i=1;
			while ($rows=mysql_fetch_assoc($rs)){
				
				if ($i=='1')
					$str="checked";
				else
					$str="";
				echo "<div class='cart_addlist'>";
				echo "<div class='c_left'>";
				echo "<input type=\"radio\"  name=\"addressList\" value=\"".$rows['useraddr_id']."\" ".$str." />";
				echo "</div> ";
				echo "<div class='c_right'>";
				echo $rows['useraddr_totaladdr'];
				echo "</div>";
				echo "<div class='clear'></div>";
				echo "</div>";
				$i++;
			}	
			echo "</div>||||".$id."||||".$addressAll;
		break;
		case "delCart":
			$id=sqlReplace(trim($_POST['id']));
			$shopID=sqlReplace(trim($_POST['shopID']));
			delcart($id,$shopID); //删除购物车	
			 
		break;
		case "qxOrder":
			$id=sqlReplace(trim($_POST['id']));
			$sql_ff="select * from qiyu_order where order_id=".$id;
			$rs_ff=mysql_query($sql_ff);
			$rows_ff=mysql_fetch_assoc($rs_ff);
			if ($rows_ff){
				if($rows_ff['order_status']=='0'){
					$order=$rows_ff['order_id2'];
					$sql_edit="update qiyu_order set order_status='3' where order_id=".$id;
					if (mysql_query($sql_edit)){
						$orderContent="<span class='greenbg redbg'><span><span>取消订单</span></span></span>您的订单已取消，给您带来的不便请谅解，我们会更好的为您服务。";
						addOrderType($order,HTMLEncode($orderContent));
						echo "S";//用户取消订单
					}else{
						echo "N";//未知原因取消失败
					}	
				}else{
					echo "Q";//商家已接收，不能取消
				}
			}else{
				echo "E";//订单不存在
			}
		break;
		case "finishOrder":
			$id=sqlReplace(trim($_POST['id']));
			$sql_ff="select * from qiyu_order where order_id=".$id." and order_status='1'";
			$rs_ff=mysql_query($sql_ff);
			$rows_ff=mysql_fetch_assoc($rs_ff);
			if ($rows_ff){
				$order=$rows_ff['order_id2'];
				$sql_edit="update qiyu_order set order_status='4' where order_id=".$id." and order_status='1'";
				if (mysql_query($sql_edit)){
					$orderContent="<span class='greenbg'><span><span>我收到餐了</span></span></span>";
					addOrderType($order,HTMLEncode($orderContent));
					//addOrderType($order,"您的订单完成");
					if(empty($_SESSION['qiyu_uid'])){
						echo "N";//没登录是
					}else{
						echo "S";//登录
					}
					
				}else{
					echo "E";
				}
			}else{
				echo "E";
			}
		break;
		case "getTotalCart":
			$cur_cart_array = empty($_COOKIE['qiyushop_cart'])?'':$_COOKIE['qiyushop_cart'];
			$id=sqlReplace(trim($_POST['id']));
			$shopID=sqlReplace(trim($_POST['shopID']));
			$spotID=sqlReplace(trim($_POST['spotID']));
			$dFee=getDeliveFee();
			$orderType=empty($_SESSION['qiyu_orderType'])?'':$_SESSION['qiyu_orderType'];
			$deliverfee=$dFee['fee'];
			$sendfee=$dFee['minfee'];
			$total=0;
			if (!empty($cur_cart_array)){
				$cur_cart_array = explode("///",$cur_cart_array);
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
			}
			$all=$total+$deliverfee;
			echo $total."|".$all;
		break;
		case "checkPhone":
			$phone=sqlReplace(trim($_POST['phone']));
			$sql="select * from qiyu_user where user_phone='".$phone."'";
			$rs=mysql_query($sql);
			$row=mysql_fetch_assoc($rs);
			if ($row)
				echo "Y";
			else
				echo "N";
		break;
		case "getFee":
			$shopID=sqlReplace(trim($_POST['shop']));
			$spot_id=sqlReplace(trim($_POST['spot']));
			$pay=sqlReplace(trim($_POST['pay']));
			$circle_id=sqlReplace(trim($_POST['circle']));
			$shopCircle=sqlReplace(trim($_POST['shopCircle']));
			getDeliver($shopID,$spot_id,$circle_id,$shopCircle,$pay);
		break;
		
		case "checkTime":
			$sql1="select * from qiyu_delivertime where time(now())>=delivertime_starttime and time(now())<=delivertime_endtime";
			$rs=mysql_query($sql1);
			$row=mysql_fetch_assoc($rs);
			if (!$row)
				echo "N";
			else
				echo "S";
		break;
		case "addCart":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$foodID=sqlReplace(trim($_POST['foodID']));
			$desc=empty($_POST['desc'])?'':HTMLEncode(trim($_POST['desc']));
			addcart($foodID,$shopID,$desc);
			
			echo "S";
		break;
		case "getCart":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$foodID=sqlReplace(trim($_POST['foodID']));
			$time1=sqlReplace(trim($_POST['time1']));
			$time2=sqlReplace(trim($_POST['time2']));
			$spotID=empty($_POST['spotID'])?'0':sqlReplace(trim($_POST['spotID']));
			$circleID=empty($_POST['circleID'])?'0':sqlReplace(trim($_POST['circleID']));
			$addressID=empty($_POST['addressID'])?'0':sqlReplace(trim($_POST['addressID']));
			$orderType=empty($_SESSION['qiyu_orderType'])?'':$_SESSION['qiyu_orderType'];
			$deliverfee='';
			$sendfee='';
			$deliverfee_r='';
			$sendfee_r='';
			$sql="select shop_discount,shop_tel,shop_istakeaway from qiyu_shop where shop_id=".$shopID;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$discount=$rows['shop_discount'];
				$tel=$rows['shop_tel'];
				$away=$rows['shop_istakeaway'];
			}
			
				$dFee=getDeliveFee();
				$deliverfee=$dFee['fee'];
				$deliverfee_r=$deliverfee;
				$sendfee=$dFee['minfee'];
				$sendfee_r=$sendfee;
				$deliver_isfee=$dFee['isFee'];
			
			$today=getdate();
			$hour=$today['hours'];
			
			$cur_cart_array = empty($_COOKIE['qiyushop_cart'])?'':$_COOKIE['qiyushop_cart'];
			echo "<script src=\"js/usercartdel.js\" type=\"text/javascript\"></script>";
			echo "<div class=\"cartbox\" style='background-color:#eeeeee;'>";
			echo "<form method=\"post\" action=\"userorder.php?shopID=".$shopID."&shopSpot=". $spotID."&circleID=".$circleID."\" id='cartForm'>";
			echo "<div><img src=\"images/cart_top.jpg\" alt=\"\" /></div>";
			echo "<div class=\"tableMain\">";
			/*
			if ($hour>=21){
				echo "<table>";
				echo "<tr>";
				echo "<td width=\"220\" style=\"border:0\">";
				echo "<div class=\"openBox\">";
				echo "<div class=\"o_top\"></div>";
				echo "<div class=\"o_center\">";
				echo "<p class=\"big\" style='margin-top:20;text-align:center;'>已经过了网站营业时间，我们将尽快推出外卖预约功能</p>";
				echo "</div>";
			echo "<div class=\"o_bottom\"></div>";
			echo "</div>";
			echo "</td>";
										
			echo "</tr>";						
			echo "</table>";
			}else{ 
				*/
				
				echo "<div class='cart_h1'  style='display:none;'>";
				echo "地址：";
				echo "<div class='defaultAddress'>";
									if (!empty($_SESSION['qiyu_uid'])){
										if (empty($addressID)){
										$defaultAddress=getDefaultAddress($_SESSION['qiyu_uid']);
										echo "<div id='defaultAddress1'>".$defaultAddress['address']."</div>";
													
										echo "<input type=\"hidden\" id=\"spotID\" name='spotID' value='".$spotID."'/>";	
										echo "<input type=\"hidden\" id=\"addressID\" name='addressID' value='".$defaultAddress['id']."'/>";
									}else{
										$defaultAddress=getDefaultAddressByID($addressID);
										echo "<div id='defaultAddress1'>".$defaultAddress['address']."</div>";
										echo "<input type=\"hidden\" id=\"spotID\" name='spotID' value='".$spotID."'/>";	
										echo "<input type=\"hidden\" id=\"addressID\" name='addressID' value='".$addressID."'/>";
									}
									}else{
										echo "<a href='userlogin.php' style='text-decoration:underLine;'>您还没有提交地址</a>";
										echo "<input type=\"hidden\" id=\"spotID\" name='spotID' value='".$spotID."'/>";	
										echo "<input type=\"hidden\" id=\"addressID\" name='addressID' value='0'/>";
									}
	
									
								
				echo "</div>";
				echo "<span><a href='javascript:void()' onClick='showAddressCart()'>编辑</a></span>";
				echo "</div>";
				if (!empty($_SESSION['qiyu_uid'])){
				
				
				
				echo "<div id='addressShow' style='display:none;'>";
							
								
				echo "<div id='addressAll'>";
				if (!empty($spotID))
					$sql="select * from qiyu_useraddr,qiyu_circle,qiyu_spot,qiyu_area where useraddr_area=area_id and useraddr_circle=circle_id and useraddr_spot=spot_id and useraddr_user =".$QIYU_ID_USER." and useraddr_spot='".$spotID."'  order by useraddr_id desc";
				else
					$sql="select * from qiyu_useraddr,qiyu_circle,qiyu_spot,qiyu_area where useraddr_area=area_id and useraddr_circle=circle_id and useraddr_spot=spot_id and useraddr_user =".$QIYU_ID_USER."  order by useraddr_id desc";
				$rs=mysql_query($sql);
				$count=mysql_num_rows($rs);
				$j=1;
				
				if($count>0){
					echo "<div class='haveAddress'>";
					echo "<p class='title'>您已经有的地址：</p>";
					while ($rows=mysql_fetch_assoc($rs)){
						$str_1='';
						if ($j=='1'){
							
							$str_1="checked";
						}
						echo "<div class='cart_addlist'>";
						echo "<div class='c_left'>";
						echo "<input type=\"radio\"  name=\"addressList\" value=\"".$rows['useraddr_id']."\" ".$str_1."/>";
						echo "</div>";
						echo "<div class='c_right'>";
						echo $rows['area_name'].$rows['circle_name'].$rows['spot_name'].$rows['useraddr_address'];
						echo "</div>";
						echo "<div class='clear'></div>";
						echo "</div>";
							$j++;
						}
						echo "</div>";
					}
							
							

								
					echo "</div>";
					echo "<div class='clear'></div>";
					echo "<div class='haveAddress'>";
					echo "<p class='title'>我要添加新地址+</p>";
					echo "<div class='cart_list'><label>北京市</label><select id=\"area1\" name=\"area1\" class='select'>";
					echo "<option value=\"\">请选择</option>";
										$selecte="";
										$sql_area = "select * from ".WIIDBPRE."_area";
										$rs_area = mysql_query($sql_area);
										while($row_area = mysql_fetch_assoc($rs_area)){
											if ($area_id==$row_area['area_id'])
												$selecte="selected";
											else
												$selecte='';
											echo '<option value="'.$row_area['area_id'].'" '.$selecte.'>'.$row_area['area_name'].'</option>';
										}
						echo "</select> <select id=\"circle1\" name=\"circle1\" class='select select_84'>";
						echo "<option value=\"\">请选择</option>";
								if (!empty($area_id)){
									$selecte="";
									$sql_area = "select ac.areacircle_circle,c.circle_name from ".WIIDBPRE."_areacircle ac,".WIIDBPRE."_circle c where ac.areacircle_circle=c.circle_id and areacircle_area=".$area_id;
									$rs_area = mysql_query($sql_area);
									while($row_area = mysql_fetch_assoc($rs_area)){
										if ($circle_id==$row_area['areacircle_circle'])
											$selecte="selected";
										else
											$selecte='';
										echo '<option value="'.$row_area['areacircle_circle'].'" '.$selecte.'>'.$row_area['circle_name'].'</option>';
									}
								}
								
								echo "</select><div class='clear'></div></div>";
								echo "<div class='cart_list'><select id=\"spot1\" name=\"spot1\" class='select select_84' style='margin-left:118px;'>";
								echo "	<option value=\"\">请选择</option>";
								if (!empty($circle_id)){
									$selecte="";
									$sql_area = "select spot_id,spot_name from ".WIIDBPRE."_spot where spot_circle=".$circle_id;
									$rs_area = mysql_query($sql_area);
									while($row_area = mysql_fetch_assoc($rs_area)){
										if ($spotID==$row_area['spot_id'])
											$selecte="selected";
										else
											$selecte='';
										echo '<option value="'.$row_area['spot_id'].'" '.$selecte.'>'.$row_area['spot_name'].'</option>';
									}
								}
								echo "</select></div>";
								$userStr=getUser($QIYU_ID_USER);
								echo "<input type=\"hidden\" id=\"phone\" value='".$userStr['user_phone']."'/>";
								echo "<input type=\"hidden\" id=\"name\" value='".$userStr['user_name']."'/>";
								echo "<div class='cart_list'><label style='width:64px;'>详细门牌号</label><input type=\"text\" id=\"address\" name=\"address\" class='input'/><div class='clear'></div></div>";
								echo "<div class='cart_list' style='text-align:right;margin-right:4px;'><a href='javascript:void();' style='color:#fe5b02;' onClick='addAddress_cart()'>确认</a></div>";
							echo "</div>";
							echo "</div>";
								}
							if ($away=='0'){
							echo "<div class='haveAddress' style='border:0;'>";
							echo "<p>外卖时间要求：</p>";
							echo "<div class='cart_list'><select id=\"time1\" name='time1' class='select' style='width:107px;color:#fe5b02;'>";
									
									
									for ($s=0;$s<7;$s++){
										$today=time()+24*3600*$s;
										$today1=date('Y-m-d',time()+24*3600*$s);
										$ss=getdate($today);
										if ($s==0)
											$dayStr="今天".$ss['mon']."月".$ss['mday']."日";
										else
											$dayStr=$ss['mon']."月".$ss['mday']."日";
										if ($today1==$time1)
											$select1='selected';
										else
											$select1='';

									echo "<option value=\"".$today1."\" ".$select1.">".$dayStr."</option>";

									}	
								echo "</select> <select id=\"time2\" name='time2' class='select' style='width:86px;color:#fe5b02;'>";
								$time1_r=getdate(strtotime($time1));
								$now=getdate();
								$nowDay=$now['mday'];
								$timeDay=$time1_r['mday'];
								if ($timeDay==$nowDay){
									if (checkDeliverTime($shopID)) echo "<option value=\"\">尽快送到</option>";
								}else{
									//echo "<option value=\"\">尽快送到</option>";
								}
								$tt=1;
									$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID." order by delivertime_starttime asc";
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
										$start=strtotime($rows['delivertime_starttime']);
										$end=strtotime($rows['delivertime_endtime']);
										
										for($i=$start;$i<=$end;$i+=1800){
											$today=date('H:i',time());
											$result=date('H:i',$i);
											if ($result==$time2){
												$str='selected';
											}else{
												$str='';
											}
											if ($timeDay==$nowDay){
												
												if ($result>$today){
													if ($tt>2)
														echo "<option value='".$result."' ".$str.">".$result."</option>";
													$tt++;
												}
											}else{
												echo "<option value='".$result."' ".$str.">".$result."</option>";
											}
										}
									}
								echo "</select></div>";
								
							echo "</div>";
							} //是都是外卖的结束
							echo "<div style='margin-top:14px;'><img src=\"images/line_c.jpg\" alt=\"\" /></div>";

			
			
			echo "<table>";
									$i=0;
									$total=0;
									$orderType=empty($_SESSION['qiyu_orderType'])?'':$_SESSION['qiyu_orderType'];
									if (!empty($cur_cart_array)){
									$cur_cart_array = explode("///",$cur_cart_array);
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

												echo "<tr id='".$key."cart'>";
												echo "	<td width=\"117\" class=\"padding\">".$rows['food_name']."</td>";
												echo "<td width=\"12\" ><img class=\"addImg\" src=\"images/add.jpg\" alt=\"\" style='cursor:pointer;' onClick=\"addCart_c(".$cookieShopID.",".$cookieFoodID.")\"/></td>";
												echo "	<td width=\"12\" ><input type=\"text\" readonly class=\"cutInput\" value=\"".$cookieFoodCount."\"/></td>";
												echo "	<td width=\"22\" ><img class=\"subtractImg\" src=\"images/cut.jpg\" alt=\"\" style='cursor:pointer;' onClick=\"subtractCart(".$cookieShopID.",".$cookieFoodID.")\"/></td>";
												echo "	<td width=\"33\" class=\"center\">".$cookieFoodCount."</td>";
												echo "	<td width=\"21\" class=\"center\"><img src=\"images/del.gif\" alt=\"删除\" class=\"delImg\" onClick=\"delCart(".$key.",".$shopID.",".$rows['food_id'].",".$spotID.")\"  style=\"cursor:pointer;\"/></td>";
												echo "</tr>";

												$i+=1;
											}

										}
									}
									}

									if ($i==0)			
										echo "<tr><td colspan='6' style=\"padding-left:10px;\" width=\"220\"> 购物车为空 </td></tr>";
										

									
									
									if ($i>0){
										
										if ($deliver_isfee=='1' && $total>=$sendfee_r) $deliverfee_r=0;	
										
									
									echo "<tr>";
									echo "	<td colspan='6' class=\"red\" width=\"220\">订单总计：<span id=\"total\">".$total."</span>元</td> ";
									
													
									echo "</tr>";
									/*
								if ($discount!="0.0"){	
										$total=$total*($discount/10);
									echo "<tr>";
									echo "	<td colspan='6' class=\"red\" width=\"220\">折扣后价格：<span id=\"total\">".$total."</span>元</td> ";
									
													
									echo "</tr>";
								}
								*/
								if ($away=='0'){
									
									echo "<tr>
										<td id='selever' colspan='6' class=\"gray padding\" width=\"220\" ".$display."><span id=\"deliverfee\">送餐费：".$deliverfee."元</span><span style=\"margin-left:13px;\" id='sendfee'>";
									if ($deliver_isfee=='1') echo "满".$sendfee_r."元免送餐费";
									echo "最低起送".$sendfee_r."元";
									echo "</span></td>																			
									</tr>";
									
									echo "<tr>
										<td colspan='6' id='selever2' class=\"padding\" width=\"220\" ".$display.">总计：<span id=\"totalAll\">".($total+$deliverfee_r)."元</span></td> 
													
									</tr>";
								
									echo "<tr>
										<td colspan='6' class=\"gray padding\" width=\"220\">订单备注</td> 
													
									</tr>";
									
									echo "<tr>
										<td colspan='6' class=\"gray padding\" width=\"220\" style='padding-left:7px;'><textarea id=\"desc\"  name=\"desc\" class='textInput'></textarea></td> 
									
													
									</tr>";
									$checktj='';
									$send_input='';
									
										$send_input=$sendfee_r;
										
										$checktj="onClick=\"return checkout(".$total.",".$shopID.")\" ";
									if ($total>=$sendfee_r){
									echo "<tr>
										<td colspan='6' align='right' style=\"border:0\"  id=\"allSend\"><img src=\"images/button/send.gif\" id='send_button'  style=\"cursor:pointer;\" ".$checktj."/> </td> 
									
													
									</tr>";
									}else{
										echo "<tr>
										<td colspan='6' align='right' style=\"border:0\"  id=\"allSend\"><img src=\"images/button/submit_2_0.jpg\" id='send_button_44'  style=\"cursor:pointer;\" ".$checktj."/> </td> 
									
													
									</tr>";
									}
										echo "<input type=\"hidden\" id=\"send_fee\" name='send_fee' value='".$send_input."'/>";
									}//自卖的结束
									}	
									echo "<tr >";
										
									echo "</tr>";

								echo "</table>";
								
								echo "<input type=\"hidden\" id=\"uid\" value='".$QIYU_ID_USER."'/><input type=\"hidden\" id=\"shopID\"  value='".$shopID."'/><input type=\"hidden\" id=\"circleID\" name=\"circleID\"  value='".$circleID."'/>";
								echo "</form>";
							//}
							echo "</div>";
							
							echo "<div><img src=\"images/shade.jpg\" width=\"226\" height=\"8\" alt=\"\" /></div>";
						echo "</div><!--cartbox完-->";
						
		break;
		case "getCart_new":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$foodID=sqlReplace(trim($_POST['foodID']));
			$time1=sqlReplace(trim($_POST['time1']));
			$time2=sqlReplace(trim($_POST['time2']));
			$spotID=empty($_POST['spotID'])?'0':sqlReplace(trim($_POST['spotID']));
			$circleID=empty($_POST['circleID'])?'0':sqlReplace(trim($_POST['circleID']));
			$addressID=empty($_POST['addressID'])?'0':sqlReplace(trim($_POST['addressID']));
			$deliverfee='';
			$sendfee='';
			$deliverfee_r='';
			$sendfee_r='';
			$sql="select shop_discount,shop_tel,shop_istakeaway from qiyu_shop where shop_id=".$shopID;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$discount=$rows['shop_discount'];
				$tel=$rows['shop_tel'];
				$away=$rows['shop_istakeaway'];
			}
			
				$dFee=getDeliveFee();
				$deliverfee=$dFee['fee'];
				$deliverfee_r=$deliverfee;
				$sendfee=$dFee['minfee'];
				$sendfee_r=$sendfee;
				$deliver_isfee=$dFee['isFee'];
			
			
			$today=getdate();
			$hour=$today['hours'];
			$cur_cart_array = empty($_COOKIE['qiyushop_cart'])?'':$_COOKIE['qiyushop_cart'];
			echo "<script src=\"js/usercartdel.js\" type=\"text/javascript\"></script>";
			echo "<div class=\"cartbox\">";
			echo "<form method=\"post\" action=\"userorder.php?shopID=".$shopID."&shopSpot=". $spotID."&circleID=".$circleID."\" id='cartForm'>";
			echo "<div><img src=\"images/cart.jpg\" alt=\"\" /></div>";
			echo "<div class=\"tableMain\">";
				
				echo "<div class='cart_h1'  style='display:none;'>";
				echo "地址：";
				echo "<div class='defaultAddress'>";
									if (!empty($_SESSION['qiyu_uid'])){
										if (empty($addressID)){
										$defaultAddress=getDefaultAddress($_SESSION['qiyu_uid']);
										echo "<div id='defaultAddress1'>".$defaultAddress['address']."</div>";
													
										echo "<input type=\"hidden\" id=\"spotID\" name='spotID' value='".$spotID."'/>";	
										echo "<input type=\"hidden\" id=\"addressID\" name='addressID' value='".$defaultAddress['id']."'/>";
									}else{
										$defaultAddress=getDefaultAddressByID($addressID);
										echo "<div id='defaultAddress1'>".$defaultAddress['address']."</div>";
										//echo "<input type=\"hidden\" id=\"spotID\" name='spotID' value='".$spotID."'/>";	
										echo "<input type=\"hidden\" id=\"addressID\" name='addressID' value='".$addressID."'/>";
										echo "<input type=\"hidden\" id=\"spotID\" name='spotID' value='".$spotID."'/>";	
									}
									}else{
										echo "<a href='userlogin.php' style='text-decoration:underLine;'>您还没有提交地址</a>";
										echo "<input type=\"hidden\" id=\"spotID\" name='spotID' value='".$spotID."'/>";	
										echo "<input type=\"hidden\" id=\"addressID\" name='addressID' value='0'/>";
									}
	
									
								
				echo "</div>";
				echo "<span><a href='javascript:void()' onClick='showAddressCart()'>编辑</a></span>";
				echo "</div>";
				if (!empty($_SESSION['qiyu_uid'])){
				
				
				
				echo "<div id='addressShow' style='display:none;'>";
							
								
				echo "<div id='addressAll'>";
				if (!empty($spotID))
					$sql="select * from qiyu_useraddr,qiyu_circle,qiyu_spot,qiyu_area where useraddr_area=area_id and useraddr_circle=circle_id and useraddr_spot=spot_id and useraddr_user =".$QIYU_ID_USER." and useraddr_spot='".$spotID."'  order by useraddr_id desc";
				else
					$sql="select * from qiyu_useraddr,qiyu_circle,qiyu_spot,qiyu_area where useraddr_area=area_id and useraddr_circle=circle_id and useraddr_spot=spot_id and useraddr_user =".$QIYU_ID_USER."  order by useraddr_id desc";
				$rs=mysql_query($sql);
				$count=mysql_num_rows($rs);
				$j=1;
				
				if($count>0){
					echo "<div class='haveAddress'>";
					echo "<p class='title'>您已经有的地址：</p>";
					while ($rows=mysql_fetch_assoc($rs)){
						$str_1='';
						if ($j=='1'){
							
							$str_1="checked";
						}
						echo "<div class='cart_addlist'>";
						echo "<div class='c_left'>";
						echo "<input type=\"radio\"  name=\"addressList\" value=\"".$rows['useraddr_id']."\" ".$str_1."/>";
						echo "</div>";
						echo "<div class='c_right'>";
						echo $rows['area_name'].$rows['circle_name'].$rows['spot_name'].$rows['useraddr_address'];
						echo "</div>";
						echo "<div class='clear'></div>";
						echo "</div>";
							$j++;
						}
						echo "</div>";
					}
							
							

								
					echo "</div>";
					echo "<div class='clear'></div>";
					echo "<div class='haveAddress'>";
					echo "<p class='title'>我要添加新地址+</p>";
					echo "<div class='cart_list'><label>北京市</label><select id=\"area1\" name=\"area1\" class='select'>";
					echo "<option value=\"\">请选择</option>";
										$selecte="";
										$sql_area = "select * from ".WIIDBPRE."_area";
										$rs_area = mysql_query($sql_area);
										while($row_area = mysql_fetch_assoc($rs_area)){
											if ($area_id==$row_area['area_id'])
												$selecte="selected";
											else
												$selecte='';
											echo '<option value="'.$row_area['area_id'].'" '.$selecte.'>'.$row_area['area_name'].'</option>';
										}
						echo "</select> <select id=\"circle1\" name=\"circle1\" class='select select_84'>";
						echo "<option value=\"\">请选择</option>";
								if (!empty($area_id)){
									$selecte="";
									$sql_area = "select ac.areacircle_circle,c.circle_name from ".WIIDBPRE."_areacircle ac,".WIIDBPRE."_circle c where ac.areacircle_circle=c.circle_id and areacircle_area=".$area_id;
									$rs_area = mysql_query($sql_area);
									while($row_area = mysql_fetch_assoc($rs_area)){
										if ($circle_id==$row_area['areacircle_circle'])
											$selecte="selected";
										else
											$selecte='';
										echo '<option value="'.$row_area['areacircle_circle'].'" '.$selecte.'>'.$row_area['circle_name'].'</option>';
									}
								}
								
								echo "</select><div class='clear'></div></div>";
								echo "<div class='cart_list'><select id=\"spot1\" name=\"spot1\" class='select select_84' style='margin-left:118px;'>";
								echo "	<option value=\"\">请选择</option>";
								if (!empty($circle_id)){
									$selecte="";
									$sql_area = "select spot_id,spot_name from ".WIIDBPRE."_spot where spot_circle=".$circle_id;
									$rs_area = mysql_query($sql_area);
									while($row_area = mysql_fetch_assoc($rs_area)){
										if ($spotID==$row_area['spot_id'])
											$selecte="selected";
										else
											$selecte='';
										echo '<option value="'.$row_area['spot_id'].'" '.$selecte.'>'.$row_area['spot_name'].'</option>';
									}
								}
								echo "</select></div>";
								$userStr=getUser($QIYU_ID_USER);
								echo "<input type=\"hidden\" id=\"phone\" value='".$userStr['user_phone']."'/>";
								echo "<input type=\"hidden\" id=\"name\" value='".$userStr['user_name']."'/>";
								echo "<div class='cart_list'><label style='width:64px;'>详细门牌号</label><input type=\"text\" id=\"address\" name=\"address\" class='input'/><div class='clear'></div></div>";
								echo "<div class='cart_list' style='text-align:right;margin-right:4px;'><a href='javascript:void();' style='color:#fe5b02;' onClick='addAddress_cart()'>确认</a></div>";
							echo "</div>";
							echo "</div>";
								}
							if ($away=='0'){
							echo "<div class='haveAddress' style='border:0;'>";
							echo "<p>外卖时间要求：</p>";

							echo "<div class='cart_list'><select id=\"time1\" name='time1' class='time' style='width:107px;color:#fe5b02;'>";
									
									
									for ($s=0;$s<7;$s++){
										$today=time()+24*3600*$s;
										$today1=date('Y-m-d',time()+24*3600*$s);
										$ss=getdate($today);
										if ($s==0)
											$dayStr="今天".$ss['mon']."月".$ss['mday']."日";
										else
											$dayStr=$ss['mon']."月".$ss['mday']."日";
										if ($today1==$time1)
											$select1='selected';
										else
											$select1='';

									echo "<option value=\"".$today1."\" ".$select1.">".$dayStr."</option>";

									}	
								echo "</select>	<select id=\"time2\" name='time2' class='time' style='width:86px;color:#fe5b02;'>";
								$time1_r=getdate(strtotime($time1));
								$now=getdate();
								$nowDay=$now['mday'];
								$timeDay=$time1_r['mday'];
								if ($timeDay==$nowDay){
									if (checkDeliverTime($shopID)) echo "<option value=\"\">尽快送到</option>";
								}else{
									//echo "<option value=\"\">尽快送到</option>";
								}
								$tt=1;
									$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID." order by delivertime_starttime asc";
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
										$start=strtotime($rows['delivertime_starttime']);
										$end=strtotime($rows['delivertime_endtime']);
										
										for($i=$start;$i<=$end;$i+=1800){
											$today=date('H:i',time());
											$result=date('H:i',$i);
											if ($result==$time2){
												$str='selected';
											}else{
												$str='';
											}
											if ($timeDay==$nowDay){
												
												if ($result>$today){
													if ($tt>2)
														echo "<option value='".$result."' ".$str.">".$result."</option>";
													$tt++;
												}
											}else{
												echo "<option value='".$result."' ".$str.">".$result."</option>";
											}
										}
									}
								echo "</select></div>";
								
							echo "</div>";
							} //是都是外卖的结束

			
			
			echo "<table>";
									$i=0;
									$total=0;
									$orderType=empty($_SESSION['qiyu_orderType'])?'':$_SESSION['qiyu_orderType'];
									if (!empty($cur_cart_array)){
									$cur_cart_array = explode("///",$cur_cart_array);
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
												

												echo "<tr id='".$key."cart'>";
												echo "	<td width=\"117\" class=\"padding\">".$rows['food_name']."</td>";
												echo "<td width=\"12\" ><img class=\"addImg\" src=\"images/add.jpg\" alt=\"\" style='cursor:pointer;' onClick=\"addCart_c_new(".$cookieShopID.",".$cookieFoodID.")\"/></td>";
												echo "	<td width=\"12\" ><input type=\"text\" readonly class=\"cutInput\" value=\"".$cookieFoodCount."\"/></td>";
												echo "	<td width=\"22\" ><img class=\"subtractImg\" src=\"images/cut.jpg\" alt=\"\" style='cursor:pointer;' onClick=\"subtractCart_new(".$cookieShopID.",".$cookieFoodID.")\"/></td>";
												echo "	<td width=\"33\" class=\"center\">".$rows['food_price']*$cookieFoodCount."</td>";
												echo "	<td width=\"21\" class=\"center\"><img src=\"images/del.gif\" alt=\"删除\" class=\"delImg\" onClick=\"delCart_new(".$key.",".$shopID.",".$rows['food_id'].",".$spotID.")\"  style=\"cursor:pointer;\"/></td>";
												echo "</tr>";

												$i+=1;
											}

										}
									}
									}

									if ($i==0)			
										echo "<tr><td colspan='6' style=\"padding-left:10px;\" width=\"220\">还没有添加餐品</td></tr>";
										

									
									
									if ($i>0){
									if ($deliver_isfee=='1' && $total>=$sendfee_r) $deliverfee_r=0;	
									
	
									
									echo "<tr>";
									echo "	<td colspan='6' class=\"red padding no_border\" width=\"220\" style=\"padding-top:7px;\">订单总计：<span id=\"total\" style='margin-left:74px;'>".$total."</span>元</td> ";
									
													
									echo "</tr>";
									/*
								if ($discount!="0.0"){	
										$total=$total*($discount/10);
									echo "<tr>";
									echo "	<td colspan='6' class=\"red\" width=\"220\">折扣后价格：<span id=\"total\">".$total."</span>元</td> ";
									
													
									echo "</tr>";
								}*/
								if ($away=='0'){
									$display='';
									
									echo "<tr>
										<td id='selever' colspan='6' class=\"gray padding no_border\" style=\"padding-top:10px;".$display."\" width=\"220\" ><span id=\"deliverfee\">";
										if ($deliverfee_r!=='')
										 echo "送餐费：".$deliverfee."元";
										echo "</span><span style=\"margin-left:25px;\" id='sendfee'>";
										
										if ($deliver_isfee=='1')
											echo "满".$sendfee_r."元免送餐费";
										echo "最低起送".$sendfee_r."元";
										echo "</span></td>";																			
									echo "</tr>";
									
									echo "<tr>
										<td colspan='6' id='selever2' class=\"padding no_border\" width=\"220\" style='".$display."'>总计：<span id=\"totalAll\">".($total+$deliverfee_r)."元</span></td> 
													
									</tr>";
								
									echo "<tr>
										<td colspan='6' class=\"gray padding no_border\" width=\"220\">订单备注</td> 
													
									</tr>";
									
									echo "<tr>
										<td colspan='6' class=\"gray padding no_border\" width=\"220\" style='padding-left:7px;'><textarea id=\"desc\"  name=\"desc\" class='textInput'></textarea></td> 
									
													
									</tr>";
									$checktj='';
									$send_input='';
									
									 $send_input=$sendfee_r;
										
										$checktj="onClick=\"return checkout(".$total.",".$shopID.")\" ";
									if ($total>=$sendfee_r){
									echo "<tr>
										<td colspan='6' align='right' style=\"border:0;padding-top:15px;padding-right:5px;;\"  id=\"allSend\"><img src=\"images/button/sendNew.jpg\" id='send_button_n' style=\"cursor:pointer;\"  ".$checktj."/></td> 
									
													
									</tr>";
									}else{
										echo "<tr>
										<td colspan='6' align='right' style=\"border:0;padding-top:15px;padding-right:5px;;\"  id=\"allSend\"><img src=\"images/button/submit_2_0.jpg\" id='send_button_44'  style=\"cursor:pointer;\" ".$checktj."/></td> 
									
													
									</tr>";
									}
									echo " <input type=\"hidden\" id=\"send_fee\" name='send_fee' value='".$send_input."'/>";
									//}
								}//外卖判断结束
									echo "<tr >";
									
									echo "</tr>";
									
								echo "</table>";
								
								echo "<input type=\"hidden\" id=\"uid\" value='".$QIYU_ID_USER."'/><input type=\"hidden\" id=\"shopID\"  value='".$shopID."'/><input type=\"hidden\" id=\"circleID\" name=\"circleID\"  value='".$circleID."'/>";
								echo "</form>";
							}
							echo "</div>";
							
						echo "</div><!--cartbox完-->";
						
		break;
		case "getOpen":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$today=getdate();
			$hour=$today['hours'];
			echo "<div class=\"cartbox\">";
			echo "<div><img src=\"images/cart_top.jpg\" alt=\"\" /></div>";
			echo "<div class=\"tableMain\">";
			echo "<table>";
			echo "<tr>";
			echo "<td width=\"220\" style=\"border:0\">";
			echo "<div class=\"openBox\">";
			echo "<div class=\"o_top\"></div>";
			echo "<div class=\"o_center\">";
			if ($hour>=21){
				echo "<p class=\"big\" style='margin-top:20;text-align:center;'>已经过了网站营业时间，我们将尽快推出外卖预约功能</p>";
			}else{
				echo "<p class=\"big\" style='margin-top:0;text-align:center;'>餐厅接受外卖时间段为</p>";
				$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID." order by delivertime_starttime asc";
				$rs=mysql_query($sql);
				while ($rows=mysql_fetch_assoc($rs)){
					echo "<p style='text-align:center;'>".$rows['delivertime_name'].": ".substr($rows['delivertime_starttime'],0,5)." - ".substr($rows['delivertime_endtime'],0,5)."</p>";
				}	

				echo "<p class=\"big\">目前不接受外卖订单，请您选择其他餐厅或在外卖时间点餐。</p>";
			}
			echo "</div>";
			echo "<div class=\"o_bottom\"></div>";
			echo "</div>";
			echo "</td>";
										
			echo "</tr>";						
			echo "</table>";
			echo "</div>";
			echo "<div><img src=\"images/shade.jpg\" width=\"226\" height=\"8\" alt=\"\" /></div>";
			echo "</div><!--cartbox完-->";
		break;
		case "getOpen_new":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$today=getdate();
			$hour=$today['hours'];
			echo "<div class=\"cartbox\">";
			echo "<div><img src=\"images/cart.jpg\" alt=\"\" /></div>";
			echo "<div class=\"tableMain\">";
			echo "<table>";
			echo "<tr>";
			echo "<td width=\"220\" style=\"border:0\">";
			echo "<div class=\"openBox\">";
			echo "<div class=\"o_top\"></div>";
			echo "<div class=\"o_center\">";
			if ($hour>=21){
				echo "<p class=\"big\" style='margin-top:20;text-align:center;'>已经过了网站营业时间，我们将尽快推出外卖预约功能</p>";
			}else{
				echo "<p class=\"big\" style='margin-top:0;text-align:center;'>餐厅接受外卖时间段为</p>";
				$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID." order by delivertime_starttime asc";
				$rs=mysql_query($sql);
				while ($rows=mysql_fetch_assoc($rs)){
					echo "<p style='text-align:center;'>".$rows['delivertime_name'].": ".substr($rows['delivertime_starttime'],0,5)." - ".substr($rows['delivertime_endtime'],0,5)."</p>";
				}	

				echo "<p class=\"big\">目前不接受外卖订单，请您选择其他餐厅或在外卖时间点餐。</p>";
			}
			echo "</div>";
			echo "<div class=\"o_bottom\"></div>";
			echo "</div>";
			echo "</td>";
										
			echo "</tr>";						
			echo "</table>";
			echo "</div>";
			echo "</div><!--cartbox完-->";
		case "foodList":
			echo " <script src=\"js/addbg.js\" type=\"text/javascript\"></script>";
			$shopID=sqlReplace(trim($_POST['shop']));
			$lableID=sqlReplace(trim($_POST['label']));
			$ftID=sqlReplace(trim($_POST['type']));
			$logo=sqlReplace(trim($_POST['logo']));
			$spotID=sqlReplace(trim($_POST['spot']));
			$circleID=sqlReplace(trim($_POST['circle']));
			$sql="select shop_istakeaway from qiyu_shop where shop_id=".$shopID;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$away=$rows['shop_istakeaway'];
			}
			$where='';
			$i=1;
			$sql_food="select food_id,food_name,food_price,food_intro,food_pic from qiyu_food ";
			if (!empty($lableID)){
				$sql_food.=",qiyu_foodbylable";
				$where=" and foodbylable_food=food_id and foodbylable_foodlable=".$lableID;
			}
			$sql_food.=" where food_shop=".$shopID." and food_status='0' and food_special is null " ;
			if (empty($lableID) && !empty($ftID)) $sql_food.=" and food_foodtype=".$ftID;
			$sql_food.=$where;
			$sql_food.=" order by food_order asc,food_id desc";
			$rs_food=mysql_query($sql_food);
			$class='';
			$top='';
			while ($row=mysql_fetch_assoc($rs_food)){
				$pic=$row['food_pic'];
				if (empty($pic)) $pic='images/default_food.jpg';
				if ($i%3==0){
					$class="class='li_r'";
				}else{
					$class='';
				}
				$top=145;
					echo "<input type=\"hidden\" id=\"foodName".$row['food_id']."\" value='".$row['food_name']."'/>";
					echo "<input type=\"hidden\" id=\"foodPrice".$row['food_id']."\" value='".$row['food_price']."'/>";			
				echo "<li ".$class;
				if ($away=='0' && $site_iscartfoodtag=='1'){
				  echo "onClick=\"addCart(".$shopID.",".$row['food_id'].",".$spotID.",".$circleID.")\"";
				}else
					echo "onClick=\"addCart_im(".$shopID.",".$row['food_id'].",".$spotID.",".$circleID.")\"";
					echo ">";
					echo "<img src='".$pic."' width='130' height='130' alt='' class='foodPic'/>";
					echo "<p>".$row['food_name']."<span>￥".number_format($row['food_price'],2)."</span></p>";
				if (!empty($row['food_intro'])){
					echo "<div class=\"flowdd\" style=\"position:absolute;z-index:600;left:64px;display:none;top:".$top."px;\">";
					echo "<img src=\"images/gt.gif\" alt=\"\" class=\"arrow\"/>";
					echo "<div class=\"instrBox\" style=\"text-align:center\">".$row['food_intro'];
					echo "<img width='155' height='155' src=\"$row[food_pic]\" alt=\"$row[food_name]\"/></div>";
					echo "</div>";
				}
				echo "</li>";
								
				$i++;
			}
		break;
		case "foodList_new":
			echo " <script src=\"js/addbg.js\" type=\"text/javascript\"></script>";
			$shopID=sqlReplace(trim($_POST['shop']));
			$lableID=sqlReplace(trim($_POST['label']));
			$ftID=sqlReplace(trim($_POST['type']));
			$logo=sqlReplace(trim($_POST['logo']));
			$spotID=sqlReplace(trim($_POST['spot']));
			$circleID=sqlReplace(trim($_POST['circle']));
			$sql="select shop_istakeaway from qiyu_shop where shop_id=".$shopID;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$away=$rows['shop_istakeaway'];
			}
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
			$class='';
			$top='';
			while ($row=mysql_fetch_assoc($rs_food)){
				if (!empty($logo)){
					$top=12;
					if ($i%2==0){
						$class="class='li_r'";
					}else
						$class='';
				}else{
					$top=12;
				}
					echo "<input type=\"hidden\" id=\"foodName".$row['food_id']."\" value='".$row['food_name']."'/>";
					echo "<input type=\"hidden\" id=\"foodPrice".$row['food_id']."\" value='".$row['food_price']."'/>";			
				echo "<li ".$class;
				if ($away=='0'&& $site_iscartfoodtag=='1')
					echo " onClick=\"addCart_new(".$shopID.",".$row['food_id'].",".$spotID.",".$circleID.")\"";
				else
					echo " onClick=\"addCart_im_new(".$shopID.",".$row['food_id'].",".$spotID.",".$circleID.")\"";
				echo ">".$row['food_name']."<span>￥".number_format($row['food_price'],2)."</span>";
				if (!empty($row['food_intro'])){
					echo "<div class=\"flowdd\" style=\"position:absolute;z-index:600;left:124px;display:none;top:".$top."px;\">";
					echo "<img src=\"images/gt.gif\" alt=\"\" class=\"arrow\"/>";
					echo "<div class=\"instrBox\" style=\"text-align:center\">".$row['food_intro']."<br />";
					echo "<img width='155' height='155' src=\"$row[food_pic]\" alt=\"$row[food_name]\"/></div>";
					echo "</div>";
					
				}
				echo "</li>";
								
				$i++;
			}
		break;
		case "getSpotByADD":
			$addID=sqlReplace(trim($_POST['address']));
			$shopID=sqlReplace(trim($_POST['shopID']));
			$shopCircle=sqlReplace(trim($_POST['shopCircle']));
			$pay=sqlReplace(trim($_POST['pay']));
			$sql="select useraddr_spot,useraddr_circle from qiyu_useraddr where useraddr_id=".$addID;
			$rs=mysql_query($sql);
			$row=mysql_fetch_assoc($rs);
			if ($row){
				$spot_id=$row['useraddr_spot'];
				$circle_id=$row['useraddr_circle'];
			}
			getDeliver($shopID,$spot_id,$circle_id,$shopCircle,$pay);
		break;

		case "addPrefer":
			$id=sqlReplace(trim($_POST['id']));
			$type=sqlReplace(trim($_POST['type']));
			if (empty($QIYU_ID_USER))
				echo "N";  //没有登录
			else{
				//$user=sqlReplace(trim($_POST['user']));
				

				if ($type=='0'){	
					$sql="delete from qiyu_fav where fav_user=".$QIYU_ID_USER." and fav_shop=".$id;
					mysql_query($sql);
				}elseif ($type=='1'){
					$sql="select fav_id from qiyu_fav where fav_shop=".$id." and fav_user=".$QIYU_ID_USER;
					$rs=mysql_query($sql);
					$row=mysql_fetch_assoc($rs);
					if (!$row){
						$sqlStr="insert into qiyu_fav(fav_user,fav_shop,fav_time) values (".$QIYU_ID_USER.",".$id.",now()) ";
						mysql_query($sqlStr);
					}
				}
				$sql="select shop_prefer from qiyu_shop where shop_id=".$id;
				$rs=mysql_query($sql);
				$row=mysql_fetch_assoc($rs);
				if ($row)
					$prefer=$row['shop_prefer'];
				$sql="select count(fav_id) as c from qiyu_fav where fav_shop=".$id;
				$rs=mysql_query($sql);
				$row=mysql_fetch_assoc($rs);
				if ($row)
					echo $row['c']+$prefer;
					
				
			}
		break;
		case "updateCart":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$foodID=sqlReplace(trim($_POST['foodID']));
			updateCartCount($foodID,$shopID);
		break;
		case "getFoodIntro":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$foodID=sqlReplace(trim($_POST['foodID']));
			$spotID=sqlReplace(trim($_POST['spotID']));
			$sql="select * from qiyu_food where food_id=".$foodID;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$name=$rows['food_name'];
				$price=$rows['food_price'];
			}
            
			echo "<script src=\"js/usercartdel.js\" type=\"text/javascript\"></script>";
			echo "<div id=\"container\">";
			echo "	<div id='newCartBox'>";
			echo "		<div id='c_table'>";
			echo "			<table border='0' width='455'>";
			echo "				<tr>";
			echo "					<td class='menu first td' width='125'>菜名</td>";
			echo "					<td class='menu' >价格</td>";
			echo "				</tr>";
			echo "				<tr>";
			echo "					<td class='main first td'>".$name."</td>";
			echo "					<td class='main'>".$price."</td>";
			echo "				</tr>";
			echo "			</table>";
			echo "		</div>";
			echo "		<p class='cart_prompt'>对于此餐品的备注：</p>";
			echo "		<p class='cart_intro'><textarea id=\"cart_desc\" class='cart_input'></textarea></p>";
			echo "		<p class='submit_cart'><img src=\"images/button/addCart1.jpg\"  alt=\"\" style='cursor:pointer;' onClick=\"addCart_t(".$shopID.",".$foodID.",".$spotID.")\"/><span><a href='javascript:void();' onClick=\"closeFlow()\">回到餐厅界面</a></span></p>";
			echo "	</div>";
		break;
		case "getAddress":
			$id=sqlReplace(trim($_POST['address_id']));
			$defaultAddress=getDefaultAddressByID($id);
			echo $defaultAddress['address'];
		break;
		case "getYTime":
			$time=getdate(strtotime(sqlReplace(trim($_POST['time']))));
			$now=getdate();
			$nowDay=$now['mday'];
			$timeDay=$time['mday'];
		
			$shopID=sqlReplace(trim($_POST['shop']));
			if ($timeDay==$nowDay){
				if (checkDeliverTime($shopID)) echo "<option value=\"\">尽快送到</option>";
			}else{
				//echo "<option value=\"\">尽快送到</option>";
			}
			$tt=1;
									$sql="select * from qiyu_delivertime where delivertime_shop=".$shopID." order by delivertime_starttime asc";
									$rs=mysql_query($sql);
									while ($rows=mysql_fetch_assoc($rs)){
										$start=strtotime($rows['delivertime_starttime']);
										$end=strtotime($rows['delivertime_endtime']);
										
										for($i=$start;$i<=$end;$i+=1800){
											$today=date('H:i',time());
											$result=date('H:i',$i);
											if ($timeDay==$nowDay){
												
												if ($result>$today){
													if ($tt>2)
														echo "<option value='".$result."'>".$result."</option>";
													$tt++;
												}
											}else{
												echo "<option value='".$result."'>".$result."</option>";
											}
										}
									}
		break;
		case "addComment":
			$uid=sqlReplace(trim($_POST['uid']));
			$shopID=sqlReplace(trim($_POST['shopid']));
			$content=HTMLEncode(trim($_POST['content']));
			$i=1;
			if (empty($uid)){//用户名为空
				echo "N";
				exit;
			}
			if (empty($content)){//内容为空
				echo "C";
				exit;
			}
			$sql="insert into qiyu_comment(comment_user,comment_shop,comment_addtime,comment_content) values (".$uid.",".$shopID.",now(),'".$content."')";
			if (mysql_query($sql)){
				CommentList($shopID,1);
				$sql2="update qiyu_user set user_experience=user_experience+".expUserComment." where user_id=".$uid;
			    mysql_query($sql2);

			}else{//执行失败
				echo "E";
				exit;
			}
		break;
		case "getCommentList":
			$page=sqlReplace(trim($_POST['page']));
			$shopID=sqlReplace(trim($_POST['shop']));
			CommentList($shopID,$page);
		break;
		case "checkOpen":
				$day_str=date("Y-m-d");				
				$time_now=strtotime(date("H:i:s"));
				$night=strtotime($SHOP_OPENENDTIME);
				$morning=strtotime($SHOP_OPENSTARTTIME);
				if ($time_now>=$night || $time_now<$morning)//如果当前时间是打烊后或早于开店前
					echo "N";//预约
				else
					echo "S";//新订单
		break;
		case "updateTelClick":
			$shopID=sqlReplace(trim($_POST['shopID']));
			$sql="update qiyu_shop set shop_telclickcount=shop_telclickcount+1 where shop_id=".$shopID;
			mysql_query($sql);
			echo $sql;
		break;

		case "getTag":	//模板1的餐品口味选择
			$shopID = sqlReplace(trim($_POST['shopID']));
			$foodID=sqlReplace(trim($_POST['foodID']));
			$spotID = sqlReplace(trim($_POST['spotID']));
			$circleID = sqlReplace(trim($_POST['circleID']));
			$time1 = sqlReplace(trim($_POST['time1']));
			$time2 = sqlReplace(trim($_POST['time2']));
			$name  = sqlReplace(trim($_POST['name']));
			$price = sqlReplace(trim($_POST['price']));
			$str = "<div id=\"container\">";		
			$str.= "	<div id='newCartBox'>";
			$str.= "		<div id='c_table'>";
			$str.= "			<table border='0' width='455'>";
			$str.= "				<tr>";
			$str.= "					<td class='menu first td' width='195'>菜名</td>";
			$str.= "					<td class='menu' >价格</td>";
			$str.= "				</tr>";
			$str.= "				<tr>";
			$str.= "					<td class='main first td'>".$name."</td>";
			$str.= "					<td class='main'>".$price."</td>";
			$str.= "				</tr>";
			$str.= "			</table>";
			$str.= "		</div>";
			$str.= "<div id=\"cart_needs\"><span class='span span_need'>口味需求：</span>";
			foreach($tag as $k=>$v){
				$str.= "<input type=\"checkbox\" id='styleNeeds".($k+1)."' onClick='addContent(".($k+1).")' value='".$v."' class='styleCheckx' />
						<span class='span mainfood'>".$v."</span> ";
			}
				
			$str.= "</div>";
			$str.= "		<p class='cart_prompt'>对于此餐品的备注：</p>";
			$str.= "		<p class='cart_intro'><textarea id=\"cart_desc\" class='cart_input'></textarea></p>";
			$str.= "		<p class='submit_cart'><img src=\"images/button/addCart1.jpg\" onmouseout=\"checkbg1()\" onmouseover=\"checkbg2()\" mousedown='checkbg3()' id=\"addCartF\"  alt=\"\" style='cursor:pointer;' onClick=\"addCart_t_new(".$shopID.",".$foodID.",".$spotID.",".$circleID.",'".$time1."','".$time2."')\"/><span><a href='javascript:void();' onClick=\"closeFlow()\">回到餐厅界面</a></span></p>";
			$str.= "	</div>";

			echo $str;

		break;
	
	

	case "getTags":	//模板2的餐品口味选择
			$shopID = sqlReplace(trim($_POST['shopID']));			
			$where='';
			$foodID=sqlReplace(trim($_POST['foodID']));

			$spotID = sqlReplace(trim($_POST['spotID']));
			$circleID = sqlReplace(trim($_POST['circleID']));
			$time1 = sqlReplace(trim($_POST['time1']));
			$time2 = sqlReplace(trim($_POST['time2']));
			$name  = sqlReplace(trim($_POST['name']));
			$price = sqlReplace(trim($_POST['price']));
			$str = "<div id=\"container\">";		
			$str.= "	<div id='newCartBox'>";
			$str.= "		<div id='c_table'>";
			$str.= "			<table border='0' width='455'>";
			$str.= "				<tr>";
			$str.= "					<td class='menu first td' width='195'>菜名</td>";
			$str.= "					<td class='menu' >价格</td>";
			$str.= "				</tr>";
			$str.= "				<tr>";
			$str.= "					<td class='main first td'>".$name."</td>";
			$str.= "					<td class='main'>".$price."</td>";
			$str.= "				</tr>";
			$str.= "			</table>";
			$str.= "		</div>";
			$str.= "<div id=\"cart_needs\"><span class='span span_need'>口味需求：</span>";
			foreach($tag as $k=>$v){
				$str.= "<input type=\"checkbox\" id='styleNeeds".($k+1)."' onClick='addContent(".($k+1).")' value='".$v."' class='styleCheck'/>
						<span class='span mainfood'>".$v."</span> ";
			}
				
			$str.= "</div>";
			$str.= "		<p class='cart_prompt'>对于此餐品的备注：</p>";
			$str.= "		<p class='cart_intro'><textarea id=\"cart_desc\" class='cart_input'></textarea></p>";
			$str.= "		<p class='submit_cart'><img src=\"images/button/addCart1.jpg\" onmouseout=\"checkbg1()\" onmouseover=\"checkbg2()\" mousedown='checkbg3()' id=\"addCartF\"  alt=\"\" style='cursor:pointer;' onClick=\"addCart_t(".$shopID.",".$foodID.",".$spotID.",".$circleID.",'".$time1."','".$time2."')\"/><span><a href='javascript:void();' onClick=\"closeFlow()\">回到餐厅界面</a></span></p>";
			$str.= "	</div>";
			echo $str;
		break;
	}
	function CommentList($shopID,$page){
		$i=1;
				$pagesize=6;
				$startRow=0;
				$sqlStr="select user_name,comment_id,comment_addtime,comment_content from qiyu_comment inner join qiyu_user on user_id=comment_user and comment_type='1' and comment_shop=".$shopID;
				$rs=mysql_query($sqlStr) or die ("查询失败，请检查SQL语句。");
				$rscount=mysql_num_rows($rs);
				if ($rscount%$pagesize==0)
					$pagecount=$rscount/$pagesize;
				else
					$pagecount=ceil($rscount/$pagesize);

				
					if($page<1) $page=1;
					if($page>$pagecount) $page=$pagecount;
					$startRow=($page-1)*$pagesize;
				
				$sqlStr="select user_name,comment_id,comment_addtime,comment_content,comment_addtime from qiyu_comment inner join qiyu_user on user_id=comment_user and comment_type='1' and comment_shop=".$shopID." order by comment_addtime desc,comment_id desc limit $startRow,$pagesize";
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
					echo "<div ".$class." ".$style.">";
					echo "<p>".$rows['user_name']."<span style='margin-left:8px;'>".$rows['comment_addtime']."</span></p>";
					echo "<p>".HTMLDecode($rows['comment_content'])."</p>";
					echo "</div>";
					$i++;

				}
				echo "<input type=\"hidden\" id=\"shop_id\" value=\"".$shopID."\"/>";
				echo "<p class=\"h1 h1_r c_page\">评论数".$rscount;
				if ($pagecount>1){
					echo "<span style=\"font-size:12px;\">";
					commentPage($page,$pagecount);
					echo "</span>";
				 }
				echo "</p>";
	}
	function getDeliver($shopID,$spot_id,$circle_id,$shopCircle,$pay){
		//得到用户地标下的送餐费
			$orderType=empty($_SESSION['qiyu_orderType'])?'':$_SESSION['qiyu_orderType'];
			if (!empty($shopCircle)){    //商圈添加
				$sql_ff="select * from qiyu_deliverbycircle where deliverbycircle_shop=".$shopID." and deliverbycircle_circle=".$circle_id." order by deliverbycircle_fee asc limit 1";
				$rs_ff=mysql_query($sql_ff);
				$rows_ff=mysql_fetch_assoc($rs_ff);
				if ($rows_ff){
					$deliverfee_r=$rows_ff['deliverbycircle_fee'];
					$sendfee=$rows_ff['deliverbycircle_minfee'];
					$isDFee=$rows_ff['deliverbycircle_isfee'];
					$sendfee_r=$sendfee;
					$deliverfee=$deliverfee_r;
					$deliver_t=true;
				}else{
					$deliver_t=false;
					$isDFee='';
					$sendfee='';
					$sendfee_r=$sendfee;
					$deliverfee_r='';
				}
			}else{  //地标添加
				$sql="select * from qiyu_deliver where deliver_spot=".$spot_id." and deliver_shop=".$shopID;
				$rs=mysql_query($sql);
				$row=mysql_fetch_assoc($rs);
				if ($row){
					$isDFee=$row['deliver_isfee'];
					$sendfee=$row['deliver_minfee'];
					$sendfee_r=$sendfee;
					$deliverfee_r=$row['deliver_fee'];
					$deliverfee=$deliverfee_r;
					$deliver_t=true;
				}else{	
					$deliver_t=false;
					$isDFee='';
					$sendfee='';
					$sendfee_r=$sendfee;
					$deliverfee_r='';
				}
			}
			
				$total=0;
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
				//得到商家的折扣
				$sql="select shop_discount from qiyu_shop where shop_id=".$shopID." and shop_status='1'";
				$rs=mysql_query($sql);
				$rows=mysql_fetch_assoc($rs);
				if ($rows){
					$discount=$rows['shop_discount'];
				}
				
				//检查是否是饭点商家
				$sqlStr="select * from qiyu_tag where tag_id=9";
				$rs_r=mysql_query($sqlStr);
				$rows=mysql_fetch_assoc($rs_r);
				if ($rows){
					if (!empty($shopCircle)){
						$sql="select * from qiyu_shoptagbycircle where shoptagbycircle_shop=".$shopID." and shoptagbycircle_tag=9 and shoptagbycircle_circle=".$circle_id;  //按商圈
						$sql_1="select * from qiyu_shoptagbycircle where shoptagbycircle_shop=".$shopID." and shoptagbycircle_tag=9"; 
					}else{
						$sql="select * from qiyu_shoptag where shoptag_shop=".$shopID." and shoptag_tag=9 and shoptag_spot=".$spot_id;
						$sql_1="select * from qiyu_shoptag where shoptag_shop=".$shopID." and shoptag_tag=9";
					}
					if ($rows['tag_isspot']=='1'){
						
						$sql=$sql;
						
					}else{
						$sql=$sql_1;
						
					}
					
					$rs=mysql_query($sql);
					$row=mysql_fetch_assoc($rs);
					if ($row){
						$isFee=true;
					}else{ 
						
						$isFee=false;
						
						
					}
				}
				//如果>起送费并且 deliver_isfee 为1则免送餐费 
				/*
									if ($isDFee=='1' && $total>=$sendfee_r){  
										$deliverfee_r=0;						
									}
									
									if ($pay=='1'){
										$deliverfee_r=0;
									}
									*/
									
									//if ($discount!='0.0'){
										//$totalAll=($total*$discount/10)+$deliverfee_r."元";
									//}else{
										$totalAll=$total+$deliverfee_r."元";
									//}
									
									
									//if ($deliverfee_r==0){ 
										//$str= "送餐费：无";
									//}else{
										$str= "送餐费：".$deliverfee_r."元";
									//}
									
									$sendStr='最低起送：'.$sendfee_r.'元';
									echo "S|".$str."|".$totalAll."|".$total."|".$sendStr."|".$spot_id."|".$sendfee_r;
			
	}
	

?>