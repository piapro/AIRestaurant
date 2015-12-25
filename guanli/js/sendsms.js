	var http_request=false;
	function createXMLHttpRequest(){
		http_request=false;
		//初始化XMLHttpRequest对象
		if(window.XMLHttpRequest){//Mozilla浏览器
			http_request=new XMLHttpRequest();
			if(http_request.overrideMimeType){//设置Mime类别
				http_request.overrideMimeType("text/xml");
			}
		}
		else if (window.ActiveXObject)
		{//IE browser
			try
			{
				http_request=new ActiveXObject("MSXML2.XMLHTTP");
			}
			catch (e)
			{
				try
				{
					http_request=new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e)
				{
					try
					{
						http_request=new ActiveXObject("MSXML3.XMLHTTP");
					}
					catch (e)
					{
						return http_request;
					}
				}
			}
		}
		if (!http_request)
		{//异常，创建对象失败
			window.alert("不能创建XMLHttpRequest对象实例");
			return false;
		}
	}

	function doSend(url){
			createXMLHttpRequest();
			http_request.onreadystatechange=requestContent;
			http_request.open("POST",url,true);
			http_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			http_request.send("content="+content+"&tel="+tel_str[k]+"&tag="+tag);
	}
		//处理返回的信息
	function requestContent(){
			if (http_request.readyState==4)
			{
				if (http_request.status==200){	
					
					txt=http_request.responseText;
					//alert(txt);
					if (txt=="S"){
						k++;
						document.getElementById("redcount").innerHTML='<img src="images/loading.gif" /> 正在发送第 '+x+' 条短信';
						document.getElementById("realspan").innerHTML="<font color='red'>"+x+"</font>/";
						if (x>=c){//如果第x条
							document.getElementById("redcount").innerHTML="短信发送成功";
						}else if (x>=t){//发送的条数大于等于所剩余的短信
							document.getElementById("redcount").innerHTML="短信发送成功,剩余的短信需要购买才可以发送";
						}
						if (x<c && x<t)
						{
							x++;
							setTimeout("act()",800);
						}	
					}else{
						k++;
						$("#error_mm").show();
						document.getElementById("error_email").innerHTML=document.getElementById("error_email").innerHTML+"<font color='red'>"+txt+"</font>";
						if (x>=c){
							document.getElementById("redcount").innerHTML="短信发送成功";
						}else if (x>=t){
							document.getElementById("redcount").innerHTML="短信发送成功,剩余的短信需要购买才可以发送";
						}
						if (x<c && x<t)
						{
							x++;
							setTimeout("act()",800);
						}	
					}
				
				}else{
					document.getElementById("redcount").innerHTML="<font color='red'>意外错误。</font>";
				}
				
			}
		}
	function act(){	
			var u='sendsms.ajax.php';
			doSend(u);
		}