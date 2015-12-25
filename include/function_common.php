<?php
/**
 * 前台公用函数，与业务无关的函数
 */
 function getUserName($id){
	$sql_get="select user_name from qiyu_user where user_id=$id";
	$rs_get=mysql_query($sql_get);
	$row_get=mysql_fetch_assoc($rs_get);
	if($row_get){
		return $row_get['user_name'];
	}else{
		return '--';
	}

}
function getUrl(){
	$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	return ($url);
}
function sqlReplace($str){
   $strResult = $str;
   if(!get_magic_quotes_gpc())
   {
     $strResult = addslashes($strResult);
   }
   return $strResult;
}
function HTMLEncode($str){
	if (!empty($str)){
		$str=str_replace("&","&amp;",$str);
		$str=str_replace(">","&gt;",$str);
		$str=str_replace("<","&lt;",$str);
		$str=str_replace(CHR(32),"&nbsp;",$str);
		$str=str_replace(CHR(9),"&nbsp;&nbsp;&nbsp;&nbsp;",$str);
		$str=str_replace(CHR(9),"&#160;&#160;&#160;&#160;",$str);
		$str=str_replace(CHR(34),"&quot;",$str);
		$str=str_replace(CHR(39),"&#39;",$str);
		$str=str_replace(CHR(13),"",$str);
		$str=str_replace(CHR(10),"<br/>",$str);
	}
	return $str;
}
Function HTMLDecode($str){
	if (!empty($str)){
		$str=str_replace("&amp;","&",$str);
		$str=str_replace("&gt;",">",$str);
		$str=str_replace("&lt;","<",$str);
		$str=str_replace("&nbsp;",CHR(32),$str);
		$str=str_replace("&nbsp;&nbsp;&nbsp;&nbsp;",CHR(9),$str);
		$str=str_replace("&#160;&#160;&#160;&#160;",CHR(9),$str);
		$str=str_replace("&quot;",CHR(34),$str);
		$str=str_replace("&#39;",CHR(39),$str);
		$str=str_replace("",CHR(13),$str);
		$str=str_replace("<br/>",CHR(10),$str);
		$str=str_replace("<br>",CHR(10),$str);
	}
	return $str;
}
function DateDiff($part, $begin, $end){
	$diff = strtotime($end) - strtotime($begin);
	switch($part){
		case "y": $retval = bcdiv($diff, (60 * 60 * 24 * 365)); break;
		case "m": $retval = bcdiv($diff, (60 * 60 * 24 * 30)); break;
		case "w": $retval = bcdiv($diff, (60 * 60 * 24 * 7)); break;
		case "d": $retval = bcdiv($diff, (60 * 60 * 24)); break;
		case "h": $retval = bcdiv($diff, (60 * 60)); break;
		case "n": $retval = bcdiv($diff, 60); break;
		case "s": $retval = $diff; break;
	}
	return $retval;
}
function alertInfo($info,$url,$type){
	switch($type){
		case 0:
			echo "<script language='javascript'>alert('".$info."');location.href='".$url."'</script>";
			exit;
			break;
		case 1:
			echo "<script language='javascript'>alert('".$info."');history.back(-1);</script>";
			exit;
			break;
	}
}
function checkData($data,$name,$type){
	switch($type){
		case 0:
			if(!preg_match('/^\d*$/',$data)){
				alertInfo("非法参数".$name,'',1);
			}
			break;
		case 1:
			if(empty($data)){
				alertInfo($name."不能为空","",1);
			}
			break;
	}
	return $data;
}

function checkEmail($email,$name)
{
	if(empty($email))
	{
		alertInfo($name.'不能为空','',1);
	}else if(!eregi("^[a-zA-Z0-9]([a-zA-Z0-9]*[-_.]?[a-zA-Z0-9]+)+@([a-zA-Z0-9]+\.)+[a-zA-Z]{2,}$", $email)) 
	{
		alertInfo($name.'输入格式不正确','',1);
	}

}
function getRndCode($length) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	$hash = '';
	$chars = 'EMBAQIYUADFGHJKL123456789';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

function getRndCode_r($length) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	$hash = '';
	$chars = '0123456789';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}
function cutstr($string, $length) {
	$charset="utf-8";
	if(strlen($string) <= $length) {
		return $string;
	}
	//$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	//$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut.'...';
}

