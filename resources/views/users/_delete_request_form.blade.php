{{-- Delete Friend Request Form --}}
<form-component 
    class="remove-element ml-auto"
    user-box="user-box-{{$user->id}}" 
    cur-action="{{ route('users.delete_request', $user) }}"
    cur-method="delete"
>
    @csrf
  
    <button-component
        cur-class="button-outline-secondary"
        title="@lang('site.click_to_delete_the_request')"
        value="@lang('site.delete')">
    </button-component>
</form-component>