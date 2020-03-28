<template>
	<form
		:action="url" 
		method="POST"
		@submit.prevent="onSubmit()"
	>
		<slot :form="form"></slot>
	</form>
</template>

<script>
export default {
	props: ['url', 'method'],

	data() {
		return {
			form: new Form()
		};
	},

	methods: {
		onSubmit() {
			var formData = new FormData(this.$el);

			var data = {};
			formData.forEach(function(val, key) {
				if (key != '_method' && key != '_token')
			  		data[key] = val;
			});

			this.form.setData(data);

			axios[this.method](this.url, data)
				.then(response => {console.log(response.data);
					if (response.data.hasOwnProperty('redirect')) {
						window.location = response.data['redirect'];
					}
				})
				.catch(error => {
					this.form.errors.record(error.response.data.errors);
				});
		}
	}
}
</script>