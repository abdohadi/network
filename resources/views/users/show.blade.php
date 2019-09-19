@extends('layouts.app')

@section('content')
	
	<div class="lg:px-32" style="margin-top:-14px">
		<div class="relative">
			<img 
				src="/images/709eaa849a687c2a5af946a35797f66c.jpg" 
				class="w-full" 
				style="height:300px;">

			<div class="absolute flex items-center" style="left:52px;bottom:-15px;">
				<img 
					src="{{ gravatar($user->email) }}" 
					class="bg-gray-100 border border-gray-700 p-1 rounded-full"
					style="width:170px;">

				<span class="text-2xl text-white font-bold ml-8 mt-16">{{ $user->name }}</span>
			</div>

			@if ($user->isNot(auth()->user()))
				<div class="absolute px-5 py-2 bg-white rounded-sm" style="right:15px;bottom:20px">
					@if (auth()->user()->sentFriendRequests->contains($user))
		        <button 
		        	data-user-id="{{ $user->id }}" 
		        	id="cancel_friend_request" 
		        	class="button-outline-secondary ml-auto"
		        	title="Click to cancel the request"
		        ><i class="fa fa-check"></i> Sent</button>
		      @else
		        <button 
		        	data-user-id="{{ $user->id }}" 
		        	id="send_friend_request" 
		        	class="button-outline-primary ml-auto"
		        	title="Click to send a friend request"
		        ><i class="fa fa-user-plus"></i> Add</button>
		      @endif
		    </div>
		  @endif
		</div>

		<div class="lg:flex mt-5">
			<div class="lg:w-1/3 sm:my-5 lg:my-0">
				<div class="card">
					about
				</div>

				<div class="friends">
					
				</div>
			</div>

			<div class="lg:w-2/3 lg:ml-10">
				@if ($user->is(auth()->user()))
					{{-- Create New Post --}}
	        <div class="card mb-4">
	          @include('posts.form', [
	              'action' => '/posts',
	              'submit_value' => 'Post',
	              'submit_id' => 'submit-create-post',
	          ])
	        </div>
	      @endif

        <div class="text-lg text-gray-600 mb-2 mt-8 {{ $user->isNot(auth()->user()) ? 'hidden' : 'lg:block' }}">Posts</div>

				@forelse($user->posts as $post) 
					@include('posts.post')
				@empty
					<div class="card">No posts yet.</div>
				@endforelse
			</div>
		</div>
	</div>

@endsection