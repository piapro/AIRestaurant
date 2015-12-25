

	function ajaxFileUpload()
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'shop_foodpicup.php',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					data=data.replace('<pre>','');
					data=data.replace('</pre>','');
					var info=data.split('|');
					if(info[0]=="E")
						alert(info[1]);
					else{
						document.getElementById('upinfo').innerHTML=info[1];
						document.getElementById('upfile1').value=info[1];
						document.getElementById('pic1').innerHTML='<img src="../'+info[1]+'" style="width:186px;height:125px;" />';
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;
	}

	

	function check(){
		if ($("#name").val()==''){
			alert('名称不能为空');
			$("#name").focus();
			return false;
		}
		if ($("#price1").val()==''){
			alert('原价不能为空');
			return false;
		}
		if ($("#price2").val()==''){
			alert('优惠价');
			return false;
		}
		if ($("#upfile1").val()==''){
			alert('图片不能为空');
			return false;
		}
		
	}