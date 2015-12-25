<?php
	//根据订单状态统计数量
	function getOrderCountByState($state){
		$sql="select count(1) as c from qiyu_order where order_status='".$state."'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		return $rows['c'];
	}

	//根据新订单数量(预约订单除外)
	function getOrderNewCountByState($state){
		$sql="select count(1) as c from qiyu_order where order_type!='1' and order_status='".$state."'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		return $rows['c'];
	}
	//得到催餐订单状态统计数量
	function getChargeCount(){
		$sql="select count(1) as c from qiyu_order,qiyu_orderchange where orderchange_order=order_id2 and orderchange_type='1' and order_status='5'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		return $rows['c'];
	}
	//得到预约订单状态统计数量
	function getSubscribeCount(){
		$time1=date('Y-m-d',time());
		$time2=date('H:i',time());
		$sql="select count(1) as c from qiyu_order where order_type='1' and order_status='0'";
		$rs=mysql_query($sql);
		$rows=mysql_fetch_assoc($rs);
		return $rows['c'];
	}
?>