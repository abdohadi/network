<form action="{{ route('groups.store') }}" method="post">
	@csrf

	<div class="mb-4">
		<div class="mb-2">
			<span for="name" class="text-light">Group Name</span>
		</div>
  	
	  	<div>
		  	<input 
				name="name" 
				id="name" 
				placeholder="Your group name" 
				class="border w-full p-2 rounded"
			>
			
			<span id="group-error" class="text-red-500 italic text-sm hidden">Name field is required.</span>
		</div>
	</div>

	<div class="mb-4">
		<div class="mb-2">
			<span for="description" class="text-light">Group Description</span>
		</div>
  	
	  	<div>
		  	<textarea 
				name="description" 
				id="description" 
				placeholder="A brief description about this group" 
				class="border w-full p-2 rounded"
				rows="4"></textarea>

			<span id="group-error" class="text-red-500 italic text-sm hidden">Description field is required.</span>
		</div>
	</div>

	<div class="flex justify-between items-center">
		<input 
			type="submit" 
			name="create" 
			class="button-primary" 
			value="Create" 
			id="submit-create-group">
	</div>
</form>