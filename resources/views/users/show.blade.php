@extends('layouts.app')

@section('content')
	
	<div class="lg:px-32">
		<div class="relative">
			<img 
				src="/images/709eaa849a687c2a5af946a35797f66c.jpg" 
				class="w-full" 
				style="height:300px;">

			<div class="absolute flex items-center" style="left:52px;bottom:-15px;">
				<img 
					src="{{ gravatar($user->email) }}" 
					class="bg-gray-100 p-1 rounded-full"
					style="width:170px;">

				<span class="text-2xl text-white font-bold ml-8 mt-16">{{ $user->name }}</span>
			</div>

			@if(auth()->check())
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
			@endif
		</div>

		<div class="lg:flex mt-5">
			<div class="lg:w-1/3 sm:my-5 lg:my-0">
				<div class="card mb-8">
					<h3 class="text-lg text-gray-600">About</h3>
				</div>

				{{-- Friends --}}
				<div class="card friends">
					<h3 class="text-lg text-gray-600 mb-4"><i class="fa fa-user-friends text-gray-600"></i> Friends</h3>

					<div class="flex">
						@forelse(array_slice($user->friends->toArray(), 0, 3) as $friend)
							<div class="m-auto text-center mx-1" style="height:150px;">
            		<a href="{{ "/users/".$friend['id'] }}">
  	            	<img src="{{ gravatar($friend['email']) }}" class="border my-2 w-full" style="padding:1px">
           	 		</a>
           	 		<a href="{{ "/users/".$friend['id'] }}">
	             		<div>{{ substr($friend['name'], 0, 15) }}</div>
	             	</a>
							</div>

						@empty
							No Friends
						@endforelse
					</div>

					<div class="text-center mt-4 text-primary">
						<a href="{{ $user->path().'/friends' }}">See All Friends</a>	
					</div>
				</div>
			</div>

			<div class="lg:w-2/3 lg:ml-4">
				{{-- Create New Post --}}
				@if ($user->is(auth()->user()))
					<div class="card mb-4">
						@include('posts._create_post_form', [
							'action' => '/posts',
							'type' => 'post',
							'submit_value' => 'Post',
							'submit_id' => 'submit-create-post',
						])
					</div>
		      @endif

        <div class="text-lg text-gray-600 mb-2 mt-8 {{ $user->isNot(auth()->user()) ? 'hidden' : 'lg:block' }}">Posts</div>

				@forelse($user->posts as $post) 
					@include('posts._post')
				@empty
					<div class="card">No posts yet.</div>
				@endforelse
			</div>
		</div>
	</div>

@endsection