{{-- Cancel Friend Request Form --}}
<form-component 
	class="form-changes ml-auto" 
	cur-action="{{ route('users.cancel_request', $user['id']) }}"
	cur-method="delete"
	new-action="{{ route('users.send_request', $user['id']) }}"
	new-method="post"
>
  	@csrf
  
  	<button-component
		cur-class="button-outline-secondary"
		title="@lang('site.click_to_cancel_the_request')"
		value="<i class='fa fa-check'></i> @lang('site.sent')"
		new-class="button-outline-primary"
		new-title="@lang('site.click_to_send_a_friend_request')"
		new-value="<i class='fa fa-plus'></i> @lang('site.add')">
  	</button-component>
</form-component>