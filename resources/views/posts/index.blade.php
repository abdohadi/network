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
				<input type="submit" name="create" class="button-primary" value="Create">
			</div>
		</form>
	</div>

	{{-- Show Posts --}}
	@forelse($posts as $post)
		<div class="card lg:w-1/2 mb-4 m-auto">
			<div class="relative">
				<div class="flex items-center ">
					<img src="{{ gravatar($post->user->email) }}" class="rounded-full w-12 mr-2"> 
					<span>{{ $post->user->name }}</span>
				</div>

				<span 
					class="block text-gray-500 text-xs absolute"
					style="left:53px; top:38px">{{ $post->created_at->diffForHumans() }}</span>
			</div>


			<div class="text-gray-600 px-6 pt-8 pb-4">{{ $post->body }}</div>
		</div>
	@empty
		No posts yet
	@endforelse

@endsection