/*********自定义函数************/
function showPage($url,$page,$pagesize,$rscount,$pagecount){
		$temppage="";
		$temppage="<div id=\"page\" class=\"addressMore\">";

			if($page==1)
				$temppage.="<b class='gray_p'>上一页</b>";
			else
				$temppage.="<a href='".$url."?page=".($page-1)."'>上一页</a>";
		
		If($pagecount<9){
			for($p=1;$p<=$pagecount;$p++){
				if($p!=$page)
					$temppage.="<a href='".$url."?page=".$p."'>".$p."</a>";
				else
					$temppage.="<b> ".$p."</b>";
			}
		}else{
			if($page<=3){
				for($p=1;$p<=5;$p++){
					if($p!=$page)
						$temppage.="<a href='".$url."?page=".$p."'>".$p."</a>";
					else
						$temppage.="<b> ".$p."</b>";
				}
				$temppage.="<span class='active'>...</span>";
				for($p=$pagecount-3;$p<=$pagecount;$p++){
					if($p!=$page)
						$temppage.="<a href='".$url."?page=".$p."'>".$p."</a>";
					else
						$temppage.="<b> ".$p."</b>";
				}
			}else if($pagecount-$page<=3){
				for($p=1;$p<=3;$p++){
					$temppage.="<a href='".$url."?page=".$p."'>".$p."</a>";
				}
				$temppage.="<span class='active'>...</span>";
				for($p=$pagecount-4;$p<=$pagecount;$p++){
					if($p!=$page)
						$temppage.="<a href='".$url."?page=".$p."'>".$p."</a>";
					else
						$temppage.="<span class='active'> ".$p."</span>";
				}
			}
			else{
				$temppage.="<a href='".$url."?page=1'>1</a>";
				$temppage.="<span class='active'>...</span>";
				for($p=$page-2;$p<=$page+2;$p++){
					if($p!=$page)
						$temppage.="<a href='".$url."?page=".$p."'>".$p."</a>";
					else
						$temppage.="<b> ".$p."</b>";
				}
				$temppage.="<span class='active'>...</span>";
				$temppage.="<a href='".$url."?page=".$pagecount."'>".$pagecount."</a>";
			}
		}
			if($page==$pagecount)
				$temppage.="<b class='gray_p'>下一页</b>";
			else
				$temppage.="<a href='".$url."?page=".($page+1)."'>下一页</a>";
		

		$temppage.="</div>";

		if(!strpos($url,"?")===false)
			$temppage=str_replace("?page=","&page=",$temppage);

		return $temppage;
}
//根据商圈得到商家的数量
function getShopCountBYCircle($id){
	$sql_ff="select count(distinct shop_id) as c  from qiyu_circle inner join qiyu_spot on spot_circle=circle_id inner join qiyu_shopspot on shopspot_spot=spot_id inner join qiyu_shop on shop_id=shopspot_shop and circle_id=".$id." and shop_status='1'";
	$rs_ff=mysql_query($sql_ff);
	$row_ff=mysql_fetch_assoc($rs_ff);
	if ($row_ff)
		$shopCount=$row_ff['c'];
	else
		$shopCount=0;
	return $shopCount;

}
//根据地标商圈得到商家的数量
function getShopCountBYC_S($spotID,$circleID){
	$sql_ff="select count(distinct shop_id) as c from qiyu_circle inner join qiyu_spot on spot_circle=circle_id inner join qiyu_shopspot on shopspot_spot=spot_id inner join qiyu_shop on shop_id=shopspot_shop inner join qiyu_delivertime on delivertime_shop=shop_id and time(now())>=delivertime_starttime and time(now())<=delivertime_endtime and circle_id=".$circleID." and spot_id=".$spotID." and shop_status='1'";
	$rs_ff=mysql_query($sql_ff);
	$row_ff=mysql_fetch_assoc($rs_ff);
	if ($row_ff)
		$shopCount=$row_ff['c'];
	else
		$shopCount=0;
	return $shopCount;
}
//根据菜系得到商家的数量
function getShopCountBYStyle($id){
	$sql_ff="select count(shopstyle_id) as c from qiyu_shopstyle where shopstyle_style=".$id;
	$rs_ff=mysql_query($sql_ff);
	$row_ff=mysql_fetch_assoc($rs_ff);
	if ($row_ff)
		$shopCount=$row_ff['c'];
	else
		$shopCount=0;
	return $shopCount;

}
//根据菜系得到此菜系下的菜的数量
function getfoodCountByID($fID){
	if (empty($lableID))
		$sql_ff="select count(*) as c from qiyu_food where food_foodtype=".$fID." and food_status='0'";
	else
		$sql_ff="select count(*) as c from qiyu_food inner join qiyu_foodbylable on foodbylable_food=food_id and foodbylable_foodlable=".$lableID." and food_foodtype=".$fID." and food_status='0'";
	$rs_ff=mysql_query($sql_ff);
	$row_ff=mysql_fetch_assoc($rs_ff);
	if ($row_ff)
		$foodCount=$row_ff['c'];
	else
		$foodCount=0;
	return $foodCount;
}
//根据菜标签得到此标签下的下的菜的数量
function getfoodCountByLID($shopID,$lableID){
	
	$sql_ff="select count(*) as c from qiyu_food inner join qiyu_foodbylable on foodbylable_food=food_id and foodbylable_foodlable=".$lableID." and food_status='0' and food_shop=".$shopID;
	$rs_ff=mysql_query($sql_ff);
	$row_ff=mysql_fetch_assoc($rs_ff);
	if ($row_ff)
		$foodCount=$row_ff['c'];
	else
		$foodCount=0;
	return $foodCount;
}
//根据商圈 菜系统计商家数量
function getShopCountBYC_Style($circleID,$styleID){
	$sql_ff="select count(shop_id) as c  from qiyu_shopstyle inner join qiyu_shop on shop_id=shopstyle_shop inner join qiyu_shopspot on shopspot_shop=shop_id inner join qiyu_spot on spot_id=shopspot_spot inner join qiyu_circle on circle_id=spot_circle and shopstyle_style=".$styleID."  and circle_id=".$circleID."  and shop_status='1'";
	$rs_ff=mysql_query($sql_ff);
	$row_ff=mysql_fetch_assoc($rs_ff);
	if ($row_ff)
		$shopCount=$row_ff['c'];
	else
		$shopCount=0;
	return $shopCount;
}

