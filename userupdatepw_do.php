<?php 

			require_once("usercheck2.php");
			$pw=sqlReplace(trim($_POST['pw']));
			$newpw=sqlReplace(trim($_POST['newpw']));
			$repw=sqlReplace(trim($_POST['repw']));
			checkData($pw,'原密码',1);
			checkData($newpw,'新密码',1);
			if($newpw!=$repw){
				alertInfo("两次密码不一致","",1);
			}
			
			$check_sql = "select user_password,user_salt from ".WIIDBPRE."_user where user_id=".$QIYU_ID_USER;
			$check_rs = mysql_query($check_sql);
			$check_row = mysql_fetch_assoc($check_rs);
			if(!$check_row){
				alertInfo('非法用户','',1);
			}else{
				$oldpw=md5(md5($pw.$check_row['user_salt']));
				if($oldpw!=$check_row['user_password']){
					alertInfo('原密码输入不正确','',1);
				}else{
					$upd_sql = "update ".WIIDBPRE."_user set user_password='".md5(md5($newpw.$check_row['user_salt']))."' where user_id=".$QIYU_ID_USER;
					if(mysql_query($upd_sql)){
						alertInfo('修改成功','usercenter.php',0);
					}else{
						alertInfo('修改失败','',1);
					}
				}
				
			}
?>