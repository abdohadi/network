import './bootstrap';

/*****************************************************************************
 * vue section
 ******************/

// Form component
import FormComponent from './components/FormComponent.vue';
Vue.component('form-component', FormComponent);

// Button component
import ButtonComponent from './components/ButtonComponent.vue';
Vue.component('button-component', ButtonComponent);

const app = new Vue({
    el: '#app',

	data: {
		selectedList: 'friends-list',			// Toggle between friends and requests menues
	}
});








/****************************************************************************************************
 * Our custom javascript & jquery
 ***********************************/
$(document).ready(function() {
	/** 
	 * Profile page section
	 */
	// Show profile picture overlay 
	$('.profile-pic-parent-overlay').hover(function() {
	  	$(this).children('.profile-pic-overlay').show();
	  	$(this).children('.show-pic-overlay').show();

	  	$(this).find('.profile-pic-overlay .fa-camera').animate({fontSize: '2rem'}, 100, function() {
          $(this).animate({fontSize: '1.5rem'}, 400);
      });

      if (window.profilePicChanged) {
		  	$(this).children('.profile-form-pic-overlay').show();
	  		$(this).children('.show-pic-overlay').hide();
      }
	}, function() {
	  	$(this).children('.profile-pic-overlay').hide();
	  	$(this).children('.show-pic-overlay').hide();

      if (window.profilePicChanged) {
		  	$(this).children('.profile-form-pic-overlay').hide();
      }
	});

	// click on profile picture input when clicking on profile pic overlay 
	$('.profile-pic-overlay').on('click', function() {
		$('.profile-picture-input').click();
	});

	// Profile pic preview when choosing a pic
	$('.profile-picture-input').on('change', function() {
		if ($(this)[0].files && $(this)[0].files[0]) {
			let reader = new FileReader();

			reader.onload = function(e) {
			  	$('.profile-picture').attr('src', e.target.result);
			}

			reader.readAsDataURL($(this)[0].files[0]);
		}

		window.profilePicChanged = true;
	});

	// Get the original user's profile picture when clicking on cancel btn
	$('.cancel-profile-pic-btn').on('click', function(e) {
		e.preventDefault();

		// Get the picture src back
		$('.profile-picture').attr('src', $(this).data('pic-src'));

		// Hide profile-form-pic-overlay
		window.profilePicChanged = false;
		$('.profile-form-pic-overlay').hide();
	  	$('.show-pic-overlay').show();
	});

	// click on cover input when clicking on profile pic overlay 
	$('.change-cover-btn').on('click', function(e) {
		e.preventDefault();

		$('.cover-input').click();
	});

	// cover preview when choosing a pic
	$('.cover-input').on('change', function() {
		if ($(this)[0].files && $(this)[0].files[0]) {
			let reader = new FileReader();

			reader.onload = function(e) {
			  	$('.cover-img').attr('src', e.target.result);
			}

			reader.readAsDataURL($(this)[0].files[0]);
		}

		$('.profile-cover-form').css('display', 'inline');
	});

	// Get the original user's cover when clicking on cancel btn
	$('.cancel-cover-btn').on('click', function(e) {
		e.preventDefault();

		// Get the picture src back
		$('.cover-img').attr('src', $(this).data('cover-src'));

		// Hide profile-cover-form
		$('.profile-cover-form').hide();
	});



	/**
	 *	Posts Section
	 */
	// Show post options
	$(document).on('click', '.show-options', function () {
		$(this).siblings('div.options').fadeToggle(100);

		$('div.options').not($(this).parent().find('div.options')).fadeOut(100);
	});

	// Hide post options when clicking anywhere
	$(document).click(function (e) {
		if (e.target.parentElement) {
			if (! e.target.classList.contains('show-options') && ! e.target.classList.contains('options') && ! e.target.parentElement.classList.contains('show-options')) {
				$('div.options').fadeOut(100);
			} 
		}
	});

	// Show post data in modal to edit the post
	$('.open-post-modal').click(function () {
		let post = $(this).data('post');

		$('.post-modal').find('textarea').text(post.body);
		$('.post-modal').find('textarea').val(post.body);
		$('.post-modal').find('form').attr('action', '/posts/' + post.id);

		if ((window.location.pathname == '/') || (window.location.pathname == '/home')) {
			$('.post-modal').find('form').attr('action', '/posts/' + post.id);
		}
	});

	// Add post
	$('#submit-create-post').on('submit', function(e) {
		e.preventDefault();

		let textarea = $(this).find('textarea'),
			 url = $(this).attr('action'),
			 data = $(this).serializeArray().reduce((obj, item) => {
			    obj[item.name] = item.value;
			    return obj;
			 }, {});

		createOrUpdatePost(textarea, url, data, 'post');
	});

	// Update post
	$('#submit-update-post').on('submit', function(e) {
		e.preventDefault();

		let textarea = $(this).find('textarea'),
			 url = $(this).attr('action'),
			 data = $(this).serializeArray().reduce((obj, item) => {
			    obj[item.name] = item.value;
			    return obj;
			 }, {});

		createOrUpdatePost(textarea, url, data, 'patch');
	});

	// Set the path for the action of share-post-form
	$('.open-share-post-modal').on('click', function() {
		$('#share-post-form').attr('action', $(this).data('post-path'));
	});


	/**
	 *	Comments Section
	 */
	// Focus on comment input
	$('.comment-span').on('click', function() {
		$(this).parents('.post-box').find('.comment-textarea').focus();
	});

	// Add comment
	$('.comment-textarea').on('keydown', function(e) {
		if (e.witch == 13 || e.charCode == 13 || e.keyCode == 13) {
			e.preventDefault();
			var form = $(this).parents('form');

			let url = form.attr('action'),
				 data = form.serializeArray().reduce((obj, item) => {
				    obj[item.name] = item.value;
				    return obj;
				 }, {});
			
			addComment(form, data, url);
		}
	});

	// Show comment data in modal to edit the comment
	$(document).on('click', '.open-comment-modal', function () {
		let commentUpdateUrl = $(this).data('update-comment-url');
		let commentBody = $(this).parents('.user-comment').find('.comment-body').text();

		window.commentToEdit = $(this).parents('.user-comment').find('.comment-body');

		$('.comment-modal').find('textarea').val(commentBody);

		$('.comment-modal').find('form').attr('action', commentUpdateUrl);
	});

	// Update comment
	$('.update-comment-form').on('submit', function(e) {
		e.preventDefault();

		let url = $(this).attr('action'),
			data = $(this).serializeArray().reduce((obj, item) => {
			   	obj[item.name] = item.value;
			    return obj;
			}, {});

		updateComment($(this), data, url);
	});

	// Delete comment 
	$(document).on('click', '.delete-comment', function(e) {
		e.preventDefault();

		$.ajax({
			url: $(this).data('delete-comment-url'),
			method: 'get',
			success: () => {
				$(this).parents('.user-comment').remove();			
			},
			error: (error) => {
				console.log('error');
			}
		});
	});


	/**
	 *	Likes Section
	 */
	// Like a post
	$('.like-post').on('click', handlePostLikes);


	/**
	 *	Groups Section
	 */
	// Show group errors when clicking submit button
	$('#submit-create-group').click(function (e) {
		let nameInput = $(this).parents('form').find('#name');
		let descriptionInput = $(this).parents('form').find('#description');

		if (nameInput.val() == '') {
			nameInput.addClass('border-red-300');
			nameInput.siblings('.group-error').show();
			e.preventDefault();
		} else {
			nameInput.removeClass('border-red-300');
			nameInput.addClass('border-green-500');
			nameInput.siblings('.group-error').hide();
		}

		if (descriptionInput.val() == '') {
			descriptionInput.addClass('border-red-300');
			descriptionInput.siblings('.group-error').show();
			e.preventDefault();
		} else {
			descriptionInput.removeClass('border-red-300');
			descriptionInput.addClass('border-green-500');
			descriptionInput.siblings('.group-error').hide();
		}
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

		if (e.target.parentElement) {
			if (e.target.parentElement.id == 'friend-requests-dropdown') {
				return;
			}
		}

		if (e.target.parentNode) {
			if (e.target.parentNode.offsetParent) {
				if (e.target.parentNode.offsetParent.id == 'friend-requests-dropdown') {
					return;
				}
			}
		}

		$('i#show-friend-requests').removeClass('text-primary').addClass('text-gray-700');
		$('div#friend-requests-dropdown').hide();
	});


	/**
	 *	Login Section
	 */
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
	
	// Hello there login page loader 
	// let container = document.querySelector('.hello-there'),
	// 	text = "Hello there!.... You are going to join our website now. I hope you keep silent here because it's not some kind of memes-website. It's ok to share memes but keep your fu*kin mouth shut up..../Sorry! for my language. Have fun",
	// 	i = 0;
	// if (container) {
	// 	let writer = setInterval(() => {
	// 		container.innerHTML += text[i++];

	// 		if (text[i - 1] === '/') {
	// 			container.innerHTML += '<br>';
	// 		}

	// 		if (i == text.length) {
	// 			clearInterval(writer);
	// 		}
	// 	}, 150);
	// }

});



