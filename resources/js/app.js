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
	$(document).click(function (element) {
		if (element.target.id == 'show-options') {
			return;
		} 

		$('div#post-options').fadeOut(100); 
	});


	// Show post data in modal
	$('.open-post-modal').click(function () {
		let post = $(this).data('post');

		$('.post-modal').find('form').find('textarea').text(post.body);

		if ((window.location.pathname == '/') || (window.location.pathname == '/home')) {
			$('.post-modal').find('form').attr('action', '/posts/' + post.id);
		}
	});


	// Show post errors when clicking submit button
	$('#submit-update-post, #submit-create-post').click(function (e) {
		let textarea = $(this).parents('form').find('textarea');

		if (textarea.val() == '') {
			textarea.addClass('border-red-300');
			textarea.siblings('#error').show();
			e.preventDefault();
		} else {
			textarea.removeClass('border-red-300');
			textarea.addClass('border-green-500');
			textarea.siblings('#error').hide();
		}
	});


	// Redirect to post page when u click on it
	$('.post').click(function (e) {
		if (! $(this).data('in-show-page') && e.target.id != 'show-options' && e.target.id != 'open-post-modal') {
			window.location = $(this).data('post');
		}
	}); 


	// Show group errors when clicking submit button
	$('#submit-create-group').click(function (e) {
		let nameInput = $(this).parents('form').find('#name');
		let descriptionInput = $(this).parents('form').find('#description');

		if (nameInput.val() == '') {
			nameInput.addClass('border-red-300');
			nameInput.siblings('#error').show();
			e.preventDefault();
		} else {
			nameInput.removeClass('border-red-300');
			nameInput.addClass('border-green-500');
			nameInput.siblings('#error').hide();
		}

		if (descriptionInput.val() == '') {
			descriptionInput.addClass('border-red-300');
			descriptionInput.siblings('#error').show();
			e.preventDefault();
		} else {
			descriptionInput.removeClass('border-red-300');
			descriptionInput.addClass('border-green-500');
			descriptionInput.siblings('#error').hide();
		}
	});


	// send friend request
	$('button#send_friend_request, button#cancel_friend_request').click(function (e) {
		e.preventDefault();

		if ($(this).attr('id') == 'send_friend_request') {
			$.get('/users/add/' + $(this).data('user-id'));
			$(this).attr('id', 'cancel_friend_request');
			$(this).attr('class', 'button-outline-secondary ml-auto');
			$(this).attr('title', 'Click to cancel the request');
			$(this).html('<i class="fa fa-check"></i> Sent');
		} else {
			$.get('/users/cancel/' + $(this).data('user-id'))
			$(this).attr('id', 'send_friend_request');
			$(this).attr('class', 'button-outline-primary ml-auto');
			$(this).attr('title', 'Click to send a friend request');
			$(this).html('<i class="fa fa-plus"></i> Add');
		}
	});
});

	
