


/**
* Our custom javascript & jquery
*/
$(document).ready(function() {

	// Show post options
	$('i#show-options').on('click', function () {
		$(this).siblings('div#post-options').fadeToggle(100);
		$('div#post-options').not($(this).parent().find('div#post-options')).fadeOut(100);
	});

	// Hide post options when clicking anywhere
	$(document).click(function (e) {
		if (e.target.id !== 'show-options' && e.target.id !== 'post-options') {
			$('div#post-options').fadeOut(100);
		} 
	});


	// Show post data in modal to edit the post
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
		if (! $(this).data('in-show-page') && e.target.id != 'show-options' && e.target.id != 'post-options' && e.target.id != 'open-post-modal') {
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


	// Friend requests event handler
	$('button#send_friend_request, button#cancel_friend_request, button#accept_friend_request, button#delete_friend_request').click(function(e) {
		e.preventDefault();

		handleFriendRequest(this);
	});


	// Show friend requests menue
	$('#friend-requests-dropdown').css('top', $('nav').innerHeight());

	$('#show-friend-requests').click(function () { 
		$(this).children('i#show-friend-requests').toggleClass('text-gray-700').toggleClass('text-primary');
		$(this).siblings('div#friend-requests-dropdown').toggle();
	});

	// Hide friend requests menue when clicking anywhere except the menue
	$(document).click(function (e) {
		if (e.target.id == 'friend-requests-dropdown' || e.target.id == 'show-friend-requests') {
			return;
		}

		if (e.target.parentElement.id == 'friend-requests-dropdown' || e.target.parentNode.offsetParent.id == 'friend-requests-dropdown') {
			return;
		}

		$('i#show-friend-requests').removeClass('text-primary').addClass('text-gray-700');
		$('div#friend-requests-dropdown').hide();
	});


	// Login register card
	$('.create-account-button').click(function () {
		$(this).parents('.login-register').css({
				'-webkit-transform': 'rotateY(180deg)',
				'-moz-transform': 'rotateY(180deg)',
				'-o-transform': 'rotateY(180deg)',
				'transform': 'rotateY(180deg)'
			});

		$('.register-card').css('z-index', '2');
	});

	$('.have-account').click(function () {
		$(this).parents('.login-register').css({
				'-webkit-transform': 'rotateY(0)',
				'-moz-transform': 'rotateY(0)',
				'-o-transform': 'rotateY(0)',
				'transform': 'rotateY(0)'
			});
	});


	// Show register card if a register request
	if ($('.register-card').data('request') == 'register-request') {
		$('.login-register').css({
				'-webkit-transform': 'rotateY(180deg)',
				'-moz-transform': 'rotateY(180deg)',
				'-o-transform': 'rotateY(180deg)',
				'transform': 'rotateY(180deg)'
			});

		$('.login-card form input[type=email]').val('');
	}

		
	// Hello there login page
	window.onload = () => {
		let container = document.querySelector('.hello-there'),
			text = "Hello there! You are gonna join my website now. I hope you keep silent here because it's not some kind of memes-website. It's ok to share memes but keep your fu*kin mouth shut up. Sorry, dude for my language and have fun",
			i = 0;
		if (container) {
			let writer = setInterval(() => {
				container.innerHTML += text[i++];

				if (text[i - 1] === '.') {
					container.innerHTML += '<br>';
				}

				if (i == text.length) {
					clearInterval(writer);
				}
			}, 100);
		}
	};


	// Like a post
	$('.like-post').on('click', handlePostLikes);

});


/**
* Functions
*/
// Send / cancel / delete / accept friend requests
async function handleFriendRequest(el) {
	if ($(el).attr('id') == 'send_friend_request') {
		// loader
		// $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
		$(el).attr('class', 'button-outline-secondary ml-auto');
		// send the request
		await $.get('/users/request/send/' + $(el).data('user-id'));
		$(el).attr('id', 'cancel_friend_request');
		$(el).attr('title', 'Click to cancel the request');
		$(el).html('<i class="fa fa-check"></i> Sent');
	} else if ($(el).attr('id') == 'cancel_friend_request') {
		// $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
		$(el).attr('class', 'button-outline-primary ml-auto');
		await $.get('/users/request/cancel/' + $(el).data('user-id'));
		$(el).attr('id', 'send_friend_request');
		$(el).attr('title', 'Click to send a friend request');
		$(el).html('<i class="fa fa-plus"></i> Add');
	} else if ($(el).attr('id') == 'accept_friend_request') {
		// $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
		$(el).attr('class', 'button-outline-primary ml-auto');
		await $.get('/users/request/accept/' + $(el).data('user-id'));
		$(el).parents('#friend-request').fadeOut(500);
	} else if ($(el).attr('id') == 'delete_friend_request') {
		// $(el).html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
		$(el).attr('class', 'button-outline-primary ml-auto');
		await $.get('/users/request/delete/' + $(el).data('user-id'));
		$(el).parents('#friend-request').fadeOut(500);
	}
}

// handle post likes
async function handlePostLikes() {
	// like or dislike post
	let likesCount = await $.get('/posts/' + $(this).data('post-id') + '/liked');
	$(this).toggleClass('text-primary text-gray-500');

	// display & update likes count on post
	let likesBox = $(this).parents('.post-box').children('.post').children('.post-likes-count');
	if (likesBox.hasClass('hidden') || likesCount == 0) {
		likesBox.toggleClass('hidden');
	}
	likesBox.children('.likes-count').html(likesCount);
}