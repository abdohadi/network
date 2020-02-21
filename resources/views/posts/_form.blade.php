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
			rows="2"></textarea>

		<span class="{{ $type }}-error text-red-500 italic text-sm hidden">Your {{ $type }} can't be empty.</span>
	</div>

	<div class="flex justify-between items-center">
		<button
			class="button-primary ml-auto" 
			id="{{ $submit_id }}">
			{{ $submit_value }}
		</button>
	</div>
</form>