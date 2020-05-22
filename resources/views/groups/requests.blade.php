@extends('layouts.app')

@section('content')

	<div class="lg:flex mt-16 px-8">
      	{{-- Left side --}}
		<div class="lg:w-1/5 mx-2 sm:hidden lg:block">
			@include('groups._left_side')
		</div>

		<div class="lg:w-4/5 lg:ml-2 xl:ml-6">
			@include('groups._top_side')

			<div class="flex">
				<div class="lg:w-8/12 xl:pr-8">
				   <div class="card">
				   		<div class="text-lg text-gray-700 mb-4 mb-6 pb-2" style="border-bottom: 1px solid #eee;">
							<i class="fa fa-users-cog mr-1"></i> @lang('site.requests') . <small>{{ count($group->joinRequests) }}</small>
				   		</div>

						<div>
					   		@forelse ($group->joinRequests as $user)
								<div class="flex items-center mb-4 relative">
									<a href="{{ route('users.show', $user) }}">
										<img src="{{ getProfilePicture($user) }}" class="rounded-full w-16 mr-2" style="border:1px solid rgb(241, 239, 239);border-radius:50%" title="{{ $user->name }}">
									</a> 

									<a href="{{ route('users.show', $user) }}" class="text-gray-700 text-lg" title="{{ $user->name }}">{{ $user->name }}</a>

									<span class="absolute text-gray-600 text-sm" style="left:65px;top:45px">
						                {{ __('site.request_since') .' '. $user->pivot->created_at->diffForHumans() }}
						            </span>									

					   				@if ($group->hasAdmin(auth()->user()))
					   					<div class="ml-auto flex">
									        <form-component 
									        	class="form-changes remove-element mr-1" 
									            cur-action="{{ route('groups.accept_request', [$group, $user]) }}"
									            cur-method="patch"
									        >
									            @csrf
									  	        
									            <button-component
									              	cur-class="button-outline-primary"
									              	title="@lang('site.click_to_accept_join_request')"
									              	value="@lang('site.accept')">
									            </button-component>
									        </form-component>

											<form-component 
									        	class="form-changes remove-element" 
									            cur-action="{{ route('groups.remove_request', [$group, $user]) }}"
									            cur-method="delete"
									        >
									            @csrf
									  	        
									            <button-component
									              	cur-class="button-outline-primary"
									              	title="@lang('site.click_to_accept_join_request')"
									              	value="@lang('site.remove')">
									            </button-component>
									        </form-component>
									    </div>
									@endif
								</div>
							@empty
								<div>@lang('site.no_join_requests')</div>
					   		@endforelse
					   	</div>
				   </div>
				</div>

				{{-- Right side --}}
				<div class="lg:w-2/6 sm:hidden lg:block lg:w-5/12 ml-4">
				   @include('groups._suggested_groups')
				</div>
			</div>
		</div>
   </div>

@endsection