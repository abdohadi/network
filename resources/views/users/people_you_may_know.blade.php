<div class="card mb-8">
	<div 
		class="p-2 bg-gray-400 text-center border font-bold text-gray-700 rounded-lg" 
		style="margin:-16px;margin-bottom:16px;background:rgb(247, 247, 247);"
	>Make new friends</div>

	<div>
		@forelse($users as $user)
			<div class="flex items-center mb-4">
        <a href="{{ $user->path() }}">
            <img src="{{ gravatar($user->email) }}" class="rounded-full w-10 mr-2">
        </a> 
        <a href="{{ $user->path() }}">
            <span>{{ $user->name }}</span>
        </a>
        <button class="button-outline ml-auto"><i class="fa fa-user-plus"></i> Add</button>
    	</div>
		@empty
			<div>No users yet</div>
		@endforelse
	</div>
</div>
