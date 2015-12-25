<ul>
	<li style="margin-top:0;background:url('../images/take_up.gif') no-repeat 0 50%;">
		<a href="admin.php">管理首页</a>
	</li>
	<li>
		<span>餐厅管理</span>
		<ul>
			<li><a href="shopadd.php">餐厅信息管理</a></li>
			<li><a href="shoppic.php">餐厅图片</a></li>
			<li><a href="shopdelivertime.php">送餐时段</a></li>
			<li><a href="shopdeliverfee.php">送餐费及时限</a></li>
			<?php
				if ($site_isshowcard=='1'){
			?>
					<li><a href="shopcard.php">餐厅证照</a></li>
			<?php
				}	
			?>
		</ul>
	</li>
	<li>
		<span>菜单信息管理</span>
		<ul>
			<li><a href="foodtype.php">菜单分类管理</a></li>
			<li><a href="food.php">菜单管理</a></li>
			<li><a href="shoptop.php">推荐菜管理</a></li>
		</ul>
	</li>
	
	<li>
		<span>订单管理</span>
		<ul>
			
			<li><a href="subscribe.php">预约订单[<?php echo getSubscribeCount();?>]</a></li>
			<li><a href="userorder.php?key=0">新订单[<?php echo getOrderNewCountByState(0);?>]</a></li>
			<li><a href="userorder.php?key=1">确定订单[<?php echo getOrderCountByState(1);?>]</a></li>
			<li><a href="userorder.php?key=4">完成的订单[<?php echo getOrderCountByState(4);?>]</a> </li>
			<li><a href="userorder.php?key=2">商家取消订单[<?php echo getOrderCountByState(2);?>]</a></li>
			<li><a href="userorder.php?key=3">用户取消订单[<?php echo getOrderCountByState(3);?>]</a> </li>
			<li><a href="userordersearch.php">订单搜索</a></li>
		</ul>
		
	</li>
	
	<li>
		<span>用户管理</span>
		<ul>
			<li><a href="userlist.php">用户列表</a></li>
			<!--<li><a href="userconsume.php">用户消费记录</a></li>-->
			<?php if($site_isshowcomment==1){?>
				<li><a href="usercomment.php">评论列表</a></li>
			<?php }?>
		</ul>
	</li>

	<li>
		<span>统计分析</span>
		<ul>
			<li><a href="stat_login.php">用户登录分析</a></li>
			<li><a href="stat_topuser.php">消费排行分析</a></li>
			<li><a href="stat_hotfood.php">热卖菜分析</a></li>
			<li><a href="stat_order.php">订单分析</a></li>
		</ul>
	</li>
	
	<li>
		<span>系统管理</span>
		<ul>
			<li><a href="site.php">网站设置</a></li>			
			<li><a href="site_sms.php">短信设置</a></li>
			<li><a href="site_tmp.php">模板设置</a></li>
			<li><a href="seo.php">SEO优化</a></li>
			<li><a href="about.php">底部链接</a></li>
			<li><a href="other.php">其他设置</a></li>
			<li><a href="yunprint.php">打印设置</a></li>
		</ul>
	</li>
</ul>
<script>
	$(function(){
		$('#leftspan').toggle(
		  function () {
			$('#openli').css('background-image',"url('../images/take_up.gif')");
		  },
		  function () {
			$('#openli').css('background-image',"url('../images/open.gif')");
		  }
		); 
	})
</script>