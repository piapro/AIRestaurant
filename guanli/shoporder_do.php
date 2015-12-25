<?php 
	/**
	 *  shop_do.php  
	 */
	require_once("usercheck2.php");
	$act=sqlReplace(trim($_GET['act']));
	switch ($act){
		case "sure":
			$key=sqlReplace(trim($_GET['key']));
			$id=sqlReplace(trim($_GET['id']));
			$keyword=empty($_GET['keyword'])?'':sqlReplace(trim($_GET['keyword']));
			$start=empty($_GET['start'])?'':sqlReplace(trim($_GET['start']));
			$end=empty($_GET['end'])?'':sqlReplace(trim($_GET['end']));
			$url="?key=".$key."&keyword=".$keyword."&start=".$start."&end=".$end;
			$sql="select * from qiyu_order where order_id=".$id." and order_shopid='".$QIYU_ID_SHOP."' and order_status='0'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$order=$rows['order_id2'];
				$sql2="update qiyu_order set order_status='1'  where order_id=".$id;
				if(mysql_query($sql2)){
					//添加订单记录
					//addOrderType($order,'商家正在为你下单');
					$orderContent="<span class='greenbg'><span><span>我们正在下单</span></span></span>";
					$orderContent.="亲，大厨正在努力烹制美味的食物，请耐心等待！";
					addOrderType($order,HTMLEncode($orderContent));
					alertInfo('确定成功','shoporder.php'.$url,0);
				}else
					alertInfo('确定失败，原因SQL出现异常','shoporder.php'.$url,0);
			}else
				alertInfo("意外出错","",1);
		break;
		case "qx":
			$key=sqlReplace(trim($_GET['key']));
			$id=sqlReplace(trim($_GET['id']));
			$keyword=empty($_GET['keyword'])?'':sqlReplace(trim($_GET['keyword']));
			$start=empty($_GET['start'])?'':sqlReplace(trim($_GET['start']));
			$end=empty($_GET['end'])?'':sqlReplace(trim($_GET['end']));
			$url="?key=".$key."&keyword=".$keyword."&start=".$start."&end=".$end;
			$sql="select * from qiyu_order where order_id=".$id." and order_shopid='".$QIYU_ID_SHOP."' and order_status in(0,1,5)";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$order=$rows['order_id2'];
				$sql2="update qiyu_order set order_status='2'  where order_id=".$id;
				if(mysql_query($sql2)){
					//添加订单记录
					//addOrderType($order,'商家取消订单');
					$orderContent="<span class='greenbg redbg'><span><span>取消订单</span></span></span>";
					$orderContent.="您的订单已取消，给您带来的不便请谅解，我们会更好的为您服务。";
					addOrderType($order,HTMLEncode($orderContent));
					alertInfo('取消成功','shoporder.php'.$url,0);
				}else
					alertInfo('取消失败，原因SQL出现异常','shoporder.php'.$url,0);
			}else
				alertInfo("意外出错","",1);
		break;
		case "bc":
			$key=sqlReplace(trim($_GET['key']));
			$id=sqlReplace(trim($_GET['id']));
			$keyword=empty($_GET['keyword'])?'':sqlReplace(trim($_GET['keyword']));
			$start=empty($_GET['start'])?'':sqlReplace(trim($_GET['start']));
			$end=empty($_GET['end'])?'':sqlReplace(trim($_GET['end']));
			$url="?key=".$key."&keyword=".$keyword."&start=".$start."&end=".$end;
			$sql="select * from qiyu_order where order_id=".$id." and order_shopid='".$QIYU_ID_SHOP."' and order_status=1";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$order=$rows['order_id2'];
				$sql2="update qiyu_order set order_status='5'  where order_id=".$id;
				if(mysql_query($sql2)){
					//添加订单记录
					//addOrderType($order,'商家开始备餐');
					$orderContent="<span class='greenbg'><span><span>订单已被餐厅接受</span></span></span>";
					$orderContent.="亲,您在".$rows['order_addtime']."所订美味餐品已迫不及待奔向您，马上会到达，请注意查收哦！";
					addOrderType($order,HTMLEncode($orderContent));
					alertInfo('操作成功','shoporder.php'.$url,0);
				}else
					alertInfo('操作失败，原因SQL出现异常','shoporder.php'.$url,0);
			}else
				alertInfo("意外出错","",1);
		break;
		case "finish":
			$key=sqlReplace(trim($_GET['key']));
			$id=sqlReplace(trim($_GET['id']));
			$keyword=empty($_GET['keyword'])?'':sqlReplace(trim($_GET['keyword']));
			$start=empty($_GET['start'])?'':sqlReplace(trim($_GET['start']));
			$end=empty($_GET['end'])?'':sqlReplace(trim($_GET['end']));
			$url="?key=".$key."&keyword=".$keyword."&start=".$start."&end=".$end;
			$sql="select * from qiyu_order where order_id=".$id." and order_shopid='".$QIYU_ID_SHOP."' and order_status='5'";
			$rs=mysql_query($sql);
			$rows=mysql_fetch_assoc($rs);
			if ($rows){
				$order=$rows['order_id2'];
				$sql2="update qiyu_order set order_status='4'  where order_id=".$id;
				if(mysql_query($sql2)){
					//添加订单记录
				//	addOrderType($order,'订单已完成');
					$orderContent="<span class='greenbg'><span><span>订单已完成</span></span></span>";
					$orderContent.="亲，享受美味的时候，别忘了继续光顾<?php echo $SHOP_NAME?>哦，我们将更好的为您服务";
					addOrderType($order,HTMLEncode($orderContent));
					alertInfo('操作成功','shoporder.php'.$url,0);
				}else
					alertInfo('操作失败，原因SQL出现异常','shoporder.php'.$url,0);
			}else
				alertInfo("意外出错","",1);
		break;
		
	}
	

	
?>