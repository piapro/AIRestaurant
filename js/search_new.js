var lat;
var lng;
var page='';
var keyword='';
var sortID='';
var circleID='';
var style='';
var order1='';
var order2='';
var map;
var geocoder;

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
		   var shopSort=$("#shopClass").val();
		   var spotname=$("#spotname").val();
		   $("#spanspotname").html("<a href='spot.php?circleID="+circle+"&spotID="+spot+"'>"+spotname+"</a>");
			$.get("shopstyle.ajax.php", { 
				'style' :  style,
				'circle':  circle,
				'key'	:  key,
				'str'   :  str,
				'sort1' :  sort1,
				'sort2' :  sort2,
				'shopSort' : shopSort,
				'spot'  :  spot
				}, function (data, textStatus){
						var msg=data.split('|||||');
						$("#shopResult").html(msg[0]);
						$("#searchcount").html(msg[1]);
						if (shopSort==''){
							$("#all").html("("+msg[1]+")");
						}else{
							$("#count"+shopSort).html("("+msg[1]+")");
						}
					    
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
		 var shopSort=$("#shopClass").val();

		 $.get("shopstyle.ajax.php", { 
			'style' :  style,
			'circle':  circle,
			'key'   :  key,
			'str'   :  str,
			'spot'  :  spot,
			'sort1' :  sort1,
			'sort2' :  sort2,
			'shopSort' : shopSort,
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
			var shopSort=$("#shopClass").val();
			var spotname=$("#spotname").val();
			$("#spanspotname").html("<a href='spot.php?circleID="+circle+"&spotID="+spot+"'>"+spotname+"</a>");
			$.get("shopstyle.ajax.php", { 
				'style' :  style,
				'circle':  circle,
				'key'   :  key,
				'str'   :  str,
				'sort1' :  sort1,
				'sort2' :  sort2,
				'shopSort' : shopSort,
				'spot'  :  spot
				}, function (data, textStatus){
				var msg=data.split('|||||');
				$("#shopResult").html(msg[0]);
				$("#searchcount").html(msg[1]); 
				if (shopSort==''){
							$("#all").html("("+msg[1]+")");
						}else{
							$("#count"+shopSort).html("("+msg[1]+")");
						}
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

function getListBySort(sortID,name,count){
	$("#shopClass").val(sortID);
	$("#total").html(name+" (<span id='searchcount'>"+count+"</span>)");
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
		   var shopSort=$("#shopClass").val();
		 
		   var spotname=$("#spotname").val();
		   $("#spanspotname").html("<a href='spot.php?circleID="+circle+"&spotID="+spot+"'>"+spotname+"</a>");
			$.get("shopstyle.ajax.php", { 
				'style' :  style,
				'circle':  circle,
				'key'	:  key,
				'str'   :  str,
				'sort1' :  sort1,
				'sort2' :  sort2,
				'shopSort' : shopSort,
				'spot'  :  spot
				}, function (data, textStatus){
						var msg=data.split('|||||');
						$("#shopResult").html(msg[0]);
						$("#searchcount").html(msg[1]);
						if (shopSort==''){
							$("#all").html("("+msg[1]+")");
						}else{
							$("#count"+shopSort).html("("+msg[1]+")");
						}
					    
			});
	   
}


$(function(){				
			$("#groupButton").hover(function(){
				
							$(this).attr('src','images/cart2.jpg');
					 },function(){
							 $(this).attr('src','images/cart1.jpg');
			});
			$("#groupButton").mousedown(function(){
			  $(this).attr('src','images/cart2.jpg');
			  
			});
		})

function addGroupCart(uid,shop,food,spot,group){
	 $.post("userorder.ajax.php", { 
							'shopID'   :  shop,
							'foodID'   :  food,
							'desc'   :  '',
							'act'     :  'addCart'
							}, function (data, textStatus){
							location.href="userorder.php?shopID="+shop+"&shopSpot="+spot+"&ordertype=group&groupID="+group;
							
		});
}

function specialAdd(shop,food,url){
	 $.post("userorder.ajax.php", { 
							'shopID'   :  shop,
							'foodID'   :  food,
							'desc'   :  '',
							'act'     :  'addCart'
							}, function (data, textStatus){
							location.href="userorder.php?shopID="+shop;
							
							
		});
}

function specialAdd_shop(shop,food,circle){
	 $.post("userorder.ajax.php", { 
							'shopID'   :  shop,
							'foodID'   :  food,
							'desc'   :  '',
							'act'     :  'addCart'
							}, function (data, textStatus){
							location.href="shop.php?id="+shop+"&circleID="+circle;
							
							
		});
}
//分页函数
function getshopPageData(page1,order1,order2){
			page=page1;
			keyword='';
			sortID=$("#firstClass").val();
			circleID=$("#circleID").val();
			style=$("#style").val();
			order1=order1;
			order2=order2;
			//得到该分类下的商家信息
			//if (keyword=='')
			//{
				searchResult(sortID,circleID,style,order1,order2,page,keyword,lat,lng);
			//}else{
				//geocoder = new GClientGeocoder();
				//geocoder.getLocations(keyword, getlap);
			//}
			
}
//按人均排序的函数
function averageOrder(){
	order1=$("#order1").attr('name');
	order2=$("#order2").attr('name');
	keyword='';
	sortID=$("#firstClass").val();
	circleID=$("#circleID").val();
	style=$("#style").val();
	if (order1=="desc")
	{
		$("#order1").attr('name','asc');
		$("#order1").attr('src','images/up_1.jpg');
	}else{
		$("#order1").attr('name','desc');
		$("#order1").attr('src','images/down_1.jpg');
	}
	order1=$("#order1").attr('name');
	 order2='';
			
	//得到该分类下的商家信息
	//if (keyword=='')
	//{
		searchResult(sortID,circleID,style,order1,order2,page,keyword,lat,lng);
	//}else{
	//	geocoder = new GClientGeocoder();
	//	geocoder.getLocations(keyword, getlap);
	//}
}
//按折扣排序的函数
function discountOrder(){
	order1=$("#order1").attr('name');
	order2=$("#order2").attr('name');
	keyword='';
	sortID=$("#firstClass").val();
	circleID=$("#circleID").val();
	style=$("#style").val();
	if (order2=="desc")
	{
		$("#order2").attr('name','asc');
		$("#order2").attr('src','images/up_1.jpg');
	}else{
		$("#order2").attr('name','desc');
		$("#order2").attr('src','images/down_1.jpg');
	}
	 order1='';
	 order2=$("#order2").attr('name');
			
	//得到该分类下的商家信息
	//if (keyword=='')
	//{
		searchResult(sortID,circleID,style,order1,order2,page,keyword,lat,lng);
	//}else{
	//	geocoder = new GClientGeocoder();
	//	geocoder.getLocations(keyword, getlap);
	//}
}
//搜索的函数
function searchShop(){
	$(".shop_box ul li").removeClass("active");
	$("#firstClass").val('');
	keyword=$("#keyword").val();
	sortID='';
	circleID=$("#circleID").val();
	style='';
	order1='';
	 order2='';
	page='';

	

	
	
	if (keyword=='')
	{
		 TINY.box.show_spot('搜索的外卖地址不能为空',0,297,163,0,10);
		return false;
	}
	searchResult_s(page,keyword,lat,lng);
	/*
	geocoder = new GClientGeocoder();
      geocoder.getLocations(keyword, addAddressToMap);
	  */
	
}

 function addAddressToMap(response) {
	 
	 var keyword=$("#keyword").val();
	
      if (!response || response.Status.code != 200) {
        alert("对不起，没有找到这个地址的地标");
      } else {
        place = response.Placemark[0]; 
		lat=place.Point.coordinates[1];//纬度
		lng=place.Point.coordinates[0]; //经度
		//得到该分类下的商家信息
		searchResult_s(page,keyword,lat,lng);
      
       
      }
    }

 function getlap(response) {
	 
	 keyword=$("#keyword").val();
	
      if (!response || response.Status.code != 200) {
        alert("对不起，没有找到这个地址的地标");
      } else {
        place = response.Placemark[0]; 
		lat=place.Point.coordinates[1];//纬度
		lng=place.Point.coordinates[0]; //经度
		//得到该分类下的商家信息
		searchResult(sortID,circleID,style,order1,order2,page,keyword,lat,lng);
      
       
      }
    }

function searchResult(sortID,circleID,style,order1,order2,page,keyword,lat,lng){
	$.post("shop.ajax.php", { 
							'sortID'     :  sortID,
							'circleID' :  circleID,
							'style' :  style,
							'order1' :  order1,
							'order2' :  order2,
							'page' :  page,
							'keyword' : keyword,
								'lat' :  lat,
							'lng' : lng,
							'act'    :  'getShopBySort'
							}, function (data, textStatus){
								var msg=data.split('|||||');
								$("#shopResult").html(msg[0]);
								$("#allShop").html(msg[1]);
						});
}
function searchResult_s(page,keyword,lat,lng){
	$.post("shop.ajax.php", { 
							'lat' :  lat,
							'lng' : lng,
							'page' :  page,
							'keyword' : keyword,
							'act'    :  'getShopBySort_search'
							}, function (data, textStatus){
								var msg=data.split('|||||');
								$("#shopResult").html(msg[0]);
								$("#allShop").html(msg[1]);
						});
}

//分页函数
function getshopPageData_s(page1){
			keyword=$("#keyword").val();
			page=page1;
			
			searchResult_s(page,keyword,lat,lng);
			/*
			geocoder = new GClientGeocoder();
      geocoder.getLocations(keyword, addAddressToMap);
	  */
}
//菜系的函数
$(function(){
	   $("#main_white_center #style").change(function(){
		   style=$(this).val();
			keyword='';
			sortID=$("#firstClass").val();
			circleID=$("#circleID").val();
			order1=$("#order1").attr('name');
			order2=$("#order2").attr('name');
			//得到该分类下的商家信息
			//if (keyword=='')
			//{
				searchResult(sortID,circleID,style,order1,order2,page,keyword,lat,lng);
		//	}else{
				//geocoder = new GClientGeocoder();
				//geocoder.getLocations(keyword, getlap);
			//}
	   })
	})

function getIndexPageData(page){
		
		 $.post("shop.ajax.php", { 
			'act' :  "getIndexRmd",
			'page'  :  page
			}, function (data, textStatus){
				$("#reBox").html(data);
					    
		});
	}