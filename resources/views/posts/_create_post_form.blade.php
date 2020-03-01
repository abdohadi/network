<form id="submit-create-post" 
		action="{{ localizeURL('/posts') }}" 
		method="POST"
>
	@csrf

	<div class="mb-4">
  		<textarea 
			name="body" 
			id="body" 
			placeholder="What's in your mind?" 
			class="border w-full p-2 rounded"
			rows="2"></textarea>

		<span class="post-error text-red-500 italic text-sm"></span>
	</div>

	<div class="flex justify-between items-center">
		<input type="submit" class="button-primary ml-auto" value="@lang('site.post_it')">
	</div>
</form>