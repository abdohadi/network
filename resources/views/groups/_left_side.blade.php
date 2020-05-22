<div class="fixed pr-6" style="width: inherit;">
	<h2 class="mb-6 leading-tight text-3xl">{{ $group->name }}</h2>

	<div class="mb-6">
		<h3 class="text-lg text-gray-600 mb-2">@lang('site.description')</h3>

		<p>{{ $group->description }}</p>
	</div>

    <div class="mb-6">
    	@if ($group->hasAdmin(auth()->user()))
			<h3 class="text-lg text-gray-600 mb-2">@lang('site.manage_group')</h3>
		@else
			<h3 class="text-lg text-gray-600 mb-2">@lang('site.group_details')</h3>
		@endif

   		<ul>
			<li class="mb-2">
				<a href="{{ route('groups.admins', $group) }}" class="text-gray-700 text-xl">
					<i class="fa fa-user-tie mr-1 text-gray-600"></i> @lang('site.admins') . <small>{{ count($group->admins) }}</small>
				</a>
			</li>

			<li class="mb-2">
				<a href="{{ route('groups.members', $group) }}" class="text-gray-700 text-xl">
					<i class="fa fa-users mr-1 text-gray-600"></i> @lang('site.members') . <small>{{ count($group->acceptedMembers) }}</small>
				</a>
			</li>

			@if ($group->hasAdmin(auth()->user()))
				<li class="mb-2">
					<a href="{{ route('groups.requests', $group) }}" class="text-gray-700 text-xl">
						<i class="fa fa-users-cog mr-1 text-gray-600"></i> @lang('site.requests') . <small>{{ count($group->joinRequests) }}</small>
					</a>
				</li>

				<li class="mb-2">
					<a href="{{ route('groups.view_friends', $group) }}" class="text-gray-700 text-xl">
						<i class="fa fa-user-plus mr-1 text-gray-600"></i> @lang('site.add_member')
					</a>
				</li>

				<li class="mb-2">
					<a href="#edit-group-modal" rel="modal:open" class="text-gray-700 text-xl">
						<i class="fa fa-edit mr-1 text-gray-600"></i> @lang('site.edit_group')
					</a>
				</li>

				@if ($group->owner->is(auth()->user()))
					<li class="mb-2">
						<a href="#delete-group-modal" rel="modal:open" class="text-gray-700 text-xl">
							<i class="fa fa-trash-alt mr-1 text-gray-600"></i> @lang('site.delete_group')
						</a>
					</li>
				@endif
			@endif
		</ul>
    </div>
</div>

{{-- Modals --}}
@if ($group->hasAdmin(auth()->user()))
    @include('groups._edit_modal')
@endif

@if ($group->owner->is(auth()->user()))
    @include('groups._delete_modal')
@endif

@if ($group->hasAcceptedMember(auth()->user()))
    @include('groups._leave_modal')
@endif