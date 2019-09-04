@extends('layouts.app')

@section('content')
	
	<div class="card w-3/4 m-auto py-12 rounded-lg">
		<h2 class="text-center mb-10">Create New Post</h2>

		<form action="/posts" method="POST" class="w-1/2 m-auto">
			@csrf	

			<div class="block mb-4">
				<label for="body" class="block text-lg">Your post</label>
				<textarea 
					name="body" 
					id="body" 
					placeholder="What's in your mind?" 
					class="border w-full p-2 rounded"
					rows="7"></textarea>
			</div>
			<div>
				<input type="submit" name="create" class="btn btn-primary" value="Create">
			</div>
		</form>
	</div>

@endsection