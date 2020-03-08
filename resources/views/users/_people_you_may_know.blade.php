<div class="flex items-center mb-4">
  <a href="{{ '/users/'.$user['id'] }}">
    <img src="{{ gravatar($user['email']) }}" class="rounded-full w-16 mr-2" style="border:1px solid rgb(241, 239, 239);border-radius:50%">
  </a> 

  <a href="{{ '/users/'.$user['id'] }}">
      <span title="{{ $user['name'] }}" class="text-gray-700">{{ substr($user['name'], 0, 15) }}</span>
  </a>

  <button 
  	data-user-id="{{ $user['id'] }}" 
    data-btn-add="{{ __('site.add') }}" 
    data-btn-sent="{{ __('site.sent') }}" 
  	id="send_friend_request" 
  	class="button-outline-primary ml-auto"
  	title="@lang('site.click_to_send_a_friend_request')"
  ><i class="fa fa-user-plus"></i> @lang('site.add')</button>
</div>
