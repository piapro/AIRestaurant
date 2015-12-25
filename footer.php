<?php
	/**
	 *  footer.php  
	*/
?>
	<div id="footer">
		<div id="footer_main">
			<p class="center">
				
					<?php
						$sql="select * from ".WIIDBPRE."_about  order by about_order asc,about_id desc";
						$rs=mysql_query($sql);
						$num=mysql_num_rows($rs);
						$i=1;
						while($rows=mysql_fetch_assoc($rs)){							
						    $type=$rows['about_type'];

							if ($type=='1'){
								if ($site_isshowadminindex=='1' || $site_isshowcard=='1'){
									$class="class='li'";
								}else{
									$class="class='li no-bg'";
								}
								
								echo "<a href='about.php?id=".$rows['about_id']."' ".$class.">".$rows['about_title']."</a>";//内容	
							}else{						
								echo "<a href='".$rows['about_content']."' class='li'>".$rows['about_title']."</a>";//链接
							}
							$i++;
						}
						if ($site_isshowadminindex=='1'){
							$class="class='li'";
							$manage=" <a href='".$admin_dir."/index.php' class='li no-bg,li' target='_blank'>管理后台</a>";
						}else{
							$class="class='li no-bg'";
							$manage='';
						}
						if ($site_isshowcard=='1') echo "<a href='certificate.php' ".$class.">餐厅证照</a>";
						echo $manage;
					?>
					
					
				
			
			<div>
			
			
		</div>
		
	</div>