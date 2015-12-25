<?php
/**
 * 打印信息
 */
set_time_limit(0);
header("content-type:text/html;charset=utf-8");
require_once("usercheck2.php");
$act=$_GET['act'];
//根据用户id获取用户信息
	function getuserinfo($id){
		$sql="select * from ".WIIDBPRE."_user where user_id=".$id;
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		if($row){
			return $row;
		}else{
			return '';
		}
	}
switch($act)
{
	case 'print':
			$id=sqlReplace(trim($_GET['id']));
			if(!empty($id)){
				$row=getuserinfo($id);
				if(!$row){
					alertInfo('数据不存在','',1);
				}
				
				require_once('PHPWord.php');
				$PHPWord = new PHPWord();
				//复制模板文件，变成下载文件
				$now=time();
				$y_url='../userfiles/print.docx';
				$x_url='../userfiles/docx/'.$now.'.docx';

				$document = $PHPWord->loadTemplate($y_url);
				$document->setValue('name', $row['user_name']);//姓名
				$document->setValue('phone',$row['user_phone']);//姓名
				
				
				
				//文件内容替换完毕  保存  下载
				$document->save($x_url);
				//header("Content-Type: application/force-download");
				//header("Content-Disposition: attachment; filename=".basename($x_url)); 
				//readfile($x_url);
				header("location:".$x_url);

			}else{
				alertInfo('参数错误','',1);
			}
			
		break;
}
?>