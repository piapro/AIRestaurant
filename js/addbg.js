$(function(){
		 $(".food").hover(function(){
					var $self = $(this);
					$self.find(".click").show();
					$self.find(".intro").addClass(" intro_r");
			 },function(){
					var $self = $(this);
					$self.find(".click").hide();
					$self.find(".intro").removeClass("intro_r");
		 })
})


 $(function(){
		 $(".left_c li").hover(function(){
					var $self = $(this);
					//$self.addClass("active");
					$self.css({"background-color":"#ffdada","color":"#a50003"});
					if ($("#left").hasClass("left_shop")){
						$('.left_c_new li:odd').addClass('li_r_r');
						
						
					}
					$self.css("z-index",'900');
					$self.find(".flowdd").show();
			 },function(){
					var $self = $(this);
					//$self.removeClass("active");
					$self.css({"background-color":"","color":"#3d3d3d"});
					$self.find(".flowdd").hide();
					if ($("#left").hasClass("left_shop")){
						//$('.left_c_new li:odd').addClass('li_r_r');
						
					}
					$self.css("z-index",'600');
		 })
})



$(function(){
		 $(".left_l li").click(function(){
					var $self = $(this);
					
					$self.not(".img").addClass("active");
					$self.siblings().removeClass("active");
					
			 })
})




$(function(){
		 $(".tag .click").hover(function(){
					 $(this).attr('src','images/button/click_0.jpg');
			 },function(){
					 $(this).attr('src','images/button/click_index.jpg');
		 })
})
 $(function(){
		 $("#header #reg").hover(function(){
					 $("#header #hide").show();
			 },function(){
					 $("#header #hide").hide();
		 })
})
$(function(){
		 $(".help").hover(function(){
					 $("#help").show();
			 },function(){
					 $("#help").hide();
		 })
})

 $(function(){
		 $("#header #top_user").hover(function(){
					 $("#header #user_select").show();
					 $("#icon").attr("src","images/up.gif");
			 },function(){
					 $("#header #user_select").hide();
					 $("#icon").attr("src","images/down.jpg");
		 })
})

$(function(){
		 $("#header #sina").hover(function(){
					 $("#header #sinaLogin").show();
			 },function(){
					 $("#header #sinaLogin").hide();
		 })
})

$(function(){
		 $(".s_pot_box").hover(function(){
					var $self = $(this);
					$(this).addClass("s_pot_box_r");
					//$(this).find('.address').show();
			 },function(){
					$(this).removeClass("s_pot_box_r");
					//$(this).find('.address').hide();
		 })
})

			 $(function(){
$(".s_pot_box_dd").hover(function(){
					var $self = $(this);
					$(this).addClass("brand_r");
					//$(this).find('.address').show();
			 },function(){
					$(this).removeClass("brand_r");
					//$(this).find('.address').hide();
		 })
})


 $(function(){
		 $("#index_header #reg").hover(function(){
					 $("#index_header #hide").show();
			 },function(){
					 $("#index_header #hide").hide();
		 })
})

 $(function(){
		 $("#index_header #top_user").hover(function(){
					 $("#index_header #user_select").show();
					 $("#icon").attr("src","images/up1.gif");
			 },function(){
					 $("#index_header #user_select").hide();
					 $("#icon").attr("src","images/down.gif");
		 })
})
 $(function(){
		 $("#header.white_header #top_user").hover(function(){
					 $("#index_header #user_select").show();
					 $("#icon").attr("src","images/up1.gif");
			 },function(){
					 $("#index_header #user_select").hide();
					 $("#icon").attr("src","images/down.gif");
		 })
})

$(function(){
		 $("#index_header #sina").hover(function(){
					 $("#index_header #sinaLogin").show();
			 },function(){
					 $("#index_header #sinaLogin").hide();
		 })
})
//新shop页
 $(function(){
		 $("#f_center li").hover(function(){
					var $self = $(this);
					//$self.addClass("active");
					$self.css({"background-color":"#ffdada","color":"#a50003"});
					$self.css("z-index",'900');
					$self.find(".flowdd").show();
			 },function(){
					var $self = $(this);
					//$self.removeClass("active");
					$self.css({"background-color":"","color":"#3d3d3d"});
					$self.find(".flowdd").hide();
					$self.css("z-index",'600');
		 })
})



$(function(){
		 $("#f_left li").click(function(){
					var $self = $(this);
					
					$self.not(".img").addClass("active");
					$self.siblings().removeClass("active");
					
			 })
})
$(function(){	
	$(".classBox li").mousedown(function(){
		
			  $(this).addClass("first")
				  .siblings().removeClass("first");  
			
		})
})



