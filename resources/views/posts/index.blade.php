@extends('layouts.app')

@section('content')
	{{-- Create New Post --}}
	<div class="card lg:w-1/2 mb-4 m-auto">
		@include('posts.form', [
			'action' => '/posts',
			'submit_value' => 'Post',
			'submit_id' => 'submit-create',
		])
	</div>

	{{-- Show Posts --}}
	@forelse($posts as $post)
		@include('posts.post')
	@empty
		<div class="card lg:w-1/2">No posts yet</div>
	@endforelse


	@include('posts.edit-modal')

@endsection