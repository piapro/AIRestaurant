	//取消订单
	function orderCancel(id){
		if(confirm('您确定要取消订单吗？')){
			$.post("userorder.ajax.php", { 
				'id'     :  id,
				'act'    :  'qxOrder'
				}, function (data, textStatus){
					var post = data;
					if (post=="S"){
						alert('取消成功');
						//TINY.box.show('取消成功',0,160,60,0,2);
						location.href='usercenter.php?tab=2&key=all';
					}
					if (post=="E"){
						alert('订单不存在');
						location.href='usercenter.php?tab=2&key=all';
					}
					if (post=="Q"){
						alert('餐厅已接收订单，不能取消');
						location.href='usercenter.php?tab=2&key=all';
					}
					if (post=="N"){
						alert('未知原因，取消失败');
						location.href='usercenter.php?tab=2key=all';
					}
				});
		}
	}
	function orderFinish(id){
		$.post("userorder.ajax.php", { 
			'id'     :  id,
			'act'    :  'finishOrder'
			}, function (data, textStatus){
				var post = data;
				if (post=="S"){
					location.href='usercenter.php?tab=2&key=all';
				}else if(post=="N"){
					location.href='usercentertab2_n.inc.php';
				}else{
					alert("操作失败");
				}
			});

	}