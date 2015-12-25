/*产品树展开和关闭*/

$(function(){
	   $("#shopLeft li > span").click(function(){ 
			    var $ul = $(this).siblings("ul");
				if($ul.is(":visible")){
					$(this).parent().addClass("m-collapsed");
					$ul.hide();
					//$("#openli").css("background","url('../images/take_up.gif') no-repeat 0 3%");
				}else{
					$(this).parent().removeClass("m-collapsed");
					$ul.show();
					//$("#openli").css("background","url('../images/open.gif') no-repeat 0 3%");
				}
				return false;
	   })
})