/********************************
* Functions
********************************/
// add or update post
async function createOrUpdatePost(textarea, url, data, method) {
	await $.ajax({
			url: url,
			method: method,
			data: data,
			success: function(success) {
				textarea.removeClass('border-red-300');
				textarea.addClass('border-green-500');
				textarea.siblings('.post-error').hide();

				window.location = success.redirect;
			},
			error: function(error) {
				textarea.addClass('border-red-300');
				textarea.siblings('.post-error').html(error.responseJSON.errors.body[0]);
			}
		});
}

// handle post likes
async function handlePostLikes() {
	// like or dislike post
	let likesCount = await $.get('/posts/' + $(this).data('post-id') + '/like');
	$(this).toggleClass('text-primary text-gray-500 hover:text-gray-600');

	// display & update likes count on post
	let likesBox = $(this).parents('.post-box').find('.post-likes-count');
	if (likesBox.hasClass('hidden') || likesCount == 0) {
		likesBox.toggleClass('hidden');
	}
	likesBox.children('.likes-count').html(likesCount);
}

// handle adding comment request
async function addComment(form, data, url) {
	await $.ajax({
		url: url,
		type: 'post',
		data: data,
		success: function(success) {
			let userName = form.data('user-name');
			let userPath = form.data('user-path');
			let postId = form.data('post-id');
			let editTrans = form.data('edit-trans');
			let deleteTrans = form.data('delete-trans');
			let commentId = success.commentId;
			let updateCommentUrl = success.updateCommentUrl;
			let deleteCommentUrl = success.deleteCommentUrl;
			let userImgSrc = form.data('user-img-src');
			let newComment = `
				<div class="user-comment">
					<div class="pl-4 mt-4">
	             		<div class="flex">
							<div class="w-1/12">
							   <a href="${userPath}"><img src="${userImgSrc}" class="rounded-full w-10 border"></a>
							</div>

							<div class="w-11/12 bg-main py-2 px-4 border border-gray-200 rounded text-gray-600 ml-2 relative"
								  style="word-wrap: break-word;border-radius: 1.25rem;">
                         		<i class="show-options fa fa-ellipsis-h absolute right-0 mr-2 text-gray-500 hover:text-gray-600 cursor-pointer mr-4 text-xl"></i>

		                        <div class="options absolute card mr-10 right-0 text-center w-40 cursor-auto z-10" style="top:-8px;display:none">
		                            <ul>
		                                <a data-update-comment-url="${updateCommentUrl}"
		                                    href="#comment-modal"
		                                    rel="modal:open" 
		                                    class="open-comment-modal"
		                                >
		                                    <li class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" id="open-comment-modal">${editTrans}</li>
		                                </a>

		                                <a class="delete-comment cursor-pointer hover:text-gray-900 text-gray-600 py-1"
		                                   data-delete-comment-url="${deleteCommentUrl}"
		                                >${deleteTrans}</a>
		                            </ul>
		                        </div>

								<p>
			                        <a href="${userPath}" class="text-gray-700">
			                           ${userName}
			                        </a>

			                        <span class="text-gray-500 text-xs ml-2">
			                           just now
			                        </span>
			                    </p>

								<p class="comment-body text-gray-800">${data.body}</p>
							</div>
		             	</div>
		          	</div>
	          	</div>
			`;
			
			form.parents('.comments-box').find('.user-comments').prepend(newComment);
			
			if (form.find('textarea').hasClass('border-red-300')) {
				form.find('textarea').removeClass('border-red-300');
			}
			
			form.find('textarea').val('');

			form.find('.comment-error').toggle()
		},
		error: function(error) {
			form.find('.comment-error').toggleClass('hidden').html(error.responseJSON.errors.body[0]);

			form.find('textarea').toggleClass('border-gray-300 border-red-300');
		}
	});
}

// Update comment function
async function updateComment(form, data, url) {
	await $.ajax({
		url: url,
		type: 'patch',
		data: data,
		success: () => {
			form.find('textarea').addClass('border-gray-300');
			form.find('textarea').removeClass('border-red-300');
			form.find('textarea').val('');

			form.find('.comment-error').hide()

			form.siblings('.close-modal').click();

			window.commentToEdit.text(data.body);
		},
		error: (response) => {
			let commentErrorSpan = form.find('.comment-error');
			commentErrorSpan.html('');
			
			if (response.responseJSON.errors) {
				response.responseJSON.errors.body.forEach(function(error) {
					commentErrorSpan.show().append(error);
				});
			} else if (response.responseJSON.message) {
				commentErrorSpan.show().append(response.responseJSON.message);
			}

			form.find('textarea').addClass('border-red-300');
			form.find('textarea').removeClass('border-gray-300');
		}
	});
}