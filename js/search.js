/*  //旧的以后可以删除
$(function(){
	   $("#main #select").change(function(){
		   var style=$(this).val();
		   var checkedObj = $('input:checkbox[name="seachcheck"]:checked');
		   var str='';
		   var com='';
		   checkedObj.each(function(){ 
				str=str+com+$(this).attr("id")+","+this.value;
				com="|";
			});
			
		   var style=$("#main #select").val();
		   var sort1=$("#sort1").val();
		   var sort2=$("#sort2").val();
		   var circle=$("#circleID").val();
		   var spot=$("#spotID").val();
		   var key=$("#key").val();
		   var spotname=$("#spotname").val();
		   $("#spanspotname").html("<a href='spot.php?circleID="+circle+"&spotID="+spot+"'>"+spotname+"</a>");
			$.get("shopstyle.ajax.php", { 
				'style' :  style,
				'circle':  circle,
				'key'	:  key,
				'str'   :  str,
				'sort1' :  sort1,
				'sort2' :  sort2,
				'spot'  :  spot
				}, function (data, textStatus){
						var msg=data.split('|||||');
						$("#shopResult").html(msg[0]);
						$("#searchcount").html(spotname+"附近的外卖("+msg[1]+")");
					    
			});
	   })
	})

	function getPageData(page){
	
		 var checkedObj = $('input:checkbox[name="seachcheck"]:checked');
		 var str='';
		 var com='';
		  
		 checkedObj.each(function(){ 
			str=str+com+$(this).attr("id")+","+this.value;
			com="|";
		 });
		 var style=$("#main #select").val();
		 var circle=$("#circleID").val();
		 var spot=$("#spotID").val();
		 var key=$("#key").val();
		 var sort1=$("#sort1").val();
		 var sort2=$("#sort2").val();

		 $.get("shopstyle.ajax.php", { 
			'style' :  style,
			'circle':  circle,
			'key'   :  key,
			'str'   :  str,
			'spot'  :  spot,
			'sort1' :  sort1,
			'sort2' :  sort2,
			'page'  :  page
			}, function (data, textStatus){
				var msg=data.split('|||||');
				$("#shopResult").html(msg[0]);
					    
		});
	}

	$(function(){
	   $('input:checkbox[name="seachcheck"]').click(function(){
		   
			var checkedObj = $('input:checkbox[name="seachcheck"]:checked');
			var str='';
			var com='';
			$('input:checkbox[name="seachcheck1"]').attr('checked','');
			$('input:checkbox[name="seachcheck2"]').attr('checked','');
			$('input:checkbox[name="seachcheck3"]').attr('checked','');
			checkedObj.each(function(){ 
				str=str+com+$(this).attr("id")+","+this.value;
				com="|";
				if(this.value=='m'){
					$('input:checkbox[name="seachcheck1"]').attr('checked','true');
				}
				if(this.value=='1'){
					$('input:checkbox[name="seachcheck2"]').attr('checked','true');
				}
				if(this.value=='0'){
					$('input:checkbox[name="seachcheck3"]').attr('checked','true');
				}
			});
			var style=$("#main #select").val();
		    var circle=$("#circleID").val();
		    var spot=$("#spotID").val();
			var key=$("#key").val();
			var sort1=$("#sort1").val();
		    var sort2=$("#sort2").val();
			var spotname=$("#spotname").val();
			$("#spanspotname").html("<a href='spot.php?circleID="+circle+"&spotID="+spot+"'>"+spotname+"</a>");
			$.get("shopstyle.ajax.php", { 
				'style' :  style,
				'circle':  circle,
				'key'   :  key,
				'str'   :  str,
				'sort1' :  sort1,
				'sort2' :  sort2,
				'spot'  :  spot
				}, function (data, textStatus){
				var msg=data.split('|||||');
				$("#shopResult").html(msg[0]);
				$("#searchcount").html(spotname+"附近的外卖("+msg[1]+")");	    
			});
	   })
	})
	$(function(){				
			$("#search_button").hover(function(){
				$(this).attr('src','images/button/search_new_1.gif');
			 },function(){
				$(this).attr('src','images/button/search_new.gif');
		});
		$("#search_button").mousedown(function(){
			 $(this).attr('src','images/button/search_new_2.gif');
			  
		});
})
*/


function search_left(){
	var key=$("#keyword").val();
	if (key=='')
	{
		TINY.box.show_spot('搜索关键字不能为空',0,297,163,0,10);
		$("#keyword").focus();
		return false;
	}
}
$(function(){
		
	   $("#search_circle").change(function(){
		   var circle=$("#search_circle").val();
		  
			$.post("shop.ajax.php", { 
						'circle' :  circle,
						'act':'getCricleclass'
					}, function (data, textStatus){
							if (data==""){
								$("#search_type").html("<option value=''>没有类型</option>")
							}else
								$("#search_type").html(data);
						
					});
	   })
	})
