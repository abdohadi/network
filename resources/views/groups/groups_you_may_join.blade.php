<div class="card">
	<div 
		class="p-2 bg-gray-400 text-center border font-bold text-gray-700 rounded-lg" 
		style="margin:-16px;margin-bottom:16px;background:rgb(247, 247, 247);"
	>Join New Groups</div>

	<div>
		@forelse(array_slice(groupsYouMayJoin(), 0, 2) as $group)
			<div class="border mb-6 pb-3">
        <a href="{{ '/groups/'.$group['id'] }}">
          <img src="/images/{{ $group['cover'] }}" class="h-32 mb-2 mr-2 w-full">
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
            <i class="fa fa-plus"></i> Join
          </button>
        </div>
    	</div>
		@empty
			<div>No groups yet</div>
		@endforelse

		<div class="text-center text-primary mt-6">
      <a href="/find_people">Find More</a>
    </div>
	</div>
</div>
