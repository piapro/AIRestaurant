/*模块展开和关闭*/
$(function(){
		 $(".module_up_down").toggle(function(){
					var $self = $(this);
					$self.attr("src","images/down.jpg");
					//$self.parent().next().find("li:eq(0) a").css("color","#bf0101");
					$self.next().find("li:gt(9)").slideToggle(600);
			 },function(){
					var $self = $(this);
					$self.attr("src","images/up.jpg");
					//$self.parent().next().find("li:eq(0) a").css("color","#bf0101");
					$self.next().find("li:gt(9)").slideToggle(600);
		 })
})

 /*首页广告效果*/
$(function(){
     var len  = $(".box_ad .num > li").length;
	 var index = 0;
	 var adTimer;
	 
	 $(".num li").mouseover(function(){
		index  =   $(".box_ad .num li").index(this);
		showImg(index);
	 }).eq(0).mouseover();	
	
	 //滑入 停止动画，滑出开始动画.
	 $('.box_ad').hover(function(){
			 clearInterval(adTimer);
		 },function(){
			 adTimer = setInterval(function(){
			    showImg(index)
				index++;
				if(index==len){index=0;}
			  } , 3000);
	 }).trigger("mouseleave");
})
// 通过控制top ，来显示不同的幻灯片
function showImg(index){
        var adHeight = $(".box_ad").height();
		$(".box_ad .slider").stop(true,false).animate({top : -adHeight*index},1000);
		$(".box_ad .num li").removeClass("active")
			.eq(index).addClass("active");
}

			