{{-- Accept Friend Request Form --}}
<form-component 
    class="remove-element ml-auto" 
    user-box="user-box-{{$user->id}}" 
    cur-action="{{ route('users.accept_request', $user) }}"
    cur-method="post"
>
    @csrf
  
    <button-component
        cur-class="button-outline-primary"
        title="@lang('site.click_to_accept_the_request')"
        value="@lang('site.accept')">
    </button-component>
</form-component>