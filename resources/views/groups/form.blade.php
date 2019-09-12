<form action="/groups" method="POST">
	@csrf

	<div class="mb-4">
		<div class="mb-2">
			<label for="name" class="text-light">Group Name</label>
		</div>
  	
  	<div>
	  	<input 
				name="name" 
				id="name" 
				placeholder="Your group name" 
				class="border w-full p-2 rounded"
			>
			
			<label id="error" class="text-red-500 italic text-sm hidden">Name field is required.</label>
		</div>
	</div>

	<div class="mb-4">
		<div class="mb-2">
			<label for="description" class="text-light">Group Description</label>
		</div>
  	
  	<div>
	  	<textarea 
				name="description" 
				id="description" 
				placeholder="A brief description about this group" 
				class="border w-full p-2 rounded"
				rows="4"></textarea>

			<label id="error" class="text-red-500 italic text-sm hidden">Description field is required.</label>
		</div>
	</div>
{{-- 
	<div class="mb-4">
		<div class="mb-2">
			<label for="cover" class="text-light">Choose Cover</label>
		</div>
		<div>
			<input type="file" id="cover" name="cover">
		</div>
	</div> --}}

	<div class="flex justify-between items-center">
		<input 
			type="submit" 
			name="create" 
			class="button-primary" 
			value="Create" 
			id="submit-create-group">
	</div>
</form>