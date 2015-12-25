 $(function(){
		 $(".listBox").hover(function(){
					var $self = $(this);
					$self.find('h1').addClass("h1_r");
					$self.find('.brand').addClass("brand_r");
					$self.find('.tag').show();
			 },function(){
					var $self = $(this);
					$self.find('h1').removeClass("h1_r");
					$self.find('.brand').removeClass("brand_r");
					$self.find('.tag').hide();
		 })
})