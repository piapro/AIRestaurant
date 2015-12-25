<?php
	/**
	 *  header.php
	 */
?>
	<div id="hearderBox" style="height:90px;">
		<div id="header" >
			
			<div id="login" >
			<?php
				if (!empty($_SESSION['qiyu_shopID'])){
			?>
			<span><span>
			
				
			<?php
				
					$sql="select shop_account from qiyu_shop where shop_id=".$_SESSION['qiyu_shopID'];
					$rs=mysql_query($sql);
					$row=mysql_fetch_assoc($rs);
					if ($row){
			?>
						<?php echo $row['shop_account']?>  <a href="shopupdatepass.php" style='margin-left:10px;'>修改密码</a> <a href="http://www.diancan365.com/bbs/" target="_blank">帮助</a> <a href="shopquit.php" class="no_bg">退出</a> 
			<?php
						
					}
				
			?>
				</span></span>
			<?php
				}	
			?>
			</div>
		
			<div class="location" style='left:100px;top:30px;'><a href="admin.php" style="color:#fff;"><?php echo $SHOPNAME_DDMIN?></a></div>
			<p class='shopindex'><a href="../index.php" target='_blank'>餐厅首页</a></p>
			
		</div>
	</div>
	<script type="text/javascript">
	<!--
		$(document).ready(function(){
			$('#search_input').focus(function(){
				this.value='';
			});
		});
	//-->
	</script>