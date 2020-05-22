<template>
	<form @submit.prevent="onSubmit()">
		<slot :form="form"></slot>
	</form>
</template>

<script>
	export default {
		props: ['curAction', 'curMethod', 'newAction', 'newMethod'],

		data() {
			return {
				form: new Form(),
				isChanged: false,
				action: this.curAction,
				method: this.curMethod
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

				axios[this.method](this.action, data)
					.then(response => {
						// Remove the user element after if it has 'remove-element' class
						if (this.$el.classList.contains('remove-element')) {
							this.$el.parentElement.parentElement.remove();
						}

						// For forms that only have a changable button
						if (this.$el.classList.contains('form-changes')) {
							this.isChanged = !this.isChanged;

							// Change form attributes and props
							this.action = this.isChanged ? this.newAction : this.curAction;
							this.method = this.isChanged ? this.newMethod : this.curMethod;
						}

						if (response.data.hasOwnProperty('message')) {
							console.log(response.data.message);
						}

						// Redirection if exists
						if (response.data.hasOwnProperty('redirect')) {
							window.location = response.data['redirect'];
						}
					})
					.catch(error => {console.log(error);
						this.form.errors.record(error.response.data.errors);
					});
			}
		}
	}
</script>