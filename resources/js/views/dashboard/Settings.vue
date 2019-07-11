<template>
	<div>
		<div class="row">
			<div class="col-md">
				<div class="card">
					<div class="card-body">
						<h3>Pilot Counties</h3>
						<b-button variant="primary" size="sm" @click="updateData">Update</b-button>
						<b-form-group>
							<b-form-checkbox-group
							v-model="selectedCounties"
							:options="countyOptions"
							stacked
							name="flavour-1a"
							></b-form-checkbox-group>
						</b-form-group>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data() {
			return {
				countyOptions: [],
				selectedCounties: []
			}
		},
		created(){
			this.getCounties()
		},
		methods: {
			getCounties: function(){
				axios.get('/api/counties').then((res)=> {
					this.countyOptions = _.map(res.data, (county) => {
						return {
							text: county.county,
							value: county.id
						}
					})

					var selectedCounties = _.map(res.data, (county) => {
						if (county.is_pilot == 1) {
							return county.id
						}
					})

					this.selectedCounties = _.without(selectedCounties, undefined)
				})
			},
			updateData: function(){
				axios.post('/api/counties/pilot', { counties: this.selectedCounties })
				.then(res => {
					console.log(res)
				})
			}
		}
	}
</script>