<div class="fixed sm:hidden lg:block">
    <ul class="left-side-ul">
        <li>
            <a class="mt-4 mb-4" href="#">
                <i class="fas fa-user-friends"></i> @lang('site.friends') 
                @if (count(auth()->user()->friends))
                    <small>{{ count(auth()->user()->friends) }}</small>
                @endif
            </a>
        </li>

        <li class="mt-4 mb-4">
            <div>
                <a href="{{ route('users.groups.index', auth()->user()) }}"><i class="fa fa-users"></i> @lang('site.groups')</a>
            </div>
        </li>

        <li class="mt-4 mb-4">
            <a href=""><i class="fa fa-cog"></i> @lang('site.settings')</a>
        </li>

        <li class="mt-4 mb-4">
            <span><i class="fa fa-flag"></i> @lang('site.language')</a></span>

            <ul class="pl-8">
                <li><a class="text-sm" href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a></li>
                <li><a class="text-sm" href="{{ LaravelLocalization::getLocalizedURL('ar') }}">العربيه</a></li>
            </ul>
        </li>
    </ul>

    @include('layouts._footer')
</div>
