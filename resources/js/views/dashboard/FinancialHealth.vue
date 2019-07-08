<template>
	<div>
		<div class="header-body mb-3">
			<div class="row align-items-end">
				<div class="col-md">
					<h6 class="header-pretitle">
						Total Budget
					</h6>
					<h1 class="header-title">
						KSH. 4,500,000
					</h1>
				</div>

				<div class="col-md">
					<h6 class="header-pretitle">
						Total Funds Disbursed
					</h6>
					<h1 class="header-title">
						KSH. 3,500,000
					</h1>
				</div>

				<div class="col-md">
					<h6 class="header-pretitle">
						Total Funds Spent
					</h6>
					<h1 class="header-title">
						KSH. 3,450,000
					</h1>
				</div>

				<div class="col-md">
					<h6 class="header-pretitle">
						Total Funds Remaining
					</h6>
					<h1 class="header-title">
						KSH. 0
					</h1>
				</div>
			</div> <!-- / .row -->
		</div>
		<div class="row">
			<div class="col-md">
				<div class="card">
					<div class="card-body">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex align-items-center justify-content-between px-0">
								<small>At the current rate of expenditure, remaining funds will be spent by</small>
								<small><strong class="text-success text-bold">To be discussed</strong></small>
							</li>
						</ul>
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
								<h4 class="card-header-title">Budget Utilization by County</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="countyUtilization"></highcharts>
					</div>
				</div>
			</div>
			<div class="col-md">
				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Budget Utilization by Activity</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<highcharts :options="activityUtilization"></highcharts>
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
								<h4 class="card-header-title">Budget Priorities By County</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col" v-for="(data, county) in countyData">
								<county-budget :title = "county" :key="county" :data="data"></county-budget>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import CountyBudget from '../../components/graphs/CountyBudget'
	export default {
		components: {CountyBudget},
		data(){
			let colors = {
				blue: "#4472c4",
				orange: "#ed7d31",
				pink: "#c2185b",
				green: "#43a047",
				red: "#e53935"
			};
			return {
				counties: ["Isiolo", "Kisumu", "Machakos", "Nyeri"],
				priorities: ["Medicines", "Equipment", "Operations", "Human Resources", "Community Health"],
				colors: colors
			}
		},
		computed: {
			countyUtilization: function(){
				return {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: null
				    },
				    xAxis: {
				        categories: this.counties
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Utilization'
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
				        pointFormat: '{series.name}: {point.y}<br/>Utilization: {point.stackTotal}'
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
				        name: 'Budget Utilized',
				        data: [10000, 22000, 10500, 1500],
				        color: this.colors.blue
				    }, {
				        name: 'Budget Remaining',
				        data: [20000, 22000, 3000, 700],
				        color: this.colors.orange
				    }]
				}
			},
			activityUtilization: function(){
				return {
					chart: {
				        type: 'column'
				    },
				    title: {
				        text: null
				    },
				    xAxis: {
				        categories: ['Medicines', 'Equipment', 'Operations', 'Human Resources', 'Community Health']
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'Utilization'
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
				        pointFormat: '{series.name}: {point.y}<br/>Utilization: {point.stackTotal}'
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
				        name: 'Budget Utilized',
				        data: [10000, 10000, 30500, 1500, 2300],
				        color: this.colors.blue
				    }, {
				        name: 'Budget Remaining',
				        data: [20000, 12000, 15000, 7000, 2500],
				        color: this.colors.orange
				    }]
				}
			},
			countyData: function(){
				var data = {};
				_.forOwn(this.counties, (county) => {
					if(typeof data[county] == "undefined"){
						data[county] = [];
					}

					var colorsArr = _.map(this.colors, (color)=>{
						return color
					})

					var k = 0;
					_.forOwn(this.priorities, (priority) => {
						var obj = {};

						obj.name = priority
						obj.y = _.random(100000, 10000000)
						obj.color = colorsArr[k]

						data[county].push(obj)

						k++
					})

				})

				return data;
			}
		}
	}
</script>