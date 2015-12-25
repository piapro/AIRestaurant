/*Tab 选项卡 标签*/
/*
$(function(){
		var $div_li =$("#tab_menu ul li");
		var len=$div_li.length;
		 $div_li.hover(function(){
					var index =  $div_li.index(this); 
					$(this).addClass("select")            
						.siblings().removeClass("select");
					if (index==0)
					{
						$(this).addClass("selectFirst");
					}
					if ((len-1)==index)
					{
						$(this).addClass("selectLast");
					}
					//$("#tab_box >div").eq(index).show()
										//.siblings().hide();
				
										
					
					
			 },function(){
				
					$div_li.removeClass("select");  
					var index =  $div_li.index(this);  
					if (index==0)
					{
						$(this).removeClass("selectFirst");
					}
					if ((len-1)==index)
					{
						$(this).removeClass("selectLast");
					}
					//$("#tab_box >div").hide();
					
					
		 })
})
*/

$(function(){
	var $div_li =$("#tab_menu .tab_li");
	var len=$div_li.length;
  $div_li.hover(function(){
	 var index =  $div_li.index(this); 
					$(this).addClass("select")            
						.siblings().removeClass("select"); 
		if (index==0)
					{
						$(this).addClass("selectFirst");
					}
					if ((len-1)==index)
					{
						$(this).addClass("selectLast");
					}
    $(this).children(".tab_box").show();
  },function(){
			$div_li.removeClass("select"); 
			var index =  $div_li.index(this);  
					if (index==0)
					{
						$(this).removeClass("selectFirst");
					}
					if ((len-1)==index)
					{
						$(this).removeClass("selectLast");
					}
					$(this).children(".tab_box").hide();
  })

  })
$(function(){
	    var $div_li =$("#tab3 ul li");
	    $div_li.click(function(){
            var index =  $div_li.index(this);  
			
			$(this).addClass("selected")           
						.siblings().removeClass("selected");  
			$("#left > div")  	
					.eq(index).show()
					.siblings().hide();
			if (index==1)
			{
				
				$("#left").css('width','686px');
				$("#main_top").addClass('shop_top');
				$('.main_bottom').addClass('main_bottom_shop');
				if ($("#left").hasClass("left_shop"))
				{
					$("#left_shop_new").removeClass('left_shop_new');
					$("#left").removeClass('left_shop_r');
					$("#bottom_img").hide();
				}else{
					$("#left").removeClass('left_r');
					$("#left").css('background','url("images/l_bg.gif") repeat-y right');
					$('.main_bottom').removeClass('main_bottom_shop2');
					$("#right").css('margin-left','18px');
					
				}
			}else{
				
				if ($("#left").hasClass("left_shop"))
				{
					$("#left_shop_new").addClass('left_shop_new');
					$("#left").addClass('left_shop_r');
					$("#bottom_img").show();
				}else{
					$("#left").addClass('left_r');
					$("#left").css('width','695px');
					$("#left").css('background','url("images/l_bg_r.jpg") repeat-y right');
					$("#main_top").removeClass('shop_top');
					$('.main_bottom').removeClass('main_bottom_shop');
					$('.main_bottom').addClass('main_bottom_shop2');
					$("#right").css('margin-left','12px');
					
					
				}
			}
		})
		
})

$(function(){
	    var $div_li =$("#tab4 ul li");
	    $div_li.click(function(){
            var index =  $div_li.index(this);  
			$(this).addClass("selected")           
						.siblings().removeClass("selected");  
			$("#order_right > div")  	
					.eq(index).show()
							.siblings().hide(); 
			
		});
			
})

function auto(){
	var height1=document.documentElement.clientHeight;
	 var main_height=parseFloat($('#main').height(),10);
	 var fooder_margin=parseFloat($('#footer').css("margin-top"),10);
	 var header_height=parseFloat($('#hearderBox').height(),10);
	 var height2=main_height+fooder_margin+header_height+70;
	if (height1>height2){
		
		 $("#footer").addClass("bottom");
	}else{
		 $("#footer").removeClass("bottom");
	}

}






 $(function(){
	var $div_li =$("#index_tab li");
	var len=$div_li.length;
  $div_li.click(function(){
	 var index =  $div_li.index(this); 
					$(this).addClass("select")            
						.siblings().removeClass("select");
						
		if (index=='0')
		{
			$("#tab0").show();
			$("#tab1").hide();
		}
		if (index=='1')
		{
			$("#tab1").show();
			$("#tab0").hide();
		}
  })

  })

  $(function(){
	    var $div_li =$(".shop_box ul li");
	    $div_li.click(function(){
            var index =  $div_li.index(this);
			var sortID=$(this).attr('name');
			var circleID=$("#circleID").val();
			var style=$("#style").val();
			var order1='';
			var order2='';
			$(this).addClass("active")           
						.siblings().removeClass("active");  
			$("#firstClass").val(sortID);
			//得到该分类下的商家信息
			$.post("shop.ajax.php", { 
							'sortID'     :  sortID,
							'circleID' :  circleID,
							'style' :  style,
							'order1' :  order1,
							'order2' :  order2,
							'act'    :  'getShopBySort'
							}, function (data, textStatus){
								var msg=data.split('|||||');
								$("#shopResult").html(msg[0]);
								$("#allShop").html(msg[1]);
						});
			
			
		});
			
})