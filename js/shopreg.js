$(document).ready(function(){
	   $(".input").blur(function(){
			 var $parent = $(this).parent();
			
			  if( $(this).is('#account') ){
					if( this.value==""){
					    var errorMsg = '用户名不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
			 }

			  if( $(this).is('#account1') ){
					if( this.value==""){
					    var errorMsg = '帐号不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
			 }
			
			 if( $(this).is('#phone') ){
					if( this.value=="" || this.value.length < 11 ||  this.value.length > 11){
					    var errorMsg = '请输入正确的手机号.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
			 }
			  if( $(this).is('#email') ){
				 if (this.value!=''){
					if( this.value!="" && !/.+@.+\.[a-zA-Z]{2,4}$/.test(this.value) ){
						  var errorMsg = "请输入正确的E-Mail地址.";
						  $parent.find('.red').text(errorMsg);
						  $parent.find('.red').addClass('onError')
					}else{
						  var okMsg = "输入正确";
						 $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
				 }
			 }
			  if( $(this).is('#pw') ){
					if( this.value==""){
					    var errorMsg = '密码不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else if (this.value.length < 6){
						var errorMsg = '密码不能小于6位.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
			 }
			
			  if( $(this).is('#pw1') ){
					if( this.value==""){
					    var errorMsg = '密码不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else if (this.value.length < 6){
						var errorMsg = '密码6位以上.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else{
					    var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
			 }

			 if( $(this).is('#repw') ){
					if( this.value==""){
					    var errorMsg = '确认密码不能为空.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else if ($('#pw').val()!=this.value){
					
					     var errorMsg = '两次输入的密码不同.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
						
					}else{
						var okMsg = '输入正确.';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
			 }

			 if( $(this).is('#imgcode') ){
					if( this.value==""){
					    var errorMsg = '请输入验证码.';
                        $parent.find('.red').text(errorMsg);
						$parent.find('.red').addClass('onError')
					}else{
					    var okMsg = '';
					     $parent.find('.red').text(okMsg);
						 $parent.find('.red').removeClass('onError')
					}
			 }
		}).keyup(function(){
		   $(this).triggerHandler("blur");
		}).focus(function(){
	  	   $(this).triggerHandler("blur");
		});//end blur

		
	});

	function checkReg(){
		$(".input").trigger('blur');
		var numError = $('.onError').length;
		if(numError){
			return false;
		} 
	}

	