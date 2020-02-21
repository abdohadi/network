<div class="flex items-center mb-4">
  <a href="{{ '/users/'.$user['id'] }}">
    <img src="{{ gravatar($user['email']) }}" class="rounded-full w-16 mr-2" style="border:1px solid rgb(241, 239, 239);border-radius:50%">
  </a> 
  <a href="{{ '/users/'.$user['id'] }}">
      <span title="{{ $user['name'] }}" class="text-gray-700">{{ substr($user['name'], 0, 15) }}</span>
  </a>
  @if (auth()->user()->sentFriendRequests->contains($user))
    <button 
    	data-user-id="{{ $user['id'] }}" 
    	id="cancel_friend_request" 
    	class="button-outline-secondary ml-auto"
    	title="Click to cancel the request"
    ><i class="fa fa-check"></i> Sent</button>
  @else
    <button 
    	data-user-id="{{ $user['id'] }}" 
    	id="send_friend_request" 
    	class="button-outline-primary ml-auto"
    	title="Click to send a friend request"
    ><i class="fa fa-user-plus"></i> Add</button>
  @endif
</div>
