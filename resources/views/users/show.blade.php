@extends('layouts.app')

@section('content')
	
	<div class="lg:px-32">
		<div class="relative">
			<img 
				src="/uploads/images/user_images/covers/default.png" 
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
						{{-- <button 
							data-user-id="{{ $user->id }}" 
							id="cancel_friend_request" 
							class="button-outline-secondary ml-auto"
							title="Click to cancel the request"
						><i class="fa fa-check"></i> Sent</button> --}}
						<button 
							data-user-id="{{ $user['id'] }}" 
							data-btn-add="{{ __('site.add') }}" 
							data-btn-sent="{{ __('site.sent') }}" 
							id="cancel_friend_request" 
							class="button-outline-secondary ml-auto"
							title="{{ __('site.click_to_cancel_the_request') }}"
						><i class="fa fa-check"></i> @lang('site.sent')</button>
			      @else
						<button 
							data-user-id="{{ $user['id'] }}" 
							data-btn-add="{{ __('site.add') }}" 
							data-btn-sent="{{ __('site.sent') }}" 
							id="send_friend_request" 
							class="button-outline-primary ml-auto"
							title="{{ __('site.click_to_send_a_friend_request') }}"
						><i class="fa fa-user-plus"></i> @lang('site.add')</button>
			      @endif
			    </div>
			  @endif
			@endif
		</div>

		<div class="lg:flex mt-5">
			<div class="lg:w-1/3 sm:my-5 lg:my-0">
				{{-- About --}}
				<div class="card mb-8">
					<h3 class="text-lg text-gray-600">
						<i class="fa fa-globe-africa"></i> @lang('site.about')
					</h3>

					<ul class="user-info">
						@if (auth()->user()->is($user) || $user->bio)
							<li class="text-center my-2">
								<h4 class="text-gray-500 mb-2 text-sm">
									<i class="fa fa-meh-rolling-eyes"></i> @lang('site.bio')
								</h4>
								<p class="text-gray-700 px-4">{{ $user->bio }}</p>
							</li>
							
							<hr class="my-4">
						@endif

						@if (auth()->user()->is($user) || $user->gender)
							<li class="my-2 border px-1 py-1 rounded border-gray-200 px-3">
								<span class="text-gray-500 text-sm mr-2">
									<i class="fa fa-{{ $user->gender }}"></i> @lang('site.gender')
								</span> 

								<span class="text-gray-700">{{ $user->gender }}</span>
							</li>
						@endif

						@if (auth()->user()->is($user) || $user->birth_date)
							<li class="my-2 border px-1 py-1 rounded border-gray-200 px-3">
								<span class="text-gray-500 text-sm mr-2">
									<i class="fa fa-birthday-cake"></i> @lang('site.birth_date')
								</span> 

								<span class="text-gray-700">{{ $user->birth_date ? $user->birth_date->toFormattedDateString() : '' }}</span>
							</li>
						@endif

						@if (auth()->user()->is($user) || $user->college)
							<li class="my-2 border px-1 py-1 rounded border-gray-200 px-3">
								<span class="text-gray-500 text-sm mr-2">
									<i class="fa fa-graduation-cap"></i> @lang('site.college')
								</span> 

								<span class="text-gray-700">{{ $user->college }}</span>
							</li>
						@endif

						@if (auth()->user()->is($user) || $user->address)
							<li class="my-2 border px-1 py-1 rounded border-gray-200 px-3">
								<span class="text-gray-500 text-sm mr-2">
									<i class="fa fa-home"></i> @lang('site.address')
								</span> 

								<span class="text-gray-700">{{ $user->address }}</span>
							</li>
						@endif

						@if (auth()->user()->is($user) || $user->phone)
							<li class="my-2 border px-1 py-1 rounded border-gray-200 px-3">
								<span class="text-gray-500 text-sm mr-2">
									<i class="fa fa-mobile-alt"></i> @lang('site.phone')
								</span>

								<span class="text-gray-700">{{ $user->phone }}</span>
							</li>
						@endif

						@if (auth()->user()->is($user) || $user->email)
							<li class="my-2 border px-1 py-1 rounded border-gray-200 px-3">
								<span class="text-gray-500 text-sm mr-2">
									<i class="fa fa-envelope"></i> @lang('site.email_address')
								</span>

								<span class="text-gray-700">{{ $user->email }}</span>
							</li>
						@endif
					</ul>

					@if (auth()->user()->is($user))
						<div class="text-center mt-4 text-primary">
							<a href="{{ auth()->user()->path() . '/edit_info' }}">@lang('site.edit_your_info')</a>
						</div>
					@endif
				</div>

				{{-- Friends --}}
				<div class="card friends">
					<h3 class="text-lg text-gray-600 mb-4"><i class="fa fa-user-friends text-gray-600"></i> @lang('site.friends')</h3>

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
							@lang('site.no_friends')
						@endforelse
					</div>

					<div class="text-center mt-4 text-primary">
						<a href="{{ $user->path().'/friends' }}">@lang('site.see_all_friends')</a>	
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
					<div class="card">@lang('site.no_posts_yet')</div>
				@endforelse
			</div>
		</div>
	</div>

@endsection