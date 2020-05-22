@extends('layouts.app')

@section('content')
	
	@if (auth()->user()->is($user))
		@if ($errors->has('profile_picture') || $errors->has('profile_cover'))
			<ul 
				class="bg-white border absolute z-10 r-0 right-0 pl-2 pr-6 pt-6 pb-2" 
				style="border-top: 6px solid red;top: 105px;max-width: 396px;">
				<span 
					class='absolute text-gray-500 cursor-pointer text-sm hover:font-bold' 
					style='right: 17px;top: 7px;' 
					title='Close'
					onclick='script: this.parentElement.style.display = "none"' 
				>X</span>

				@foreach ($errors->all() as $error)
					<div class="flex py-4 ">
						<div class="text-center" style="width: 31px;">
							<span class="rounded-full text-red-700 bg-red-200 text-sm" style="padding: 1px 6px">x</span>
						</div>

						<div class="break-normal px-4 text-red-600">
							<li>{{ $error }}</li>
						</div>
					</div>
				@endforeach
			</ul>
		@endif
	@endif

	<div class="lg:px-32">
		<div class="relative" style="height:300px;">
			{{-- Profile cover --}}
			<a href="{{ asset('/uploads/images/user_images/covers/' . $user->profile_cover) }}" target="_blank">
				<img 
					src="{{ '/uploads/images/user_images/covers/' . $user->profile_cover }}" 
					class="cover-img w-full h-full" >
			</a>

			@if(auth()->user()->is($user))
				{{-- Change cover --}}
				<div class="absolute p-2" style="top: 13px;left: 13px;background: #333">
					<button class="change-cover-btn border border-gray-500 text-gray-500 py-2 rounded-full px-4 hover:border-blue-400 hover:text-blue-400">@lang('site.change_cover')</button>

					<form 
						class="profile-cover-form hidden ml-2" 
						action="{{ localizeURL(auth()->user()->path() . '/update_cover') }}" 
						method="POST" 
						enctype="multipart/form-data"
					>
						@csrf
						@method('PATCH')

						<input class="cover-input hidden" type="file" name="profile_cover">

						<button 
							class="cancel-cover-btn button-outline-secondary mt-1" 
							style="font-size: 12px" 
							data-cover-src="{{ '/uploads/images/user_images/covers/' . $user->profile_cover }}"
						>@lang('site.cancel')</button>
						<button 
							class="submit-cover-btn button-outline-primary" 
							style="font-size: 12px"
						>@lang('site.save')</button>
					</form>
				</div>
			@endif


			{{-- Profile Picture section --}}
			@if(auth()->user()->is($user))
				<div class="flex items-center">
					<div 
						class="profile-pic-parent-overlay" 
						style="width: 163px; overflow: hidden; border-radius: 50%; position: absolute; height: 164px; z-index: 10; bottom: -16px; left: 57px;">
						<div 
							class="profile-pic-overlay hidden text-gray-200 text-center cursor-pointer absolute" style="width: 166px;background: #000000c9;height: 109px;border-radius: 0px 0 50% 50%;top: 91px;">
							<div><i class="fa fa-camera mt-4 text-2xl mb-1"></i></div>

							<div class="font-bold">@lang('site.change')</div>
						</div>
						
						{{-- Show profile pic --}}
						<div 
							class="show-pic-overlay text-gray-200 text-center absolute hidden" 
							style="width: 165px;background: #000000c9;height: 109px;border-radius: 50% 50% 0 0;top: -18px;"
						>
							<a href="{{ getProfilePicture($user, 60) }}" target="_blank">
								<span 
									class="py-2 px-3 border border-gray-500 text-gray-500 rounded-full relative hover:border-blue-400 hover:text-blue-400"
									style="top: 53px;"
								>@lang('site.show')</span>
							</a>
						</div>

						{{-- Update profile picture form --}}
						<div 
							class="profile-form-pic-overlay text-gray-200 text-center absolute hidden" 
							style="width: 164px;background: #000000c9;height: 105px;border-radius: 50% 50% 0 0;top: -14px;"
						>
							<form 
								class="profile-picture-form" 
								action="{{ localizeURL(auth()->user()->path() . '/update_picture') }}" 
								method="post" 
								enctype="multipart/form-data"
							>
								@csrf
								@method('PATCH')

								<input class="hidden profile-picture-input" type="file" name="profile_picture">

								<button 
									class="button-outline-primary submit-profile-pic-btn block m-auto mt-10" 
									style="font-size: 11px"
								>@lang('site.save')</button>
							</form>

							<button 
								class="button-outline-secondary cancel-profile-pic-btn mt-1" 
								style="font-size: 11px" 
								data-pic-src="{{ getProfilePicture($user) }}"
							>@lang('site.cancel')</button>
						</div>
					</div>

					{{-- Profile picture --}}
					<img 
						class="profile-picture bg-gray-100 p-1 rounded-full absolute"
						src="{{ getProfilePicture($user, 60) }}" 
						style="width: 170px;height: 170px;left: 53px;bottom: -19px;">

					<span class="text-2xl text-white font-bold ml-8 mt-16 absolute" style="left: 222px; bottom: 30px;">{{ $user->name }}</span>
				</div>
			@else
				<a href="{{ getProfilePicture($user, 60) }}" target="_blank">
					<img 
						class="profile-picture bg-gray-100 p-1 rounded-full absolute"
						src="{{ getProfilePicture($user, 60) }}" 
						style="width: 170px;height: 170px;left: 52px;bottom: -19px;">
				</a>
			@endif

			@if ($user->isNot(auth()->user()))
				<div class="absolute px-5 py-2 bg-white rounded-sm" style="right:15px;bottom:20px">
					@if (auth()->user()->sentFriendRequests->contains($user))
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
			  	            		<img src="{{ getProfilePicture($friend, 60) }}" 
			  	            			class="border my-2 w-full" 
			  	            			style="padding:1pxwidth: 100px;height: 100px;">
			           	 		</a>

			           	 		<a href="{{ "/users/".$friend['id'] }}" class="text-gray-700">{{ substr($friend['name'], 0, 12) }}
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

			<div class="lg:w-2/3 lg:ml-4 pl-10">
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