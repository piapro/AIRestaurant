<?php
	/**
	 *  getstatus.php 动态获取订单状态
	 */
		header("Content-type: text/html; charset=utf-8");
		include("include/dbconn.php");
		//require_once("usercheck.php");
		$orderid=sqlReplace(trim($_GET['id']));
		$orderkey=sqlReplace(trim($_GET['key']));
		$url=empty($_GET['url'])?'':sqlReplace(trim($_GET['url']));

		$sql="select * from ".WIIDBPRE."_order where order_id=".$orderid;
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		//检查是否可以催餐
		$isHurry_30=false;
		$isHurry_45=false;
		$isHurry_60=false;
		$sql="select * from ".WIIDBPRE."_orderchange where orderchange_type='1' and orderchange_hurry='0' and orderchange_order='".$row['order_id2']."'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		if ($rows)
			$isHurry_30=true;
		$sql="select * from ".WIIDBPRE."_orderchange where orderchange_type='1' and orderchange_hurry='1' and orderchange_order='".$row['order_id2']."'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		if ($rows)
			$isHurry_45=true;
		$sql="select * from ".WIIDBPRE."_orderchange where orderchange_type='1' and orderchange_hurry='2' and orderchange_order='".$row['order_id2']."'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		if ($rows)
			$isHurry_60=true;
		$svalue='';
		$svalue2='';
		$svalue3='';
		if($row){
			/*
			$svalue.='<div id="orderState">';
			$svalue.='<img src="images/order/1_1.jpg" width="166" height="45" alt="" />';
			$svalue.='<img src="images/point.jpg" width="44" height="32" alt="" class="point"/>';
			if ($row['order_status']=='0' ||  $row['order_status']=='3'){
				$svalue.='<img src="images/order/2_0.jpg" width="202" height="45" alt="" />';
			}else{
				$svalue.='<img src="images/order/2_1.jpg"  alt="" />';
			}				
			$svalue.='<img src="images/point.jpg" width="44" height="32" alt="" class="point"/>';
			if ($row['order_status']=='5' || $row['order_status']=='4' ){
				$svalue.="<img src=\"images/order/3_1.jpg\" alt=\"\" class=\"no-margin\"/>";
			}else{
				$svalue.="<img src=\"images/order/3_0.jpg\" alt=\"\" class=\"no-margin\"/>";
			}
			$svalue.="<div class=\"clear\"></div>";
			$svalue.="</div>";
			if ($row['order_status']=='2' || $row['order_status']=='3'){
				$svalue.='<div class="point" style="margin-left:259px;"><img src="images/position.gif" alt="" /></div>';
				$svalue.='<div class="point" style="margin-left:250px;">订单已取消</div>';
			}*/
		}else{
			//
		} 
		
		//$svalue2.="<div class=\"centerBorder\"><img src=\"images/intro_bg.jpg\" alt=\"\" /></div>";
		$sql="select * from ".WIIDBPRE."_orderchange,qiyu_order where orderchange_order=order_id2 and order_id=".$orderid;
		$rs=mysql_query($sql);
		while ($rows=mysql_fetch_assoc($rs)){
			$svalue2.="<table border='0'>";
			$svalue2.="<tr>";
			$svalue2.="<td class='s_left' valign='top'>".substr($rows['orderchange_addtime'],11)."</td>";
			$svalue2.="<td class='s_right' valign='top'>".HTMLDecode($rows['orderchange_name'])."</td>";
			$svalue2.="</tr>";
			$svalue2.="</table>";
			$svalue2.="<table border='0'>";
			$svalue2.="	<tr>";
			$svalue2.="<td style='padding:0'><img src=\"images/line_719.jpg\"  alt=\"\" /></td>";
			$svalue2.="</tr>";
			$svalue2.="</table>";
			
		}
		
		
		
		if ($row['order_status']=="1"){
			$svalue3.="<p class='finishButton'><img src=\"images/button/finish.jpg\" onClick=\"orderFinish(".$orderid.")\" alt=\"\" class=\"finishButton\" style=\"cursor:pointer;\" /></p>";
		}
		 echo $svalue."||||||".$svalue2."||||||".$svalue3;
?>