<?php
	/**
	 *  usercentertab6.php 
	*/
?>

						<h1 class="order_h1">修改密码</h1>
						<div class="addList newAddList listUpdate" style='margin-top:34px;'>
							<label>输入您当前密码：</label><input type="password" id="old" name="phone" class="input"/> <span class="red errormt"></span>
						</div>
						<div class="addList newAddList listUpdate">
							<label>输入新密码：</label><input type="password" name="name" id="pw1" class="input"/> <span class="red errormt"></span>
						</div>
						<div class="addList newAddList listUpdate">
							<label>再次输入新密码：</label><input type="password" name="name" id="pw2" class="input"/> <span class="red errormt"></span>
						</div>
						<div class="clear"></div>
						<div class="addList newAddList" style="height:40px; margin-top:43px;">
							<img src="images//button/save.jpg" class="button" style="position:absolute;top:5px;left:340px;" id="addAddress2" onclick="return updatePWD();" />
						</div>
						<div class="clear"></div>
						
<script type="text/javascript">

$(function(){				
			$("#addAddress2").hover(function(){
							 $(this).attr('src','images/button/save_1.jpg');
					 },function(){
							 $(this).attr('src','images/button/save.jpg');
			});
			$("#addAddress2").mousedown(function(){
			  $(this).attr('src','images/button/save_2.jpg');
			  
			});
		})

	
function updatePWD(){
	var old=$("#old").val();
	var pw1=$("#pw1").val();
	var pw2=$("#pw2").val();
	if (old==''){
		 TINY.box.show('当前密码不能为空!',0,160,60,0,10);
	}
	if (pw1==''){
		 TINY.box.show('新密码不能为空!',0,160,60,0,10);
	}else if(pw1.length<6){
		 TINY.box.show('新密码最少是6位!',0,160,60,0,10);
	}else if(pw2==''){
		 TINY.box.show('确认密码不能为空!',0,160,60,0,10);
	}else if(pw2.length<6){
		 TINY.box.show('确认码最少是6位!',0,160,60,0,10);
	}else if (pw1!=pw2){
		TINY.box.show('确认码与新密码不相同!',0,160,60,0,10);
	}
	$.post("usercenter.ajax.php", { 
		'old' : old,
		'pw1'  : pw1,
		'pw2'  : pw2,
		'act'  : 'updatePW'
		}, function (data, textStatus){
			if (data=='OLD'){
				TINY.box.show('当前密码不能为空!',0,160,60,0,10);
			}else if(data=='PW1'){
				 TINY.box.show('新密码不能为空!',0,160,60,0,10);
			}else if(data=='pw2'){
				 TINY.box.show('确认密码不能为空!',0,160,60,0,10);
			}else if (data=='N'){
				TINY.box.show('确认码与新密码不相同!',0,160,60,0,10);
			}else if (data=='PW_E'){
				TINY.box.show('当前密码不正确!',0,160,60,0,10);
			}else if (data=='S'){
				TINY.box.show('您的密码修改成功，即将返回首页',0,160,60,0,10);
				setTimeout("location.href='index.php'",2000);
			}else if (data=='E'){
				TINY.box.show('修改失败!',0,160,60,0,10);
			}
	});
}
 

</script>
 
