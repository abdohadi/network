<div class="card">
	<div 
		class="p-2 bg-gray-400 text-center border font-bold text-gray-700 rounded-lg" 
		style="margin:-16px;margin-bottom:16px;background:rgb(247, 247, 247);"
	>Join new groups</div>

	<div>
		@forelse($groups as $group)
			<div class="border mb-6 pb-3">
        <a href="{{ $group->path() }}">
          <img src="/images/{{ $group->cover }}" class="h-32 mb-2 mr-2 w-full">
          <div class="ml-2">
	          <div class="font-bold text-lg" title="{{ $group->name }}">{{ $group->name }}</div>
	          <div class="text-sm text-gray-500 my-2">{{ substr($group->description, 0, 40).(strlen($group->description) > 40 ? '...' : '') }}</div>
        	</div>
        </a>
        <div class="text-center">
	        <button class="button-outline mt-2"><i class="fa fa-plus"></i> Join</button>
        </div>
    	</div>
		@empty
			<div>No groups yet</div>
		@endforelse
	</div>
</div>
