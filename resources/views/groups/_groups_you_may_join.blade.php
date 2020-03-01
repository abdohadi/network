<div class="card">
	<div 
		class="font-bold text-gray-600 mb-4">@lang('site.groups_you_may_join')</div>

	<div>
		@forelse(array_slice(groupsYouMayJoin(), 0, 2) as $group)
			<div class="border mb-6 pb-3">
        <a href="{{ '/groups/'.$group['id'] }}">
          <img src="/uploads/images/group_covers/{{ $group['cover'] }}" class="h-32 mb-2 mr-2 w-full">
        </a>

        <div class="ml-2">
          <div class="font-medium text-xl text-gray-700">
      			<a href="{{ '/groups/'.$group['id'] }}">
          		<span title="{{ $group['name'] }}">{{ $group['name'] }}</span>
      			</a>
          </div>

          <div class="text-sm text-gray-500 my-2">
          	{{ substr($group['description'], 0, 40).(strlen($group['description']) > 40 ? '...' : '') }}
          </div>
      	</div>

        <div class="text-center">
	        <button 
          class="button-outline-primary mt-4"
          title="Click to send a join request">
            <i class="fa fa-plus"></i> @lang('site.join')
          </button>
        </div>
    	</div>
		@empty
			<div>@lang('site.no_groups_yet')</div>
		@endforelse

		<div class="text-center text-primary mt-6">
      <a href="/find_people">@lang('site.find_more')</a>
    </div>
	</div>
</div>
