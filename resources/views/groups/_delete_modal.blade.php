<div id="delete-group-modal" class="modal group-modal">
  	<h3 class="font-semibold mb-6 text-2xl text-center">@lang('site.delete_your_group')</h3>

	<div class="text-lg mb-6">@lang('site.are_you_sure_you_want_to_delete_this_group')</div>

	<form action="{{ route('groups.destroy', $group) }}" method="post" class="text-center">
		@csrf
		@method('delete')

		<button class="button-primary">@lang('site.delete')</button>
	</form>
</div>
