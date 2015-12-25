<?php
	/**
	 *  usercentertab5.php 
	 */
?>
						<!--修改姓名-->
						<h1 class="order_h1">修改您的姓名</h1>
						
						<div class="addList newAddList">
							<label>您的姓名：</label><input type="text" id="user_name" name="user_name" class="input" value="<?php echo $row['user_name'];?>"/> <span class="red errormt2"></span>
						</div>
						<div class="addList newAddList">
							<label>&nbsp;</label> <span>此姓名是显示在网站头部的姓名。</span>
						</div>
						<div class="clear"></div>
						<div class="addList newAddList" style="height:40px;margin-bottom:30px;">
							<img src="images//button/save.jpg" class="button" style="position:absolute;top:5px;left:260px;" onclick="return updateusername();" />
						</div>
						<div class="clear"></div>
						
						<!--新增地址和联系方式-->
						<h1 class="order_h1">新增地址和联系方式</h1>
						
						<div class="addList newAddList">
							<label>您的手机号：</label><input type="text" id="phone" name="phone" class="input"/> <span class="red errormt"></span>
						</div>
						<div class="addList newAddList">
							<label>您的姓名：</label><input type="text" name="name" id="name" class="input"/> <span class="red errormt"></span>
						</div>
						
						<div class="addList newAddList">
							<label>您的详细地址：</label><input type="text" id="address" name="address" class="input"/> <span class="red errormt"></span>
						</div>
						<div class="addList newAddList">
							<label>&nbsp;</label> <span>请填写您的准确地址，以便及时收到餐点。 例如：西四北大街888号11层1102室</span>
						</div>
						<div class="clear"></div>
						<div class="addList newAddList" style="height:40px;">
							<img src="images//button/save.jpg" class="button" style="position:absolute;top:5px;left:260px;" id="addAddress1" onclick="return alertadd('addaddress');" />
						</div>
						<div class="clear"></div>
						<h1 class="order_h1" style="margin-top:20px;">已保存的地址和联系方式</h1>
						<div class="table orderTable">
							<table>
								<tr>
									<td width="220" class="metal">送货地址</td>
									<td width="100" class="metal borderLeft">姓名</td>
									<td width="100" class="metal borderLeft">联系方式</td>
									<td width="300" class="metal borderLeft" colspan='2'>操作</td>		
								</tr>
							<?php
								$sql="select * from qiyu_useraddr where useraddr_user=".$QIYU_ID_USER." order by useraddr_type asc";
								$rs=mysql_query($sql);
								while ($rows=mysql_fetch_assoc($rs)){
							?>
								<tr id="table<?php echo $rows['useraddr_id']?>">
									<td class="borderBottom borderLeft"><?php echo $rows['useraddr_address']?></td>
									<td class="borderBottom borderLeft"><?php echo $rows['useraddr_name']?></td>
									<td class="borderBottom borderLeft"><?php echo $rows['useraddr_phone']?></td>
									<td class="borderBottom borderLeft"><span class="red"><?php if ($rows['useraddr_type']=='0') echo "当前默认地址";?></span></td>
									<td class="borderBottom borderRight borderLeft red">
										<a href="javascript:void();" onClick="updateAddress(<?php echo $rows['useraddr_id']?>)">修改</a> | <span onclick="alert1('deladdress','<?php echo $rows['useraddr_id']?>');" style="cursor:pointer;">删除</span> <?php if ($rows['useraddr_type']!='0'){?> | <span onclick="setaddress('setaddress','<?php echo $rows['useraddr_id']?>');" style="cursor:pointer;">设为默认</a><?php }?>
									</td>
									
								</tr>
							<?php
								}	
							?>
								
							</table>
						</div>
<script type="text/javascript">

