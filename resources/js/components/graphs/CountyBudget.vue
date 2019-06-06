<template>
	<div>
		<highcharts :options="graphOption"></highcharts>
	</div>
</template>
<script type="text/javascript">
	import Highcharts from 'highcharts'
	export default {
		name: "CountyBudget",
		props: {
			title: { type: null, default: null },
			data: { type: null, default: null }
		},
		computed: {
			graphOption: function(){
				return {
					chart: {
				        plotBackgroundColor: null,
				        plotBorderWidth: null,
				        plotShadow: false,
				        type: 'pie'
				    },
				    title: {
				        text: this.title
				    },
				    tooltip: {
				        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				    },
				    plotOptions: {
				        pie: {
				            allowPointSelect: true,
				            cursor: 'pointer',
				            dataLabels: {
				                enabled: false
				            },
				            showInLegend: true
				        }
				    },
				    series: [{
				        name: this.title,
				        colorByPoint: true,
				        data: this.data
				    }]
				}
			}
		}
	}
</script>