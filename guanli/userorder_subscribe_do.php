<?php 
	/**
	 *  shop_do.php  
    */
	require_once("usercheck2.php");
	$act=$_GET['act'];
	$start=empty($_GET['start'])?'':$_GET['start'];
	$end=empty($_GET['end'])?'':$_GET['end'];
	$name=empty($_GET['name'])?'':$_GET['name'];
	$phone=empty($_GET['phone'])?'':$_GET['phone'];
	$order=empty($_GET['order'])?'':$_GET['order'];
	$url="&start=".$start."&end=".$end."&name=".$name."&phone=".$phone."&order=".$order;
	switch($act)
	{
		
		case 'del':
			$id=sqlReplace(trim($_GET['id']));
			$key=sqlReplace(trim($_GET['key']));
			$id=checkData($id,"ID",0);
			$sql="select * from qiyu_order where order_id=".$id;
			$result=mysql_query($sql);
			$row=mysql_fetch_assoc($result);
			if(!$row){
				alertInfo('您要删除的订单不存在','userorder.php?key='.$key.$url,0);
			}else{
				$sql2="delete from qiyu_order where order_id=".$id;
				if(mysql_query($sql2)){
					$sql3="delete from qiyu_orderchange where orderchange_order='".$row['order_id2']."'";
					if(mysql_query($sql3)){
						alertInfo('删除成功','',1);
					}
				}else{
					alertInfo('删除失败，原因SQL出现异常','',1);
				}
			}
			break;
		case "delAll":
			$id_list=$_POST["id_list"];
			$key=sqlReplace(trim($_GET['key']));
		    if(empty($id_list)){
				alertInfo('请选择删除项!','userorder.php?key='.$key,0);
			}else{
				foreach($id_list as $val){
					$sql="select * from qiyu_order where order_id=".$val."";
					$rs=mysql_query($sql);
					$row=mysql_fetch_assoc($rs);
					if($row){
						
						$sqlStr="delete from qiyu_order where order_id=".$val."";
						if(mysql_query($sqlStr)){
							$sql3="delete from qiyu_orderchange where orderchange_order='".$row['order_id2']."'";
							mysql_query($sql3);
						}else{
							alertInfo('删除失败！原因：SQL删除失败。',"",1);
						}
					}else{
						alertInfo('删除失败！原因：不存在',"",1);
						exit;
					}
				}
				alertInfo('删除成功','',1);
			}
			break;
		case 'qx':
			$id=sqlReplace(trim($_GET['id']));
			$key=sqlReplace(trim($_GET['key']));
			$id=checkData($id,"ID",0);
			$sql="select * from qiyu_order where order_id=".$id." and order_status in(0,1,5)";
			$result=mysql_query($sql);
			$row=mysql_fetch_assoc($result);
			$order_status=$row['order_status'];
			if(!$row){
				alertInfo('订单不存在','',1);
			}else{
				if ($order_status!='2'){
					$order=$row['order_id2'];
					if($key=='0'){
						$sql2="update qiyu_order set order_status='2',order_operator='".$QIYU_ID_SHOP."' where order_id=".$id." and order_status='0'";
					}else{
						$sql2="update qiyu_order set order_status='2' where order_id=".$id." and order_status in(1,5)";
					}
					if(mysql_query($sql2)){
						//添加订单记录
						$orderContent="<span class='greenbg redbg'><span><span>取消订单</span></span></span>";
						$orderContent.="您的订单已取消，给您带来的不便请谅解，我们会更好的为您服务。";
						addOrderType($order,HTMLEncode($orderContent));
						alertInfo('取消成功','',1);
					}else{
						alertInfo('取消失败，原因SQL出现异常','',1);
					}
				}else{
					alertInfo('取消成功','',1);
				}
			}
			break;
		case 'sure':
			$id=sqlReplace(trim($_GET['id']));
			$key=sqlReplace(trim($_GET['key']));
			$id=checkData($id,"ID",0);
			$sql="select * from qiyu_order where order_id=".$id." and order_status='0'";
			$result=mysql_query($sql);
			$row=mysql_fetch_assoc($result);
			if(!$row){
				alertInfo('订单不存在','userorder.php?key='.$key.$url,0);
			}else{
				$order=$row['order_id2'];
				$sql2="update qiyu_order set order_status='1'  where order_id=".$id;
				if(mysql_query($sql2)){
					//添加订单记录
					$orderContent="<span class='greenbg'><span><span>我们正在下单</span></span></span>";
					$orderContent.="亲，大厨正在努力烹制美味的食物，请耐心等待！";
					addOrderType($order,HTMLEncode($orderContent));
					alertInfo('确定成功','',1);
				}else{
					alertInfo('确定失败，原因SQL出现异常','',1);
				}
			}
			break;	
		case 'finish':
			$id=sqlReplace(trim($_GET['id']));
			$key=sqlReplace(trim($_GET['key']));
			$id=checkData($id,"ID",0);
			$sql="select * from qiyu_order where order_id=".$id." and order_status='1'";
			$result=mysql_query($sql);
			$row=mysql_fetch_assoc($result);
			if(!$row){
				alertInfo('订单不存在','',1);
			}else{
				$order=$row['order_id2'];
				$sql2="update qiyu_order set order_status='4'  where order_id=".$id." and order_status='1'";
				if(mysql_query($sql2)){
					//添加订单记录
					$orderContent="<span class='greenbg'><span><span>订单已完成</span></span></span>";
					$orderContent.="亲，享受美味的时候，别忘了继续光顾".$SHOP_NAME."哦，我们将更好的为您服务。";
					addOrderType($order,HTMLEncode($orderContent));
					alertInfo('设置订单为已完成成功','',1);
				}else{
					alertInfo('取消失败，原因SQL出现异常','',1);
				}
			}
			break;
		
		
		

	}

	
?>