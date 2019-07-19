<template>
	<div>
		<div class="header-body mb-3">
			<div class="row align-items-end">
				<div class="col">
					<b-form-select v-model="selected" :options="options"></b-form-select>
				</div>

				<div class="col">
					<h6 class="header-pretitle">
						Total Population
					</h6>
					<h1 class="header-title">
						
					</h1>
				</div>

				<div class="col">
					<h6 class="header-pretitle">
						Enrolled Population
					</h6>
					<h1 class="header-title">
						0
					</h1>
				</div>

				<div class="col">
					<h6 class="header-pretitle">
						% of target population enrolled
					</h6>
					<h1 class="header-title">
						0%
					</h1>
				</div>
			</div> <!-- / .row -->
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Age Distribution of Enrolled Population</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="ageDistribution"></highcharts>
					</div>
				</div>
			</div>

			<div class="col-5">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Geographical Distribution of Enrolled Population</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="geographicalDistribution"></highcharts>
					</div>
				</div>
			</div>

			<div class="col-7">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Gender Distribution of Enrolled Population</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col">
								<highcharts :options="genderDistribution.enrolled"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="genderDistribution.total"></highcharts>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data(){
			let colors = {
				blue: "#4472c4",
				orange: "#ed7d31"
			};
			return {
				options: [
					{ value: 'national', text: 'National' },
					{ value: 'isiolo', text: 'Isiolo' },
					{ value: 'national', text: 'Kisumu' },
					{ value: 'national', text: 'Machakos' },
					{ value: 'national', text: 'Nyeri' },
				],
				selected: "",
				ageDistribution: {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: 'Age Distribution of Enrolled Population'
				    },
				    xAxis: {
				        categories: [
				            '< 15',
				            '15 - 24',
				            '25 - 34',
				            '35 - 44',
				            '45 - 54',
				            '55 - 64',
				            '65 - 79',
				            '> 80'
				        ],
				        crosshair: true
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Percentage'
				        }
				    },
				    tooltip: {
				        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
				        footerFormat: '</table>',
				        shared: true,
				        useHTML: true
				    },
				    plotOptions: {
				        column: {
				            pointPadding: 0.2,
				            borderWidth: 0
				        }
				    },
				    series: [{
				        name: 'Enrolled Population',
				        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6],
				        color: colors.blue

				    }, {
				        name: 'Total Population',
				        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4],
				        color: colors.orange

				    }]
				},
				geographicalDistribution: {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: 'Geographical Distribution of Enrolled Population'
				    },
				    xAxis: {
				        categories: [
				            'Urban',
				            'Rural'
				        ],
				        crosshair: true
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Percentage'
				        }
				    },
				    tooltip: {
				        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
				        footerFormat: '</table>',
				        shared: true,
				        useHTML: true
				    },
				    plotOptions: {
				        column: {
				            pointPadding: 0.2,
				            borderWidth: 0
				        }
				    },
				    series: [{
				        name: 'Enrolled Population',
				        data: [48.9, 38.8],
				        color: colors.blue

				    }, {
				        name: 'Total Population',
				        data: [42.4, 33.2],
				        color: colors.orange

				    }]
				},
				genderDistribution: {
					enrolled: {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: 'Enrolled Population'
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
					        name: 'Enrolled Population',
					        colorByPoint: true,
					        data: [{
					            name: 'Male',
					            y: 35,
					            color: colors.blue
					        }, {
					            name: 'Female',
					            y: 65,
					            color: colors.orange
					        }]
					    }]
					},
					total: {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: 'Total Population'
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
					        name: 'Total Population',
					        colorByPoint: true,
					        data: [{
					            name: 'Male',
					            y: 35,
					            color: colors.blue
					        }, {
					            name: 'Female',
					            y: 65,
					            color: colors.orange
					        }]
					    }]
					}
				}
			}
		}
	}
</script>