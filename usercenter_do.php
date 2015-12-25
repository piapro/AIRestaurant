<?php 
	/**
	 *  usercenter_do.php
	 */
	require_once("usercheck2.php");
	$act=sqlReplace(trim($_GET['act']));
	switch ($act){
		case "delOrder":
			$url=$_SESSION['order_url'];
			$tab=sqlReplace(trim($_GET['tab']));
			$id=sqlReplace(trim($_GET['id']));
			$sql="delete from qiyu_order where order_id=".$id." and order_user=".$QIYU_ID_USER;
			mysql_query($sql);
			alertInfo('删除成功',$url,0);
		break;
		case "addaddress":
		//	$url=$_SESSION['order_url'];
			//$tab=sqlReplace(trim($_GET['tab']));
			$name = sqlReplace($_POST['name']);
			
			$phone = sqlReplace($_POST['phone']);
			$address = sqlReplace($_POST['address']);
			checkData($phone,'手机号',1);
			checkData($name,'用户姓名',1);
			
			checkData($address,'详细地址',1);
			$sql="insert into qiyu_useraddr(useraddr_user,useraddr_phone,useraddr_name,useraddr_address,useraddr_type) values (".$QIYU_ID_USER.",'".$phone."','".$name."','".$address."','1')";
			if(mysql_query($sql))
				echo '添加成功';
			else 
				echo '添加失败';
		break;
		case "deladdress":
	
			$id=sqlReplace(trim($_GET['id']));
			$sql="select * from qiyu_useraddr where useraddr_id=".$id;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$sqlStr="delete from qiyu_useraddr where useraddr_id=".$id;
				mysql_query($sqlStr);
				echo '删除成功';
			}else{
				echo '删除失败,无此地址';
			}
		break;
		case "setaddress":
			$id=sqlReplace(trim($_GET['id']));
			$sql="select * from qiyu_useraddr where useraddr_id=".$id." and useraddr_user=".$QIYU_ID_USER;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$sqlStr="update qiyu_useraddr set useraddr_type='1' where useraddr_user=".$QIYU_ID_USER." and useraddr_type='0'";
				mysql_query($sqlStr);
				$sqlStr="update qiyu_useraddr set useraddr_type='0' where useraddr_id=".$id." and useraddr_user=".$QIYU_ID_USER;
				mysql_query($sqlStr);
				echo '设置成功';
			}else{
				echo '设置失败,无此地址';
			}
		break;
		case "scoreAdd":
	
			$id=sqlReplace(trim($_GET['id']));
			$total=sqlReplace(trim($_POST['total']));
			$test=sqlReplace(trim($_POST['test']));
			$speed=sqlReplace(trim($_POST['speed']));
			$sql="select shop_id,order_id2 from qiyu_order,qiyu_shop where (shop_id2=order_shop or shop_id=order_shopid) and order_id=".$id;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$sqlStr="insert into qiyu_userscore(userscore_shop,userscore_user,userscore_total,userscore_test,userscore_speed,userscore_order,userscore_addtime) values (".$rows['shop_id'].",".$QIYU_ID_USER.",".$total.",".$test.",".$speed.",'".$rows['order_id2']."',now())";
				if (mysql_query($sqlStr)){
					
					
					Header("Location: userorderscore2.php?id=".$id);
				}else{
					alertInfo('意外出错','',1);
				}
			}else{
				alertInfo('非法','usercenter.php?tab=5',0);
			}
		break;

		case "updateusername"://修改用户姓名
			$user_name=sqlReplace(trim($_POST['user_name']));
			$sql="select * from qiyu_user where user_id=".$QIYU_ID_USER;
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$sqlStr="update qiyu_user set user_name='".$user_name."' where user_id=".$QIYU_ID_USER;
				mysql_query($sqlStr);
				echo '保存成功';
			}else{
				echo '保存失败';
			}
		break;
		
	}
	

	
?>