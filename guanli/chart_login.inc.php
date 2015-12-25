	<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						defaultSeriesType: 'bar'
					},
					title: {
						text: '用户登录分析'
					},
					xAxis: {
						categories: [<?php
								if($provinces){
									$i=1;
									foreach($provinces as $key=>$val){
										if($i==count($provinces)){
											echo "'".$val."'";
										}else{
											echo "'".$val."',";
										}
										$i++;
									}
								}
							?>],
						title: {
							text: null
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: '客户数',
							align: 'high'
						}
					},
					tooltip: {
						formatter: function() {
							return ''+
								 this.series.name +': '+ this.y +' 人';
						}
					},
					plotOptions: {
						bar: {
							dataLabels: {
								enabled: true
							}
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -100,
						y: 100,
						floating: true,
						borderWidth: 1,
						backgroundColor: '#FFFFFF',
						shadow: true
					},
					credits: {
						enabled: false
					},
				        series: [{
						name: '客户数',
						data: [<?php
								if($provinces){
									$i=1;
									foreach($provinces as $key=>$val){
										if($i==count($provinces)){
											echo getUserBirthAddressCount($val,'');
										}else{
											echo getUserBirthAddressCount($val,'').",";
										}
										$i++;
									}
								}
							?>]
					}]
				});
				
				
			});
				
	</script>
	<div id="container" style="height: 1270px; margin: 0 auto"></div>