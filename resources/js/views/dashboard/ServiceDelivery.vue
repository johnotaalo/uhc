<template>
	<div>
		<div class="row">
			<div class="col-md-3">
				<b-form-select v-model="selected" :options="options"></b-form-select>
			</div>

			<div class="col-md-3">
				<b-form-select v-model="periodSelect" :options="periods"></b-form-select>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Case Load Management - Diarrhoea</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="caseLoadManagement.diarrhoea"></highcharts>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Case Load Management - Pneumonia</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="caseLoadManagement.pneumonia"></highcharts>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Case Load Management - Pneumonia</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="caseLoadManagement.pneumoniaLevel"></highcharts>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Top 10 Diagnoses by Level of Care</h4>
							</div>
						</div>
					</div>

					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>Level 2</th>
									<th>Level 3</th>
									<th>Level 4</th>
									<th>Level 5</th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "diag in top10diagnoses">
									<td v-for = "level in levels">{{ diag[level] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Top 10 Services by Level of Care</h4>
							</div>
						</div>
					</div>

					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>Level 2</th>
									<th>Level 3</th>
									<th>Level 4</th>
									<th>Level 5</th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "service in top10services">
									<td v-for = "level in levels">{{ service[level] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Top 10 Services - OPD</h4>
							</div>
						</div>
					</div>

					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>2019</th>
									<th>2018</th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "service in top10servicesOPD">
									<td v-for = "year in years">{{ service[year] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Top 10 Services - IPD</h4>
							</div>
						</div>
					</div>

					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>2019</th>
									<th>2018</th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "service in top10servicesIPD">
									<td v-for = "year in years">{{ service[year] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Top 20 Pharmaceuticals - OPD</h4>
							</div>
						</div>
					</div>

					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "pharmaceuticals in top20PharmaceuticalsOPD">
									<td v-for = "p in pharmaceuticals">{{ p }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Top 20 Pharmaceuticals - IPD</h4>
							</div>
						</div>
					</div>

					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "pharmaceuticals in top20PharmaceuticalsIPD">
									<td v-for = "p in pharmaceuticals">{{ p }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Staffing Ratio</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="staffingRatio"></highcharts>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">KEMSA Order Fulfillment Rate</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="kemsaOrderFullfilment"></highcharts>
					</div>
				</div>
			</div>
		</div>
	</div>

	
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				options: [
					{ value: 'national', text: 'National' },
					{ value: 'isiolo', text: 'Isiolo' },
					{ value: 'national', text: 'Kisumu' },
					{ value: 'national', text: 'Machakos' },
					{ value: 'national', text: 'Nyeri' },
				],
				periods: [
					{ value: 'current-month', text: 'Current Month' },
					{ value: 'average', text: 'Average over pilot period' },
				],
				selected: "",
				periodSelect: "",
				caseLoadManagement: {
					diarrhoea: {
					    chart: {
					        type: 'column'
					    },
					    title: {
					        text: 'Case Load Management - Diarrhoea'
					    },
					    xAxis: {
					        categories: ['Cases', 'Zinc/ORS Kit Order']
					    },
					    yAxis: {
					        min: 0,
					        title: {
					            text: 'Cases'
					        },
					        stackLabels: {
					            enabled: true,
					            style: {
					                fontWeight: 'bold',
					                color: 'gray'
					            }
					        }
					    },
					    tooltip: {
					        headerFormat: '<b>{point.x}</b><br/>',
					        pointFormat: '{series.name}: {point.y}<br/>Cases: {point.stackTotal}'
					    },
					    plotOptions: {
					        column: {
					            stacking: 'normal',
					            dataLabels: {
					                enabled: true,
					                color: 'white'
					            }
					        }
					    },
					    series: [{
					        name: 'January',
					        data: [5000, 6000]
					    }, {
					        name: 'February',
					        data: [3000, 2000]
					    }, {
					        name: 'March',
					        data: [3000, 4000]
					    }, {
					        name: 'April',
					        data: [1000, 1500]
					    }]
					},
					pneumonia: {
						chart: {
							type: 'column'
						},
						title: {
							text: null
						},
						xAxis: {
							categories: [
								'January',
								'February',
								'March',
								'April'
							],
							crosshair: true
						},
						yAxis: {
							min: 0,
							title: 'Value'
						},
						series: [{
							name: "Cases",
							data: [ 1000, 3000, 1500, 1780 ]
						}, {
							name: "Amox DT set to expire",
							data: [ 1500, 250, 0, 0 ]
						}, {
							name: "Amox DT Available",
							data: [ 3000, 4000, 750, 2500 ]
						}]
					},
					pneumoniaLevel: {
						chart: {
							type: 'column'
						},
						title: {
							text: null
						},
						xAxis: {
							categories: [
								'Level 3',
								'Level 4',
								'Level 5'
							],
							crosshair: true
						},
						yAxis: {
							min: 0,
							title: 'Value'
						},
						series: [{
							name: "Total Facilities",
							data: [ 1000, 3000, 1500 ]
						}, {
							name: "Failities with Pulse Oximeter",
							data: [ 1500, 250, 300]
						}]
					}
				},
				diagnoses: [
					'Diagnosis 1', 'Diagnosis 2', 'Diagnosis 3', 'Diagnosis 4', 'Diagnosis 5', 'Diagnosis 6', 'Diagnosis 7', 'Diagnosis 8', 'Diagnosis 9', 'Diagnosis 10', 
				],
				services: [
					'Service 1', 'Service 2', 'Service 3', 'Service 4', 'Service 5', 'Service 6', 'Service 7', 'Service 8', 'Service 9', 'Service 10', 
				],
				levels: [ 'Level 2', 'Level 3', 'Level 4', 'Level 5' ],
				years: ['2019', '2018'],
				pharmaceuticals: []
			}
		},
		mounted: function(){
			for( var i = 1; i <= 20; i++ ){
				this.pharmaceuticals.push(`Pharmaceutical ${i}`);
			}
		},
		computed: {
			top10diagnoses: function(){
				var levels =this.levels;

				var data = [];
				_.forOwn(levels, (level) => {
					var ownDiagnoses = _.shuffle(this.diagnoses);

					for (var i = 0; i < this.diagnoses.length; i++) {
						if(typeof data[i] == 'undefined'){
							data[i] = {};
						}
						data[i][level] = ownDiagnoses[i]
					}
				})
				

				return data;
			},
			top10services: function(){
				var levels =this.levels;

				var data = [];
				_.forOwn(levels, (level) => {
					var ownServices = _.shuffle(this.services);

					for (var i = 0; i < this.services.length; i++) {
						if(typeof data[i] == 'undefined'){
							data[i] = {};
						}
						data[i][level] = ownServices[i]
					}
				})
				

				return data;
			},
			top10servicesOPD: function(){
				var years =this.years;

				var data = [];
				_.forOwn(years, (year) => {
					var ownServices = _.shuffle(this.services);

					for (var i = 0; i < this.services.length; i++) {
						if(typeof data[i] == 'undefined'){
							data[i] = {};
						}
						data[i][year] = ownServices[i]
					}
				})
				

				return data;
			},
			top10servicesIPD: function(){
				var years =this.years;

				var data = [];
				_.forOwn(years, (year) => {
					var ownServices = _.shuffle(this.services);

					for (var i = 0; i < this.services.length; i++) {
						if(typeof data[i] == 'undefined'){
							data[i] = {};
						}
						data[i][year] = ownServices[i]
					}
				})
				

				return data;
			},
			top20PharmaceuticalsOPD: function(){
				var randomisedPharmaceuticals = _.shuffle(this.pharmaceuticals);
				var chunked = _.chunk(randomisedPharmaceuticals, 2)

				return chunked
			},
			top20PharmaceuticalsIPD: function(){
				var randomisedPharmaceuticals = _.shuffle(this.pharmaceuticals);
				var chunked = _.chunk(randomisedPharmaceuticals, 2)

				return chunked
			},
			staffingRatio: function(){
				return {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: null
				    },
				    xAxis: {
				        categories: this.levels
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Positions'
				        },
				        stackLabels: {
				            enabled: true,
				            style: {
				                fontWeight: 'bold',
				                color: 'gray'
				            }
				        }
				    },
				    tooltip: {
				        headerFormat: '<b>{point.x}</b><br/>',
				        pointFormat: '{series.name}: {point.y}<br/>Positions: {point.stackTotal}'
				    },
				    plotOptions: {
				        column: {
				            stacking: 'normal',
				            dataLabels: {
				                enabled: false,
				                color: 'white'
				            }
				        }
				    },
				    series: [{
				        name: 'Positions Filled',
				        data: [5000, 6000, 3000, 4000]
				    }, {
				        name: 'Positions Available',
				        data: [3000, 1000, 1000, 1500]
				    }]
				}
			},
			kemsaOrderFullfilment: function(){
				return {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: null
				    },
				    xAxis: {
				        categories: ['January', 'February', 'March', 'April']
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Positions'
				        },
				        stackLabels: {
				            enabled: true,
				            style: {
				                fontWeight: 'bold',
				                color: 'gray'
				            }
				        }
				    },
				    tooltip: {
				        headerFormat: '<b>{point.x}</b><br/>',
				        pointFormat: '{series.name}: {point.y}<br/>Positions: {point.stackTotal}'
				    },
				    plotOptions: {
				        column: {
				            stacking: 'normal',
				            dataLabels: {
				                enabled: false,
				                color: 'white'
				            }
				        }
				    },
				    series: [{
				        name: 'Commodities Received',
				        data: [15, 22, 15, 15]
				    }, {
				        name: 'Commodies Not Received',
				        data: [1, 22, 3, 7]
				    }]
				}
			}
		}
	}
</script>