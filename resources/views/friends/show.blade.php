@extends('layouts.app')

@section('content')
	
	<div class="lg:px-32">
		{{-- Cover section --}}
		<div class="relative">
			<img 
				src="/images/709eaa849a687c2a5af946a35797f66c.jpg" 
				class="w-full" 
				style="height:300px;">

			<div class="absolute flex items-center" style="left:52px;bottom:-15px;">
				<img 
					src="{{ getProfilePicture($user) }}" 
					class="bg-gray-100 border border-gray-700 p-1 rounded-full"
					style="width:170px;">

				<span class="text-2xl text-white font-bold ml-8 mt-16">{{ $user->name }}</span>
			</div>

			@if(auth()->check())
				@if($user->isNot(auth()->user()))
					<div class="absolute px-5 py-2 bg-white rounded-sm" style="right:15px;bottom:20px">
						@if(auth()->user()->sentFriendRequests->contains($user))
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

		{{-- Friends section --}}
		<div class="mt-8">
			<div class="p-4" style="background:#f5f6f7;">
				<h3 class="text-3xl font-bold text-gray-700">
					<i class="text-2xl mr-2 fa fa-users text-gray-500"></i> Friends
				</h3>

				<ul class="mt-4 flex">
					<li class="text-lg font-medium mr-5 text-link cursor-pointer hover:text-gray-700 active">All Friends</li>
					<li class="text-lg font-medium mr-5 text-link cursor-pointer hover:text-gray-700">Sent Requests</li>
					<li class="text-lg font-medium text-link cursor-pointer hover:text-gray-700">Received Requests</li>
				</ul>
			</div>

			<div class="bg-white p-4 flex flex-wrap">
				@forelse($user->friends as $friend)
					<div class="px-1 w-1/2">
						<div class="flex items-center mb-4 border border-gray-200">
							<a href="{{ '/users/'.$friend->id }}" style="margin: 2px;border:1px solid #f9f9f9;">
								<img 
									src="{{ getProfilePicture($friend) }}"
									style="width:140px;height:140px;">
							</a>

							<a href="{{ '/users/'.$friend->id }}" style="margin-top:-30px;">
								<span class="text-xl text-link font-medium ml-6 mt-10" title="{{ $friend->name }}">{{ substr($friend->name, 0, 15).(strlen($friend->name) > 15 ? '...' : '') }}</span>
							</a>

							@if(auth()->check())
								@if($user->is(auth()->user()) || auth()->user()->friends->contains($friend))
									<button 
										data-user-id="{{ $user['id'] }}" 
								    id="unfriend"
										class="button-outline-secondary ml-auto mr-4 py-1"
										title="Click to unfriend"
									>Unfriend</button>
								@elseif($user->isNot(auth()->user()) && $friend->isNot(auth()->user()))
									@if(auth()->user()->sentFriendRequests->contains($friend))
										<button 
								    	data-user-id="{{ $user['id'] }}" 
								    	id="cancel_friend_request" 
								    	class="button-outline-secondary ml-auto"
								    	title="Click to cancel the request"
								    ><i class="fa fa-check"></i> Sent</button>
									@elseif(auth()->user()->receivedFriendRequests->contains($friend))
										<button 
                      data-user-id="{{ $user->id }}" 
                      id="accept_friend_request" 
                      class="button-outline-secondary ml-auto"
                    >Accept</button>
                    <button 
                      data-user-id="{{ $user->id }}" 
                      id="delete_friend_request" 
                      class="button-outline-primary ml-auto"
                    >Delete</button>
                  @else
                  	<button 
								    	data-user-id="{{ $user['id'] }}" 
								    	id="send_friend_request" 
								    	class="button-outline-primary ml-auto"
								    	title="Click to send a friend request"
								    ><i class="fa fa-user-plus"></i> Add</button>
									@endif
								@endif
							@endif
						</div>
					</div>
				@empty
					No friends.
				@endforelse
			</div>
		</div>
	</div>

@endsection