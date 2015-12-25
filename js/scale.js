$(function(){
	var $img=$(".icon img");
		 $img.hover(function(){
					var $self = $(this);
					var index = $img.index(this);	
					$self.attr("src","images/icon/"+index+"_1.gif");
					
			 },function(){
					var $self = $(this);
					var index = $img.index(this);
					$self.attr("src","images/icon/"+index+"_0.gif")
		 })
})