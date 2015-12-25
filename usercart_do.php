<?php 
	/**
	 *  usercart.php  购物车
	 */
	require_once("include/dbconn.php");
	require_once("usercheck.php");
	$act=sqlReplace(trim($_GET['act']));
	switch ($act){
		case "add":
			$url=empty($_SESSION['user_url'])?'':$_SESSION['user_url'];
			if (empty($url))
				$url="index.php";
			$shopID=sqlReplace(trim($_GET['id']));
			$foodID=sqlReplace(trim($_GET['foodID']));
			$lableID=empty($_GET['lableID'])?0:sqlReplace(trim($_GET['lableID']));
			$ftID=empty($_GET['ftID'])?0:sqlReplace(trim($_GET['ftID']));  //菜的大类id
			$sql1="select shop_id from qiyu_shop inner join qiyu_shopspot on shopspot_shop=shop_id";
			$sql1.=" inner join qiyu_delivertime on delivertime_shop=shop_id and time(now())>=delivertime_starttime and time(now())<=delivertime_endtime";
			$sql1.=" and shop_id=".$shopID." and shop_status='1'";
			$rs=mysql_query($sql1);
			$row=mysql_fetch_assoc($rs);
			if (!$row) alertInfo('现在不能点餐','',1);
			addcart($foodID,$shopID);
			Header("Location: ".$url." ");
		break;
		case "del":
			$id=sqlReplace(trim($_GET['id']));
			$shopID=sqlReplace(trim($_GET['shopID']));
			delcart($id,$shopID); //删除购物车
			alertInfo('删除成功','',1);
		break;
	}
	

	
?>