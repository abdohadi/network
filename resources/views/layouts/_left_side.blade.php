<div class="lg:w-1/4 mx-2 sm:hidden lg:block">
    <div class="fixed">
        {{-- <a href="#group-modal" rel="modal:open" class="button-primary open-group-modal">Create Group</a> --}}
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
                    <a href="/groups">
                        <i class="fa fa-users"></i> @lang('site.groups') 
                        @if (count(auth()->user()->groups))
                            <small>{{ count(auth()->user()->groups) }}</small>
                        @endif
                    </a>
                </div>
                <div>
                    @for($i = 0; $i < (count(auth()->user()->groups) < 3 ? count(auth()->user()->groups) : 3); ++$i)
                        <div>
                            <a class="ml-4 text-primary" href="">{{ auth()->user()->groups->toArray()[$i]['name'] }}</a>
                        </div>
                    @endfor
                </div>
            </li>

            <li class="mt-4 mb-4">
                <a href="">
                    <i class="fa fa-grip-horizontal"></i> @lang('site.pages') 
                    {{-- @if (count(auth()->user()->pages)) --}}
                        {{-- <small>100</small> --}}
                    {{-- @endif --}}
                </a>
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
</div>