//根据商圈 菜系,地标统计商家数量
function getShopCountBYSC_Style($spotID,$styleID,$circleID){
	$sql_ff="select count(shop_id) as c from qiyu_shopstyle inner join qiyu_shop on shop_id=shopstyle_shop inner join qiyu_shopspot on shopspot_shop=shop_id inner join qiyu_spot on spot_id=shopspot_spot  and shopstyle_style=".$styleID." and shop_status='1' and spot_circle=".$circleID." and shopspot_spot=".$spotID;
	$rs_ff=mysql_query($sql_ff);
	$row_ff=mysql_fetch_assoc($rs_ff);
	if ($row_ff)
		$shopCount=$row_ff['c'];
	else
		$shopCount=0;
	return $shopCount;
}
//添加积分动态
function addscoreDynamic($score,$uid,$order,$id2,$getScore,$type){
	$sql_rr="insert into qiyu_rscore(rscore_user,rscore_order,rscore_shop,rscore_spendvalue,rscore_getvalue,rscore_addtime,rscore_type) values (".$uid.",'".$order."',".$id2.",".$score.",".$getScore.",now(),'".$type."')";
	mysql_query($sql_rr);
}
//修改用户积分
function updateuserScore($score,$uid){
	$sql_rr="update qiyu_user set user_score=user_score+".$score." where user_id=".$uid;
	mysql_query($sql_rr);
}
//判断是否在送餐范围
function isdeliverscope($spot_id,$shopID){
	
	$sql="select * from qiyu_shopspot where shopspot_spot=".$spot_id." and shopspot_shop=".$shopID;
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	if ($row){
		$isScope=true;
	}else{
		$isScope=false;
	}
	return $isScope;
}

//判断是否在送餐范围----商圈
function isdeliverscopeByCircle($circle_id,$shopID){
	
	$sql="select * from qiyu_shopcircle where shopcircle_circle=".$circle_id." and shopcircle_shop=".$shopID;
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	if ($row){
		$isScope=true;
	}else{
		$isScope=false;
	}
	return $isScope;
}
//统计购物车数量
function getCartCount($shopID){
	$cartCount=0;
	$cur_goods_array = empty($_COOKIE['qiyushop_cart'])?'':$_COOKIE['qiyushop_cart'];
	//删除该商品在数组中的位置
	$cartArray=explode("///",$cur_goods_array);
	foreach ($cartArray as $key => $cartValue){
		$currentArray=explode("|",$cartValue);
		if ($currentArray[0]==$shopID)
			$cartCount+=1;
	}
	return $cartCount;
}
function addcart($goods_id,$shop_id,$desc){
	$cur_cart_array = empty($_COOKIE['qiyushop_cart'])?'':$_COOKIE['qiyushop_cart'];
	$isExist=false;
	if($cur_cart_array==""){
		setcookie("qiyushop_cart",$shop_id."|".$goods_id."|1|".$desc,time()+60*60*2);
	}elseif($cur_cart_array<>""){
		$cur_cart_array1 = explode("///",$cur_cart_array);
		foreach($cur_cart_array1 as $key => $goods_current_cart){
			$currentArray=explode("|",$goods_current_cart);
			$cookieShopID=$currentArray[0];
			$cookieFoodID=$currentArray[1];
			$cookieFoodCount=$currentArray[2];
			//echo 'shuliang'.$cookieFoodCount;
			$cookieFoodDesc=$currentArray[3];
			if ($shop_id==$cookieShopID && $goods_id==$cookieFoodID){
				$isExist=true;
				$cookieFoodCount++;
				$cookieFoodDesc.=" ".$desc;
				$cur_cart_array1[$key]=$cookieShopID."|".$cookieFoodID."|".$cookieFoodCount."|".$cookieFoodDesc;
				break;
			}
		}
		if ($isExist===false){
			
			$cur_cart_array.="///".$shop_id."|".$goods_id."|1|".$desc;
			setcookie("qiyushop_cart",$cur_cart_array,time()+60*60*2);
		}else{
			$str='';
			$comm='';
			foreach ($cur_cart_array1 as $cartValue){
				$str.=$comm.$cartValue;
				$comm='///';
			}
			setcookie("qiyushop_cart",$str,time()+60*60*2);
		}
		
	}
}
//从购物车删除
function delAllcart($shopID){
	$cur_goods_array = $_COOKIE['qiyushop_cart'];
	setcookie("qiyushop_cart",'',time()+60*60*2);
	//删除该商品在数组中的位置
	$cartArray=explode("///",$cur_goods_array);
	foreach ($cartArray as $key => $cartValue){
		$currentArray=explode("|",$cartValue);
		if ($currentArray[0]==$shopID)
			unset($cartArray[$key]);
	}
	$str='';
	$comm='';
	foreach ($cartArray as $cartValue){
		$str.=$comm.$cartValue;
		$comm='///';
	}
	setcookie("qiyushop_cart",$str,time()+60*60*2);
}
//从购物车删除某一个商品
function delcart($id,$shopID){
	$cur_goods_array = $_COOKIE['qiyushop_cart'];
	setcookie("qiyushop_cart",'',time()+60*60*2);
	//删除该商品在数组中的位置
	$cartArray=explode("///",$cur_goods_array);
	foreach ($cartArray as $key => $cartValue){
		$currentArray=explode("|",$cartValue);
		if ($id==$key)
			unset($cartArray[$key]);
	}
	$str='';
	$comm='';
	foreach ($cartArray as $cartValue){
		$str.=$comm.$cartValue;
		$comm='///';
	}
	
	setcookie("qiyushop_cart",$str,time()+60*60*2);
}

function updateCartCount($goods_id,$shop_id){
	$cur_goods_array = $_COOKIE['qiyushop_cart'];
	setcookie("qiyushop_cart",'',time()+60*60*2);
	//删除该商品在数组中的位置
	$cartArray=explode("///",$cur_goods_array);

	foreach($cartArray as $key => $goods_current_cart){
			$currentArray=explode("|",$goods_current_cart);
			$cookieShopID=$currentArray[0];
			$cookieFoodID=$currentArray[1];
			$cookieFoodCount=$currentArray[2];
			$cookieFoodDesc=$currentArray[3];
			if ($shop_id==$cookieShopID && $goods_id==$cookieFoodID){
				if ($cookieFoodCount==1){
					//当菜的份数为1的时候直接跳出
					//unset($cartArray[$key]);
					break;
				}else{
					$cookieFoodCount--;
					$cartArray[$key]=$cookieShopID."|".$cookieFoodID."|".$cookieFoodCount."|".$cookieFoodDesc;
					break;
				}
				
			}
		}
	$str='';
	$comm='';
	foreach ($cartArray as $cartValue){
		$str.=$comm.$cartValue;
		$comm='///';
	}
	
	setcookie("qiyushop_cart",$str,time()+60*60*2);
}

