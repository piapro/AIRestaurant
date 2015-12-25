$(function(){
    var page = 1;
    var i = 1;
    //向后 按钮
    $(".click_box .next").click(function(){    //绑定click事件
	     var $parent = $("div.scroll");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.scroll_list"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.scroll_main_r"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width() ;
		 var len = $v_show.find(".list").length;
		 var page_count = Math.ceil(len / 2) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
			  if( page == page_count ){  //已经到最后一个版面了,如果再向后，必须跳转到第一个版面。
				 $(".click_box .next").hide();
				 $(".click_box .pre").show();
				//$v_show.animate({ left : '0px'}, "slow"); //通过改变left值，跳转到第一个版面
				//page = 1;
				}else{
					 $(".click_box .next").show();
					 $(".click_box .pre").show();
				$v_show.animate({ left : '-='+v_width }, "slow");  //通过改变left值，达到每次换一个版面
				page++;
				if (page == page_count)
				{
					 $(".click_box .next").hide();
					 $(".click_box .pre").show();
				}
			 }
		 }
   });

    //往前 按钮
    $(".click_box .pre").click(function(){
	     var $parent = $("div.scroll");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.scroll_list"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.scroll_main_r"); //寻找到“视频内容展示区域”外围的DIV元素
		var v_width = $v_content.width();
		 var len = $v_show.find(".list").length;
		 var page_count = Math.ceil(len / 2) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
		 	 if( page == 1 ){  //已经到第一个版面了,如果再向前，必须跳转到最后一个版面。
				//$v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
				$(".click_box .pre").hide();
				 $(".click_box .next").show();
				//page = page_count;
			}else{
				$(".click_box .pre").show();
				 $(".click_box .next").show();
				$v_show.animate({ left : '+='+v_width }, "slow");
				page--;
				 if( page == 1 ){
					$(".click_box .pre").hide();
					 $(".click_box .next").show();
				 }
			}
		}
    });
});


//shouye

$(function(){
    var page = 1;
    var i = 1;
    //向后 按钮
    $("#right_img").click(function(){    //绑定click事件
		var $v_show = $('#scrollList'); //寻找到“视频内容展示区域”
		 var $v_content = $('#scroll'); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width() ;
		 var len = $v_show.find(".scrll_content").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
			  if( page == page_count ){  //已经到最后一个版面了,如果再向后，必须跳转到第一个版面。
				 $("#right_img").show();
				 $("#left_img").hide();
				$v_show.animate({ left : '0px'}, "slow"); //通过改变left值，跳转到第一个版面
				page = 1;
				}else{
					 $("#right_img").show();
					 $("#left_img").show();
				$v_show.animate({ left : '-='+v_width }, "slow");  //通过改变left值，达到每次换一个版面
				page++;
				if (page == page_count)
				{
					 $("#right_img").hide();
					 $("#left_img").show();
				}
			 }
		 }
   })

    //往前 按钮
    $("#left_img").click(function(){
		 var $v_show = $('#scrollList'); //寻找到“视频内容展示区域”
		 var $v_content = $('#scroll'); //寻找到“视频内容展示区域”外围的DIV元素
		var v_width = $v_content.width();
		 var len = $v_show.find(".scrll_content").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
		 	 if( page == 1 ){  //已经到第一个版面了,如果再向前，必须跳转到最后一个版面。
				//$v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
				$("#left_img").hide();
				 $("#right_img").show();
				//page = page_count;
			}else{
				$("#left_img").show();
				 $("#right_img").show();
				$v_show.animate({ left : '+='+v_width }, "slow");
				page--;
				 if( page == 1 ){
					$("#left_img").hide();
					 $("#right_img").show();
				 }
			}
		}
    });

	
});


$(function(){
	 var adTimer;
	
	 //滑入 停止动画，滑出开始动画.
	 $('#scroll').hover(function(){
			 clearInterval(adTimer);
			 $(this).find("a").addClass("underLine");
		 },function(){
			  $(this).find("a").removeClass("underLine");
			 adTimer = setInterval(function(){
			   $("#right_img").trigger('click');
			  } , 3000);
	 }).trigger("mouseleave");
})

//首页推荐的隐藏

$(function(){
	$(".tt").toggle(
	  function(){
	  $(this).next().hide();$(this).addClass("h1")},
	  function(){
	  $(this).next().show();$(this).removeClass("h1")}
	);
})

//首页连锁餐厅推荐滚动

$(function(){
    var page = 1;
    var i = 6;
    //向后 按钮
    $("#index_up").click(function(){    //绑定click事件
	     var $parent = $(this).parents('.index_shop_box');//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.scroll_list"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.scroll_main_r"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_height = $(".index_shop").height()+14 ;
		 var len = $v_show.find(".index_shop").length;
		 var page_count = Math.ceil(len / 3) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
			  if( page == page_count ){  //已经到最后一个版面了,如果再向后，必须跳转到第一个版面。
				 $("#index_up").hide();
				 $("#index_down").show();
				//$v_show.animate({ left : '0px'}, "slow"); //通过改变left值，跳转到第一个版面
				//page = 1;
				}else{
					 $("#index_down").show();
					 $("#index_up").show();
				$v_show.animate({ top : '-='+v_height }, "slow");  //通过改变left值，达到每次换一个版面
				page++;
				if (page == page_count)
				{
					$("#index_up").hide();
					 $("#index_down").show();
				}
			 }
		 }
   });

    //往下 按钮
    $("#index_down").click(function(){
	     var $parent = $(this).parents('.index_shop_box');///根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.scroll_list"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.scroll_main_r"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_height = $(".index_shop").height()+14 ;
		 var len = $v_show.find(".index_shop").length;
		 var page_count = Math.ceil(len / 3) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
		 	 if( page == 1 ){  //已经到第一个版面了,如果再向前，必须跳转到最后一个版面。
				//$v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
				$("#index_down").hide();
				 $("#index_up").show();
				//page = page_count;
			}else{
				$("#index_down").show();
				 $("#index_up").show();
				$v_show.animate({ top : '+='+v_height }, "slow");
				page--;
				 if( page == 1 ){
					$("#index_down").hide();
					 $("#index_up").show();
				 }
			}
		}
    });
});