<?php
	/**
	 * shop_ajax.php 
	 */
	require_once("usercheck2.php");

	$str='';
	$act=$_POST['act'];
	switch ($act){
		case "delSpot":
			$spot_id=sqlReplace(trim($_POST['spotid']));
			$sql="delete from qiyu_shopspot where shopspot_id=".$spot_id;
			mysql_query($sql);
			$sql="select spot_id,spot_name,shopspot_id from qiyu_shopspot inner join qiyu_spot where spot_id=shopspot_spot and shopspot_shop=".$QIYU_ID_SHOP;
			$rs=mysql_query($sql);
			while ($rows=mysql_fetch_assoc($rs)){
				$str.= "<li>". $rows['spot_name']."<a href=\"javascript:void();\" onClick=\"delShopSpot(".$rows['shopspot_id'].")\"><img src=\"../images/del_spot.gif\" alt=\"\" /></a></li>";

			}
		break;
		case "delTime":
			$time_id=sqlReplace(trim($_POST['timeid']));
			$sql="delete from qiyu_delivertime where delivertime_id=".$time_id;
			mysql_query($sql);
			$sql="select * from qiyu_delivertime where delivertime_shop=".$QIYU_ID_SHOP;
			$rs=mysql_query($sql);
			while ($rows=mysql_fetch_assoc($rs)){
				$str.= "<p>".$rows['delivertime_name']."：".substr($rows['delivertime_starttime'],0,5)." - ".substr($rows['delivertime_endtime'],0,5)."<a href=\"javascript:void();\" onClick=\"delShopTime(".$rows['delivertime_id'].")\">	<img src=\"../images/del_spot.gif\" alt=\"\" /></a></p>";

			}
		break;
		case "delStyle":
			$style_id=sqlReplace(trim($_POST['styleid']));
			$sql="delete from qiyu_shopstyle where shopstyle_id=".$style_id;
			mysql_query($sql);
			$sql="select style_id,style_name,shopstyle_id from qiyu_shopstyle inner join qiyu_style where style_id=shopstyle_style and shopstyle_shop=".$QIYU_ID_SHOP;
			$rs=mysql_query($sql);
			while ($rows=mysql_fetch_assoc($rs)){
				$str.= "<li>".$rows['style_name']."<a href=\"javascript:void();\" onClick=\"delShopStyle(".$rows['shopstyle_id'].")\">	<img src=\"../images/del_spot.gif\" alt=\"\" /></a></li>";

			}
		break;
		case "getSpot":
			$tagId=sqlReplace(trim($_POST['tagId']));
			$sql="select * from qiyu_tag where tag_id=".$tagId;
			$result=mysql_query($sql);
			$row=mysql_fetch_assoc($result);
			if ($row){
				if ($row['tag_isspot']=="1"){
					$str.="选择标签：<select name='spot'>";
					
					$sql1="select * from qiyu_spot order by spot_order asc,spot_id desc";
					$rs=mysql_query($sql1);
					while ($rows=mysql_fetch_assoc($rs)){
						$str.="<option value='".$rows['spot_id']."'>".$rows['spot_name']."</option>";
					}
					$str.="</select>";
				}
			}
		break;
		case "browse":
			$id=sqlReplace(trim($_POST['id']));
			$name=sqlReplace(trim($_POST['name']));
			$price1=sqlReplace(trim($_POST['price1']));
			$price2=sqlReplace(trim($_POST['price2']));
			$pic=sqlReplace(trim($_POST['pic']));
			$sql="update qiyu_food set food_name='".$name."',food_pic='".$pic."',food_price=".$price2.",food_oldprice=".$price1.",food_check='1' where food_id=".$id;
			if (mysql_query($sql))
				$str="S";
			else
				$str="E";
		break;
		case "addOrderIntro":
			$id=sqlReplace(trim($_POST['id']));
			$intro=HTMLEncode($_POST['content']);
			$sql="select * from qiyu_order where order_id=".$id;
			$rs=mysql_query($sql);
			$row=mysql_fetch_assoc($rs);
			if ($row){
				$order=$row['order_id2'];
				$sql="update qiyu_order set order_infor='".$intro."',order_status='6' where order_id=".$id;
				mysql_query($sql);
				//添加订单记录
				addOrderType($order,'你的订单被修改，修改内容为：'.$intro);
				$str="S";
			}
		break;
		case "addOrderText":
			$id=sqlReplace(trim($_POST['id']));
			$intro=HTMLEncode($_POST['content']);
			$sql="select * from qiyu_order where order_id=".$id;
			$rs=mysql_query($sql);
			$row=mysql_fetch_assoc($rs);
			if ($row){
				$order=$row['order_id2'];
				$sql="update qiyu_order set order_text='".$intro."',order_status='6' where order_id=".$id;
				mysql_query($sql);
				//添加订单记录
				//addOrderType($order,'你的订单被修改，修改内容为：'.$intro);
				$str="S";
			}
		break;
		case "excel":
			require_once 'excel_writer/Writer.php';
			$workbook = new Spreadsheet_Excel_Writer('shopexcel/shop'.$QIYU_ID_SHOP.'.xls');
			$workbook->setVersion(8);
			$worksheet =& $workbook->addWorksheet('sheet1');
			$worksheet->setInputEncoding('utf-8');
			$worksheet->write(0, 0, '日期');
			$worksheet->write(0, 1, '订单数量');
			$worksheet->write(0, 2, '订单总额');
			$worksheet->write(0, 3, '收入现金');
			$worksheet->write(0, 4, '收入饭点');
			$worksheet->write(0, 5, '支出饭点');
			$worksheet->write(0, 6, '饭点结算');
			$where='';
			$orderCountTotal=0;
			$orderALLTotal=0;
			$orderMoneyTotal=0;
			$getvalueTotal=0;
			$spendvalueTotal=0;
			$scoreTotal=0;

			$type=sqlReplace(trim($_POST['type']));
			$start=sqlReplace(trim($_POST['start']));
			$end=sqlReplace(trim($_POST['end']));
			if ($type=='1'){
				if (!(empty($start) || empty($end)))
					$where.=" and date(order_addtime) >= '".$start."' and date(order_addtime) <= '".$end."'";
				elseif (!empty($start) && empty($end))
					$where.=" and date(order_addtime) >= '".$start."'";
				elseif (empty($start) && !empty($end))
					$where.=" and date(order_addtime) <= '".$end."'";
			}
			$sql="select count(order_id) as cOrder,sum(order_totalprice) as total,order_addtime  from qiyu_order where order_shop='".$SHOP_ID2."' ".$where." group by date(order_addtime) order by order_id desc";
			$rs=mysql_query($sql);
			$i=1;
			while ($rows=mysql_fetch_assoc($rs)){
				$orderCountTotal+=$rows['cOrder'];
				$orderALLTotal+=$rows['total'];
				$sqlStr="select sum(rscore_spendvalue) as s,sum(rscore_getvalue) as g from qiyu_rscore where rscore_shop='".$SHOP_ID2."'  and DATEDIFF('".$rows['order_addtime']."',rscore_addtime)=0";
				$rs_r=mysql_query($sqlStr);
				$row=mysql_fetch_assoc($rs_r);
				if ($row){
					$spendvalue=$row['s'];
					$getvalue=$row['g'];
				}else{
					$spendvalue=0;
					$getvalue=0;
				}
										
				$subtractScore=$getvalue-$spendvalue;
				$moeny=$rows['total']-$spendvalue;
				$scoreTotal+=$subtractScore;
				$orderMoneyTotal+=$moeny;
				$getvalueTotal+=$getvalue;
				$spendvalueTotal+=$spendvalue;

				$worksheet->write($i, 0, substr($rows['order_addtime'],0,10));
				$worksheet->write($i, 1, $rows['cOrder']);
				$worksheet->write($i, 2, $rows['total']);
				$worksheet->write($i, 3, $moeny);
				$worksheet->write($i, 4, $getvalue);
				$worksheet->write($i, 5, $spendvalue);
				$worksheet->write($i, 6, $subtractScore);
				$i+=1;

			}
			$worksheet->write($i, 0, '总计');
			$worksheet->write($i, 1, $orderCountTotal);
			$worksheet->write($i, 2, $orderALLTotal);
			$worksheet->write($i, 3, $orderMoneyTotal);
			$worksheet->write($i, 4, $getvalueTotal);
			$worksheet->write($i, 5, $spendvalueTotal);
			$worksheet->write($i, 6, $scoreTotal);
			$workbook->close();
			$str= "S";

		break;


		case "excelOrder":
			require_once 'excel_writer/Writer.php';
			$workbook = new Spreadsheet_Excel_Writer('shopexcel/shopOrder'.$QIYU_ID_SHOP.'.xls');
			$workbook->setVersion(8);
			$worksheet =& $workbook->addWorksheet('sheet1');
			$worksheet->setInputEncoding('utf-8');
			$worksheet->write(0, 0, '序号');
			$worksheet->write(0, 1, '订单时间');
			$worksheet->write(0, 2, '订单号');
			$worksheet->write(0, 3, '用户名');
			$worksheet->write(0, 4, '订单详情');
			$worksheet->write(0, 5, '送餐费');
			$worksheet->write(0, 6, '订单总额');
			$worksheet->write(0, 7, '现金支付');
			$worksheet->write(0, 8, '饭点支付');
			$worksheet->write(0, 9, '订单返点');
			$where='';
			$orderDeliverTotal=0;
			$orderALLTotal1=0;
			$orderMoneyTotal1=0;
			$getvalueTotal1=0;
			$spendvalueTotal1=0;

			$type=sqlReplace(trim($_POST['type']));
			$start=sqlReplace(trim($_POST['start']));
			$end=sqlReplace(trim($_POST['end']));
			if ($type=='1'){
				if (!(empty($start) || empty($end)))
					$where.=" and date(order_addtime) >= '".$start."' and date(order_addtime) <= '".$end."'";
				elseif (!empty($start) && empty($end))
					$where.=" and date(order_addtime) >= '".$start."'";
				elseif (empty($start) && !empty($end))
					$where.=" and date(order_addtime) <= '".$end."'";
			}
			$sql="select *  from qiyu_order inner join qiyu_useraddr on useraddr_id=order_useraddr and order_shop='".$SHOP_ID2."' ".$where." order by order_id desc";
			$rs=mysql_query($sql);
			$i=1;
			while ($rows=mysql_fetch_assoc($rs)){
				$orderDeliverTotal+=$rows['order_deliverprice'];
				$orderALLTotal1+=$rows['order_totalprice'];
										

				$sqlStr="select * from qiyu_rscore where rscore_shop='".$SHOP_ID2."'  and rscore_order='".$rows['order_id2']."'";
				$rs_r=mysql_query($sqlStr);
				$row=mysql_fetch_assoc($rs_r);
				if ($row){
					$spendvalue=$row['rscore_spendvalue'];
					$getvalue=$row['rscore_getvalue'];
				}else{
					$spendvalue=0;
					$getvalue=0;
				}
										
				$moeny=$rows['order_totalprice']-$spendvalue;
				$orderMoneyTotal1+=$moeny;
				$getvalueTotal1+=$getvalue;
				$spendvalueTotal1+=$spendvalue;

				$cartCount=0;
				$cartAll=0;
				$str='';
				$sql_cart="select * from qiyu_cart inner join qiyu_food on food_id=cart_food and cart_status='1' and cart_order='".$rows['order_id2']."' and cart_shop='".$SHOP_ID2."'";	
				$rs_cart=mysql_query($sql_cart);
				while ($rows_cart=mysql_fetch_assoc($rs_cart)){
					$cartCount+=1;
					$cartAll+=$rows_cart['cart_count']*$rows_cart['cart_price'];
					$str.= $rows_cart['food_name']." ".$rows_cart['cart_count']."*".$rows_cart['cart_price']."\r\n";
				}
				if ($cartCount>0) $str.= "总额:".$cartAll;

				$worksheet->write($i, 0, $rows['order_id']);
				$worksheet->write($i, 1, $rows['order_addtime']);
				$worksheet->write($i, 2, $rows['order_id2']);
				$worksheet->write($i, 3, $rows['useraddr_name']);
				$worksheet->write($i, 4, $str);
				$worksheet->write($i, 5, $rows['order_deliverprice']);
				$worksheet->write($i, 6, $rows['order_totalprice']);
				$worksheet->write($i, 7, $moeny);
				$worksheet->write($i, 8, $spendvalue);
				$worksheet->write($i, 9, $getvalue);
				$i+=1;

			}
			$worksheet->write($i, 0, '总计');
			$worksheet->write($i, 1, '');
			$worksheet->write($i, 2, '');
			$worksheet->write($i, 3, '');
			$worksheet->write($i, 4, '');
			$worksheet->write($i, 5, $orderDeliverTotal);
			$worksheet->write($i, 6, $orderALLTotal1);
			$worksheet->write($i, 7, $orderMoneyTotal1);
			$worksheet->write($i, 8, $spendvalueTotal1);
			$worksheet->write($i, 9, $getvalueTotal1);
			$workbook->close();
			$str= "S";

		break;
		case "sendcode":
			$phone=sqlReplace(trim($_POST['phone']));
			$vercodePhone=getRndCode_r(6);
			$content="验证码是".$vercodePhone;
			$sql="update qiyu_shop set shop_code='".$vercodePhone."' where shop_id=".$QIYU_ID_SHOP;
			if (mysql_query($sql)){
				//发送验证码
				sendCode($phone,$content);
				$str="S";
			}else
				$str="E";
		break;

	}
	
	
	echo $str;	
?>