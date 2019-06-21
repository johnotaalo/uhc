<template>
	<div>
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<b-card title="Upload Data">
					<div class="row">
						<div class="col-md">
							<label>Select the type of data you wish to upload</label>
							<b-form-select :options="data.dataTypes" v-model="form.dataType" class="mb-5"></b-form-select>
						</div>

						<div class="col-md">
							<label>Select the county</label>
							<b-form-select :options="selectCounties" v-model="form.county" class="mb-5"></b-form-select>
						</div>
					</div>
					
					<vue-dropzone id="dropzone" ref = "dropzone" :options="dropzoneOptions" @vdropzone-sending="sendingEvent"></vue-dropzone>

					<b-button @click="submitUpload" block variant="primary" class = "mt-5" size="sm">Upload Data</b-button>
				</b-card>
				
			</div>
			<div class="col-md">
				
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import vue2Dropzone from 'vue2-dropzone'
	import 'vue2-dropzone/dist/vue2Dropzone.min.css'

	export default {
		components: {
			vueDropzone: vue2Dropzone
		},
		data() {
			return {
				selectedDataType: null,
				form: {
					dataType: null,
					county: null
				},
				data: {
					dataTypes: [
						{ value: null, text: 'Please select an option' },
						{ value: 515, text: 'MoH 515' },
						{ value: 717, text: 'MoH 717' }
					],
					counties: {}
				},
				dropzoneOptions: {
					url: '/api/data/uploadData',
					thumbnailWidth: 200,
					addRemoveLinks: true,
					autoProcessQueue: false,
					timeout: 0,
					acceptedFiles: "text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
					dictDefaultMessage: '<div class="dz-icon"><i class="demo-pli-upload-to-cloud" style="font-size: 5em;"></i></div><div><span class="dz-text">Drop file to upload</span><p class="text-sm text-muted">or click to pick manually</p><p><strong>Accepted file formats (.csv and .xlsx)</strong></p></div>',
					maxFiles: 1,
					init: function(){
						this.on("maxfilesexceeded", function(file){
							alert("You cannot upload more than 1 File");
							this.removeFile(file);
						})
						this.on("addedfile", function(file){
							// em.uploadBtnDisplay = true
						})
						this.on("removedfile", function(file){
							// em.uploadBtnDisplay = false
						})
					},
					success: function(){
						// this.isLoading = false
						location.reload();
					}
				}
			}
		},
		created(){
			this.getComponentOptions();
		},
		methods: {
			submitUpload: function() {
				this.$refs.dropzone.processQueue();
			},
			getComponentOptions: function(){
				var em = this
				axios.get('/api/data/uploadOptions')
				.then((res) => {
					console.log(res);
					em.data.counties = res.data.counties
				});
			},
			sendingEvent: function (file, xhr, formData) {
				// this.isLoading = true
				var data = this.form;
				formData = this.createFormData(data, formData)
			},
			createFormData(data, formData = null, previousKey = null){
				if (!formData) { formData = new FormData() }
				if (data instanceof Object) {
					Object.keys(data).forEach(key => {
						const value = data[key]
						if (previousKey) {
							key = `${previousKey}[${key}]`
						}
						if (value instanceof Object && !Array.isArray(value)) {
							this.createFormData(value, formData, key)
						}
						if (Array.isArray(value)) {
							value.forEach((val, index) => {
								let arrayIndex = index
								if (val.id) { arrayIndex = val.id }
								this.createFormData(val, formData, key + `[${arrayIndex}]`)
								// formData.append(`${key}[]`, val);
							})
						} else if (value instanceof Blob) {
							formData.append(key, value)
						} else if (!(value instanceof Object)) {
							formData.append(key, value)
						}
					})
					return formData
				}
			}
		},
		computed: {
			selectCounties: function(){
				console.log("counties");
				var counties = _.map(this.data.counties, (o) => {
					return {
						value: o.id,
						text: o.county
					}
				})
				console.log(counties);
				return counties 
			}
		}
	}
</script>