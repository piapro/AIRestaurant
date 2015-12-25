<?php
	/**
	 *  usercentertab2.php 
	 */
?>					
					<input type="hidden" id="orderid" name="orderid" value="<?php echo $row_n['order_id']?>" />
					<input type="hidden" id="orderkey" name="orderkey" value="<?php echo $key?>" />
					<h1 class="order_h1">所有订单</h1>
				<?php
					if ($orderAllCount>0){
						if ($key=="all"){
					?>
						<div class="table orderTable">
							<table>
								<tr>
									<td width="150" class="metal">订单时间</td>
									<td width="130" class="metal borderLeft">订单号</td>
									<td width="75" class="metal borderLeft">金额</td>
									<td width="84" class="metal borderLeft">状态</td>
									<td width="84" class="metal borderLeft">是否预约</td>
									<td width="150" class="metal borderLeft">预约时间</td>
									<td width="100"  class="metal borderLeft">操作</td>
								</tr>
					<?php
								
								$sql="select order_addtime,shop_name,shop_id,order_totalprice,order_status,order_id,order_id2,order_type,order_time1,order_time2 from qiyu_order,qiyu_shop where (shop_id2=order_shop or shop_id=order_shopid) and order_user=".$QIYU_ID_USER." and shop_status='1' order by order_addtime desc limit 10";
								$rs=mysql_query($sql);
								while ($rows=mysql_fetch_assoc($rs)){
									$type=$rows['order_type'];
									$time1=$rows['order_time1'];
									$time2=substr($rows['order_time2'],0,5);
									if ($type=='1')
										$str='是';
									else
										$str='否';
					?>
									<tr>
										<td class="borderBottom borderLeft" width="86"><?php echo $rows['order_addtime']?></td>
										<td class="borderBottom borderLeft" align='center'><a href="userorderintro.php?id=<?php echo $rows['order_id']?>&key=all" style="color:red;"><?php echo $rows['order_id2']?></a></td>
										<td class="borderBottom borderLeft" align='center'><?php echo $rows['order_totalprice']?>元</td>
										<td class="borderBottom borderLeft" align='center'><?php echo $orderState[$rows['order_status']]?></td>
										<td class="borderBottom borderLeft" align='center'><?php echo $str?></td>
										<td class="borderBottom borderLeft"><?php echo $time1." ".$time2?></td>
										<td class="borderBottom borderRight borderLeft" width="91" align='center'><?php if ($rows['order_status']=='0'){?><a href="javascript:void()" onClick="orderCancel(<?php echo $rows['order_id']?>)">取消订单</a><?php }?></td>
										
									</tr>
				<?php
								}	
				?>
								
							</table>
						</div>
				<?php
						}
					}else{
						echo "<p style='text-align:center;font-size:18px;padding-top:50px;padding-bottom:30px;'>您还没有任何订单信息</p>";
					}
				?>
