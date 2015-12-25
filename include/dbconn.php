<?php
/**
 * 数据库连接
 */
	
	define('PATH', str_replace('\\', '/', substr(__FILE__, 0, -10)));  //往前文件所在的文件夹 E:/ljx/p/php/wiibbs/include/
	define('ROOT_PATH', str_replace('include/', '', PATH));  //根目录 E:/ljx/p/php/wiibbs/
	
	if (!file_exists(ROOT_PATH."include/configue.php")){
		header("location: install/index.php");
		exit();
	}else{
		if(file_exists(ROOT_PATH."install"))
			rename(ROOT_PATH."install",ROOT_PATH."__".md5("install".rand(100,999)));
	} 

	if (file_exists(ROOT_PATH."install")){
		echo "请重命名install文件夹";
	}
	if (file_exists(ROOT_PATH."admin")){
		echo "请重命名admin文件夹";
	}

	require_once('configue_con.php');
	require_once('configue.php');
	require_once('function_common.php');
	require_once(ROOT_PATH.'api/wiiyun/wiiyun.class.php'); 
	require_once(ROOT_PATH.'api/print.class.php'); 

	$db_connect=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
	if (!$db_connect){
		die ('数据库连接失败');
	}
	mysql_select_db(WIIDBNAME, $db_connect) or die ("没有找到数据库。");
	mysql_query("set names utf8;");

	$sql="select * from ".WIIDBPRE."_site";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$logo=$rows['site_logo'];
		$site_icp=$rows['site_icp'];
		$site_wiiyunsalt=$rows['site_wiiyunsalt'];
		$site_wiiyunaccount=$rows['site_wiiyunaccount'];
		$site_protocol=$rows['site_protocol'];
		$site_isshowprotocol=$rows['site_isshowprotocol'];
		$site_isshowcomment=$rows['site_isshowcomment'];
		$site_isshowadminindex=$rows['site_isshowadminindex'];
		$site_isshowcard=$rows['site_isshowcard'];
		$site_sms=$rows['site_sms'];
		$site_tmp=$rows['site_tmp'];
		$site_onlinechat=$rows['site_onlinechat'];
		$icon=$rows['site_icon'];
		if(empty($icon)){
			$imgstr2='images/icon_default.png';
		}else{
			$imgstr2=$icon;
		}
		$site_stat=$rows['site_stat'];
		$site_iscartfoodtag=$rows['site_iscartfoodtag'];
		$site_cartfoodtag=$rows['site_cartfoodtag'];
		$site_yunprint=$rows['site_yunprint'];
		$site_yunprintnum=$rows['site_yunprintnum'];
		$tag=explode(";",$rows['site_cartfoodtag']);
	}

	$sql="select * from ".WIIDBPRE."_shop";
	$rs=mysql_query($sql);
	$rows=mysql_fetch_assoc($rs);
	if ($rows){
		$SHOP_NAME=$rows['shop_name'];
		$SHOP_PHONE=$rows['shop_phone'];
		$SHOP_TEL=$rows['shop_tel'];
		$SHOP_CERTPIC=$rows['shop_certpic'];
		$SHOP_LICENSEPIC=$rows['shop_licensepic'];
		$SHOP_OPENSTARTTIME=$rows['shop_openstarttime'];
		$SHOP_OPENENDTIME=$rows['shop_openendtime'];
		$SHOP_MAINFOOD=$rows['shop_mainfood'];
		$SHOP_ADDRESS=$rows['shop_address'];
		$SHOP_ORDERNUM=$rows['shop_ordernum'];
		
	}
   

    define("expUserConsume","10");//消费经验值
	define("expUserComment","5");//评论经验值
	define("expUserLogin","2");//登录经验值
?>