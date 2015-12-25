$(document).ready(function(){
	    $(".input").blur(function(){
			 var $parent = $(this).parent();
			 $("#insert").val('1');
			 $parent.find("span").remove();
			 if( $(this).is('#phone') ){
					
					if( this.value=="" || this.value.length < 11 ||  this.value.length > 11){
						$("#movediv").remove();
					    var errorMsg = "请输入正确的手机号.";
                        $parent.append("<span class='red onError'>"+errorMsg+"</span>");
					}else{

						//
							var name=$("#phone").val();
							var reg=/^1[358]\d{9}$/;
						 if(name.match(reg)){
							var okMsg = "<span><img src='images/ok.gif' /></span>";
							$.post("userorder.ajax.php", { 
								'phone' :  this.value,
									'act':'checkPhone'
							}, function (data, textStatus){
									if (data=="Y"){
										if (!$parent.next().hasClass('movediv')){
										$('<div class="contact contact_r movediv" id="movediv"><label>您的密码：</label><input type="password" id="password" name="password" class="input" /> <span>请输入密码</span>&nbsp;&nbsp;<span><a href="userpw.php">忘记密码？</a></span></div>').insertAfter($parent);
										}
										//$parent.append('<div class="contact contact_r" ><label>您的密码：</label><input type="password" id="password" name="password" class="input" /> <span>请输入密码</span></div>');
										$parent.append("<img src='images/point_l.jpg' class='point' /><span class='bg'>您的手机之前已注册<?php echo $SHOP_NAME?>网，请在下面的密码框里输入密码。</span>");
										
									}else{
										$parent.find("img").remove();
										$("#movediv").remove();
										$parent.append(okMsg);

									}
							});
						 }else{
							 $("#movediv").remove();
							  $parent.find("img").remove();
							  var errorMsg = '格式不正确.';
								 $parent.append("<span class='red onError'>"+errorMsg+"</span>");
						}
						//
					    
						
					}
			 }
			  if( $(this).is('#name') ){
					if( this.value==""){
					    var errorMsg = "<span class='red onError'>姓名不能为空.</span>";
						$parent.append(errorMsg);
					}else{
					   var name=$("#name").val();
							var reg=/^[\u0391-\uFFE5]+$/;
						 if(name.match(reg)){

							  if (this.value.length>4){
								 var errorMsg = "<span class='red onError'>不能超过4个中文.</span>";
									$parent.append(errorMsg);
									
							  }else{
								 var okMsg = "<span><img src='images/ok.gif' /></span>";
								 $parent.append(okMsg);
								
							}
						
						 }else{
							 var errorMsg = "<span class='red onError'>姓名只能是中文.</span>";
								$parent.append(errorMsg);
						 }
					}
			 }
			  if( $(this).is('#address') ){
					if( this.value==""){
					    var errorMsg = "<span class='red onError'>地址不能为空.</span>";
                        $parent.append(errorMsg);
					}else{
					   var okMsg = "<span><img src='images/ok.gif' /></span>";
					    $parent.append(okMsg);
					}
			 }

			 if( $(this).is('#phone1') ){
					if( this.value=="" || this.value.length < 11 ||  this.value.length > 11){
						
					    var errorMsg = "请输入正确的手机号.";
                        $parent.append("<span class='red onError'>"+errorMsg+"</span>");
					}else{
						var name=$("#phone1").val();
							var reg=/^1[358]\d{9}$/;
						 if(name.match(reg)){
							var okMsg = "<span><img src='images/ok.gif' /></span>";
							$parent.append(okMsg);
						 }else{
							  var errorMsg = '格式不正确.';
								 $parent.append("<span class='red onError'>"+errorMsg+"</span>");
						}
						
					}
			 }
			  if( $(this).is('#name1') ){
					if( this.value==""){
					    var errorMsg = "<span class='red onError'>姓名不能为空.</span>";
						$parent.append(errorMsg);
					}else{
					   var name=$("#name1").val();
							var reg=/^[\u0391-\uFFE5]+$/;
						 if(name.match(reg)){

							  if (this.value.length>4){
								 var errorMsg = "<span class='red onError'>不能超过4个中文.</span>";
									$parent.append(errorMsg);
									
							  }else{
								 var okMsg = "<span><img src='images/ok.gif' /></span>";
								 $parent.append(okMsg);
								
							}
						
						 }else{
							 var errorMsg = "<span class='red onError'>姓名只能是中文.</span>";
								$parent.append(errorMsg);
						 }
					}
			 }
			  if( $(this).is('#address1') ){
					if( this.value==""){
					    var errorMsg = "<span class='red onError'>地址不能为空.</span>";
                        $parent.append(errorMsg);
					}else{
					   var okMsg = "<span><img src='images/ok.gif' /></span>";
					    $parent.append(okMsg);
					}
			 }
			
			
		});//end blur

		//添加新地址。
		 $('#addAddress').click(function(){
				$(".input").trigger('blur');
				var numError = $('.onError').length;
				if(numError){
					return false;
				} 
		 });
	});

	