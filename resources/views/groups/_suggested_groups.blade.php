<div class="card">
	<div 
		class="mb-4 text-lg text-gray-700">@lang('site.suggested_groups')</div>

	<div>
		@forelse(suggestedGroups(3) as $group)
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
          <form-component 
            class="mt-4 form-changes" 
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
    	</div>
		@empty
			<div>@lang('site.no_suggestions_available')</div>
		@endforelse

		<div class="text-center text-primary mt-6">
      <a href="/find_people">@lang('site.find_more')</a>
    </div>
	</div>
</div>