$(function(){				
			$("#addAddress1").hover(function(){
							 $(this).attr('src','images/button/save_1.jpg');
					 },function(){
							 $(this).attr('src','images/button/save.jpg');
			});
			$("#addAddress1").mousedown(function(){
			  $(this).attr('src','images/button/save_2.jpg');
			  
			});
		})

	$(function(){
	   $("#area").change(function(){
		   var area=$("#area").val();
			$.post("area.ajax.php", { 
						'area_id' :  area,
							'act':'circle'
					}, function (data, textStatus){
							if (data==""){
								$("#circle").html("<option value=''>没有商圈</option>")
							}else
								$("#circle").html("<option value=''>请选择</option>"+data);
					});
	   })
	})

	$(function(){
	   $("#circle").change(function(){
		   var circle=$("#circle").val();
			$.post("area.ajax.php", { 
						'circle_id' :  circle,
						'act':'spot'
					}, function (data, textStatus){
							if (data==""){
								$("#spot").html("<option value=''>没有地标</option>")
							}else
								$("#spot").html(data);
						
					});
	   })
	})

 

</script>
 <script type="text/javascript">
 <!--
	function updateAddress(ID){
		$.post("usercenter.ajax.php", { 
			'id'      :  ID,
			'act'     : 'getAddress'
			}, function (data, textStatus){
				$('.addtr').remove();
				$(data).insertAfter('#table'+ID);
						
		});
		
	}
	function checkphone(){
		var phone=$("#phone_r").val();
		if (phone==''){
			$("#spanphone").html('联系电话不能为空');
			return false;
		}else{
			var reg=/^1[358]\d{9}$/;
			if(phone.match(reg)){
				$("#spanphone").html('<img src="images/ok.gif" />');
				return true;
			}else{
				$("#spanphone").html('电话格式不正确');
				return false;
			}
		}
	}
	function checkname(){
		var name=$("#name_r").val();
		if (name==''){
			$("#spanname").html('姓名不能为空');
			return false;
		}else{
			var reg=/^[\u0391-\uFFE5]+$/;
			if(name.match(reg)){
				if(name.length>4){
					$("#spanname").html('姓名不能超过四个字');
					return false;
				}else{
					$("#spanname").html('<img src="images/ok.gif" />');
					return true;
				}
			}else{
				$("#spanname").html('姓名只能是中文');
				return false;
			}
		}
	}
	function checkaddr(){
		var address=$("#address_r").val();
		if (address==''){
			$("#spanaddr").html('详细地址不能为空');
			return false;
		}else{
			$("#spanaddr").html('<img src="images/ok.gif" />');
			return true;
		}
	}
	function checkcircle(){
		var area=$("#area_r").val();
		var circle=$("#circle_r").val();
		var spot=$("#spot_r").val();
		if (area==''||circle==''||spot==''){
			$("#spancircle").html('地址不能为空');
			return false;
		}else{
			$("#spancircle").html('<img src="images/ok.gif" />');
			return true;
		}
	}
	function submitAddress(id){
		var phone=$("#phone_r").val();
		var name=$("#name_r").val();
		
		var address=$("#address_r").val();
		checkphone();
		checkname();

		checkaddr();
		if(!checkphone()){return false;}
		if(!checkname()){return false;}
		
		if(!checkaddr()){return false;}

		$.post("usercenter.ajax.php", { 
			'id'      :  id,
			'phone' :  phone,
			'name' :  name,
			
			'address' :  address,
			'act'     : 'updateAddress'
			}, function (data, textStatus){
				if (data=="S"){
					TINY.box.show('修改成功',0,160,60,0,10);
					setTimeout('location.href="usercenter.php?tab=5"',2000) ;
				}else
					TINY.box.show('修改失败',0,160,60,0,10);
					setTimeout('location.href="usercenter.php?tab=5"',1000);
						
		});
	}
	 //-->
	</script>
	<script type="text/javascript">
		function alert1(act,useraddrid){//用户地址、删除设置为默认
			if(confirm('您确定要删除吗？')){
				$.ajax({
				   type: "GET",
				   url: "usercenter_do.php?act="+act+"&id="+useraddrid,
				   data: "",
				   success: function(msg){
					 TINY.box.show(msg,0,160,60,0,10);
					 setTimeout('location.href="usercenter.php?tab=5"',1000)
				   }
				});
			}
		}

		function setaddress(act,useraddrid){
			$.ajax({
				   type: "GET",
				   url: "usercenter_do.php?act="+act+"&id="+useraddrid,
				   data: "",
				   success: function(msg){
					 TINY.box.show(msg,0,160,60,0,10);
					 setTimeout('location.href="usercenter.php?tab=5"',1000)
				   }
			});
		}
	</script>