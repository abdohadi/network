<form action="{{ $action ?? '' }}" method="POST">
	@if (isset($method))
		@method($method)
	@endif
	@csrf

	<div class="mb-4">
  	<textarea 
			name="body" 
			id="body" 
			placeholder="What's in your mind?" 
			class="border w-full p-2 rounded"
			rows="5"></textarea>

		<label id="error" class="text-red-500 italic text-sm hidden">Your post can't be empty.</label>
	</div>

	<div class="flex justify-between items-center">
		<input 
			type="submit" 
			name="create" 
			class="button-primary" 
			value="{{ $submit_value }}" 
			id="{{ $submit_id }}">
	</div>
</form>