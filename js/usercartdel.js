	//删除购物车里对应的商品
	function delCart(id,shopID,fid,spotID){
		var addressID='';
		var circleID=$('#circleID').val();
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		if ($("#spotID").length>0)
		{
			var spotID=$('#spotID').val();
			addressID=$('#addressID').val();
		}
		
		$.post("userorder.ajax.php", { 
			'id'     :  id,
			'shopID' :  shopID,
			'rnd' :  10*Math.random(),
			'act'    :  'delCart'
			}, function (data, textStatus){
				/*
				$('#'+id+'cart').remove();
				//得到总金额
				$.post("userorder.ajax.php", { 
				'id'     :  id,
				'shopID' :  shopID,
				'spotID' :  spotID,
				'act'    :  'getTotalCart'
				}, function (data, textStatus){
					var val=data.split('|');
					$('#total').html(val[0]);
					$('#totalAll').html(val[1]);
					if (val[0]=='0')
					{
						$('#totalAll').html('0');
						$("#allSend").html("<img src=\"images/button/send.gif\"  alt=\"\" />");
					}
				});*/
				//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  fid,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'time1' :  time1,
							'time2' :  time2,
							'addressID' :addressID,
							'act'    :  'getCart'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
			});

	}

	

    /*
	function getPrintId(yunprint){
		var yunprint=$('#yunprint').val();
		$.post("../../do/do.ajax.php",{
		   'yunprint' : yunprint
		},function(data,textStatus){
			   alert(data);
		   $("did").html(data);
		 })
		alert('234');	
	}

	function getPrintContent(dtuId){
		var dtuId=$('#yunprint').val();
		$.post("../../do/do.ajax.php",{
		   'dtuId' : dtuId
		},function(data,textStatus){
		   $("#result").html(data);
		 })
		alert('234');	
	}
    */

	function delCart_new(id,shopID,fid,spotID){
		var addressID='';
		var circleID=$('#circleID').val();
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		if ($("#spotID").length>0)
		{
			var spotID=$('#spotID').val();
			addressID=$('#addressID').val();
		}
		
		$.post("userorder.ajax.php", { 
			'id'     :  id,
			'shopID' :  shopID,
			'rnd' :  10*Math.random(),
			'act'    :  'delCart'
			}, function (data, textStatus){
				
				//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  fid,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'time1' :  time1,
							'time2' :  time2,
							'addressID' :addressID,
							'act'    :  'getCart_new'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
			});

	}
	function checkout(total,shopID){
		 var shop=$("#shopID").val();
		 var uid=$("#uid").val();
		
		 //$("input:radio[name='addressList']:checked").trigger('click');
		 var sendfree=$("#send_fee").val();
		 //检查是否在营业时间之内
		 $.post("userorder.ajax.php", { 
					
					'act'    :  'checkOpen'
					}, function (data, textStatus){
						if (data=="N")//表示预约
						{
							TINY.box.show('亲爱的用户，目前已经过了餐厅的营业时间，我们会尽快延长网站服务时间。您可以点（继续）来提交预约订单，非常感谢您的使用<p style="margin-top:5px;"><img src="images/button/continue.jpg" onClick="continue_buy()" style="cursor:pointer;"/></p>',0,297,163,0,10);
							return false;
						}else{
						
							if (total=='')
							 {
								 TINY.box.show_spot('您还没有添加餐品。',0,297,163,0,10);
								return false;
							 }
							var spot=$('#spotID').val();
							var a_id=$('#addressID').val();
							/*
							if (spot!='')
							{
								if (total<sendfree)
								{
									TINY.box.show_spot('您的订单不够起送金额，请酌情增加或更换餐厅。',0,297,163,0,10);
									return false;
								}
							}
							
							*/
							$("#cartForm").submit();
						}
						
		});
		
			
		
		 

	}

	function continue_buy(){
		if ($("#time2 :selected").text()=='')
		{
			TINY.box.show_spot('请选择预订时间。',0,297,163,0,10);
			return false;
		}else{
			$("#cartForm").submit();
		}
	}

	function addCart(shopID,foodID,spotID,circleID){
		//检查是否是送餐时间
		var str='';
		var name=$('#foodName'+foodID).val();
		var price=$('#foodPrice'+foodID).val();
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		 $.post("userorder.ajax.php", { 
			'shopID' :  shopID,
			'foodID' :  foodID,
			'spotID' :  spotID,
			'circleID' :  circleID,
			'time1' :  time1,
			'time2' :  time2,
			'name' :  name,
			'price' :  price,
			'act' :  "getTags"
			}, function (data, textStatus){
				TINY.box.show_cart(data,0,487,297,0,0);
				//$("#cart_needs").html(data);
					    
		});
		/*
		str+= "<div id=\"container\">";
		
			str+= "	<div id='newCartBox'>";
			str+= "		<div id='c_table'>";
			str+= "			<table border='0' width='455'>";
			str+= "				<tr>";
			str+= "					<td class='menu first td' width='195'>菜名</td>";
			str+= "					<td class='menu' >价格</td>";
			str+= "				</tr>";
			str+= "				<tr>";
			str+= "					<td class='main first td'>"+name+"</td>";
			str+= "					<td class='main'>"+price+"</td>";
			str+= "				</tr>";
			str+= "			</table>";
			str+= "		</div>";
			str+= "<div id=\"cart_needs\"><span class='span span_need'>口味需求：</span><input type=\"checkbox\" id='styleNeeds1' onClick='addContent(1)' value='主食加量' class='styleCheck'/> <span class='span mainfood'>主食加量</span> <input type=\"checkbox\" id='styleNeeds2' onClick='addContent(2)' value='加辣' class='styleCheck styleCheck2' /> <span class='span span2'>加辣</span> <input type=\"checkbox\" id='styleNeeds3' value='加醋' class='styleCheck styleCheck3' onClick='addContent(3)'/> <span class='span span3'>加醋</span> <input type=\"checkbox\" id='styleNeeds4' value='不加香菜' onClick='addContent(4)' class='styleCheck styleCheck4'/> <span class='span span4'>不加香菜</span></div>";
			str+= "		<p class='cart_prompt'>对于此餐品的备注：</p>";
			str+= "		<p class='cart_intro'><textarea id=\"cart_desc\" class='cart_input'></textarea></p>";
			str+= "		<p class='submit_cart'><img src=\"images/button/addCart1.jpg\" onmouseout=\"checkbg1()\" onmouseover=\"checkbg2()\" mousedown='checkbg3()' id=\"addCartF\"  alt=\"\" style='cursor:pointer;' onClick=\"addCart_t("+shopID+","+foodID+","+spotID+","+circleID+",'"+time1+"','"+time2+"')\"/><span><a href='javascript:void();' onClick=\"closeFlow()\">回到餐厅界面</a></span></p>";
			str+= "	</div>";*/
			TINY.box.show_cart(str,0,487,297,0,0);
	}

	function checkbg1(){
		$("#addCartF").attr('src','images/button/addCart2.jpg');
	}
	function checkbg2(){
		$("#addCartF").attr('src','images/button/addCart1.jpg');
	}
	function checkbg3(){
		$("#addCartF").attr('src','images/button/addCart3.jpg');
	}

	function addContent(id){
		var value=document.getElementById("styleNeeds"+id).value;
		var content=document.getElementById('cart_desc').innerHTML;
		var com=" ";
		if (content=='')
		{
			com='';
		}
		if (document.getElementById("styleNeeds"+id).checked==true){
			document.getElementById('cart_desc').innerHTML=content+com+value;
		}else{
			content=content.replace(value,'');
			document.getElementById('cart_desc').innerHTML=content;
		}
	}

	function addCart_t(shopID,foodID,spotID,circleID,time1,time2){
		//检查是否是送餐时间
		var addressID='';
		if ($("#spotID").length>0)
		{
			var spotID=$('#spotID').val();
			addressID=$('#addressID').val();
		}
		
		var desc=$('#cart_desc').val();
		/*
		$.post("userorder.ajax.php", { 
			'shopID'     :  shopID,
			'foodID' :  foodID,
			'act'    :  'checkTime'
			}, function (data, textStatus){
				
				if (data=="S")
				{
					*/
					//添加购物车
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'desc'   :  desc,
					'addressID' :addressID,
					'act'    :  'addCart'
					}, function (data1, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'addressID' :addressID,
							'time1'     :time1,
							'time2'     :time2,
							'act'    :  'getCart'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
			/*	}else{
					//提示
					$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'act'    :  'getOpen'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
				} */
				$('#tinymask').hide();
				$('#tinybox').hide();
				
			//});
	}
		//直接加入购物车
	function addCart_im(shopID,foodID,spotID,circleID){
		//检查是否是送餐时间
		var addressID='';
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		if ($("#spotID").length>0)
		{
			var spotID=$('#spotID').val();
			
		}
		
		var desc='';
		
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'desc'   :  desc,
					'addressID' :addressID,
					'act'    :  'addCart'
					}, function (data1, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'addressID' :addressID,
							'time1'     :time1,
							'time2'     :time2,
							'act'    :  'getCart'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
			
				
	}

	function addCart_c(shopID,foodID){
		//检查是否是送餐时间
		var desc='';
		var spotID='';
		var circleID=$('#circleID').val();
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		var addressID='';
		if ($("#spotID").length>0)
		{
			spotID=$('#spotID').val();
			addressID=$('#addressID').val();
		}
		/*
		$.post("userorder.ajax.php", { 
			'shopID'     :  shopID,
			'foodID' :  foodID,
			'act'    :  'checkTime'
			}, function (data, textStatus){
				if (data=="S")
				{ */
					//添加购物车
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'desc'   :  desc,
					'act'    :  'addCart'
					}, function (data, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'time1'     :time1,
							'time2'     :time2,
							'addressID' : addressID,
							'act'    :  'getCart'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
				/*}else{
					//提示
					$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'act'    :  'getOpen'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
				} */
				$('#tinymask').hide();
				$('#tinybox').hide();
				
			//});
	}

	function closeFlow(){
		$('#tinymask').hide();
		$('#tinybox').hide();
	}


	function foodList(shop,foodType,label,spot,l,circle){
		$.post("userorder.ajax.php", { 
			'shop'     :  shop,
			'type'     :  foodType,
			'label'     :  label,
			'spot'     :  spot,
			'circle'     :  circle,
			'logo'     :l,
			'act'    :   'foodList'
			}, function (data, textStatus){
				$("#foodBox").html(data);
		});
	
	}
	function foodList_new(shop,foodType,label,spot,l,circle){
		$.post("userorder.ajax.php", { 
			'shop'     :  shop,
			'type'     :  foodType,
			'label'     :  label,
			'spot'     :  spot,
			'circle'     :  circle,
			'logo'     :l,
			'act'    :   'foodList_new'
			}, function (data, textStatus){
				$("#foodBox").html(data);
		});
	
	}

	function subtractCart(shopID,foodID){
					var spotID='';
					var circleID=$('#circleID').val();
					var time1=$('#time1').val();
					var time2=$('#time2').val();
					var addressID='';
					if ($("#spotID").length>0)
					{
						spotID=$('#spotID').val();
						addressID=$('#addressID').val();
					}
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'act'    :  'updateCart'
					}, function (data, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'addressID' :addressID,
							'time1'     :time1,
							'time2'     :time2,
							'act'    :  'getCart'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
	}

	

	$(function(){				
			$(".addCart_button").hover(function(){
							 $(this).attr('src','images/button/addCart_1.gif');
					 },function(){
							 $(this).attr('src','images/button/addCart.gif');
			});
			$(".addCart_button").mousedown(function(){
			  $(this).attr('src','images/button/addCart_2.gif');
			  
			});
		})

		$(function(){				
			$("#send_button").hover(function(){
							 $(this).attr('src','images/button/send_1.gif');
					 },function(){
							 $(this).attr('src','images/button/send.gif');
			});
			$("#send_button").mousedown(function(){
			  $(this).attr('src','images/button/send_2.gif');
			  
			});
		})
		$(function(){				
			$("#send_button_44").hover(function(){
							 $(this).attr('src','images/button/submit_2_1.jpg');
					 },function(){
							 $(this).attr('src','images/button/submit_2_0.jpg');
			});
			$("#send_button_44").mousedown(function(){
			  $(this).attr('src','images/button/submit_2_1.jpg');
			  
			});
		})
		$(function(){				
			$(".subtractImg").hover(function(){
							 $(this).attr('src','images/cut_1.jpg');
					 },function(){
							 $(this).attr('src','images/cut.jpg');
			});
			$(".subtractImg").mousedown(function(){
			  $(this).attr('src','images/cut_1.jpg');
			  
			});
		})
		$(function(){				
			$(".addImg").hover(function(){
				
							$(this).attr('src','images/add_1.jpg');
					 },function(){
							 $(this).attr('src','images/add.jpg');
			});
			$(".addImg").mousedown(function(){
			  $(this).attr('src','images/add_1.jpg');
			  
			});
		})

		$(function(){				
									$(".delImg").hover(function(){
										$(this).attr('src','images/del_1.gif');
									 },function(){
										$(this).attr('src','images/del.gif');
								});
								$(".delImg").mousedown(function(){
									 $(this).attr('src','images/del_1.gif');
									  
								});
						})

	function showAddressCart(){
		$('#addressShow').css('display',"inline-block");
	}
	$(function(){
	   $("#area1").change(function(){
		   var area=$("#area1").val();
			$.post("area.ajax.php", { 
						'area_id' :  area,
							'act':'circle'
					}, function (data, textStatus){
							if (data==""){
								$("#circle1").html("<option value=''>没有商圈</option>")
							}else
								$("#circle1").html("<option value=''>请选择</option>"+data);
					});
	   })
	})

	 $(function(){
	   $("#circle1").change(function(){
		   var circle=$("#circle1").val();
			$.post("area.ajax.php", { 
						'circle_id' :  circle,
						'act':'spot'
					}, function (data, textStatus){
							if (data==""){
								$("#spot1").html("<option value=''>没有地标</option>")
							}else
								$("#spot1").html("<option value=''>请选择</option>"+data);
						
					});
	   })
	})

		   $(function(){
	   $("#spot1").change(function(){
		   var spot=$("#spot1").val();
		   var shop=$("#shopID").val();
		    var circle=$("#circle1").val();
			$.post("userorder.ajax.php", { 
						'spot' :  spot,
						'shop'  : shop,
						'act':'getFee'
					}, function (data, textStatus){
						
							var rs;
							rs=data.split('|');
							if (rs[0]=="N"){
								$("#selever").hide();
								$("#selever2").hide();
								TINY.box.show_spot('亲，您选择的地址不在此餐厅派 送范围内。查看可如约送达的餐 厅，请点击<a href="spot.php?spotID='+spot+'&circleID='+circle+'">这里</a>。',0,297,163,0,0);
							}else{
								$("#selever").show();
								$("#selever2").show();
								$("#deliverfee").html(rs[1]);
								$("#totalAll").html(rs[2]);
								$("#sendfee").html(rs[4]);
								$("#spotID").val(spot);
								$("#send_fee").val(rs[6]);
								
							}
						
					});
	   })
	})

 function addAddress_cart(){
		var phone=$("#phone").val();
		var name=$("#name").val();
		var area=$("#area1").val();
		var circle1=$("#circle1").val();
		var spot=$("#spot1").val();
		var address=$("#address").val();
		if (circle1==''){
			TINY.box.show_spot('商圈不能为空',0,160,60,0,10);
			return false;
		}
		if (spot==''){
			TINY.box.show_spot('地标不能为空',0,160,60,0,10);
			return false;
		}
		if (address==''){
			TINY.box.show_spot('地址不能为空',0,160,60,0,10);
			return false;
		}
		$.post("userorder.ajax.php", { 
							'phone'   :  phone,
							'name'    :  name,
							'area'    :  area,
							'circle'  :  circle1,
							'spot'    :  spot,
							'address' :  address,
							'act'     :  'addAddress'
							}, function (data, textStatus){
							var post = data;
							if (data=='E')

								alert('添加失败！');
							else{
								var st=data.split('||||');
								$("#addressAll").html(st[0]);
								$('#addressID').val(st[1]);
								$('#spotID').val(spot);
								$('#defaultAddress1').html(st[2]);
								showAddressCart();
							}
							
		});
	}

