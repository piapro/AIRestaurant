<?php
	class YunPrint {
		public $host = "http://www.diancan365.com/api_print/";
		public $timeout = 5;
	
		/*
			* function 打印订单
			* @param $dtuid  DTU编号
			  @param $text   打印订单的内容
			*return 
		*/
		public function printTxt($dtuid,$text){
			$data=array('dtu'=>$dtuid,'txt'=>$text);
			$result=$this->http('print.php','POST',$data);
			return $result;
		}

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