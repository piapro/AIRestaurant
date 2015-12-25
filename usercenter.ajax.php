<?php
	/**
	 *  userorder.ajax.php  修改默认地址 修改电话  添加新地址
	 */
	require_once("usercheck2.php");
	$act=sqlReplace(trim($_POST['act']));
	switch ($act){
		case "getAddress": //修改默认地址
			
			$id=sqlReplace(trim($_POST['id']));
			$sql="select * from qiyu_useraddr where useraddr_id=".$id;
			$rs=mysql_query($sql);
			while ($rows=mysql_fetch_assoc($rs)){
				$phone=$rows['useraddr_phone'];
				$name=$rows['useraddr_name'];
				
				$address=$rows['useraddr_address'];
			}
			echo "<tr id='update'".$id." class='addtr'><td colspan='5' class='borderBottom borderRight borderLeft' style='padding:10px;'>";
			echo "<script src='js/userreg.js' type='text/javascript'></script>";
			echo "<p style='margin-top:10px;'>您的手机号：</label><input type=\"text\" id=\"phone_r\" name=\"phone\" class=\"input\" value='".$phone."'/ onblur='checkphone();' ><span id='spanphone' style='color:red;'></span></p>";
			echo "<p style='margin-top:10px;'>您的姓名：</label><input type=\"text\" id=\"name_r\" name=\"name\" class=\"input\" value='".$name."' onblur='checkname();' /><span id='spanname' style='color:red;'></span></p>";
			
			echo "<p style='margin-top:10px;'>您的详细地址：</label><input type=\"text\" id=\"address_r\" name=\"address\" class=\"input\" value='".$address."' onblur='checkaddr();' /><span id='spanaddr' style='color:red;'></span></p>";
			echo "<p style='margin-top:10px;'><a href=\"javascript:void();\" onClick=\"submitAddress(".$id.")\"><img src=\"images/button/edit.gif\" alt=\"修改\" /></a></p>";
			echo "</td></tr>";
			
		break;
		case "updateAddress";
			$id=sqlReplace(trim($_POST['id']));
			
			$name=sqlReplace(trim($_POST['name']));
			$phone=sqlReplace(trim($_POST['phone']));
			$address=sqlReplace(trim($_POST['address']));
			$sql="update qiyu_useraddr set useraddr_phone='".$phone."',useraddr_name='".$name."',useraddr_address='".$address."' where useraddr_id=".$id." and useraddr_user=".$QIYU_ID_USER;
			if (mysql_query($sql))
				echo "S";
			else
				echo "E";
		break;
		
		
		case "updatePW":
			$old=sqlReplace(trim($_POST['old']));
			$pw1=sqlReplace(trim($_POST['pw1']));
			$pw2=sqlReplace(trim($_POST['pw2']));
			if (empty($old)){
				echo "OLD";
				exit;
			}
			if (empty($pw1)){
				echo "PW1";
				exit;
			}
			if (empty($pw2)){
				echo "PW2";
				exit;
			}
			if ($pw1!=$pw2){
				echo "N";
				exit;
			}
			$sql="select user_id from qiyu_user where user_id=".$QIYU_ID_USER." and user_password='".md5(md5($old.$USER_SALT))."'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if(!$rows){
				echo "PW_E";
			}else{
				$sqlStr="update qiyu_user set user_password='".md5(md5($pw1.$USER_SALT))."' where user_id=".$QIYU_ID_USER;
				if (mysql_query($sqlStr)){
					setcookie("QIYUUSER","",time()+60*60*24*7);
					setcookie("QIYUVERD","",time()+60*60*24*7);
					session_unset();
					session_destroy();
					echo "S";
				}else{
					echo "E";
				}
			}
		break;
		
	}
	

?>
