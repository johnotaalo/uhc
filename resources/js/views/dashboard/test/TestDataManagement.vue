<template>
	<div>
		<b-card no-body>
			<b-tabs card>
				<b-tab title="Data FIelds" active>
					<div class="form-group">
						<b-select :options="dataTypes" v-model="dataType"></b-select>
					</div>
					<b-input-group class="mt-3">
						<v-select class="form-control" label="data_name" :filterable="false" :options="data" @search="onDataSearch" v-model="selectedData" multiple></v-select>
						<b-input-group-append>
							<b-button size="sm" @click="addDataToType">Add</b-button>
						</b-input-group-append>
					</b-input-group>
					<b-table :fields="columns" :items="tableItems">
						<template slot="Actions">
							<b-button variant="danger" size="sm">Delete</b-button>
						</template>
					</b-table>
				</b-tab>
			</b-tabs>
		</b-card>
	</div>
</template>

<script type="text/javascript">
	import _ from 'lodash'
	export default{
		data(){
			return {
				dataType: "",
				dataTypes: [],
				columns: [
					{key: 'no', label: "#"}, 
					{key: 'data_name', label: "Data Name"}, 
					"Actions"
				],
				tableItems: [],
				data: [],
				selectedData: ""
			}
		},
		created(){
			console.log("Created")
			this.getDataTypes()
		},
		methods: {
			getDataTypes: function(){
				axios.get('/api/data/types')
				.then((res) => {
					this.dataTypes = _.map(res.data, (v, k) => {
						return {
							value: k,
							text: v
						}
					})
				});
			},

			getDataNamesForDataType: function(type){
				axios.get(`/api/data/names/${type}`)
				.then((res) => {
					this.tableItems = this.cleanDataItems(res.data)
				});
			},

			cleanDataItems: function(data){
				return _.map(data, (v, k) => {
					return {
						no: k + 1,
						data_name: v.data_name
					}
				})
			},

			onDataSearch: function(search, loading){
				loading(true)
				this.searchData(loading, search, this)
			},

			searchData: _.debounce( (loading, search, vm) => { 
				axios(`/api/data/search?q=${escape(search)}`)
				.then((res) => {
					vm.data = res.data
					loading(false)
				})
			}, 350),

			addDataToType: function(){
				var d = _.map(this.selectedData, (o) => {
					return o.id
				})
				axios.post('/api/data/name/type/add', { type: this.dataType, data: d })
				.then((res) => {
					this.tableItems = this.cleanDataItems( res.data );
				})
			}
		},
		watch: {
			dataType: function(val){
				this.getDataNamesForDataType(val)
			}
		}
	}
</script>