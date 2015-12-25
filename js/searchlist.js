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
		   var key=$("#key").val();
			$.get("search.ajax.php", { 
				'style' :  style,
				'key':  key,
				'str'   :  str
				}, function (data, textStatus){
						$("#shopResult").html(data);
					    
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
		  var key=$("#key").val();
		 $.get("search.ajax.php", { 
			'style' :  style,
			'key':  key,
			'str'   :  str,
			'page'  :  page
			}, function (data, textStatus){
			$("#shopResult").html(data);
					    
		});
	}

	$(function(){
	   $('input:checkbox[name="seachcheck"]').click(function(){
		   
			var checkedObj = $('input:checkbox[name="seachcheck"]:checked');
			var str='';
			var com='';
		  
			checkedObj.each(function(){ 
				str=str+com+$(this).attr("id")+","+this.value;
				com="|";
			});
			var style=$("#main #select").val();
		     var key=$("#key").val();
			$.get("search.ajax.php", { 
				'style' :  style,
				'key':  key,
				'str'   :  str
				}, function (data, textStatus){
				$("#shopResult").html(data);
					    
			});
	   })
	})

