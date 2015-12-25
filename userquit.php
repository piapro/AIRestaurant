<?php
	
	require_once("include/dbconn.php");
	if($_COOKIE['QIYUCHECK']=='yes'){
		
	}else{
		setcookie("QIYUUSER","",time()-1);
	}
	setcookie("QIYUVERD","",time()-1);
	session_unset();
	session_destroy();
	Header("Location:index.php");
?>