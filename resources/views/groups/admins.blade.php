@extends('layouts.app', ['title' => $group->name])

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
							<i class="fa fa-user-tie mr-1"></i> @lang('site.admins') . <small>{{ count($group->admins) }}</small>
				   		</div>

						<div class="xl:px-10">
					   		@foreach ($group->admins as $admin)
								<div class="flex items-center mb-4 relative">
									<a href="{{ route('users.show', $admin) }}">
										<img src="{{ getProfilePicture($admin) }}" class="rounded-full w-16 mr-2" style="border:1px solid rgb(241, 239, 239);border-radius:50%" title="{{ $admin->name }}">
									</a> 

									<a href="{{ route('users.show', $admin) }}" class="text-gray-700 text-lg" title="{{ $admin->name }}">{{ $admin->name }}</a>

									<span class="absolute text-gray-600 text-sm" style="left:65px;top:45px">
						                {{ $admin->is($group->owner) ? __('site.group_owner') : __('site.admin_since') .' '. $admin->pivot->updated_at->diffForHumans() }}
						            </span>									

					   				@if ($group->owner->is(auth()->user()) && $admin->isNot($group->owner))
										<form-component 
								            class="ml-auto form-changes" 
								            cur-action="{{ route('groups.dismiss_admin', [$group, $admin]) }}"
								            cur-method="patch"
								            new-action="{{ route('groups.assign_admin', [$group, $admin]) }}"
								            new-method="patch"
								        >
								            @csrf
								  	        
								            <button-component
								              	cur-class="button-outline-primary"
								              	title="@lang('site.click_to_remove_from_admins_list')"
								              	value="@lang('site.dismiss')"
								              	new-title="@lang('site.click_to_add_to_admins_list')"
								              	new-value="@lang('site.assign')"
								              	new-class="button-outline-secondary">
								            </button-component>
								        </form-component>
									@endif
								</div>
					   		@endforeach
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