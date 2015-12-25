<?php
	/**
	 *  userquit.php  
	 */
	 require('../include/dbconn.php');
	setcookie("QIYUSHOP","",time()+60*60*24*7);
	setcookie("QIYUSHOPVERD","",time()+60*60*24*7);
	session_unset();
	session_destroy();
	Header("Location:index.php");
?>