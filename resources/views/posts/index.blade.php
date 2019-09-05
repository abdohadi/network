@extends('layouts.app')

@section('content')
	{{-- Create New Post --}}
	<div class="card lg:w-1/2 mb-4 m-auto">
		<form action="/posts" method="POST" class="m-auto">
			@csrf	
			
			<div class="mb-4">
				<textarea 
					name="body" 
					id="body" 
					placeholder="What's in your mind?" 
					class="border w-full p-2 rounded @error('body') border-red-300 @enderror"
					rows="5"></textarea>

				@error('body')
					<label class="text-red-500 italic text-sm">Your post can't be empty.</label>
				@enderror
			</div>

			<div>
				<input type="submit" name="create" class="button-primary" value="Post">
			</div>
		</form>
	</div>

	{{-- Show Posts --}}
	@forelse($posts as $post)
		@include('posts.post')
	@empty
		<div class="card lg:w-1/2">No posts yet</div>
	@endforelse


	@include('posts.edit-modal')

@endsection