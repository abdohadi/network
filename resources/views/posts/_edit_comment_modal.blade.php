<div id="comment-modal" class="modal comment-modal">
  <h3 class="font-semibold mb-6 text-2xl text-center">@lang('site.edit_your_comment')</h3>

	<form class="update-comment-form" action="" method="post">
		@method('PATCH')
		@csrf

		<div class="mb-4">
	  		<textarea 
				name="body" 
				id="body" 
				placeholder="Edit your comment"
				class="border w-full p-2 rounded"
				rows="2"></textarea>

			<span class="comment-error text-red-500 italic text-sm hidden"></span>
		</div>

		<div class="flex justify-between items-center">
			<button class="button-primary ml-auto">Save</button>
		</div>
	</form>
</div>