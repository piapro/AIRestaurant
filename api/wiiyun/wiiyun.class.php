<?php
	class AppException {
		public $host = "http://www.wiiyun.com/api_wiiyun/";
		//public $host = "http://localhost/wiiyun/api_wiiyun/";
		/**
		 * Set timeout default.
		 *
		 * @ignore
		 */
		public $timeout = 30;
		/*
			* function 提示函数
			
			
			$return true 执行成功 false 执行失败
		*/
		public function alertInfo($info,$url,$type){
			switch($type){
				case 0:
					echo "<script language='javascript'>alert('".$info."');location.href='".$url."';</script>";
					exit();
					break;
				case 1:
					echo "<script language='javascript'>alert('".$info."');history.back(-1);</script>";
					exit();
					break;
			}
		}
		/*
			* function 检查函数
			
			
			*return 
		*/
		public function checkData($data,$name,$type){
			switch($type){
				case 0:
					if(!preg_match('/^\d*$/',$data)){
						$this->alertInfo(error_invalid.$name,'',1);
						exit();
					}
					break;
				case 1:
					if(empty($data)){
						$this->alertInfo($name.'不能为空',"",1);
						exit();
					}
					break;
				case 2: //integer
					if (!preg_match('/^[-+]?[0-9]+$/',trim($data))){
						$this->alertInfo(error_invalid.$name,'',1);
						exit();
					}
					break;
				case 3: //float
					if (!preg_match('/^[-+]?([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?$/',trim($data))){
						$this->alertInfo(error_invalid.$name,'',1);
						exit();
					}
					break;
			}
			return $data;
		}

		/*
			* function 用户登陆
			* @param $account 账号
			* @param $pwd 账m密码
			*return 
		*/

		public function login($account,$pwd){
			//判断登陆的结果
			$data=array('account'=>$account,'pwd'=>$pwd);
			$result=$this->http('login.php','POST',$data);
			
			$result=json_decode($result);
			return $result;
		}


		/*
			* function 得到发送短信的信息
			* @param $id 用户id2
			*return 
		*/

		public function getSMS($id){
			//判断登陆的结果
			$data=array('id'=>$id);
			$result=$this->http('sms.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}

		/*
			* function 发送短信
			* @param $id 用户id2
			* @param $data 一个数组，包括接受者跟短信的内容
			*return 
		*/

		public function sendSMS($id,$data){
			$result=$this->http('smssend.php','POST',$data);
			return $result;
		}

		/*
			* function 用户注册
			* @param $data 一个数组，包括 用户名、密码
			*return 
		*/

		public function reg($data){
			$result=$this->http('register.php','POST',$data);
			return $result;
		}

		/*
			* function 根据账号得到用户信息
			* @param $account 账号
			* @param $pwd 账m密码
			*return 
		*/

		public function getUserByAccount($account){
			//判断登陆的结果
			$data=array('account'=>$account);
			$result=$this->http('getuserByaccount.php','POST',$data);
			
			$result=json_decode($result);
			return $result;
		}

		/*
			* function 根据用户ID得到用户信息
			* @param $account 账号
			* @param $pwd 账m密码
			*return 
		*/

		public function getUserByID($uid){
			//判断登陆的结果
			$data=array('uid'=>$uid);
			$result=$this->http('getuserByID.php','POST',$data);
			
			$result=json_decode($result);
			return $result;
		}

		/*
			* function qq登陆
			* @param $account 账号
			* @param $pwd 账m密码
			*return 
		*/

		public function loginQQ(){
			//判断登陆的结果
			$result=$this->http('loginqq.php','','');
			
			$result=json_decode($result);
			return $result;
		}

		/*
			* function 激活用户
			* @param $data 一个数组，包括 用户名、密码
			*return 
		*/

		public function useractivite($data){
			$result=$this->http('useractive.php','POST',$data);
			return $result;
		}

		/*
			* function 插入数据到 wiiyun_userapp
			* @param 
			*return 
		*/

		public function insertUserApp_only($uid,$aid){
			$data=array('uid'=>$uid,'aid'=>$aid);
			$result=$this->http('insertuserapp_only.php','POST',$data);
			return $result;
		
		}

		/*
			* function 插入数据到 wiiyun_userapp_m_t 
			* @param $data 一个数组，包括 用户名、密码
			*return 
		*/

		public function insertUserAppByUser_retun_ID($uid,$aid,$unit,$num,$num2){
			$data=array('uid'=>$uid,'aid'=>$aid,'unit'=>$unit,'num'=>$num,'num2'=>$num2);
			$result=$this->http('insertuserapp_returnid.php','POST',$data);
			return $result;
		}

		/*
			* function 改变用户的余额 
			* @param 
			*return true false
		*/

		public function updateUserBalance($uid,$price){
			$data=array('uid'=>$uid,'price'=>$price);
			$result=$this->http('updateeserbalance.php','POST',$data);
			return $result;
		}

		/*
			* function 根据应用ID以及用户id得到所有的信息
			* @param 
			*return 
		*/

		public function getUserApp_m_t($uid,$aid){
			$data=array('uid'=>$uid,'aid'=>$aid);
			$result=$this->http('getUserApp_m_t.php','POST',$data);
			
			$result=json_decode($result);
			return $result;
		}

		/*
			* function 检查应用的状态
			* @param $id 
			* $return 1 已创建 2已过期 3可以创建
			* @param $type 1 标示是否即将到期 空标示不是即将到期
		*/

		public function checkIsUse_m_t($id,$type=''){
			$data=array('id'=>$id,'type'=>$type);
			$result=$this->http('checkIsUse_m_t.php','POST',$data);
			return $result;
		}
		/*
			* function 修改wiiyun_userapp_m_t 表的时间
			* @param $mid  userapp_m_t_id
			* @patam $unit 单位
			* @patam $num 数量
			* return true false
		*/

		public function updateUserApp_m_time($mid,$unit,$num){
			$data=array('mid'=>$mid,'unit'=>$unit,'num'=>$num);
			$result=$this->http('updateUserApp_m_time.php','POST',$data);
			return $result;
		}
		/*
			* function 添加日志
			* @param $uid  用户
			* @patam $content 内容
			* @patam $type 类型 1前台
			* 
		*/
		public function addLog($uid,$content,$type){
			$data=array('uid'=>$uid,'content'=>$content,'type'=>$type);
			$result=$this->http('addlog.php','POST',$data);
		}

		/*
			* function 在线充值
			* @param $uid  用户
			* @patam $mode 0代表支付宝1代表后台 3 充值卡 
			* @patam $total_fee 总金额
			* @param $out_trade_no 订单号
			* *reurn S 成功 E 修改用户的余额失败
		*/

		public function addOnlineCharge($uid,$mode,$total_fee,$out_trade_no){
			$data=array('uid'=>$uid,'mode'=>$mode,'total'=>$total_fee,'order'=>$out_trade_no);
			$result=$this->http('onlinechargeadd.php','POST',$data);
			return $result;
		}
		
		/*
			* function 修改在线充值状态
			* @param $order 订单号
			* @patam $mode 0代表支付宝1代表后台 3 充值卡 
			* @patam $total_fee 总金额
			* @param $out_trade_no 订单号
			* *reurn S 成功 E 修改用户的余额失败
		*/

		public function updateonlineState($order){
			$data=array('order'=>$order);
			$result=$this->http('updateonlinestatus.php','POST',$data);
			return $result;
		}

		/*
			* function 充值卡充值
			* @param $uid  用户
			* @patam $card_id 卡号
			* @patam $pwd 密码 
			* *return "C"; 已过期 S 充值成功 E修改充值卡状态失败 D 修改用户的余额失败 B 密码错误 A 卡号不存在
		*/

		public function cardOnline($card,$pwd,$uid){
			$data=array('uid'=>$uid,'card'=>$card,'pwd'=>$pwd);
			$result=$this->http('cardonline.php','POST',$data);
			return $result;
		}
		/*
			* function 修改用户资料
			* @param $data
			
			* *return "E"; 失败 S 成功
		*/

		public function updateUserInfo($data){
			$result=$this->http('updateuserinfo.php','POST',$data);
			return $result;
		}

		/*
			* function 修改用户的激活码
			* @param $id2 用户ID2
			
			* @param  $code_v 激活码
		*/

		public function updateUserCode($id2,$code_v){
			$data=array('id2'=>$id2,'code'=>$code_v);
			$result=$this->http('updateusercode.php','POST',$data);
			return $result;
			
		}

		/*
			* function 根据用户id2跟激活码查找用户
			* @param $id2 用户ID2
			
			* @param  $code_v 激活码
		*/

		public function selectUserBy_id2_code($id2,$code){
			$data=array('id2'=>$id2,'code'=>$code);
			$result=$this->http('selectuserby_id2_code.php','POST',$data);
			return $result;
		}

		/*
			* function 根据ID2跟激活码修改用户密码
			* @param $id 用户ID2
			
			* @param  $v 激活码
			* @param  $pwd 密码
		*/

		public function forgetUserPWD($id,$v,$pwd){
			$data=array('id2'=>$id,'code'=>$v,'pwd'=>$pwd);
			$result=$this->http('forgetuserpwd.php','POST',$data);
			return $result;
		}

		/*
			* function 修改密码
			* return S 成功 N 原密码不对 E 失败
			
		*/

		public function updatePWD($data){
			$result=$this->http('updateuserpwd.php','POST',$data);
			return $result;
		}

		/*
			* function 得到新闻
			* @param $type  wiimoni分类id2
			
			* @param  $start 开始条数
			* @param  $pagesize 显示的条数
			* @type  1为推荐
		*/

		public function getCms($id2,$start,$pagesize,$type){
			$data=array('id2'=>$id2,'start'=>$start,'pagesize'=>$pagesize,'type'=>$type);
			$result=$this->http('getcms.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}

		/*
			* function 得到新闻的总数
			* @param $type  wiimoni分类id2
			* @type  1为推荐
			
			
		*/

		public function getCMSCount($id2,$type){
			$data=array('id2'=>$id2,'type'=>$type);
			$result=$this->http('getcmscount.php','POST',$data);
			return $result;
		}
		/*
			* function 得到新闻的详情
			* @param $id 新闻ID		
			
		*/
		public function getCmsIntro($id){
			$data=array('id'=>$id);
			$result=$this->http('getcmsinfo.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}

		/*
			* function 得到上一篇新闻
			* @param $id 新闻ID		
			
		*/
		public function getCmsPre($id2,$id){
			$data=array('id'=>$id,'id2'=>$id2);
			$result=$this->http('getcmspre.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}
		/*
			* function 得到上一篇新闻
			* @param $id 新闻ID		
			
		*/
		public function getCmsNext($id2,$id){
			$data=array('id'=>$id,'id2'=>$id2);
			$result=$this->http('getcmsnext.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}


		/*
			* function 插入建议
			* return S 成功 F 失败
			
		*/

		public function InsertAppSuggest($data){
			$result=$this->http('suggestadd.php','POST',$data);
			return $result;
		}
		/*
			* function 得到订单总数
			* return
			
		*/

		public function getOrderCount($uid,$appid){
			$data=array('uid'=>$uid,'appid'=>$appid);
			$result=$this->http('getordercount.php','POST',$data);
			return $result;
		}
		/*
			* function 得到订单列表
			* return
			
		*/

		public function getOrderList($uid,$appid){
			$data=array('uid'=>$uid,'appid'=>$appid);
			$result=$this->http('getorderlist.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}

		/*
			* function 添加订单
			* @param $uid 用户ID		
			* @param $price 账户的金额	
			* @param $totalPrice 总价格	
			* @param $aid appID	
			* @param $desc 备注	
			* return
			
		*/

		public function orderInsert($uid,$price,$totalPrice,$aid,$desc){
			$data=array('uid'=>$uid,'price'=>$price,'totalPrice'=>$totalPrice,'aid'=>$aid,'desc'=>$desc);
			$result=$this->http('orderinsert.php','POST',$data);
			return $result;
		}

		/*
			* function 检查微云码是否存在
			* @param $salt 微云码
			* @param $account 账号
			
			* return  数组
			
		*/
		public function checkWiiyunSalt($salt,$account){
			$data=array('salt'=>$salt,'account'=>$account);
			$result=$this->http('wiiyunsalt.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}
        /*
		public function checkPrintDtu($yunprint){
			$data=array('yunprint'=>$yunprint);
			$result=$this->http('yunprint.php','POST',$data);
			$result=json_decode($result);
			return $result;
		}*/










		/*
			* function 获取数据
			* @param $data 参数数组
			* @param $url 路径
			* @param $method 提交方式 
			*return 
		*/

		public function http($url,$method='',$data=null){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->host.$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
			switch ($method) {
				case 'POST':
					curl_setopt($ch, CURLOPT_POST, TRUE);
					if (!empty($data)) {
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					}
					break;
			}
			$output = curl_exec($ch); 
			curl_close($ch); 
			return $output;
		}
		
	}
?>