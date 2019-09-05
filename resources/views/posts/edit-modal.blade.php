<div id="ex1" class="modal">
  <div>
  	<h3 class="font-semibold mb-6 text-2xl text-center">Edit Your Post</h3>

  	<form action="" method="POST">
  		@method('PATCH')
  		@csrf

  		<div>
		  	<textarea 
					name="body" 
					id="body" 
					placeholder="What's in your mind?" 
					class="border w-full p-2 rounded mb-4 @error('body') border-red-300 @enderror"
					rows="5"></textarea>
				@error('body')
					<label class="text-red-500 italic text-sm">Your post can't be empty.</label>
				@enderror
			</div>

			<div class="flex justify-between items-center">
				<input type="submit" name="create" class="button-primary" value="Save">
  		</div>
  </div>
  
</div>