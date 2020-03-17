<div id="share-post-modal" class="modal share-post-modal">
  <h3 class="font-semibold mb-6 text-2xl text-center">@lang('site.add_something')</h3>

	<form id="share-post-form"
			action=""
			method="POST"
	>
		@csrf

		<div class="mb-4">
	  		<textarea 
				name="body" 
				id="body" 
				placeholder="Add something..." 
				class="border w-full p-2 rounded"
				rows="2"></textarea>

			<span class="post-error text-red-500 italic text-sm"></span>
		</div>

		<div class="flex justify-between items-center">
			<input type="submit" class="button-primary ml-auto" value="@lang('site.save')">
		</div>
	</form>
</div>