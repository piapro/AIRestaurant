
	 var height1=document.documentElement.clientHeight;
	 var main_height=parseFloat($('#main').height(),10);
	 var fooder_margin=parseFloat($('#footer').css("margin-top"),10);
	 var header_height=parseFloat($('#hearderBox').height(),10);
	 var height2=main_height+fooder_margin+header_height+70;
	if (height1>height2){
		 $("#footer").addClass("bottom");
	}else{
		 $("#footer").removeClass("bottom");
	}