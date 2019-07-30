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
						{{ data.population | numFormat }}
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
				colors: colors,
				options: [
					{ value: 'national', text: 'National' }
				],
				selected: "national",
				data: {
					geographicalDistribution: {},
					population: {},
					pyramid: {}
				}
			}
		},
		mounted() {
			this.getPilotAreas();
			this.getGeographicalDistribution(this.selected);
			this.getCountyPopulation(this.selected)
			this.getPopulationPyramid()
		},
		methods: {
			getPilotAreas: function(){
				axios.get('/api/counties/pilot')
				.then((res) => {
					var options = _.map(res.data, (o) => {
						return { value: o.id, text: o.county }
					})

					var merge =this.options.concat(options)
					this.options = merge
				});
			},
			getGeographicalDistribution(county){
				axios.get(`/api/data/geographical/county/${county}`)
				.then((res) => {
					this.data.geographicalDistribution = res.data
				});
			},
			getCountyPopulation(val){
				if(val == ""){
					val = 'national'
				}
				axios.get(`/api/data/counties/population?q=${val}`)
				.then((res) => {
					this.data.population = res.data
				})
			},
			getPopulationPyramid(){
				axios.get('/api/data/pyramid')
				.then((res) => {
					this.data.pyramid = res.data
				});
			}
		},
		watch: {
			selected: function(val){
				this.getGeographicalDistribution(val);
				this.getCountyPopulation(val)
			}
		},
		computed: {
			geographicalDistribution: function(){
				var totalUrbanPercentage = parseInt(this.data.geographicalDistribution.urban);
				var totalRuralPercentage = parseInt(this.data.geographicalDistribution.rural);

				var totalUrban = ( (totalUrbanPercentage * this.data.population) / 100 );
				var totalRural = ( (totalRuralPercentage * this.data.population) / 100 );

				return {
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
				            '<td style="padding:0"><b>{point.y}</b></td></tr>',
				        footerFormat: '</table>',
				        shared: false,
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
				        data: [0, 0],
				        color: this.colors.blue

				    }, {
				        name: 'Total Population',
				        data: [totalUrban, totalRural],
				        color: this.colors.orange

				    }]
				}
			},
			ageDistribution: function() {
				var categories = _.map(this.data.pyramid, (p) => {
					return p.age_group
				})

				var totalPopulations = _.map(this.data.pyramid, (p) => {
					return p.male + p.female
				})

				return {
					chart: {
			        	type: 'column'
			    	},
				    title: {
				        text: 'Age Distribution of Enrolled Population'
				    },
				    subtitle: {
				    	text: 'Data from 2009 Census'
				    },
				    xAxis: {
				        categories: categories,
				        crosshair: true
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Population'
				        }
				    },
				    tooltip: {
				        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				            '<td style="padding:0"><b>{point.y}</b></td></tr>',
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
				        data: [],
				        color: this.colors.blue

				    }, {
				        name: 'Total Population',
				        data: totalPopulations,
				        color: this.colors.orange

				    }]
				}
			},
			genderDistribution: function(){
				var femalesTotal = _.sumBy(this.data.pyramid, 'female')
				var malesTotal = _.sumBy(this.data.pyramid, 'male')
				return { 
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
					            y: 0,
					            color: this.colors.blue
					        }, {
					            name: 'Female',
					            y: 0,
					            color: this.colors.orange
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
					    subtitle: {
					    	text: 'Data from 2009 Census'
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
					            y: malesTotal,
					            color: this.colors.blue
					        }, {
					            name: 'Female',
					            y: femalesTotal,
					            color: this.colors.orange
					        }]
					    }]
					}
				}
			}
		}
	}
</script>