/*

	* getDeliveFee() 的到送餐费
	* param $spotID 地标ID
	* param $shopID 商家ID
*/
function getDeliveFee(){
	$deleverFee=array();
	$sql_ff="select * from qiyu_deliver";
	$rs_ff=mysql_query($sql_ff);
	$rows_ff=mysql_fetch_assoc($rs_ff);
	if ($rows_ff){
		$deleverFee['fee']=$rows_ff['deliver_fee'];
		$deleverFee['minfee']=$rows_ff['deliver_minfee'];
		$deleverFee['isFee']=$rows_ff['deliver_isfee'];
		$deleverFee['deliverTime']=$rows_ff['deliver_delivertime'];
	}else{
		$deleverFee['fee']='';
		$deleverFee['minfee']='';
		$deleverFee['isFee']='';
		$deleverFee['deliverTime']='';
	}
	return $deleverFee;

}
//按商圈的送餐费 
function getDeliveFeeByCircle($circleID,$shopID){
	$deleverFee=array();
	
	$sql_ff="select * from qiyu_deliverbycircle where deliverbycircle_shop=".$shopID." and deliverbycircle_circle=".$circleID." order by deliverbycircle_fee asc limit 1";
	$rs_ff=mysql_query($sql_ff);
	$rows_ff=mysql_fetch_assoc($rs_ff);
	if ($rows_ff){
		$deleverFee['fee']=$rows_ff['deliverbycircle_fee'];
		$deleverFee['minfee']=$rows_ff['deliverbycircle_minfee'];
		$deleverFee['isFee']=$rows_ff['deliverbycircle_isfee'];
		$deleverFee['deliverTime']=$rows_ff['deliverbycircle_delivertime'];
	}else{
		$deleverFee['fee']='';
		$deleverFee['minfee']='';
		$deleverFee['isFee']='';
		$deleverFee['deliverTime']='';
	}
	return $deleverFee;
}

