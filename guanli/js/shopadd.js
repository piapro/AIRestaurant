$(function(){
	   $("#circle").change(function(){
		   var circle=$("#circle").val();
		   if (circle==''){
				alert('请选择商圈');
				return false;
		   }
			$.post("area.ajax.php", { 
						'circle_id' :  circle,
						'act':'spot'
					}, function (data, textStatus){
							if (data==""){
								$("#spot").html("<option value=''>没有地标</option>")
							}else
								$("#spot").html(data);
						
					});
	   });
	   $("#address").focus(function(){
			this.value='';
	   });
	   $("#mainfood").focus(function(){
			this.value='';
	   });
	});

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
				url:'shop_picup1.php',
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
						document.getElementById('pic1').innerHTML='<img src="../'+info[1]+'" style="width:99px; height:69px;" />';
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

	function ajaxFileUpload2()
	{
		$("#loading2")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'shop_picup2.php',
				secureuri:false,
				fileElementId:'fileToUpload2',
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
						document.getElementById('upinfo2').innerHTML=info[1];
						document.getElementById('upfile2').value=info[1];
						document.getElementById('pic2').innerHTML='<img src="../'+info[1]+'" style="width:199px; height:78px;" />';
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

	function ajaxFileUpload_m()
	{
		$("#loading_m")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'shop_map.php',
				secureuri:false,
				fileElementId:'fileToUpload_m',
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
						document.getElementById('upinfo_m').innerHTML=info[1];
						document.getElementById('upfile_m').value=info[1];
						document.getElementById('pic_m').innerHTML='<img src="../'+info[1]+'" style="width:199px; height:78px;" />';
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
			alert('商家名称不能为空');
			$("#name").focus();
			return false;
		}
		if ($("#address").val()==''){
			alert('餐厅地址不能为空');
			$("#address").focus();
			return false;
		}
		if ($("#tel").val()==''){
			alert('餐厅电话不能为空');
			$("#tel").focus();
			return false;
		}
		if ($("#opentime").val()==''){
			alert('营业开始时间不能为空');
			$("#opentime").focus();
			return false;
		}
		if ($("#endtime").val()==''){
			alert('营业结束时间不能为空');
			$("#endtime").focus();
			return false;
		}
		if ($("#mainfood").val()==''){
			alert('主营食物不能为空');
			$("#mainfood").focus();
			return false;
		}
		if ($("#upfile1").val()==''){
			alert('请上传图片1');
			return false;
		}
		if ($("#upfile2").val()==''){
			alert('请上传图片2');
			return false;
		}
		if ($("#circle").val()==''){
			alert('请选择商圈');
			return false;
		}
		if ($("#spot").val()==''){
			alert('请选择地标');
			return false;
		}
		if ($("#intro").val()!=''){
			if ($("#intro").val()==''){
				alert('简介不能为空');
				return false;
			}
		}
		if ($("#intro").val()!=''){
			if ($("#intro").val().length>200){
				alert('简介不能超过200');
				return false;
			}
		}
	}

	function check_about(){
		if ($("#title").val()==''){
			alert('标题不能为空');
			return false;
		}
	}