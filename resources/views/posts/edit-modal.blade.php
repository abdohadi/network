<div id="ex1" class="modal">
  <h3 class="font-semibold mb-6 text-2xl text-center">Edit Your Post</h3>

	@include('posts.form', [
		'method' => 'PATCH',
		'submit_value' => 'Save',
		'submit_id' => 'submit-update',
	])
</div>