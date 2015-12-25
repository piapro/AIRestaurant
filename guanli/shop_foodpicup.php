<?php
/**
 * 首页Flash图片上传 flash_picup.php
 */
header("content-type:text/html;charset=utf-8");
require_once('inc_image.class.php');

	$info = "";
	$fileElementName = 'fileToUpload';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
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
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none'){
		$info = 'E|没有选择文件。';
	}else{
		$f_name=$_FILES[$fileElementName]['name'];
		$f_size=$_FILES[$fileElementName]['size'];
		$f_tmpName=$_FILES[$fileElementName]['tmp_name'];

		$f_ext=strtolower(preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$f_name));
		$f_extAllowList="png|jpg|gif";

		$f_exts=explode("|",$f_extAllowList);
		$checkExt=true;
		foreach ($f_exts as $v){
			if ($f_ext==$v){
				$checkExt=false;
				break;
			}
		}

		if ($checkExt){
			$info = 'E|图片格式不正确，格式必须为jpg、png、gif之一。';
		}else{
			if ($f_size>200*1024){
				$info = 'E|文件大小不能超过200K。';
			}else{
				$random= rand(100,999); 
				$f_fullname= time().$random.".".$f_ext;
				$f_path="userfiles/food/".$f_fullname;

				if (copy($f_tmpName,"../".$f_path)){
					/**if($f_ext=="jpg"){
						$t = new ThumbHandler();
						$t->setSrcImg("../".$f_path);
						//$t->setCutType(1);
						$t->setDstImg("../".$f_path_s);
						$t->createImg(885,229);
						$f_path=$f_path_s;
					}**/
					$info = "S|".$f_path;
				}else{
					$info = 'E|图片保存的目标文件夹不存在或无写权限。';
				}
			}
		}
		@unlink($_FILES[$fileElementName]);
	}
	echo $info;
?>