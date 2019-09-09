@extends('layouts.app')

@section('content')

	<div class="lg:flex">
		@include('users.people')

		<div class="lg:w-1/2 mx-2">
			@include('posts.post')
		</div>

		<div class="card lg:w-1/4 mx-2 sm:hidden lg:block">
			right
		</div>
	</div>


	@include('posts.edit-modal')

@endsection