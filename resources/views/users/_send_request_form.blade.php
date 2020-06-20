{{-- Send Friend Request Form --}}
<form-component 
	class="form-changes ml-auto" 
	cur-action="{{ route('users.send_request', $user['id']) }}"
	cur-method="post"
	new-action="{{ route('users.cancel_request', $user['id']) }}"
	new-method="delete"
>
  	@csrf
  
  	<button-component
		cur-class="button-outline-primary"
		title="@lang('site.click_to_send_a_friend_request')"
		value="<i class='fa fa-plus'></i> @lang('site.add')"
		new-class="button-outline-secondary"
		new-title="@lang('site.click_to_cancel_the_request')"
		new-value="<i class='fa fa-check'></i> @lang('site.sent')">
  	</button-component>
</form-component>