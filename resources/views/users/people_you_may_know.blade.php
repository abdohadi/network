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
        @if (auth()->user()->sentFriendRequests->contains($user))
	        <button 
	        	data-user-id="{{ $user->id }}" 
	        	id="cancel_friend_request" 
	        	class="button-outline-secondary ml-auto"
	        	title="Click to cancel the request"
	        ><i class="fa fa-check"></i> Sent</button>
	      @else
	        <button 
	        	data-user-id="{{ $user->id }}" 
	        	id="send_friend_request" 
	        	class="button-outline-primary ml-auto"
	        	title="Click to send a friend request"
	        ><i class="fa fa-user-plus"></i> Add</button>
	      @endif
    	</div>
		@empty
			<div>No users yet</div>
		@endforelse
	</div>
</div>
