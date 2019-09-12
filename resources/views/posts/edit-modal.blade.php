<div id="post-modal" class="modal post-modal">
  <h3 class="font-semibold mb-6 text-2xl text-center">Edit Your Post</h3>

	@include('posts.form', [
		'action' => isset($post) ? $post->path() : '',
		'method' => 'PATCH',
		'submit_value' => 'Save',
		'submit_id' => 'submit-update-post',
	])
</div>