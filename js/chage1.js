 $(function(){
		 $(".brand").hover(function(){
					var $self = $(this);
					$self.addClass("brand_r");
					
					$self.find('.tag').css('display','block');
			 },function(){
					var $self = $(this);
					$self.removeClass("brand_r");
					$self.find('.tag').css('display','none');
		 })
})