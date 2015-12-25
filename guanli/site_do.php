<?php 
	/**
	 *  shop_do.php  
	 */
	 
	require_once("usercheck2.php");
	$act=sqlReplace(trim($_GET['act']));
	switch ($act){
		case "base":
			$comment_status=sqlReplace(trim($_POST['comment_status']));//评论是否显示
			$protocol_status=sqlReplace(trim($_POST['protocol_status']));//证书协议是否显示
			$logo=sqlReplace(trim($_POST['upfile1']));
			$icon=sqlReplace(trim($_POST['upfile2']));
			$icp=sqlReplace(trim($_POST['icp']));
			$admin=sqlReplace(trim($_POST['admin']));
			$card=sqlReplace(trim($_POST['card']));
			$intro=$_POST['intro'];
			$intro=str_replace("'","&#39;",$intro);
			$intro=str_replace("<br />","</p><p>",$intro);
			$sql="update qiyu_site set site_logo='".$logo."',site_icon='".$icon."',site_icp='".$icp."',site_isshowcomment='".$comment_status."',site_isshowprotocol='".$protocol_status."',site_isshowadminindex='".$admin."',site_protocol='".$intro."',site_isshowcard='".$card."'";
			if (mysql_query($sql)){
				//echo 'ok';
				alertInfo('操作成功','',1);
			}else{

				//echo 'fail';
				alertInfo('出错','',1);

			}
		break;
		case "tmp":
			$tmp=sqlReplace(trim($_POST['tmp']));
			
			//更新相应的模板
			$from_dir="template/".$tmp;
			$to_dir="../";
			if(!xCopy($from_dir,$to_dir,1)){
				alertInfo('更新文件失败','',1);
			}else{
				$sql="update qiyu_site set site_tmp=".$tmp."";
				if (mysql_query($sql)){
					alertInfo('操作成功','',1);
				}else{
					alertInfo('出错','',1);
				}
			}
					
		break;
        case "other":				
			$onlinechat=sqlReplace(trim($_POST['onlinechat']));
			$iscartfoodtag=sqlReplace(trim($_POST['iscartfoodtag']));
			$cartfoodtag=sqlReplace(trim($_POST['cartfoodtag']));
			$stat=sqlReplace(trim($_POST['stat']));
			$sql="update qiyu_site set site_onlinechat='".$onlinechat."',site_stat='".$stat."',site_iscartfoodtag='".$iscartfoodtag."',site_cartfoodtag='".$cartfoodtag."'";
			if (mysql_query($sql)){
				alertInfo('操作成功','',1);
			}else{
				alertInfo('出错','',1);
			}
		break;

		case "print":				
			$print=sqlReplace(trim($_POST['yunprint']));
			$num=sqlReplace(trim($_POST['yunprintnum']));
			$sql="update qiyu_site set site_yunprint='".$print."',site_yunprintnum='".$num."'";
			if (mysql_query($sql)){
				alertInfo('操作成功','',1);
			}else{
				alertInfo('出错','',1);
			}
		break;


        case "other":				
			$onlinechat=sqlReplace(trim($_POST['onlinechat']));
			$iscartfoodtag=sqlReplace(trim($_POST['iscartfoodtag']));
			$cartfoodtag=sqlReplace(trim($_POST['cartfoodtag']));
			$stat=sqlReplace(trim($_POST['stat']));
			$sql="update qiyu_site set site_onlinechat='".$onlinechat."',site_stat='".$stat."',site_iscartfoodtag='".$iscartfoodtag."',site_cartfoodtag='".$cartfoodtag."'";
			if (mysql_query($sql)){
				alertInfo('操作成功','',1);
			}else{
				alertInfo('出错','',1);
			}
		break;

		case "print":				
			$print=sqlReplace(trim($_POST['yunprint']));
			$sql="update qiyu_site set site_yunprint='".$print."'";
			if (mysql_query($sql)){
				alertInfo('操作成功','',1);
			}else{
				alertInfo('出错','',1);
			}
		break;


    }
	
	

	
?>