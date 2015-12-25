<?php
/**
 * install.php
 
 * Update Record:
 *
 */
//header

	$_['header_index']                   = '欢迎';
	$_['header_database']                = '设置数据库';
	$_['header_initialization']          = '系统初始化';
	$_['header_admin']                   = '设置管理员';
	$_['header_finish']                  = '完成安装';

	$_['text_title']                     ='安装点餐系统';
	$_['text_install_step']              ='安装步骤';
	$_['text_step1_title']               ='欢迎使用点餐系统';
	$_['text_step2_title']               ='设置数据库';
	$_['text_step3_title']               ='系统初始化';
	$_['text_step4_title']               ='设置管理员';
	$_['text_step5_title']               ='完成安装';

	$_['text_step1_intro1']              ='感谢您使用点餐系统。点餐系统是一款轻量级的基于PHP+Mysql的论坛系统。';
	$_['text_step2_intro1']              ="请按照说明完成安装步骤。整个过程只需要几分钟";
	$_['text_step3_intro1']              ='点餐系统所需环境';
	$_['text_step4_intro1']              ='您可以向服务器提供商询问是否支持以下环境参数。';
	$_['text_param1_title']              ='项目';
	$_['text_param2_title']              ='需求';
	$_['text_param3_title']              ='实际环境';
	$_['text_param1']                    ='PHP';
	$_['text_param1_value']              ='5.0及以上';
	$_['text_param2']                    ='MySQL';
	$_['text_param2_value']              ='5.0及以上';

	$_['text_database_intro']            ='请填写MySql的连接参数。（可从服务器提供商处获得）';
	$_['text_databaseparam1_title']      ='主机地址';
	$_['text_databaseparam2_title']      ='用 户 名';
	$_['text_databaseparam3_title']      ='密　　码';
	$_['text_databaseparam4_title']      ='数据库名';
	$_['text_databaseparam5_title']      ='表前缀';


	$_['text_initialization_title1']     ='步骤';
	$_['text_initialization_title2']     ='运行结果';
	$_['text_initialization1']           ='检测数据库环境';
	$_['text_initialization2']           ='创建表';
	$_['text_initialization3']           ='初始化数据库数据';


	$_['text_adminParam1_title']         ='网站地址';
	$_['text_adminParam2_title']         ='管理目录';
	$_['text_adminParam3_title']         ='管理员帐号';
	$_['text_adminParam4_title']		 ='管理员密码';
	$_['text_adminParam5_title']         ='确认密码';
	$_['text_subject1']                  ='建议不修改';
	$_['text_subject2']                  ='安全起见，建议修改';

	$_['text_success']                   ='恭喜您，点餐系统安装顺利完成！';
	$_['text_notice']                    ='请牢记以下资料';
	$_['text_adminUrl']                  ='管理后台地址';
	$_['text_inAdmin']                   ='进入点餐系统管理后台';
	$_['text_inIndex']                   ='进入点餐系统首页';

	$_['text_check']                  ='下一步检测';
	$_['text_folderLimit']                  ='文件夹的权限';
	$_['text_write']                  ='写';
	$_['text_edit']                  ='修改';

	$_['text_superAdmin']                ='超级管理员';
 
	$_['text_footer']                    ="2015";

	//button alt

	$_['alt_pre']                        ='上一步';
	$_['alt_next']                       ='下一步';
	$_['alt_finish']                     ='完成';
	$_['alt_install']                     ='点餐系统安装程序';


//error


	$_['error_mb_string']                  ='您的服务器不支持mb_string。';
	$_['error_php']                        ='您的PHP版本低于点餐系统所需的版本。';
	$_['error_database_connect']           ='0005:数据库服务器连接失败！请返回上一页检查连接参数。';
	$_['error_mysql']                      ='错误：Mysql版本低于点餐系统正常运行所需版本';
	$_['error_session']                    ='错误：您的服务器环境不支持SESSION。';
	$_['error_noDatabase']                 ='0006:数据库不存在！请返回上一页检查连接参数。';
	$_['error_root_limit']                 ='0007:请为网站根目录设置写权限，然后刷新本页面。';
	$_['error_install_limit']              ='0008:请为install目录设置写权限，然后刷新本页面。';
	$_['error_admin_limit']                ='0009:请为admin目录设置写权限，然后刷新本页面。';
	$_['error_root_limit']                 ='0007:请为网站根目录设置写权限，然后刷新本页面。';


	$_['error_admin_folder']               ='请修改管理后台地址';
	$_['error_admin_length']               ='后台管理地址长度最少为2位';
	$_['error_account_length']             ='帐号长度最少为3位';
	$_['error_pwd_length']                 ='管理员密码长度最少为6位';
	$_['error_pwd2']                       ='两次输入的密码不一样';

	$_['error_finish_connect']             ='0003:意外错误！';
	$_['error_finish_database']            ='0004:意外错误！';
	$_['error_finish_insertAdmin']         ='0107:意外错误！';

	$_['error_ajax_connect']               ='错误：0010。';
	$_['error_ajax_noDatabase']            ='错误：0011。';
	$_['error_ajax_setuft8']               ='错误：0012。';
	$_['error_finish_fail']                ='失败';
	$_['error_creat_fail']                ='创建数据库失败！';
	
?>