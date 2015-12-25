<?php 
	/**
	 *  shop_do.php
	 */
	require_once("usercheck2.php");
	require_once("inc/function.php");
	$act=$_GET['act'];
	$start=empty($_GET['start'])?'':$_GET['start'];
	$end=empty($_GET['end'])?'':$_GET['end'];
	$name=empty($_GET['name'])?'':$_GET['name'];
	$phone=empty($_GET['phone'])?'':$_GET['phone'];
	$order=empty($_GET['order'])?'':$_GET['order'];
	$uid=empty($_GET['uid'])?'':$_GET['uid'];
	$url="&start=".$start."&end=".$end."&name=".$name."&phone=".$phone."&order=".$order."&uid=".$uid;
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
						alertInfo('删除成功','userorder.php?key='.$key.$url,0);
					}
				}else{
					alertInfo('删除失败，原因SQL出现异常','userorder.php?key='.$key.$url,0);
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
				alertInfo('删除成功','userorder.php?key='.$key.$url,0);
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
				alertInfo('订单不存在','userorder.php?key='.$key.$url,0);
			}else{
				if ($order_status!='2'){
					$order=$row['order_id2'];
					if($key=='0'){
						$sql2="update qiyu_order set order_status='2',order_operator='".$QIYU_ID_SHOP."' where order_id=".$id."  and order_status='0'";
					}else{
						$sql2="update qiyu_order set order_status='2' where order_id=".$id."  and order_status in(1,5)";
					}
					if(mysql_query($sql2)){
						//添加订单记录
						$orderContent="<span class='greenbg redbg'><span><span>取消订单</span></span></span>";
						$orderContent.="您的订单已取消，给您带来的不便请谅解，我们会更好的为您服务。";
						addOrderType($order,HTMLEncode($orderContent));
						alertInfo('取消成功','userorder.php?key='.$key.$url,0);
						
					}else{
						alertInfo('取消失败，原因SQL出现异常','userorder.php?key='.$key.$url,0);
					}
				}else{
					alertInfo('取消成功','userorder.php?key='.$key.$url,0);
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
				$sql2="update qiyu_order set order_status='1'  where order_id=".$id." and order_status='0'";
				if(mysql_query($sql2)){
					//添加订单记录
					$orderContent="<span class='greenbg'><span><span>我们正在下单</span></span></span>";
					$orderContent.="亲，大厨正在努力烹制美味的食物，请耐心等待！";
					addOrderType($order,HTMLEncode($orderContent));
					alertInfo('确定成功','userorder.php?key='.$key.$url,0);
				}else{
					alertInfo('确定失败，原因SQL出现异常','userorder.php?key='.$key.$url,0);
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
				alertInfo('订单不存在','userorder.php?key='.$key.$url,0);
			}else{
				$order=$row['order_id2'];
				$sql2="update qiyu_order set order_status='4'  where order_id=".$id." and order_status='1'";
				if(mysql_query($sql2)){
					//添加订单记录
					$orderContent="<span class='greenbg'><span><span>订单已完成</span></span></span>";
					$orderContent.="亲，享受美味的时候，别忘了继续光顾".$SHOP_NAME."哦，我们将更好的为您服务。";
					addOrderType($order,HTMLEncode($orderContent));
					$sql3="select order_user,order_id,order_id2 from qiyu_order where  order_id=".$id." and order_status='4'";
					$results=mysql_query($sql3);
			        $row2=mysql_fetch_assoc($results);
					$uid=$row2['order_user'];//用户id
					$oid=$row2['order_id2'];//订单号码
					$orderid=$row2['order_id'];//订单id
					$score=getScore($orderid);
					$sql4= "update qiyu_user set user_score=user_score+".$score." ,user_experience=user_experience+".expUserConsume." where user_id=".$uid;//更新积分,经验值	
					mysql_query($sql4);
					$sql5="select cart_count,food_id from qiyu_cart,qiyu_food where cart_food=food_id and cart_order=".$oid;//查询外卖数量
					$rs5=mysql_query($sql5);
					while($rows5=mysql_fetch_assoc($rs5)){
						$arr[]=$rows5;
						$foodcount=$rows5['cart_count'];
						$fid=$rows5['food_id'];
						$sql6="update qiyu_food set food_count=food_count+".$foodcount." where food_id=".$fid;//插入外卖数量到食物表中
						mysql_query($sql6);
					}
					alertInfo('设置订单为已完成成功','userorder.php?key='.$key.$url,0);
				}else{
					alertInfo('取消失败，原因SQL出现异常','userorder.php?key='.$key.$url,0);
				}
			}
			
			break;
		case "set":
				$sqlStr="select * from qiyu_order where order_status='1' and TIMESTAMPDIFF(hour,order_suretime,now())>24";
				$rs=mysql_query($sqlStr) or die('error1');
				while ($rows=mysql_fetch_assoc($rs)){
					$order=$rows['order_id2'];
					$sql="update qiyu_order set order_status='4' where order_id=".$rows['order_id'];
					mysql_query($sql) or die('error');
					$orderContent="<span class='greenbg'><span><span>订单完成</span></span></span>";
					$orderContent.="亲，享受美味的时候，别忘了继续光顾".$SHOP_NAME."哦，我们将更好的为您服务。";
					addOrderType($order,HTMLEncode($orderContent));
					//addOrderType($order,'您的订单完成');
				}
				alertInfo('批量修改成功','main.php',0);
			break;

		case 'xxqx'://批量取消
			$idlist= $_POST['idlist'];
			$key=sqlReplace(trim($_GET['key']));
			if(!$idlist){
				alertInfo('请选择','userorder.php?key='.$key.$url,0);
			}
			foreach ($idlist as $k=>$v){
				$sql="select * from qiyu_order where order_id='".$v."' and order_status in(0,1,5)";
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				$order_status=$row['order_status'];
				if(!$row){
					alertInfo('订单不存在','userorder.php?key='.$key.$url,0);
				}else{
					if ($order_status!='2'){
						$order=$row['order_id2'];
						if($key=='0'){
							$sql2="update qiyu_order set order_status='2',order_operator='".$QIYU_ID_SHOP."' where order_id='".$v."'  and order_status='0'";
						}else{
							$sql2="update qiyu_order set order_status='2' where order_id=".$v;
						}
						if(!mysql_query($sql2)){
							    alertInfo('取消失败，原因SQL出现异常','userorder.php?key='.$key.$url,0);
						}
					}
				}
			}
			$orderContent="<span class='greenbg redbg'><span><span>取消订单</span></span></span>";
			$orderContent.="您的订单已取消，给您带来的不便请谅解，我们会更好的为您服务。";
			addOrderType($order,HTMLEncode($orderContent));
			alertInfo('取消成功','userorder.php?key='.$key.$url,0);
			break;

		case 'xxsure'://批量确认
			$idlist= $_POST['idlist'];
			$key=sqlReplace(trim($_GET['key']));
			if(!$idlist){
				alertInfo('请选择','userorder.php?key='.$key.$url,0);
			}
			foreach ($idlist as $k=>$v){		
				$sql="select * from qiyu_order where order_id='".$v."' and order_status='0'";
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				if(!$row){
					alertInfo('订单不存在','userorder.php?key='.$key.$url,0);
				}else{
					$sql2="update qiyu_order set order_status='1'  where order_id=".$v." and order_status='0'";
					if(!mysql_query($sql2)){
					    alertInfo('确定失败，原因SQL出现异常','userorder.php?key='.$key.$url,0);  
					}
						
					
				}
			}
			alertInfo('确定成功','userorder.php?key='.$key.$url,0);
			break;	

        case 'xxdel'://批量删除	
			$idlist= $_POST['idlist'];
			$key=sqlReplace(trim($_GET['key']));
			if(!$idlist){
				alertInfo('请选择','userorder.php?key='.$key.$url,0);
			}
			foreach ($idlist as $k=>$v){
				$sql="select * from qiyu_order where order_id=".$v;
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				if(!$row){
					alertInfo('您要删除的订单不存在','userorder.php?key='.$key.$url,0);
				}else{
					$sql2="delete from qiyu_order where order_id=".$v;
					if(!mysql_query($sql2)){
					     alertInfo('删除失败！原因：SQL删除失败。',"",1);
					}
							
				}
			}
			alertInfo('删除成功','userorder.php?key='.$key.$url,0);
			break;
		
		case 'xxfinish'://批量完成			    
			$idlist= $_POST['idlist'];
			$key=sqlReplace(trim($_GET['key']));
            if(!$idlist){
				alertInfo('请选择','userorder.php?key='.$key.$url,0);
			}
			foreach ($idlist as $k=>$v){								
					$sql3="select * from qiyu_order where  order_id ='".$v."' and order_status='1'";
					$rs3=mysql_query($sql3);
					$row3=mysql_fetch_assoc($rs3);
					if(!$row3){
						alertInfo('订单不存在','userorder.php?key='.$key.$url,0);
					}else{
						$order=$row3['order_id2'];					
						$sql2="update qiyu_order set order_status='4'  where order_id='".$v."' and order_status='1'";
						if(mysql_query($sql2)){							
							//添加订单记录
							$orderContent="<span class='greenbg'><span><span>订单已完成</span></span></span>";
							$orderContent.="亲，享受美味的时候，别忘了继续光顾".$SHOP_NAME."哦，我们将更好的为您服务。";
							addOrderType($order,HTMLEncode($orderContent));
							$sql4="select order_user,order_id2 from qiyu_order where order_status =4 and order_id =".$v;
							$rs4 = mysql_query($sql4) or die ("查询失败，请检查SQL语句。");
							while($row4=mysql_fetch_assoc($rs4)){
								$arr[]=$row4;
								$user=$row4['order_user'];
								$oid=$row4['order_id2'];//订单号
								$sql5="select cart_count,food_id from qiyu_cart,qiyu_food where cart_food=food_id and cart_order=".$oid;//查询外卖数量
								$rs5=mysql_query($sql5);
								while($rows5=mysql_fetch_assoc($rs5)){
									$arr[]=$rows5;
									$foodcount=$rows5['cart_count'];
									$fid=$rows5['food_id'];							
									$sql6="update qiyu_food set food_count=food_count+".$foodcount." where food_id=".$fid;//更新外卖数量
									mysql_query($sql6);
								}
								$score=floor(getScore($v));
								$sql7="update qiyu_user set user_score=user_score+".$score." ,user_experience=user_experience+".expUserConsume." where user_id=".$user;//更新积分,经验值
								if(!mysql_query($sql7)){
								   alertInfo('取消失败，原因SQL出现异常','userorder.php?key='.$key.$url,0);
								}	
							}				
							
						
						}
					}
			  
			}
			alertInfo('设置订单为已完成成功','userorder.php?key='.$key.$url,0);
			
			break;

		case 'subqx'://预约取消
			$idlist= $_POST['idlist'];
			if(!$idlist){
				alertInfo('请选择','subscribe.php?'.$url,0);
			}
			foreach ($idlist as $k=>$v){
				$sql="select * from qiyu_order where order_id='".$v."' and order_type='1' and order_status in(0,1,5) ";
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				$order_status=$row['order_status'];
				if(!$row){
					alertInfo('订单不存在','subscribe.php?'.$url,0);
				}else{					
					$sql2="update qiyu_order set order_status='2' where order_id=".$v." and order_type='1' and order_status in(0,1,5)";
					if(!mysql_query($sql2)){
							alertInfo('取消失败，原因SQL出现异常','subscribe.php?'.$url,0);
					}
					
				}
			}
			$orderContent="<span class='greenbg redbg'><span><span>取消订单</span></span></span>";
			$orderContent.="您的订单已取消，给您带来的不便请谅解，我们会更好的为您服务。";
			addOrderType($order,HTMLEncode($orderContent));
			alertInfo('取消成功','subscribe.php?'.$url,0);
			break;

		case 'subsure'://批量确认
			$idlist= $_POST['idlist'];
			if(!$idlist){
				alertInfo('请选择','subscribe.php?'.$url,0);
			}
			foreach ($idlist as $k=>$v){		
				$sql="select * from qiyu_order where order_id='".$v."' and order_type='1' and order_status='0'";
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				if(!$row){
					alertInfo('订单不存在','subscribe.php?'.$url,0);
				}else{
					$sql2="update qiyu_order set order_status='1'  where order_id=".$v." and order_type='1' and order_status='0'";
					if(!mysql_query($sql2)){
					    alertInfo('确定失败，原因SQL出现异常','subscribe.php?'.$url,0);  
					}
						
					
				}
			}
			alertInfo('确定成功','subscribe.php?'.$url,0);
			break;	

		case 'subdel'://批量删除	
			$idlist= $_POST['idlist'];
			if(!$idlist){
				alertInfo('请选择','subscribe.php?'.$url,0);
			}
			foreach ($idlist as $k=>$v){
				$sql="select * from qiyu_order where order_type='1' and order_id=".$v;
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				if(!$row){
					alertInfo('您要删除的订单不存在','subscribe.php?'.$url,0);
				}else{
					$sql2="delete from qiyu_order where order_type='1' and  order_id=".$v;
					if(!mysql_query($sql2)){
					     alertInfo('删除失败！原因：SQL删除失败。',"",1);
					}
							
				}
			}
			    alertInfo('删除成功','subscribe.php?'.$url,0);
			break;

	}

	
?>