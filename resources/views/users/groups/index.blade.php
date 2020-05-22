@extends('layouts.app')

@section('content')

	<div class="lg:px-6 lg:flex">
		<div class="lg:w-1/5 mx-2 sm:hidden lg:block">
            @include('layouts._left_side')
		</div>

		<div class="lg:w-4/5 lg:ml-2 xl:ml-6 mt-3">
			{{-- Groups user created --}}
			<div class="card mb-6">
				<div class="flex mb-6">
					<div class="text-gray-700 text-lg mt-1">{{ $user->is(auth()->user()) ? __('site.groups_created_by_you') : __('site.groups_created_by').' '.$user->name }}</div>

					@if ($user->is(auth()->user()))
						<a href="#create-group-modal" rel="modal:open" class="button-primary open-group-modal ml-auto">@lang('site.create_group')</a>
					@endif
				</div>

				<div>
					@if (count($ownedGroups))
						@foreach ($ownedGroups as $group)
							<div class="lg:w-1/2 mb-4 flex float-left">
								<div class="w-1/4">
									<a href="{{ route('groups.show', $group) }}">
										<img class="w-32 h-16 rounded" src="{{ '/uploads/images/group_covers/'.$group->cover }}">
									</a>
								</div>

								<div class="{{ $group->hasAcceptedMember(auth()->user()) ? 'w-3/4' : 'w-2/4' }} mx-3">
									<div class="mt-1 text-gray-700 text-lg">
										<a href="{{ route('groups.show', $group) }}">{{ $group->name }}</a>
									</div>

									<div class="text-gray-500 text-sm">{{ count($group->members) . ' members'}}</div>
								</div>

								@if (! $group->hasAcceptedMember(auth()->user()) && ! $group->hasRequest(auth()->user()))
									<div class="w-1/4">
										<form-component 
								            class="mt-3 form-changes" 
								            cur-action="{{ route('groups.join', $group) }}"
								            cur-method="post"
								            new-action="{{ route('groups.cancel_request', $group) }}"
								            new-method="delete"
								        >
								            @csrf
								  	        
								            <button-component
								              	cur-class="button-outline-primary"
								              	title="@lang('site.click_to_send_a_join_request')"
								              	value="<i class='fa fa-plus'></i> @lang('site.join')"
								              	new-title="@lang('site.click_to_cancel_the_request')"
								              	new-value="@lang('site.cancel')"
								              	new-class="button-outline-secondary">
								            </button-component>
								        </form-component>
									</div>
								@elseif ($group->hasRequest(auth()->user()))
									<div class="w-1/4">
										<form-component 
								            class="mt-3 form-changes" 
								            cur-action="{{ route('groups.cancel_request', $group) }}"
								            cur-method="delete"
								            new-action="{{ route('groups.join', $group) }}"
								            new-method="post"
								        >
								            @csrf
								  	        
								            <button-component
								              	cur-class="button-outline-secondary"
								              	title="@lang('site.click_to_cancel_the_request')"
								              	value="@lang('site.cancel')"
								              	new-title="@lang('site.click_to_send_a_join_request')"
								              	new-value="<i class='fa fa-plus'></i> @lang('site.join')"
								              	new-class="button-outline-primary">
								            </button-component>
								        </form-component>
									</div>
								@endif
							</div>
						@endforeach
					
						<div style="clear: both;"></div>
					@else
						<div>@lang('site.no_groups_yet')</div>
					@endif
				</div>
			</div>

			{{-- Groups user is a member of --}}
			<div class="card mb-6">
				<div class="flex mb-6">
					<div class="text-gray-700 text-lg mt-1">{{ $user->is(auth()->user()) ? __('site.groups_you_are_in') : __('site.groups').' '.$user->name.' '.__('site.is_member_of') }}</div>
				</div>

				<div>
					@if (count($joinedGroups))
						@foreach ($joinedGroups as $group)
							<div class="lg:w-1/2 mb-4 flex float-left">
								<div class="w-1/4">
									<a href="{{ route('groups.show', $group) }}">
										<img class="w-32 h-16 rounded" src="{{ '/uploads/images/group_covers/'.$group->cover }}">
									</a>
								</div>

								<div class="{{  'w-2/4' }} mx-3">
									<div class="mt-1 text-gray-700 text-lg">
										<a href="{{ route('groups.show', $group) }}">{{ $group->name }}</a>
									</div>

									<div class="text-gray-500 text-sm">{{ count($group->members) . ' members'}}</div>
								</div>

								@if (! $group->hasAcceptedMember(auth()->user()) && ! $group->hasRequest(auth()->user()))
									<div class="w-1/4">
										<form-component 
								            class="mt-3 form-changes" 
								            cur-action="{{ route('groups.join', $group) }}"
								            cur-method="post"
								            new-action="{{ route('groups.cancel_request', $group) }}"
								            new-method="delete"
								        >
								            @csrf
								  	        
								            <button-component
								              	cur-class="button-outline-primary"
								              	title="@lang('site.click_to_send_a_join_request')"
								              	value="<i class='fa fa-plus'></i> @lang('site.join')"
								              	new-title="@lang('site.click_to_cancel_the_request')"
								              	new-value="@lang('site.cancel')"
								              	new-class="button-outline-secondary">
								            </button-component>
								        </form-component>
									</div>
								@elseif ($group->hasRequest(auth()->user()))
									<div class="w-1/4">
										<form-component 
								            class="mt-3 form-changes" 
								            cur-action="{{ route('groups.cancel_request', $group) }}"
								            cur-method="delete"
								            new-action="{{ route('groups.join', $group) }}"
								            new-method="post"
								        >
								            @csrf
								  	        
								            <button-component
								              	cur-class="button-outline-secondary"
								              	title="@lang('site.click_to_cancel_the_request')"
								              	value="@lang('site.cancel')"
								              	new-title="@lang('site.click_to_send_a_join_request')"
								              	new-value="<i class='fa fa-plus'></i> @lang('site.join')"
								              	new-class="button-outline-primary">
								            </button-component>
								        </form-component>
									</div>
								@endif
							</div>
						@endforeach

						<div style="clear: both;"></div>
					@else
						<div>@lang('site.no_groups_yet')</div>
					@endif
				</div>
			</div>

			{{-- Groups user sent join requests to --}}
			@if ($user->is(auth()->user()))
				<div class="card mb-6">
					<div class="flex mb-6">
						<div class="text-gray-700 text-lg mt-1">@lang('site.groups_you_sent_join_request_to')</div>
					</div>

					<div>
						@if (count($requestedGroups))
							@foreach ($requestedGroups as $group)
								<div class="lg:w-1/2 mb-4 flex float-left">
									<div class="w-1/4">
										<a href="{{ route('groups.show', $group) }}">
											<img class="w-32 h-16 rounded" src="{{ '/uploads/images/group_covers/'.$group->cover }}">
										</a>
									</div>

									<div class="{{  'w-2/4' }} mx-3">
										<div class="mt-1 text-gray-700 text-lg">
											<a href="{{ route('groups.show', $group) }}">{{ $group->name }}</a>
										</div>

										<div class="text-gray-500 text-sm">{{ count($group->members) . ' members'}}</div>
									</div>

									<div class="w-1/4">
										<form-component 
								            class="mt-3 form-changes" 
								            cur-action="{{ route('groups.cancel_request', $group) }}"
								            cur-method="delete"
								            new-action="{{ route('groups.join', $group) }}"
								            new-method="post"
								        >
								            @csrf
								  	        
								            <button-component
								              	cur-class="button-outline-secondary"
								              	title="@lang('site.click_to_cancel_the_request')"
								              	value="@lang('site.cancel')"
								              	new-title="@lang('site.click_to_send_a_join_request')"
								              	new-value="<i class='fa fa-plus'></i> @lang('site.join')"
								              	new-class="button-outline-primary">
								            </button-component>
								        </form-component>
									</div>
								</div>
							@endforeach

							<div style="clear: both;"></div>
						@else
							<div>@lang('site.no_groups_yet')</div>
						@endif
					</div>
				</div>
			@endif
		</div>
	</div>

    @include('groups._create_modal')
	
@endsection