//单击添加新地址时显示添加表单
$(function(){
		 $("input:radio[name='addressList']").click(function(){
			  var shop=$("#shopID").val();
			 var $parent=$(this).parent();
			 var a_id=this.value;
				$.post("userorder.ajax.php", { 
					'address' :  this.value,
					'shopID'  : shop,
					'act':  'getSpotByADD'			
					},function(data, textStatus){
						var rs;
							rs=data.split('|');
							if (rs[0]=="N"){
								$("#selever").hide();
								$("#selever2").hide();
								TINY.box.show_spot('亲，您选择的地址不在此餐厅派 送范围内。查看可如约送达的餐 厅，请点击<a href="spot.php?spotID='+rs[2]+'&circleID='+rs[1]+'">这里</a>',0,297,163,0,0);
								return false;
							}else{
								$("#selever").show();
								$("#selever2").show();
								$("#deliverfee").html(rs[1]);
								$("#totalAll").html(rs[2]);
								$("#sendfee").html(rs[4]);
								$("#spotID").val(rs[5]);
								$("#send_fee").val(rs[6]);
								$('#addressID').val(a_id);
								$.post("userorder.ajax.php", { 
									'address_id' :  a_id,
									'act':'getAddress'
								}, function (data, textStatus){
										$('#defaultAddress1').html(data);
									
								});
								
							}
					}
				);
				//location.reload();
			

					
		 });
});

