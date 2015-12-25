<?php
	/**
	 *  userorder_do.php 添加订单
	
	 */
	header("Content-type: text/html; charset=utf-8");
	require_once("usercheck.php");
	$userphone=sqlReplace(trim($_POST['phone1']));
	
	$sql="select order_addtime from qiyu_order where order_userphone='".$userphone."' order by order_addtime desc limit 0 ,1";
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	$addtime=strtotime($row['order_addtime']);//最新订单时间
	$ntime=time();//当前时间
	$btime=$ntime-$addtime;
	if($btime<60*1){//如果距离此用户最新的订单时间小于一分钟
        alertInfo('亲，一分钟内您不能频繁下订单哦','',0);
		exit;
	}
	$o = new AppException();
	$fee=sqlReplace(trim($_POST['fee']));
	$shopID=sqlReplace(trim($_GET['shopID']));//商家id
	$ISinsert=sqlReplace(trim($_POST['insert']));
	$pay=empty($_POST['pay'])?'':sqlReplace(trim($_POST['pay']));
	$orderDesc=$_SESSION['qiyu_orderDesc'];
	$time1=$_SESSION['qiyu_orderTime1'];
	$time2=$_SESSION['qiyu_orderTime2'];
	$orderType=$_SESSION['qiyu_orderType'];
	$orderGroup=$_SESSION['qiyu_orderGroup'];
	$addressList=sqlReplace(trim($_POST['addressList']));
	$temporary=empty($_SESSION['qiyu_temporary'])?false:$_SESSION['qiyu_temporary']; //新浪临时账号 true 是
	$shopSpot=empty($_GET['shopSpot'])?'0':sqlReplace(trim($_GET['shopSpot']));
	$sinaUid=empty($_SESSION['sinaUid'])?'':sqlReplace($_SESSION['sinaUid']);
	$sinaNick=empty($_SESSION['sinaNick'])?'':sqlReplace($_SESSION['sinaNick']);
	$circleID=empty($_GET['circleID'])?0:sqlReplace(trim($_GET['circleID']));//商圈
	$NOUSERID='';//未登录就下单的标识
	if (empty($QIYU_ID_USER)){
		Header("Location: userlogin.php?p=order&shopID=".$shopID."&shopSpot=".$shopSpot."&shopCircle=".$circleID);
		exit;
	}
	if ($ISinsert=="1"){
		$password=sqlReplace(trim($_POST['password']));
		$phone=sqlReplace(trim($_POST['phone']));
		$name=sqlReplace(trim($_POST['name']));
		$area=sqlReplace(trim($_POST['area']));
		$circle=sqlReplace(trim($_POST['circle']));
		$spot=sqlReplace(trim($_POST['spot']));
		$address2=sqlReplace(trim($_POST['address']));
		$phone1=sqlReplace(trim($_POST['phone1']));
		$name1=sqlReplace(trim($_POST['name1']));
		$area1=sqlReplace(trim($_POST['area1']));
		$circle1=sqlReplace(trim($_POST['circle1']));
		$spot1=sqlReplace(trim($_POST['spot1']));
		$address1=sqlReplace(trim($_POST['address1']));
		
		
		
		if (empty($QIYU_ID_USER)){   //没有登录的操作
			checkData($phone,'手机号',1);
			checkData($name,'用户姓名',1);
			
			checkData($address2,'详细地址',1);
			$pw1=getRndCode_r(6);  //随即生成的密码

			$ip=$_SERVER['REMOTE_ADDR'];
			$logincount = 1;
			$vercode=getRndCode(6);
			$pw=md5(md5($pw1.$vercode));
			//检查用户名的存在
			$sqlStr="select user_id,user_salt from qiyu_user where user_phone='".$phone."'";
			$rs=mysql_query($sqlStr);
			$row=mysql_fetch_assoc($rs);
			if (!$row){  //手机号没注册
				$_SESSION['NOUSERID']=true;
				$sql = "insert into qiyu_user(user_account,user_password,user_logintime,user_loginip,user_logincount,user_phone,user_time,user_name,user_salt,user_status,user_sinauid,user_sinanick,user_regtype) values('".$phone."','".$pw."',now(),'".$ip."','".$logincount."','".$phone."',now(),'".$name."','".$vercode."','0','".$sinaUid."','".$sinaNick."','1')";
				if(mysql_query($sql)){
					$id = mysql_insert_id();
					$QIYU_ID_USER=$id;
					//记录Session
					//$_SESSION['qiyu_uid']=$QIYU_ID_USER;

					$totaladdr=$address2;

					$address_sql = "insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_address,useraddr_name,useraddr_type,useraddr_totaladdr) values (".$id.",'".$phone."','".$address2."','".$name."','0','".$totaladdr."')";
					mysql_query($address_sql) or die('插入地址错误');
					//把密码发给此用户
					$addressList=mysql_insert_id();
					$_SESSION['login_url']='';
					$content="感谢您使用<?php echo $SHOP_NAME?>网站，您今后登陆<?php echo $SHOP_NAME?>网站的帐号为您的手机号，登陆密码为".$pw1.". 可在网站个人中心页面修改您的密码。稍后您将收到订单进程的短信提醒。";
					
					if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) || empty($phone) || $site_sms!='1')){
						$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
						$r_status=$result[0]->status;
						if ($r_status!=='no'){
							$userID2=$result[0]->id2;//用户ID2
							$sms=$o->getSMS($userID2);
							$s_status=$sms[0]->status;						

							if ($s_status=='noBuy'){
								//echo "<a href='http://www.wiiyun.com' target='_blank'>还没有使用群发短信应用,请您先购买</a>";
							}else{
								
								//发送短信
								$data=array('reciver'=>$phone,'content'=>$content,'userID2'=>$userID2);
								$result=$o->sendSMS($userID2,$data);
								
							}
							
						}else{
							//
						}
					}
				}else{
					alertInfo("意外出错","userorder.php?shopID=".$shopID."&shopSpot=".$shopSpot."&circleID=".$circleID,0);	
				}
			}else{ //手机号已注册，插入新的地址
				$sqls="select user_id from qiyu_user where user_password='".md5(md5($password.$row['user_salt']))."' and user_phone=".$phone." and user_id=".$row['user_id'];
				$rss=mysql_query($sqls);
				$rows=mysql_fetch_assoc($rss);
				if(!$rows){
					alertInfo("密码错误","userorder.php?shopID=".$shopID."&shopSpot=".$shopSpot,0);	
				}else{
					$id=$row['user_id'];
					$QIYU_ID_USER=$id;
					//记录Session
					$_SESSION['qiyu_uid']=$QIYU_ID_USER;
					mysql_query($sql_update);
					//$sql_update="update qiyu_useraddr set useraddr_type='1' where useraddr_user=".$id." and useraddr_type='0'";
					//mysql_query($sql_update) or die('修改错误');
					
					$totaladdr=$address2;
					$address_sql = "insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_address,useraddr_name,useraddr_type,useraddr_totaladdr) values (".$id.",'".$phone."','".$address2."','".$name."','1','".$totaladdr."')";
					mysql_query($address_sql) or die('插入地址错误');
					$addressList=mysql_insert_id();
				}
			}
		}else if (!empty($QIYU_ID_USER) && $temporary==true){ //weibo login
			checkData($phone,'手机号',1);
			checkData($name,'用户姓名',1);
			
			checkData($address2,'详细地址',1);
			$weiboResult=set_weibo($phone,$sinaUid,$sinaNick,$QIYU_ID_USER,$password);
			if ($weiboResult=="E"){
				alertInfo("密码错误","userorder.php?shopID=".$shopID."&shopSpot=".$shopSpot."&circleID=".$circleID,0);	
			}
			$QIYU_ID_USER=$_SESSION['qiyu_uid'];
			
			$totaladdr=$address2;

			$address_sql = "insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_address,useraddr_name,useraddr_type,useraddr_totaladdr) values (".$QIYU_ID_USER.",'".$phone."','".$address2."','".$name."','0','".$totaladdr."')";
			mysql_query($address_sql) or die('插入地址错误');
			$addressList=mysql_insert_id();

		}else{ //登录
			//查询当前用户的姓名
			$sql_uname="select user_name from qiyu_user where user_id=".$QIYU_ID_USER;
			$rs_uname=mysql_query($sql_uname);
			$row_uname=mysql_fetch_assoc($rs_uname);
			$USERNAME0=$row_uname['user_name'];
			checkData($phone1,'手机号1',1);
		
			checkData($address1,'详细地址',1);
			
			$totaladdr1=$address1;
			//对微博的处理
			$temporary=empty($_SESSION['qiyu_temporary'])?false:$_SESSION['qiyu_temporary']; //新浪临时账号 true 是
			if ($addressList=="0"){
				
				$address_sql = "insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_address,useraddr_name,useraddr_type,useraddr_totaladdr) values (".$QIYU_ID_USER.",'".$phone1."','".$address1."','".$USERNAME0."','1','".$totaladdr1."')";
				mysql_query($address_sql) or die('插入地址错误');
				$addressList=mysql_insert_id();
			}else{
				
			}
		}
			
	}
	
	$sql="select * from qiyu_shop where shop_id=".$shopID." and shop_status='1'";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$shop_id2=$rows['shop_id2'];
		$shop_type=$rows['shop_type'];
		$shop_name=$rows['shop_name'];
		$shop_phone=floatval($rows['shop_phone']);
		$shop_discount=$rows['shop_discount'];
	
	}
	//得到用户的送餐地址的地标
	if (empty($addressList)){
		alertInfo("您还没有选择送餐地址","index.php",0);
		exit;
	}
	$sql="select * from qiyu_useraddr where useraddr_id=".$addressList;
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$spot_id=$rows['useraddr_spot'];
		$circle_id=$rows['useraddr_circle'];
		$address=$rows['useraddr_id'];
		
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
	

	
	$startNum=$SHOP_ORDERNUM;
	//修改订单号
	updateOrderNum();
	$vCode=rand(0,9);
	$order=substr(($startNum+$vCode),-1).$startNum.$vCode;
	
	$total=0;
	$cur_cart_array = explode("///",$_COOKIE['qiyushop_cart']);
	foreach($cur_cart_array as $key => $goods_current_cart){
		$currentArray=explode("|",$goods_current_cart);
		$cookieShopID=$currentArray[0];
		$cookieFoodID=$currentArray[1];
		$cookieFoodCount=$currentArray[2];
		$cookieFoodDesc=$currentArray[3];
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
	//判断是否满足商家设定的外送消费下限
		if ($total<$sendfee_r && $orderType!='group'){		
			alertInfo("您的订单不够起送金额，请酌情增加。","index.php",0);
		}	

	if ($isDFee=='1' && $total>=$sendfee_r){  
		$deliverfee_r=0;						
	}
	if ($pay=='1'){
		$deliverfee_r=0;
	}	

		


	//if ($shop_discount!='0.0') $total=$total*$shop_discount/10;
	$totalAll=$total+$deliverfee_r;
	if (!empty($time2)){
		$content='[预约时间:'.$time1.$time2.'],';
	}
	$content.="订单号:".$order.",总金额:".$totalAll."元";
	$content_r='';
	$sql="select * from qiyu_useraddr where useraddr_id=".$address;
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	$orderaddr=$row['useraddr_address'];//订单地址
	$orderusername=$row['useraddr_name'];
	$orderuserphone=$row['useraddr_phone'];
	$ordershopid=$shopID;
	if ($pay=='1')
		$ispay='1';
	else
		$ispay='0';
	$ordertime=date('Y-m-d H:i:s');
	
    $curDate = date("Y-m-d");     
  
	
	if (empty($time2)){//
		if ($orderType=='group'){
			$order_type='2';
			//添加团购数量
			addGroupCount($orderGroup,$QIYU_ID_USER);
		}else
			$order_type='0';//新订单
		$sql="insert into qiyu_order(order_area,order_circle,order_spot,order_build,order_id2,order_shop,order_user,order_addtime,order_totalprice,order_price,order_deliverprice,order_status,order_useraddr,order_address,order_username,order_userphone,order_shopid,order_text,order_type,order_ispay) values ('".$row['area_name']."','".$row['circle_name']."','".$row['spot_name']."','','".$order."','".$shop_id2."',".$QIYU_ID_USER.",'".$ordertime."',".$totalAll.",".$total.",".$deliverfee_r.",'0',".$address.",'".$orderaddr."','".$orderusername."','".$orderuserphone."',".$ordershopid.",'".$orderDesc."','".$order_type."','".$ispay."')";		
	}else
		$sql="insert into qiyu_order(order_area,order_circle,order_spot,order_build,order_id2,order_shop,order_user,order_addtime,order_totalprice,order_price,order_deliverprice,order_status,order_useraddr,order_address,order_username,order_userphone,order_shopid,order_text,order_type,order_time1,order_time2,order_ispay) values ('".$row['area_name']."','".$row['circle_name']."','".$row['spot_name']."','','".$order."','".$shop_id2."',".$QIYU_ID_USER.",'".$ordertime."',".$totalAll.",".$total.",".$deliverfee_r.",'0',".$address.",'".$orderaddr."','".$orderusername."','".$orderuserphone."',".$ordershopid.",'".$orderDesc."','1','".$time1."','".$time2."','".$ispay."')";
	
	if (!mysql_query($sql)){
		alertInfo('备注内容过长','',0);
	}
	$orderContent="<span class='greenbg'><span><span>订单成功生成</span></span></span>";
	$orderContent.="您的订单已经成功生成！";
	addOrderType($order,HTMLEncode($orderContent));
	if(empty($_SESSION['qiyu_uid'])){
		$_SESSION['order_id']=$order;
	}
    

	

	//把cookied的值保存到数据库
	foreach($cur_cart_array as $key => $goods_current_cart){
		$currentArray=explode("|",$goods_current_cart);
		$cookieShopID=$currentArray[0];
		$cookieFoodID=$currentArray[1];
		$cookieFoodCount=$currentArray[2];
		$cookieFoodDesc=$currentArray[3];
		if ($shopID==$cookieShopID){
			$sql="select * from qiyu_food where food_id=".$cookieFoodID." and food_shop=".$cookieShopID;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$cookieFoodDesc_rr=str_replace('&nbsp;','',$cookieFoodDesc);
				$cookieFoodDesc_rr=str_replace(' ','',$cookieFoodDesc_rr);
				$content_r.=','.$rows['food_name'].$cookieFoodCount.'份';
				$foodprice=$rows['food_price'];
				if(!empty($cookieFoodDesc)) {
					$cookieFoodDesc_rrr='('.$cookieFoodDesc_rr.')';  
				}
				
				$content_p.=$rows['food_name'].$cookieFoodDesc_rrr.'　￥'.$foodprice.' X '.$cookieFoodCount."\n";

				if (!empty($cookieFoodDesc_rr)) $content_r.='('.$cookieFoodDesc_rr.')';
				if ($orderType=='group'){
					$food_price=$rows['food_groupprice'];
				}else{
					$food_price=$rows['food_price'];
				}
				$sql="insert into qiyu_cart(cart_shop,cart_user,cart_food,cart_price,cart_count,cart_status,cart_order,cart_desc) values ('".$shop_id2."',".$QIYU_ID_USER.",".$cookieFoodID.",".$food_price.",".$cookieFoodCount.",'1','".$order."','".$cookieFoodDesc."')";
				mysql_query($sql) or die($sql);
			}
		}
	}
	$content.=$content_r;
	if (!empty($orderDesc)) $content.=',备注:'.$orderDesc.'';
	$content.=',客户:'.$orderusername.',地址:'.$orderaddr.',电话:'.$orderuserphone;

	
	//删除cookie
	 delAllcart($shopID);

	//发送短信给商家
	if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) || empty($shop_phone) || $site_sms!='1' )){
		//	检测微云码与账号是否正确
		$result=$o->checkWiiyunSalt($site_wiiyunsalt,$site_wiiyunaccount);
		$r_status=$result[0]->status;
		if ($r_status!=='no'){
			$userID2=$result[0]->id2;//用户ID2
			$sms=$o->getSMS($userID2);
			$s_status=$sms[0]->status;
			if ($s_status=='noBuy'){
				//echo "<a href='http://www.wiiyun.com' target='_blank'>还没有使用群发短信应用,请您先购买</a>";
			}else{				
				//发送短信
				$data=array('reciver'=>$shop_phone,'content'=>$content,'userID2'=>$userID2);
				$result=$o->sendSMS($userID2,$data);
				
			}
		}else{
			// 不正确的情况
		}
	}  

	//sleep(10);
	//打印订单
	//订单内容
	/* */
	$print_content='';
	
	for($i=1;$i<=$site_yunprintnum;$i++){		
		if($site_yunprintnum>1){
			$print_content='【第 '.$i.' 联】'."\n";
		}
		$print_content.="订单号：".$order.  "\n";
		$print_content.="订餐时间：".$ordertime.  "\n";
		if (!empty($time2)){
			$print_content.="预约时间：".$time1.' '.$time2. ":00\n";
		}
        
		$print_content.="姓名：" .$orderusername. " \n";	
		$print_content.="电话: " .$orderuserphone." \n";
		$print_content.="地址: " .$orderaddr. " \n";
		$print_content.="------------------------- \n";	
		$print_content.=$content_p;
		$print_content.="------------------------- \n";	
		if($deliverfee_r>0){
			$print_content.="送餐费:￥".number_format($deliverfee_r,2)." \n";
		}	
		$print_content.="总金额:￥".number_format($totalAll,2)." \n";	
		$print_content.="备注: ".str_replace('<br/>','',str_replace('&nbsp;','',$orderDesc)). " \n\n\n\n\n\n";

		if (!(empty($site_yunprint))){
			$p=new YunPrint();
			$a=$p->printTxt($site_yunprint,$print_content);
		} 
		
	}
   

	
	$_SESSION['login_url']='';
	$_SESSION['qiyu_orderTime1']='';
	$_SESSION['qiyu_orderTime2']='';
	$_SESSION['qiyu_orderDesc']='';
	$_SESSION['qiyu_orderType']='';
	$_SESSION['qiyu_orderGroup']='';
	if ($pay=='1'){
		Header("Location: pay/ali/alipayto.php?order=".$order."&price=".$totalAll);
	}else{
		Header("Location: userordersuccess.php?id=".$order);
	}

	
?>