/*

	* getTag() 的到商家的标签
	* param $spotID 地标ID
	* param $shopID 商家ID
*/
function getTag($spotID,$shopID){
	//如果地标为空显示最低的送餐费
	$tagStr='';
	$comm='';
	$sql_ff="select * from qiyu_tag inner join qiyu_shoptag on shoptag_tag=tag_id and  shoptag_shop=".$shopID;
	$rs_ff=mysql_query($sql_ff);
	while ($rows_ff=mysql_fetch_assoc($rs_ff)){
		if (!empty($spotID)){ //地标不为空是显示该地标下的标签跟与地标无关的标签
			if ($rows_ff['shoptag_spot']==$spotID || $rows_ff['tag_isspot']=='0'){
				$tagStr.=$comm."<a href=\"javascript:void();\" title='".$rows_ff['tag_name']."'><img src=\"".$rows_ff['tag_pic']."\"  alt=\"".$rows_ff['tag_name']."\"  /></a>";
				$comm=" ";
			}
		}else{  //地标为空是显示商家所有的标签
			$tagStr.=$comm."<a href=\"javascript:void();\" title='".$rows_ff['tag_name']."'><img src=\"".$rows_ff['tag_pic']."\"  alt=\"".$rows_ff['tag_name']."\"  /></a>";
			$comm=" ";
		}
	}
	return $tagStr;

}
//得到正在进行的订单的数量
function getBengUserOrderCount($userID){
	$sql_ff="select count(order_id) as t from qiyu_order,qiyu_shop where (shop_id2=order_shop or shop_id=order_shopid) and order_user=".$userID." and (order_status='0' or order_status='1' or order_status='6' or order_status='5')";
	$rs_ff=mysql_query($sql_ff);
	$rows_ff=mysql_fetch_assoc($rs_ff);
	if ($rows_ff)
		$orderCount=$rows_ff['t'];
	else
		$orderCount=0;
	return $orderCount;
}
//得到正在进行的订单的数量
function getOrderCountByUid($userID){
	$sql_ff="select count(order_id) as t from qiyu_order,qiyu_shop where (shop_id2=order_shop or shop_id=order_shopid) and order_user=".$userID;
	$rs_ff=mysql_query($sql_ff);
	$rows_ff=mysql_fetch_assoc($rs_ff);
	if ($rows_ff)
		$orderCount=$rows_ff['t'];
	else
		$orderCount=0;
	return $orderCount;
}
//添加订单记录
function addOrderType($order,$text){
	$sql_ff="insert into qiyu_orderchange(orderchange_order,orderchange_addtime,orderchange_name) values ('".$order."',now(),'".$text."')";
	$rs_ff=mysql_query($sql_ff) or die('错误 ');
}
//发短信
function sendCode($phone,$content){
	
	$wsdl = 'http://sdk3.entinfo.cn:8060/webservice.asmx?WSDL';
	try {
	 
		$client = new SoapClient($wsdl, array('trace' => true, 'exceptions' => true ));  //调用wsdl
	 
		$params = array(
			'sn'=> 'SDK-BBX-010-11317',
			'pwd'   => strtoupper(md5('SDK-BBX-010-11317811867')),
			'mobile'  => $phone,
			'content' => $content,
			'ext' => '',
			'stime' => '',
			'rrid' => ''
		);

		$return = $client->__soapCall("mt",array('parameters'=>$params));	
	 
	}catch (SOAPFault $e) {
		print_r('Exception:'.$e);
	}

	
}
//暂时没用到
function sendCode_wiiyun($phone,$site_wiiyunsalt,$site_wiiyunaccount,$content){
	$o = new AppException();
	if (!(empty($site_wiiyunsalt) || empty($site_wiiyunaccount) || empty($phone))){
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
}	

//发飞信
function sendMSG($phone,$content){
	$wsdl = 'http://huodong.feixin.10086.cn/iwebservice.asmx?WSDL';
	try {
	 
		$client = new SoapClient($wsdl, array('trace' => true, 'exceptions' => true ));  //调用wsdl
	 
		$params = array(
			'Code'=> '25',
			'Password'   => '~!@#$%^&*()',
			'Mobile'  => $phone,
			'Msg' => $content
		);
		$return = $client->__soapCall("SendSMS",array('parameters'=>$params));  //调用方法
	 
		
	 
	}catch (SOAPFault $e) {
		print_r('Exception:'.$e);
	}
}
//得到该品牌的所有商圈
function getCircleByBrand($brandID){
	$b_str=0;
	$sql_ff="select distinct circle_id from qiyu_shop inner join qiyu_brandshop on brandshop_shop=shop_id2 inner join qiyu_shopspot on shopspot_shop=shop_id inner join qiyu_spot on spot_id=shopspot_spot inner join qiyu_circle on circle_id=spot_circle and brandshop_brand=".$brandID." and shop_status='1'";
	$rs_ff=mysql_query($sql_ff);
	while ($rows_ff=mysql_fetch_assoc($rs_ff)){
		$b_str.=",".$rows_ff['circle_id'];
	}
	return $b_str;
}
//根据品牌、商圈得到商家数量
function getShopCountByB_C($brandID,$circleID){
	$sql_ff="select count(distinct shop_id) as c from qiyu_shop inner join qiyu_brandshop on brandshop_shop=shop_id2 inner join qiyu_shopspot on shopspot_shop=shop_id inner join qiyu_spot on spot_id=shopspot_spot and spot_circle=$circleID and brandshop_brand=".$brandID." and shop_status='1'";
	$rs_ff=mysql_query($sql_ff);
	$rows_ff=mysql_fetch_assoc($rs_ff);
	if ($rows_ff){
		$shopCount=$rows_ff['c'];
	}else{
		$shopCount=0;
	}
	return $shopCount;
}
//得到地标名称
function getSpotByID($id){
	$sql_rr="select spot_name from qiyu_spot where spot_id=".$id;
	$rs_rr = mysql_query($sql_rr);
	$row_rr=mysql_fetch_assoc($rs_rr);
	if ($row_rr)
		return $row_rr['spot_name'];
	else
		return "";
}
//根据品牌、商圈得到商家的id
function getShopByB_C($brandID,$circleID){
	$shopStr=0;
	$sql_ff="select distinct shop_id from qiyu_shop inner join qiyu_brandshop on brandshop_shop=shop_id2 inner join qiyu_shopspot on shopspot_shop=shop_id inner join qiyu_spot on spot_id=shopspot_spot and spot_circle=$circleID and brandshop_brand=".$brandID." and shop_status='1'";
	$rs_ff=mysql_query($sql_ff);
	while ($rows_ff=mysql_fetch_assoc($rs_ff)){
		$shopStr.=",".$rows_ff['shop_id'];
	}
	
	return $shopStr;
}

//得到商家喜欢数
function getShopLike($shopID){
	$sql_rr="select count(fav_id) as c from qiyu_fav where fav_shop=".$shopID;
	$rs_rr=mysql_query($sql_rr);
	$row_rr=mysql_fetch_assoc($rs_rr);
	if ($row_rr)
		$likeCount=$row_rr['c'];
	else
		$likeCount=0;
	return $likeCount;
}

//得到商圈名称
function getCircleByID($id){
	$sql_rr="select circle_name from qiyu_circle where circle_id=".$id;
	$rs_rr = mysql_query($sql_rr);
	$row_rr=mysql_fetch_assoc($rs_rr);
	if ($row_rr)
		return $row_rr['circle_name'];
	else
		return "";
}

function getCircleBySpot($spotID){
	$circleArray=array();
	$sql_rr="select * from qiyu_circle,qiyu_area,qiyu_areacircle,qiyu_spot where spot_circle=circle_id and areacircle_area=area_id and  spot_id=".$spotID;
	$rs_rr = mysql_query($sql_rr);
	$row_rr=mysql_fetch_assoc($rs_rr);
	if ($row_rr){
		$circleArray['circle_name']=$row_rr['circle_name'];
		$circleArray['circle_id']=$row_rr['circle_id'];
		$circleArray['area_id']=$row_rr['area_id'];
		$circleArray['area_name']=$row_rr['area_name'];
		$circleArray['spot_name']=$row_rr['spot_name'];
	}
	return $circleArray;
	
}

//检查是否有推荐商家
function checkRmdShop($sort,$spot,$sort2){
	$sql_rr="select * from qiyu_rmd where rmd_rmdsort1=".$sort." and rmd_type='2' and rmd_spot=".$spot;
	if (!empty($sort2)) $sql_rr.=" and rmd_rmdsort2=".$sort2;
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr)
		return true;
	else
		return false;
}
//检查是否有子类
function isChildren($sort){
	$sql_rr="select * from qiyu_rmdsort where rmdsort_parent=".$sort." and rmdsort_level=2";
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr)
		return true;
	else
		return false;
}
//查找商家其中的一个地标
function getShopSpot($shopID){
	$sql_rr="select shopspot_spot from qiyu_shopspot where shopspot_shop=".$shopID;
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr)
		return $rows_rr['shopspot_spot'];
	else
		return false;
}

