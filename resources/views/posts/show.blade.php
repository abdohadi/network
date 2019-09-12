@extends('layouts.app')

@section('content')

	<div class="lg:flex">
    <div class="lg:w-1/4 mx-2 sm:hidden lg:block">
			{{-- Make new friends --}}
      @include('users.people_you_may_know')
      
      {{-- Join new groups --}}
      @include('groups.groups_you_may_join')
		</div>

		<div class="lg:w-1/2 mx-2">
			@include('posts.post')
		</div>

		<div class="card lg:w-1/4 mx-2 sm:hidden lg:block">
			right
		</div>
	</div>


	@include('posts.edit-modal')

@endsection