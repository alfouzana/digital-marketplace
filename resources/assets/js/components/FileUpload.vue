<template>
	<div>
		<input type="file" 
    	   	   :id="id"
    	   	   required="true" 
		       @change="fileChange">

	    <input type="hidden" 
	    	   :name="name"
	    	   :value="fileId">

		<button type="button"
				class="btn btn-sm btn-primary"
				v-if="file"
				:disabled="fileId"
				@click="upload">{{ uploadText }}</button>

		<span class="text-success" v-if="fileId">
			<i class="fa fa-check"></i>
		</span>

		<span class="text-danger" v-if="error">
			<i class="fa fa-times"></i>
		</span>
	</div>		
</template>

<script>
	export default {
		data () {
			return {
				file: null,
				fileId: null,
				error: false
			}
		},

		methods: {
			fileChange (event) {
				this.file = event.target.files[0];
				this.fileId = null;
				this.error= false;
			}, 
			upload () {
				this.error = false;

				let formData = new FormData();
				formData.append('file', this.file);
				formData.append('assoc', this.assoc);
				axios.post('/user/files', formData).then(({data}) => {
					this.fileId = data.id;
				}).catch((error) => {
					this.error = true;
				});
			}
		},
		props: [
			'id', 'assoc', 'name', 'uploadText'
		]
	}
</script>