$(function(){
	   $("#time1").change(function(){
		   var time=$("#time1").val();
		   var shop=$("#shopID").val();
		   $.post("userorder.ajax.php", { 
							'time'   :  time,
							'shop'   :  shop,
							'act'     :  'getYTime'
							}, function (data, textStatus){
							$('#time2').html(data);
							
		});
			
	   })
	})
	$(function(){				
			$("#send_button_n").hover(function(){
							 $(this).attr('src','images/button/sendNew_1.jpg');
					 },function(){
							 $(this).attr('src','images/button/sendNew.jpg');
			});
			$("#send_button_n").mousedown(function(){
			  $(this).attr('src','images/button/sendNew.jpg');
			  
			});
		})

//添加评论
function addComment(uid,shopID){
	var content=$("#commentInput").val();
	if (uid=='')
	{
		TINY.box.show('<a href="userlogin.php">请您先登录</a>',0,359,197,0);
		return false;
	}
	if (content=='')
	{
		TINY.box.show('评论内容不能为空',0,359,197,0);
		return false;
	}
	$.post("userorder.ajax.php", { 
		'shopid'   :  shopID,
		'uid'   :  uid,
		'content'   :  content,
		'act'  :  'addComment'
		}, function (data, textStatus){
			if (data=="N")
			{
				TINY.box.show('<a href="userlogin.php">请您先登录</a>',0,359,197,0);
				return false;
			}else if (data=="E")
			{
				TINY.box.show('<a href="userlogin.php">意外出错</a>',0,359,197,0);
				return false;
			}else if (data=="C")
			{
				TINY.box.show('评论内容不能为空',0,359,197,0);
				return false;
			}else{
				$("#comment").html(data);
				$("#commentInput").val('');

			//TINY.box.show("亲，感谢您的评论，系统正在审核中...<a href='javascript:void();' onClick='closeFlow()'>关闭</a>",0,359,197,0);
			TINY.box.show("亲，感谢您的评论！<a href='javascript:void();' onClick='closeFlow()'>关闭</a>",0,359,197,0);
			}
													
	});

}

