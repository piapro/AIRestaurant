<?php
/**
 * 首页Flash图片上传 flash_picup.php
 */
header("content-type:text/html;charset=utf-8");
require_once('inc_image.class.php');

	$info = "";
	$fileElementName2 = 'fileToUpload2';
	if(!empty($_FILES[$fileElementName2]['error']))
	{
		switch($_FILES[$fileElementName2]['error'])
		{

			case '1':
				$info = 'E|上传的文件大小超过了系统限制。';
				break;
			case '3':
				$info = 'E|上传文件过程出错。';
				break;
			case '4':
				$info = 'E|没有选择文件。';
				break;
			case '6':
				$info = 'E|系统错误：不存在临时文件夹。';
				break;
			case '7':
				$info = 'E|系统错误：写入文件出错。';
				break;
			default:
				$info = 'E|未知错误';
		}
	}elseif(empty($_FILES[$fileElementName2]['tmp_name']) || $_FILES[$fileElementName2]['tmp_name'] == 'none'){
		echo 'hahhhh'.$_FILES[$fileElementName2]['tmp_name'];die;
		$info = 'E|没有选择文件。';
	}else{
		$f_name2=$_FILES[$fileElementName2]['name'];
		$f_size2=$_FILES[$fileElementName2]['size'];
		$f_tmpName2=$_FILES[$fileElementName2]['tmp_name'];

		$f_ext2=strtolower(preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$f_name2));

		$f_extAllowList2="png";

		$f_exts2=$f_extAllowList2;		
		
		if ($f_ext2!==$f_exts2){
			$info = 'E|图片格式不正确，格式必须为png。';	
		}else{
			if ($f_size2>100*1024){
				$info = 'E|文件大小不能超过100K。';
			}else{
				$random= rand(100,999); 
				$f_fullname2= time().$random.".".$f_ext2;
				$f_path2="userfiles/icon/".$f_fullname2;

				if (copy($f_tmpName2,"../".$f_path2)){
						
					$info = "S|".$f_path2;
				}else{
					$info = 'E|图片保存的目标文件夹不存在或无写权限。';
				}
			}
		}
		@unlink($_FILES[$fileElementName2]);
	}
	echo $info;
?>