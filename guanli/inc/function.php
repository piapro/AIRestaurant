<?php

    //生成随机数
	//随机数函数

	function volemail_random($length) {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789abcdefghijkmnpqrstuvwxyz';
		$max = strlen($chars) - 1;
		$salt='';
		mt_srand((double)microtime() * 1000000);
		for($i = 0; $i < $length; $i++) {
			$salt.= $chars[mt_rand(0, $max)];
		}
		/*
		$sql="select sendlog_id from qiyu_sendlog where sendlog_salt='".$salt."'";
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		if($row){
			$salt=volemail_random(4);
		}
        */
		return $salt;
	}

    function getLastWiiyunAccount(){
		$sql="select site_wiiyunsalt,site_wiiyunaccount from qiyu_site  limit 1";
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		if($row){
			return $row;
		}else{
			return '';
		}
	}

	//根据用户id 获取用户手机信息
	function getUserMoblieInfo($uid){
		$sql="select user_mobile,user_name from qiyu_user where user_id=".$uid;
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		return $row;
	}

   //个人根据用户id，订单id获取该用户的消费总额
  function getScore($oid){
		$sql="select sum(order_totalprice) as t from qiyu_order where order_status =4 and order_id =".$oid;
		$rs = mysql_query($sql) or die ("查询失败，请检查SQL语句。");
		$row=mysql_fetch_assoc($rs);
		if($rs){
			$score=$row['t'];		
		}else{
			echo '';
		}
		return $score;
  } 

  //个人根据用户id，订单id获取该用户的消费总额
  function getUserInfo($oid){
		$sql="select sum(order_totalprice) as t from qiyu_order where order_status =4 and order_id =".$oid;
		$rs = mysql_query($sql) or die ("查询失败，请检查SQL语句。");
		$row=mysql_fetch_assoc($rs);
		return $row;	
  } 

  //取出订单完成的订单id
	function getOrderId(){
		 $sql="select order_id, order_id2, order_status FROM qiyu_order WHERE order_status =4";//选出订单完成的订单order_id
		   //根据order_id取出 food_name，然后count，排序
		 $rs=mysql_query($sql);
		 $rows=mysql_fetch_assoc($rs);
		 if($rows){
			 return $rows['order_id'];	    
		 }else{
			 return false;
		 }
	}

	//取出订单完成的订单号码
	function getOrderId2(){
		 $sql="select order_id, order_id2, order_status FROM qiyu_order WHERE order_status =4";//选出订单完成的订单order_id
		   //根据order_id取出 food_name，然后count，排序
		 $rs=mysql_query($sql);
		 $rows=mysql_fetch_assoc($rs);
		 if($rows){
			 return $rows['order_id2'];	    
		 }else{
			 return false;
		 }
	}


    //根据完成订单的订单号，取出所订食物名称
	function getFoodName($oid){
		$sql="select cart_food, cart_order, cart_status, food_name from qiyu_cart, qiyu_food where food_id = cart_food and cart_order =".$oid."  and cart_status = '1'";
		 $rs=mysql_query($sql);
		 $rows=mysql_fetch_assoc($rs);
		 if($rows){
			 return $rows['food_name'];	    
		 }else{
			 return false;
		 }

	}


?>