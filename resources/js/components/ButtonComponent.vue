<template>
	<button :class="mutableClass" :title="mutableTitle" v-html="mutableValue">
		<slot></slot>
	</button>
</template>

<script>

	export default {
		props: ['curClass', 'title', 'value', 'newClass', 'newTitle', 'newValue'],

		computed: {
			isChanged() {
				return this.$parent.isChanged;
			},
			mutableClass() {
				return this.isChanged ? this.newClass : this.curClass;
			},
			mutableTitle() {
				return this.isChanged ? this.newTitle : this.title;
			},
			mutableValue() {
				return this.isChanged ? this.newValue : this.value;
			}
		}
	}
	
</script>