function getShopRmd($browse,$shopID){
	if (empty($browse))
		$sql_rr="select food_id from qiyu_food where food_special='1' and food_isshow='0' and food_check='0' and food_shop=".$shopID;
	else
		$sql_rr="select food_id from qiyu_food where food_special='1'  and food_shop=".$shopID;
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr)
		return true;
	else
		return false;
}
//修改这个用户的新浪信息
function updateUserSina($uid,$sinaUid,$sinaNick){
	$sql_rr="update qiyu_user set user_sinauid='".$sinaUid."',user_sinanick='".$sinaNick."' where user_id=".$uid;
	mysql_query($sql_rr);
}
//修改喜欢
	function updateUserLike($uid,$temp_uid){
		$sql_rr="update qiyu_fav set fav_user=".$uid." where fav_user=".$temp_uid;
		mysql_query($sql_rr);
	}
//修改地址
function updateUserADDUser($uid,$temp_uid){
	$sql_rr="update qiyu_useraddr set useraddr_user=".$uid." where useraddr_user=".$temp_uid;
		mysql_query($sql_rr);
	
}
//删除临时账号
function deleteUserByID($uid){
	$sql_rr="delete from qiyu_user where user_id=".$uid;
	mysql_query($sql_rr);
}

function set_weibo($phone1,$sinaUid,$sinaNick,$QIYU_ID_USER,$password){
	
					$sql_select="select * from qiyu_user where user_phone='".$phone1."'";
					$rs_select=mysql_query($sql_select);
					$row_select=mysql_fetch_assoc($rs_select);
					if ($row_select){
						$sqls="select user_id from qiyu_user where user_password='".md5(md5($password.$row_select['user_salt']))."' and user_phone=".$phone1." and user_id=".$row_select['user_id'];
						$rss=mysql_query($sqls);
						$rows=mysql_fetch_assoc($rss);
						if(!$rows){
							return "E";
							exit;
						}
						
						//修改这个用户的新浪信息
						updateUserSina($row_select['user_id'],$sinaUid,$sinaNick);
						//修改喜欢
						updateUserLike($row_select['user_id'],$QIYU_ID_USER);
						//修改地址
						updateUserADDUser($row_select['user_id'],$QIYU_ID_USER);
						//删除临时账号
						deleteUserByID($QIYU_ID_USER);
						
						$QIYU_ID_USER=$row_select['user_id'];
						$_SESSION['qiyu_uid']=$QIYU_ID_USER;
					}else{
						
							$pw1=getRndCode_r(6);  //随即生成的密码
							$vercode=getRndCode(6);
							$pw=md5(md5($pw1.$vercode));
							//发送短信
							$content='感谢您使用<?php echo $SHOP_NAME?>网站，您今后登陆<?php echo $SHOP_NAME?>网站的帐号为您的手机号，登陆密码为'.$pw1.'. 可在网站个人中心页面修改您的密码。稍后您将收到订单进程的短信提醒。';
							$sql_update="update qiyu_user set user_phone='".$phone1."',user_salt='".$vercode."',user_password='".$pw."',user_account='".$phone1."' where user_id=".$QIYU_ID_USER;
							mysql_query($sql_update) or die('插入出错');
							sendCode($phone1,$content);
					}
						
					$_SESSION['qiyu_temporary']='';
					$_SESSION['sinaNick']='';
}
//得到用户的默认地址
function getDefaultAddress($uid){
	$address=array();
	$sql_rr="select * from qiyu_useraddr where useraddr_type='0' and useraddr_user=".$uid;
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr){
		if (empty($rows_rr['useraddr_totaladdr']))
			$address['address']=$rows_rr['useraddr_address'];
		else
			$address['address']=$rows_rr['useraddr_totaladdr'];
		$address['spot']=$rows_rr['useraddr_spot'];
		$address['id']=$rows_rr['useraddr_id'];
		$address['circle']=$rows_rr['useraddr_circle'];
		$address['area']=$rows_rr['useraddr_area'];
	}
	return $address;
		
}

//得到用户名跟电话
function getUser($uid){
	$userArray=array();
	$sql_rr="select * from qiyu_user where user_id=".$uid;
	$rs_rr = mysql_query($sql_rr);
	$row_rr=mysql_fetch_assoc($rs_rr);
	if ($row_rr){
		$userArray['user_name']=$row_rr['user_name'];
		$userArray['user_phone']=$row_rr['user_phone'];
	}
	return $userArray;
}
function getDefaultAddressByID($id){
	$address=array();
	$sql_rr="select * from qiyu_useraddr where useraddr_id=".$id;
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr){
		if (empty($rows_rr['useraddr_totaladdr']))
			$address['address']=$rows_rr['useraddr_address'];
		else
			$address['address']=$rows_rr['useraddr_totaladdr'];
		$address['spot']=$rows_rr['useraddr_spot'];
		$address['id']=$rows_rr['useraddr_id'];
		$address['name']=$rows_rr['useraddr_name'];
		$address['phone']=$rows_rr['useraddr_phone'];
	}
	return $address;
}

