@if (count(peopleYouMayKnow()))
    {{-- Make new friends --}}
    <div class="card mb-8">
        <div class="font-bold text-gray-600 mb-4">@lang('site.people_you_may_know')</div>

        <div>
            @foreach(array_slice(peopleYouMayKnow(), 0, 3) as $user)
                @include('users._people_you_may_know')
            @endforeach

            <div class="text-center text-primary mt-6">
                <a href="/find_people">@lang('site.find_more')</a>
            </div>
        </div>
    </div>
@endif

{{-- Join new groups --}}
@include('groups._groups_you_may_join')