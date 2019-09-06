/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('edit-post-modal', require('./components/EditPostModal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});







/**
* Our custom jquery
*/
$(document).ready(function () {
	// Show post options
	$('i#show-options').click(function () { 
		$(this).siblings('div#post-options').fadeToggle(100);
		$('div#post-options').not($(this).parent().find('div#post-options')).fadeOut(100); 
	});

	// Hide post options when clicking anywhere
	$('body').click(function (element) {
		if (element.target.id == 'show-options') {
			return;
		} 

		$('div#post-options').fadeOut(100); 
	});


	// Show post data in modal
	$('.open-modal').click(function () {
		let post = $(this).data('post');

		$('.modal').find('form').find('textarea').text(post.body);
		$('.modal').find('form').attr('action', 'posts/' + post.id);
	});


	// Show errors when clicking submit button
	$('#submit-update, #submit-create').click(function (e) {
		let textarea = $(this).parents('form').find('textarea');

		if (textarea.val() == '') {
			textarea.addClass('border-red-300');
			textarea.siblings('#error').show();
			e.preventDefault();
		} 
	});


});

	