function commentPage($page,$pagecount){
	$temppage='';
	if($page==1)
				$temppage.="上一页";
			else
				$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".($page-1).")\">上一页</a>";
		
		If($pagecount<9){
			for($p=1;$p<=$pagecount;$p++){
				if($p!=$page)
					$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".$p.")\">".$p."</a>";
				else
					$temppage.=" <b> ".$p."</b>";
			}
		}else{
			if($page<=3){
				for($p=1;$p<=5;$p++){
					if($p!=$page)
						$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".$p.")\">".$p."</a>";
					else
						$temppage.=" <b> ".$p."</b>";
				}
				$temppage.=" <span class='active'>...</span>";
				for($p=$pagecount-3;$p<=$pagecount;$p++){
					if($p!=$page)
						$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".$p.")\">".$p."</a>";
					else
						$temppage.=" <b> ".$p."</b>";
				}
			}else if($pagecount-$page<=3){
				for($p=1;$p<=3;$p++){
					$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".$p.")\">".$p."</a>";
				}
				$temppage.=" <span class='active'>...</span>";
				for($p=$pagecount-4;$p<=$pagecount;$p++){
					if($p!=$page)
						$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".$p.")\">".$p."</a>";
					else
						$temppage.=" <span class='active'> ".$p."</span>";
				}
			}
			else{
				$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(1)\">1</a>";
				$temppage.=" <span class='active'>...</span>";
				for($p=$page-2;$p<=$page+2;$p++){
					if($p!=$page)
						$temppage.=" <a href='javascript:void();' onclick=\"getComPageData(".$p.")\">".$p."</a>";
					else
						$temppage.=" <b> ".$p."</b>";
				}
				$temppage.=" <span class='active'>...</span>";
				$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".$pagecount.")\">".$pagecount."</a>";
			}
		}
			if($page==$pagecount)
				$temppage.=" 下一页";
			else
				$temppage.=" <a href='javascript:void(0);' onclick=\"getComPageData(".($page+1).")\">下一页</a>";
		

		echo $temppage;
}

function indexPage($page,$pagecount){
	$temppage="";
		$temppage="<div id=\"page\" class=\"addressMore\" style='text-align:right;width:95%'>";

			if($page==1)
				$temppage.="<b class='gray_p'>上一页</b>";
			else
				$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".($page-1).")\">上一页</a>";
		
		If($pagecount<9){
			for($p=1;$p<=$pagecount;$p++){
				if($p!=$page)
					$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".$p.")\">".$p."</a>";
				else
					$temppage.="<b> ".$p."</b>";
			}
		}else{
			if($page<=3){
				for($p=1;$p<=5;$p++){
					if($p!=$page)
						$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".$p.")\">".$p."</a>";
					else
						$temppage.="<b> ".$p."</b>";
				}
				$temppage.="<span class='active'>...</span>";
				for($p=$pagecount-3;$p<=$pagecount;$p++){
					if($p!=$page)
						$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".$p.")\">".$p."</a>";
					else
						$temppage.="<b> ".$p."</b>";
				}
			}else if($pagecount-$page<=3){
				for($p=1;$p<=3;$p++){
					$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".$p.")\">".$p."</a>";
				}
				$temppage.="<span class='active'>...</span>";
				for($p=$pagecount-4;$p<=$pagecount;$p++){
					if($p!=$page)
						$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".$p.")\">".$p."</a>";
					else
						$temppage.="<span class='active'> ".$p."</span>";
				}
			}
			else{
				$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(1)\">1</a>";
				$temppage.="<span class='active'>...</span>";
				for($p=$page-2;$p<=$page+2;$p++){
					if($p!=$page)
						$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".$p.")\">".$p."</a>";
					else
						$temppage.="<b> ".$p."</b>";
				}
				$temppage.="<span class='active'>...</span>";
				$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".$pagecount.")\">".$pagecount."</a>";
			}
		}
			if($page==$pagecount)
				$temppage.="<b class='gray_p'>下一页</b>";
			else
				$temppage.="<a href='javascript:void(0);' onclick=\"getIndexPageData(".($page+1).")\">下一页</a>";
		

		$temppage.="</div>";

		

		return $temppage;
}

//根据分类下的商家数量
function getShopCountByClass($id,$spotID){
	$sql_rr="select count(shop_id) as c from qiyu_shop inner join qiyu_shopspot on shopspot_shop=shop_id inner join qiyu_shopbysort on shopbysort_shop=shop_id inner join qiyu_delivertime on delivertime_shop=shop_id and time(now())>=delivertime_starttime and time(now())<=delivertime_endtime and shopbysort_shopsort=".$id." and shopbysort_spot=".$spotID." and shopspot_spot=".$spotID." and shop_status='1'";
	$rs_rr=mysql_query($sql_rr);
	$row_rr=mysql_fetch_assoc($rs_rr);
	if ($row_rr)
		$shopCount=$row_rr['c'];
	else
		$shopCount=0;
	return $shopCount;
}
//根据id得到商家分类信息
function getShopSortByID($id){
	$sortArray=array();
	$sql_rr="select * from qiyu_shopsort where shopsort_id=".$id;
	$rs_rr = mysql_query($sql_rr);
	$row_rr=mysql_fetch_assoc($rs_rr);
	if ($row_rr){
		$sortArray['sort_name']=$row_rr['shopsort_name'];
	}
	return $sortArray;
	
}

//检查是否是送餐时间段
function checkDeliverTime($shopID){
			$sql1="select * from  qiyu_delivertime where time(now())>=delivertime_starttime and time(now())<=delivertime_endtime";
			$rs=mysql_query($sql1);
			$row=mysql_fetch_assoc($rs);
			if (!$row)
				return false;
			else
				return true;
}

//得到团购的数量

function getGroupCount($id){
	$sql_rr="select count(groupcount_id) as c from qiyu_groupcount where groupcount_group=".$id;
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr)
		return $rows_rr['c'];
	else
		return "0";
}

