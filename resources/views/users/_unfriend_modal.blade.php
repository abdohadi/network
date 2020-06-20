<div id="unfriend-modal" class="modal">
	<div class="text-lg mb-6">@lang('site.are_you_sure_you_want_to_remove_this_friend')</div>

	<form action="{{ route('users.unfriend', $friend) }}" method="post" class="text-center">
		@csrf
		@method('delete')

		<button class="button-primary">@lang('site.confirm')</button>
	</form>
</div>
