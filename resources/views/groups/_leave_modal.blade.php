<div id="leave-group-modal" class="modal group-modal">
	<div class="text-lg mb-6">@lang('site.are_you_sure_you_want_to_leave_this_group')</div>

	<form action="{{ route('groups.leave', $group) }}" method="post" class="text-center">
		@csrf
		@method('delete')

		<button class="button-primary">@lang('site.leave')</button>
	</form>
</div>