//添加团购的数量
function addGroupCount($group,$uid){
	$sql_rr="insert into qiyu_groupcount(groupcount_group,groupcount_user) values (".$group.",".$uid.")";
	mysql_query($sql_rr);
}
//根据名称、地标 商圈的到商家分类ID
function getClassIDByName($circleID,$spotID,$name){
	$sql_rr="select shopsort_id from qiyu_shopsort where shopsort_circle=".$circleID." and shopsort_spot=".$spotID." and shopsort_position='".$name."' order by shopsort_order asc,shopsort_id desc limit 1";
	$rs_rr=mysql_query($sql_rr);
	$rsCount_rr=mysql_num_rows($rs_rr);
	if ($rsCount_rr==0){
		$sql_rr="select shopsort_id from qiyu_shopsort where shopsort_circle=".$circleID." and shopsort_type='1' and shopsort_position='".$name."' order by shopsort_order asc,shopsort_id desc limit 1";
		$rs_rr=mysql_query($sql_rr);
	}
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr)
		return $rows_rr['shopsort_id'];
	else
		return false;
}

//检查栏目是否存在
function isHaveColumn($type,$circleID){
	$sql_rr="select circlecolumn_id from qiyu_circlecolumn where circlecolumn_circle=".$circleID." and circlecolumn_name='".$type."'";
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr){
		return true;
	}else
		return false;
}

//得到真实的商家购买数

function getRealBuyCount($shopID){
	$sql_rr="select count(order_id) as c from qiyu_order where order_shopid =".$shopID." and order_status='4'";
	$rs_rr=mysql_query($sql_rr);
	$rows_rr=mysql_fetch_assoc($rs_rr);
	if ($rows_rr)
		return $rows_rr['c'];
	else
		return "0";
}
//计算两个经纬度之间的距离
function rad($d)  
	{  
		return $d * 3.1415926535898 / 180.0;  
	}  
function GetDistance($lat1, $lng1, $lat2, $lng2)  
	{  
		$EARTH_RADIUS = 6378.137;  
		$radLat1 = rad($lat1);  
		//echo $radLat1;  
	   $radLat2 = rad($lat2);  
	   $a = $radLat1 - $radLat2;  
	   $b = rad($lng1) - rad($lng2);  
	   $s = 2 * asin(sqrt(pow(sin($a/2),2) +  
		cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));  
	   $s = $s *$EARTH_RADIUS;  
	   $s = round($s * 10000) / 10000;  
	   return $s;  
	} 

	//得到商家的所属商圈
	function getShopCircle($shopID){
		$sql_rr="select shopcircle_circle from qiyu_shopcircle where shopcircle_shop=".$shopID." limit 1";
		$rs_rr=mysql_query($sql_rr);
		$rows_rr=mysql_fetch_assoc($rs_rr);
		if ($rows_rr){
			return $rows_rr['shopcircle_circle'];
		}else
			return false;
	}


	//修改订单

	function updateOrderNum(){
		$sql="update qiyu_shop set shop_ordernum=shop_ordernum+1";
		mysql_query($sql);
	}

	//得到该商家的


	/*********** 后台*********************/

	function showPage_admin($url,$page,$pagesize,$rscount,$pagecount){
		$temppage="";
		$temppage= "<div class='page_admin'>&nbsp;&nbsp;&nbsp;&nbsp;当前页:".$page."/".$pagecount."页 每页 ".$pagesize." 条 共 ".$pagecount." 页 共 ".$rscount." 条记录 ";
		$temppage=$temppage. "<a href='".$url."'>首页</a> ";
		if(($page-1)>0){
		$temppage=$temppage. "<a href='".$url."?page=".($page-1)."'>上一页</a> ";
		}else{
			$temppage=$temppage. "上一页 ";
		}
		if(($page+1)<=$pagecount){
		$temppage=$temppage. "<a href='".$url."?page=".($page+1)."'>下一页</a> ";
		}else{
			$temppage=$temppage. "下一页 ";
		}
		$temppage=$temppage. "<a href='".$url."?page=".$pagecount."'>尾页</a>";
		$temppage=$temppage. "</div>";	
		
		if(!strpos($url,"?")===false)
				$temppage=str_replace("?page=","&page=",$temppage);
		return $temppage;
	}
	//得到订单的状态
	function getOrderKey($id){
		$sql_status="select order_status from qiyu_order where order_id=".$id;
		$rs_status=mysql_query($sql_status);
		$row_status=mysql_fetch_assoc($rs_status);
		if($row_status)
			return $row_status['order_status'];
		else
			return '';
	}
	//检查是否已催过餐
	function checkhurry($typechange,$order,$hurry){//催餐
		$sql="select * from qiyu_orderchange where roderchange_typechange='".$typechange."' and orderchange_order='".$order."' and orderchange_hurry='".$hurry."'";
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		if($row){
			return false;//不能向下执行
		}else{
			return true;//可以
		}
		
	}

	//拷贝文件夹

	function xCopy($source, $destination, $child){
			// xCopy("feiy","feiy2",1):拷贝feiy下的文件到 feiy2,包括子目录
			// xCopy("feiy","feiy2",0):拷贝feiy下的文件到 feiy2,不包括子目录

			if(!is_dir($source)){
			echo("Error:the $source is not a direction!");
			return 0;
			}
			if(!is_dir($destination)){
			mkdir($destination,0777);
			}
			$handle=dir($source);
			while($entry=$handle->read()) {
				if(($entry!=".")&&($entry!="..")){
					if(is_dir($source."/".$entry)){
						if($child)    xCopy($source."/".$entry,$destination."/".$entry,$child);
					}else{
						copy($source."/".$entry,$destination."/".$entry);
					}
				}
			}
			return true;
	}	
?>