function getComPageData(page){
	
		 var shopID = $("#shop_id").val();
		 $.post("userorder.ajax.php", { 
			'shop' :  shopID,
			'act' :  "getCommentList",
			'page'  :  page
			}, function (data, textStatus){
				$("#comment").html(data);
					    
		});
	}

	//新的购物车
	function addCart_new(shopID,foodID,spotID,circleID){		
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		//检查是否是送餐时间
		var str='';
		var name=$('#foodName'+foodID).val();
		var price=$('#foodPrice'+foodID).val();
		 $.post("userorder.ajax.php", { 
			'shopID' :  shopID,
			'foodID' :  foodID,
			'spotID' :  spotID,
			'circleID' :  circleID,
			'time1' :  time1,
			'time2' :  time2,
			'name' :  name,
			'price' :  price,
			'act' :  "getTag"
			}, function (data, textStatus){
				TINY.box.show_cart(data,0,487,297,0,0);
				//$("#cart_needs").html(data);
					    
		});
	}
	/*
	function addCart_new(shopID,foodID,spotID,circleID){
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		//检查是否是送餐时间
		var str='';
		var name=$('#foodName'+foodID).val();
		var price=$('#foodPrice'+foodID).val();
		str+= "<div id=\"container\">";
		
			str+= "	<div id='newCartBox'>";
			str+= "		<div id='c_table'>";
			str+= "			<table border='0' width='455'>";
			str+= "				<tr>";
			str+= "					<td class='menu first td' width='195'>菜名</td>";
			str+= "					<td class='menu' >价格</td>";
			str+= "				</tr>";
			str+= "				<tr>";
			str+= "					<td class='main first td'>"+name+"</td>";
			str+= "					<td class='main'>"+price+"</td>";
			str+= "				</tr>";
			str+= "			</table>";
			str+= "		</div>";
			str+= "<div id=\"cart_needs\"><span class='span span_need'>口味需求：</span><input type=\"checkbox\" id='styleNeeds1' onClick='addContent(1)' value='主食加量' class='styleCheck'/> <span class='span mainfood'>主食加量</span> <input type=\"checkbox\" id='styleNeeds2' onClick='addContent(2)' value='加辣' class='styleCheck styleCheck2' /> <span class='span span2'>加辣</span> <input type=\"checkbox\" id='styleNeeds3' value='加醋' class='styleCheck styleCheck3' onClick='addContent(3)'/> <span class='span span3'>加醋</span> <input type=\"checkbox\" id='styleNeeds4' value='不加香菜' onClick='addContent(4)' class='styleCheck styleCheck4'/> <span class='span span4'>不加香菜</span></div>";
			str+= "		<p class='cart_prompt'>对于此餐品的备注：</p>";
			str+= "		<p class='cart_intro'><textarea id=\"cart_desc\" class='cart_input'></textarea></p>";
			str+= "		<p class='submit_cart'><img src=\"images/button/addCart1.jpg\" onmouseout=\"checkbg1()\" onmouseover=\"checkbg2()\" mousedown='checkbg3()' id=\"addCartF\"  alt=\"\" style='cursor:pointer;' onClick=\"addCart_t_new("+shopID+","+foodID+","+spotID+","+circleID+",'"+time1+"','"+time2+"')\"/><span><a href='javascript:void();' onClick=\"closeFlow()\">回到餐厅界面</a></span></p>";
			str+= "	</div>";
			TINY.box.show_cart(str,0,487,297,0,0);
	}*/

	function addCart_t_new(shopID,foodID,spotID,circleID,time1,time2){
		//检查是否是送餐时间
		var addressID='';
		
		if ($("#spotID").length>0)
		{
			var spotID=$('#spotID').val();
			addressID=$('#addressID').val();
		}
		
		var desc=$('#cart_desc').val();
		/*
		$.post("userorder.ajax.php", { 
			'shopID'     :  shopID,
			'foodID' :  foodID,
			'act'    :  'checkTime'
			}, function (data, textStatus){
				
				if (data=="S")
				{  */
					//添加购物车
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'desc'   :  desc,
					'addressID' :addressID,
					'act'    :  'addCart'
					}, function (data1, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'time1' :  time1,
							'time2' :  time2,
							'circleID' :  circleID,
							'addressID' :addressID,
							'act'    :  'getCart_new'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
			/*	}else{
					//提示
					$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'act'    :  'getOpen_new'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
				} */
				$('#tinymask').hide();
				$('#tinybox').hide();
				
			//});
	}

	//立即加入
	function addCart_im_new(shopID,foodID,spotID,circleID){
		//检查是否是送餐时间
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		var addressID='';
		
		if ($("#spotID").length>0)
		{
			var spotID=$('#spotID').val();
			
		}	
		var desc='';
		
					//添加购物车
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'desc'   :  desc,
					'addressID' :addressID,
					'act'    :  'addCart'
					}, function (data1, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'addressID' :addressID,
							'time1' :time1,
							'time2' :time2,
							'act'    :  'getCart_new'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
			
				
	}

	function addCart_c_new(shopID,foodID){
		//检查是否是送餐时间
		var desc='';
		var spotID='';
		var addressID='';
		var circleID=$('#circleID').val();
		var time1=$('#time1').val();
		var time2=$('#time2').val();
		if ($("#spotID").length>0)
		{
			spotID=$('#spotID').val();
			addressID=$('#addressID').val();
		}
		/*
		$.post("userorder.ajax.php", { 
			'shopID'     :  shopID,
			'foodID' :  foodID,
			'act'    :  'checkTime'
			}, function (data, textStatus){
				if (data=="S")
				{ */
					//添加购物车
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'desc'   :  desc,
					'act'    :  'addCart'
					}, function (data, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'circleID' :  circleID,
							'time1' :  time1,
							'time2' :  time2,
							'addressID' : addressID,
							'act'    :  'getCart_new'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
				/*}else{
					//提示
					$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'act'    :  'getOpen_new'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
				} */
				$('#tinymask').hide();
				$('#tinybox').hide();
				
			//});
	}

	function subtractCart_new(shopID,foodID){
					var spotID='';
					var addressID='';
					var time1=$('#time1').val();
					var time2=$('#time2').val();
					var circleID=$('#circleID').val();
					if ($("#spotID").length>0)
					{
						spotID=$('#spotID').val();
						addressID=$('#addressID').val();
					}
					$.post("userorder.ajax.php", { 
					'shopID'     :  shopID,
					'foodID' :  foodID,
					'act'    :  'updateCart'
					}, function (data, textStatus){
						//显示购物车
						$.post("userorder.ajax.php", { 
							'shopID'     :  shopID,
							'foodID' :  foodID,
							'spotID' :  spotID,
							'time1' :  time1,
							'time2' :  time2,
							'circleID' :  circleID,
							'addressID' :addressID,
							'act'    :  'getCart_new'
							}, function (data, textStatus){
								$("#cart_result").html(data);
						});
						
					});
	}
$(document).ready(function(){
  $("#telButton").toggle(function(){
    $(".telBox").show();
	//修改点击数
	var shop=$("#shopID").val();
	$.post("userorder.ajax.php", { 
					'shopID'     :  shop,
					'act'    :  'updateTelClick'
			}, function (data, textStatus){
						//显示购物车
						
	});
	
	},
    function(){
		$(".telBox").hide();}
  );
});
	