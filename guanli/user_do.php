<?php 
	/**
	 *  shop_do.php  
	 */
	require_once("usercheck2.php");
	$act=sqlReplace(trim($_GET['act']));
	switch ($act){
		case "del":
			$id=sqlReplace(trim($_GET['id']));
			$id=checkData($id,"ID",0);
			$sql="select * from ".WIIDBPRE."_user where user_id=".$id;
			$result=mysql_query($sql);
			$row=mysql_fetch_assoc($result);
			if(!$row){
				alertInfo('您要删除的用户不存在','',1);
			}else{
				$sql2="delete from ".WIIDBPRE."_user where user_id=".$id;
				if(mysql_query($sql2)){
					alertInfo('删除成功','',1);
				}else{
					alertInfo('删除失败，原因SQL出现异常','',1);
				}
					
			}
		break;

		case "xxdel"://批量删除
			$idlist= $_POST['idlist'];
			if(!$idlist){
				alertInfo('请选择','userlist.php',0);
			}
            foreach ($idlist as $k=>$v){
				$sql="select * from ".WIIDBPRE."_user where user_id=".$v;				
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				if(!$v){
					alertInfo('您要删除的用户不存在','',1);
				}else{
					$sql2="delete from ".WIIDBPRE."_user where user_id=".$v;
					if(!mysql_query($sql2)){
						alertInfo('删除失败，原因SQL出现异常','',1);
					}
						
				}
			}
			alertInfo('删除成功','',1);
		break;


		
	}
	

	
?>