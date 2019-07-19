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
						1,500,000
					</h1>
				</div>

				<div class="col">
					<h6 class="header-pretitle">
						% of target population enrolled
					</h6>
					<h1 class="header-title">
						33%
					</h1>
				</div>
			</div> <!-- / .row -->
		</div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">OPD and IPD Utilization</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="opdIpd"></highcharts>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">OPD Utilization by Level of Facility</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="opdLevelofFacility"></highcharts>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">IPD Utilization by Level of Facility</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="ipdLevelofFacility"></highcharts>
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
								<h4 class="card-header-title">OPD Utilization by Sector</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col">
								<highcharts :options="opdUtilization.nonPilot"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="opdUtilization.pilot"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="opdUtilization.pilot"></highcharts>
							</div>
						</div>
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
								<h4 class="card-header-title">IPD Utilization by Sector</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col">
								<highcharts :options="ipdUtilization.nonPilot"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="ipdUtilization.pilot"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="ipdUtilization.pilot"></highcharts>
							</div>
						</div>
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
								<h4 class="card-header-title">Rate of Referrals</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in pilot area</small>
								<small><strong class="text-success text-bold">{{ totalReferrals }}</strong> per 1000 visits</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in non-pilot area</small>
								<small><strong class="text-danger text-bold">0</strong> per 1000 visits</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in pilot area 2018</small>
								<small><strong class="text-success text-bold">{{ totalReferrals }}</strong> per 1000 visits</small>
							</li>
						</ul>
					</div>

					<h3><center>Facilities with highest rate of referral</center></h3>
					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>Name</th>
									<th>County</th>
									<th>Level</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "facility in top10referrals">
									<td>{{ facility.facility_name }}</td>
									<td>{{ facility.county }}</td>
									<td>{{ facility.facility_level }}</td>
									<td>{{ facility.referrals }}</td>
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
								<h4 class="card-header-title">Average Length of Stay</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Average LOS in pilot area (selected above)</small>
								<small><strong class="text-success text-bold">2</strong> bed days</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in non-pilot area</small>
								<small><strong class="text-success text-bold">10</strong> bed days</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in pilot area 2018</small>
								<small><strong class="text-danger text-bold">15</strong> bed days</small>
							</li>
						</ul>
					</div>

					<h3><center>Facilities with highest Average LOS</center></h3>
					<div class="table-responsive mb-0">
						<table class="table table-sm table-nowrap card-table">
							<thead>
								<tr>
									<th>Name</th>
									<th>County</th>
									<th>Level</th>
									<th>AVG LOS</th>
								</tr>
							</thead>
							<tbody class="list">
								<tr v-for = "facility in data.referralFacilities">
									<td>{{ facility.name }}</td>
									<td>{{ facility.county }}</td>
									<td>{{ facility.level }}</td>
									<td>{{ facility.los }}</td>
								</tr>
							</tbody>
						</table>
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
					{ value: '', text: 'National' },
				],
				colors: colors,
				selected: "",
				data: {
					population: 0,
					opdIpdData: [],
					opdFacilityLevelData: [],
					ipdFacilityLevelData: [],
					referralData: [],
					opdUtilization: [],
					ipdUtilization: [],
					referralFacilities: [
						{
							name: "CHANDARIA DISPENSARY",
							county: "Nairobi",
							level: "Level 2",
							rate: 100,
							los: 15
						},
						{
							name: "SINGIRAINE DISPENSARY",
							county: "Kajiado",
							level: "Level 3",
							rate: 100,
							los: 14
						},
						{
							name: "GATUANYAGA DISPENSARY",
							county: "Kiambu",
							level: "Level 2",
							rate: 97,
							los: 14
						},
						{
							name: "TAWFIQ HOSPITAL",
							county: "Kilifi",
							level: "Level 4",
							rate: 93,
							los: 11
						},
						{
							name: "KILIMANGODO DISPENSARY",
							county: "Kwale",
							level: "Level 2",
							rate: 75,
							los: 11
						},
						{
							name: "ESHU DISPENSARY",
							county: "Kwale",
							level: "Level 2",
							rate: 75,
							los: 9
						},
						{
							name: "IKULU DISPENSARY",
							county: "Machakos",
							level: "Level 2",
							rate: 73,
							los: 9
						},
						{
							name: "KYUASINI HEALTH CENTRE",
							county: "Makueni",
							level: "Level 3",
							rate: 70,
							los: 9
						},
						{
							name: "KONGOWEA HEALTH CENTRE",
							county: "Mombasa",
							level: "Level 3",
							rate: 66,
							los: 8
						},
						{
							name: "KARURA DISPENSARY",
							county: "Nakuru",
							level: "Level 2",
							rate: 51,
							los: 8
						}
					]
				},
				opdUtilization: {
					nonPilot: {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: 'Non-Pilot Area (Average)'
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
					        name: 'Non-Pilot Area (Average)',
					        colorByPoint: true,
					        data: [{
					            name: 'Public',
					            y: 61.41,
					            color: colors.blue
					        }, {
					            name: 'Private',
					            y: 11.84,
					            color: colors.orange
					        }]
					    }]
					},
					pilot: {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: 'Pilot'
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
					        name: 'Pilot',
					        colorByPoint: true,
					        data: [{
					            name: 'Public',
					            y: 1000,
					            color: colors.blue
					        }, {
					            name: 'Private',
					            y: 200,
					            color: colors.orange
					        }]
					    }]
					}
				},
				ipdUtilization: {
					nonPilot: {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: 'Non-Pilot Area (Average)'
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
					        name: 'Non-Pilot Area (Average)',
					        colorByPoint: true,
					        data: [{
					            name: 'Public',
					            y: 61.41,
					            color: colors.blue
					        }, {
					            name: 'Private',
					            y: 11.84,
					            color: colors.orange
					        }]
					    }]
					},
					pilot: {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: 'Pilot'
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
					        name: 'Pilot',
					        colorByPoint: true,
					        data: [{
					            name: 'Public',
					            y: 1000,
					            color: colors.blue
					        }, {
					            name: 'Private',
					            y: 200,
					            color: colors.orange
					        }]
					    }]
					}
				}
			}
		},
		created(){
			this.getCountyPopulation(this.selected);
			this.getPilotAreas();
			this.getFacilityReferrals();
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
			getIPDOPDPilotCountyDetails(county_id){
				axios.post('/api/data/counties/pilot/opd-ipd', { id: county_id })
				.then((res) => {
					this.data.opdIpdData = res.data
				})
			},

			getOPDLevelofFacilityDetails(county_id){
				axios.post('/api/data/counties/facility/level/opd', { id: county_id })
				.then((res) => {
					this.data.opdFacilityLevelData = res.data
				})
			},

			getIPDLevelofFacilityDetails(county_id){
				axios.post('/api/data/counties/facility/level/ipd', { id: county_id })
				.then((res) => {
					this.data.ipdFacilityLevelData = res.data
				})
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

			getFacilityReferrals(){
				axios.get('/api/data/referrals')
				.then((res) => {
					var _data = _.orderBy(res.data, ['referrals'], ['desc'])
					this.data.referralData = _data
				});
			}
		},
		watch: {
			selected: function(val){
				this.getCountyPopulation(val)
				this.getIPDOPDPilotCountyDetails(val)
				this.getOPDLevelofFacilityDetails(val)
				this.getIPDLevelofFacilityDetails(val)
			}
		},
		computed: {
			totalReferrals: function(){
				return _.sumBy(this.data.referralData, 'referrals')
			},
			top10referrals: function(){
				return this.data.referralData.slice(0, 10);
			},
			opdIpd: function(){
				return {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: 'OPD and IPD Utilization'
				    },
				    xAxis: {
				        categories: [
				            'OPD',
				            'IPD'
				        ],
				        crosshair: true
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Percentage'
				        }
				    },
				    plotOptions: {
				        column: {
				            pointPadding: 0.2,
				            borderWidth: 0
				        }
				    },
				    series: [{
				        name: 'Pilot Area',
				        data: [(parseInt(this.data.opdIpdData.opd) / this.data.population) * 100, (parseInt(this.data.opdIpdData.ipd) / this.data.population) * 100],
				        color: this.colors.blue

				    }, {
				        name: 'Non-Pilot Area (Average)',
				        data: [0, 0],
				        color: this.colors.orange

				    }]
				}
			},
			opdLevelofFacility: function(){
				var categories = _.map(this.data.opdFacilityLevelData, (o) => {
					return o.facility_level
				})

				var pilotAreaData = _.map(this.data.opdFacilityLevelData, (o) => {
					return parseInt(o.totals)
				})

				var nonPilotAreaData = _.map(categories, (o) => {
					return 0
				})

				return {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: 'OPD Utilization by Level of Facility'
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
				            '<td style="padding:0"><b>{point.y:.1f} Patients</b></td></tr>',
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
				        name: 'Pilot Area',
				        data: pilotAreaData,
				        color: this.colors.blue

				    }, {
				        name: 'Non-Pilot Area (Average)',
				        data: nonPilotAreaData,
				        color: this.colors.orange

				    }]
				}
			},
			ipdLevelofFacility: function(){
				var categories = _.map(this.data.ipdFacilityLevelData, (o) => {
					return o.facility_level
				})

				var pilotAreaData = _.map(this.data.ipdFacilityLevelData, (o) => {
					return parseInt(o.totals)
				})

				var nonPilotAreaData = _.map(categories, (o) => {
					return 0
				})

				return {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: 'IPD Utilization by Level of Facility'
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
				            '<td style="padding:0"><b>{point.y:.1f} Patients</b></td></tr>',
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
				        name: 'Pilot Area',
				        data: pilotAreaData,
				        color: this.colors.blue

				    }, {
				        name: 'Non-Pilot Area (Average)',
				        data: nonPilotAreaData,
				        color: this.colors.orange

				    }]
				}
			}
		}
	}
</script>