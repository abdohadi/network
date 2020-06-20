@extends('layouts.app')

@section('content')

	<div class="lg:px-32">
		@include('users._top')

		<div class="lg:flex">
			<div class="lg:w-1/3 mt-8">
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
							<a href="{{ route('users.edit_info', auth()->user()) }}">@lang('site.edit_your_info')</a>
						</div>
					@endif
				</div>

				{{-- Friends --}}
				<div class="card friends">
					<h3 class="text-lg text-gray-600 mb-4"><i class="fa fa-user-friends text-gray-600"></i> @lang('site.friends')</h3>

					<div class="flex">
						@forelse(array_slice($user->friends->toArray(), 0, 3) as $friend)
							<div class="m-auto text-center mx-1" style="height:150px;">
			            		<a href="{{ route('users.show', $friend['id']) }}">
			  	            		<img src="{{ getProfilePicture($friend, 60) }}" 
			  	            			class="border my-2 w-full" 
			  	            			style="padding:1pxwidth: 100px;height: 100px;">
			           	 		</a>

			           	 		<a href="{{ route('users.show', $friend['id']) }}" class="text-gray-700">{{ substr($friend['name'], 0, 12) }}
				             	</a>
							</div>
						@empty
							@lang('site.no_friends')
						@endforelse
					</div>

					<div class="text-center mt-4 text-primary">
						<a href="{{ route('users.friends.index', $user) }}">@lang('site.see_all_friends')</a>	
					</div>
				</div>
			</div>

			<div class="lg:w-2/3 lg:ml-12 mt-8">
				{{-- Create New Post --}}
				@if ($user->is(auth()->user()))
					<div class="card mb-4">
						@include('posts._create_post_form', [
							'action' => route('posts.store'),
						])
					</div>
		      	@endif

				@forelse($user->posts as $post) 
					@include('posts._post')
				@empty
					<div class="card">@lang('site.no_posts_yet')</div>
				@endforelse
			</div>
		</div>
	</div>

@endsection