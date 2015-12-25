$(document).ready(function(){
	    $(".input").blur(function(){
			 var $parent = $(this).parent();
			 if( $(this).is('#phone') ){
					if( this.value=="" || this.value.length < 11 ||  this.value.length > 11){
					    var errorMsg = '请输入正确的手机号.';
                        $parent.find('.errormt').text(errorMsg);
						$parent.find('.errormt').addClass('onError');
					}else{
					    var name=$("#phone").val();
							var reg=/^1[358]\d{9}$/;
						 if(name.match(reg)){
							var okMsg = "<img src='images/ok.gif' />";
							 $parent.find('.errormt').html(okMsg);
							 $parent.find('.errormt').removeClass('onError');
						 }else{
							  var errorMsg = '格式不正确.';
								$parent.find('.errormt').text(errorMsg);
								$parent.find('.errormt').addClass('onError')
						}
						
					}
			 }
			 
			  if( $(this).is('#phone1') ){
					$('#sendCode').html("<label>&nbsp;</label> <a href=\"javascript:void();\" onClick=\"sendcode()\"><img src=\"images/button/getcode.gif\" alt=\"\" style='cursor:pointer;'/></a>");
					if( this.value==""){
					    var errorMsg = '手机号不能为空.';
                        $parent.find('.errormt').text(errorMsg);
						$parent.find('.errormt').addClass('onError');
						$('#sendCode').html("<label>&nbsp;</label> <img src=\"images/button/getcode.gif\" alt=\"\" style='cursor:pointer;'/>");
						return false;
					}else{
					   var name=$("#phone1").val();
						var reg=/^1[358]\d{9}$/;
						 if(name.match(reg)){
							 $.get("userpw_do.php", { 
							'act'   :  "check",
							'phone' :  $('#phone1').val()
							}, function (data, textStatus){
									if (data=="S")
									{
										var okMsg = "<img src='images/ok.gif' />";
										 $parent.find('.errormt').html(okMsg);
										 $parent.find('.errormt').removeClass('onError');
										return true;
									}else{
										 var errorMsg = '手机号不存在';
										$('#phoneTip').text(errorMsg);
										$('#phoneTip').addClass('onError');
										return false;
									}
							});
						 }else{
							  var errorMsg = '手机号格式不正确.';
								$parent.find('.errormt').text(errorMsg);
								$parent.find('.errormt').addClass('onError');
								$('#sendCode').html("<label>&nbsp;</label> <img src=\"images/button/getcode.gif\" alt=\"\" style='cursor:pointer;'/>");
								return false;
						}
						
					}
			 }
			 
		});//end blur
		
	});
	 function check(){
			$(".input").trigger('blur');	
			var numError = $('.onError').length;
			if(numError){
				return false;
			} 
	 }

	  function checkPWD(){
			if ($('#pw').val()==''){
				alert('新密码不能为空');
				$('#pw').focus();
				return false;
			}
			if ($('#repw').val()==''){
				alert('确认密码不能为空');
				$('#repw').focus();
				return false;
			}
			if ($('#pw').val()!=$('#repw').val())
			{
				alert('两次输入的密码不相同');
				return false;
			}
	  }

	 function sendcode(){
		 $(".input").trigger('blur');
		var numError = $('.onError').length;
		if(numError){
			return false;
		}else{
			$("#codeTip").css('display','block');
			 $.get("userpw_do.php", { 
							'act'   :  "send",
							'phone' :  $('#phone1').val()
							}, function (data, textStatus){
									if (data=="S"){
									//成功
									}	
									
			 });
		 }
	 }


	