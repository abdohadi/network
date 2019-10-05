@extends('layouts.app')

@section('content')

	<div class="lg:flex mt-16">
    <div class="lg:w-2/6 mx-2 sm:hidden lg:block">
			{{-- Make new friends --}}
			<div class="card mb-8">
				<div 
				  class="p-2 text-center border font-bold text-gray-700 rounded-lg" 
				  style="margin:-16px;margin-bottom:16px;background:rgb(247, 247, 247);"
				  >Make New Friends
				</div>

				<div>
		      @foreach(array_slice(peopleYouMayKnow(), 0, 3) as $user)
		      	@include('users.people_you_may_know')
		      @endforeach

		      <div class="text-center text-primary mt-6">
	          <a href="/find_people">Find More</a>
	      	</div>
	      </div>
	    </div>

      {{-- Join new groups --}}
      @include('groups.groups_you_may_join')
		</div>

		<div class="lg:w-1/2 mx-2">
			@include('posts.post')
		</div>

		<div class="lg:w-1/4 mx-2 sm:hidden lg:block">
			right
		</div>
	</div>


	@include('posts.edit-modal')

@endsection