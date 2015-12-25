<?php
	require_once('api/print.class.php');
	//echo 1323;
	$site_yunprint = 1;
	$print_content ="aaaaaawwwwww";
	if (!(empty($site_yunprint))){
			$p=new YunPrint();
			$a=$p->printTxt($site_yunprint,$print_content);
		} 
	
?>