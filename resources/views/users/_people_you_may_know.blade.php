<div class="card mb-8">
  <div class="text-lg text-gray-700 mb-4">@lang('site.people_you_may_know')</div>

  <div>
    @forelse(array_slice(peopleYouMayKnow(), 0, 3) as $user)      
      <div class="flex items-center mb-4">
        <a href="{{ route('users.show', $user['id']) }}">
          <img src="{{ getProfilePicture($user) }}" class="rounded-full w-16 mr-2" style="border:1px solid rgb(241, 239, 239);border-radius:50%">
        </a> 

        <a href="{{ route('users.show', $user['id']) }}">
          <span title="{{ $user['name'] }}" class="text-gray-700">{{ substr($user['name'], 0, 15) }}</span>
        </a>

        {{-- Send Friend Request Form --}}
        @include('users._send_request_form')
      </div>
    @empty
      @lang('site.no_suggestions_available')
    @endforelse

    {{-- <div class="text-center text-primary mt-6">
        <a href="/find_people">@lang('site.find_more')</a>
    </div> --}}
  </div>
</div>