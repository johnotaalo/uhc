<template>
	<div>
		<loading :active.sync="isLoading" color="#2196F3" :can-cancel="false" :is-full-page="fullPage"></loading>
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
								<highcharts :options="opdSectorUtilizationGraphs['Non Pilot']"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="opdSectorUtilizationGraphs['Pilot']"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="opdSectorUtilizationGraphs['Pilot']"></highcharts>
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
								<highcharts :options="ipdSectorUtilizationGraphs['Non Pilot']"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="ipdSectorUtilizationGraphs['Pilot']"></highcharts>
							</div>
							<div class="col">
								<highcharts :options="ipdSectorUtilizationGraphs['Pilot']"></highcharts>
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
								<small><strong class="text-success text-bold">{{ totalReferrals | numFormat }}</strong> per 1000 visits</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in non-pilot area</small>
								<small><strong class="text-danger text-bold">0</strong> per 1000 visits</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in pilot area 2018</small>
								<small><strong class="text-success text-bold">{{ totalReferrals | numFormat }}</strong> per 1000 visits</small>
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
								<small><strong class="text-success text-bold">{{ data.losData.average | numFormat }}</strong> bed days</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in non-pilot area</small>
								<small><strong class="text-success text-bold">0</strong> bed days</small>
							</li>

							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>Rate of referrals in pilot area 2018</small>
								<small><strong class="text-danger text-bold">{{ data.losData.average | numFormat }}</strong> bed days</small>
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
								<tr v-for = "facility in data.losData.data">
									<td>{{ facility.facility_name }}</td>
									<td>{{ facility.county }}</td>
									<td>{{ facility.facility_level }}</td>
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
				loadingNumber: 0,
				isLoading: false,
				fullPage: true,
				options: [
					{ value: '', text: 'National' },
				],
				areas: ["Pilot", "Non Pilot"],
				sectors: ["Private", "Public"],
				colors: colors,
				selected: "",
				data: {
					population: 0,
					opdIpdData: [],
					opdFacilityLevelData: [],
					ipdFacilityLevelData: [],
					referralData: [],
					losData: [],
					opdUtilization: [],
					ipdUtilization: [],
					ipdSectorUtilization: [],
					opdSectorUtilization: [],
					
				}
			}
		},
		created(){
			this.getCountyPopulation(this.selected);
			this.getIPDOPDPilotCountyDetails(this.selected)
			this.getOPDLevelofFacilityDetails(0)
			this.getIPDLevelofFacilityDetails(0)
			this.getPilotAreas();
			this.getFacilityReferrals(this.selected);
			this.getUtilizationSectorData(this.selected);
			this.getFacilityLOS(this.selected)
		},
		methods: {
			getUtilizationSectorData(county_id){
				this.loadingNumber++
				var c_id = (county_id == "") ? 0 : county_id;
				axios.get(`/api/data/utilization/sector/opd-ipd/${c_id}`)
				.then((res) => {
					this.data.ipdSectorUtilization = res.data[0]
					this.data.opdSectorUtilization = res.data[1]

					this.loadingNumber--
				});
			},
			getPilotAreas: function(){
				this.loadingNumber++
				axios.get('/api/counties/pilot')
				.then((res) => {
					var options = _.map(res.data, (o) => {
						return { value: o.id, text: o.county }
					})

					var merge =this.options.concat(options)
					this.options = merge

					this.loadingNumber--
				});
			},
			getIPDOPDPilotCountyDetails(county_id){
				this.loadingNumber++
				axios.post('/api/data/counties/pilot/opd-ipd', { id: county_id })
				.then((res) => {
					this.data.opdIpdData = res.data
					this.loadingNumber--
				})
			},

			getOPDLevelofFacilityDetails(county_id){
				this.loadingNumber++
				var c_id = (county_id == "") ? 0 : county_id
				axios.post('/api/data/counties/facility/level/opd', { id: c_id })
				.then((res) => {
					this.data.opdFacilityLevelData = res.data
					this.loadingNumber--
				})
			},

			getIPDLevelofFacilityDetails(county_id){
				this.loadingNumber++
				var c_id = (county_id == "") ? 0 : county_id
				axios.post('/api/data/counties/facility/level/ipd', { id: c_id })
				.then((res) => {
					this.data.ipdFacilityLevelData = res.data
					this.loadingNumber--
				})
			},

			getCountyPopulation(val){
				this.loadingNumber++
				if(val == ""){
					val = 'national'
				}
				axios.get(`/api/data/counties/population?q=${val}`)
				.then((res) => {
					this.data.population = res.data
					this.loadingNumber--
				})
			},

			getFacilityReferrals(county_id){
				this.loadingNumber++
				var c_id = (county_id == "") ? 0 : county_id;

				axios.get(`/api/data/referrals/${c_id}`)
				.then((res) => {
					var _data = _.orderBy(res.data, ['referrals'], ['desc'])
					this.data.referralData = _data
					this.loadingNumber--
				});
			},

			getFacilityLOS(county_id){
				this.loadingNumber++
				var c_id = (county_id == "") ? 0 : county_id;

				axios.get(`/api/data/los/${c_id}`)
				.then((res) => {
					// var _data = _.orderBy(res.data, ['referrals'], ['desc'])
					this.data.losData = res.data
					this.loadingNumber--
				});
			}
		},
		watch: {
			selected: function(val){
				this.getCountyPopulation(val)
				this.getIPDOPDPilotCountyDetails(val)
				this.getOPDLevelofFacilityDetails(val)
				this.getIPDLevelofFacilityDetails(val)
				this.getUtilizationSectorData(val)
				this.getFacilityReferrals(val)
				this.getFacilityLOS(val)
			},
			loadingNumber: function(val){
				if (val > 0) {
					this.isLoading = true
				}else{
					this.isLoading = false
				}
			}
		},
		computed: {
			totalReferrals: function(){
				return _.sumBy(this.data.referralData, 'referrals')
			},
			referralRate: function(){
				// return (1000 * this.totalReferrals) / ()
			},
			top10referrals: function(){
				var top = this.data.referralData.slice(0, 10)
				return top;
			},
			ipdSectorUtilizationGraphs: function(){
				var charts = {}
				var colors = _.map(this.colors, (color) => {
					return color
				})

				_.forOwn(this.areas, (area) => {
					charts[area] = {};
					var data = [];

					_.forOwn(this.sectors, (sector, k) => {
						var selected = _.find(this.data.ipdSectorUtilization, ['facility_owner', sector]);
						if(selected !== undefined){
							data.push({ name: sector, y: parseInt(selected.number), color: colors[k] })
						}
					})

					console.log(data)

					charts[area] = {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: area + ' Area'
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
					        name: area + ' Area',
					        colorByPoint: true,
					        data: data
					    }]
					}
				})

				return charts
			},
			opdSectorUtilizationGraphs: function(){
				var charts = {}
				var colors = _.map(this.colors, (color) => {
					return color
				})

				_.forOwn(this.areas, (area) => {
					charts[area] = {};
					var data = [];

					_.forOwn(this.sectors, (sector, k) => {
						var selected = _.find(this.data.opdSectorUtilization, ['facility_owner', sector]);
						if(selected !== undefined){
							data.push({ name: sector, y: parseInt(selected.number), color: colors[k] })
						}
					})

					console.log(data)

					charts[area] = {
						chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: area + ' Area'
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
					        name: area + ' Area',
					        colorByPoint: true,
					        data: data
					    }]
					}
				})

				return charts
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