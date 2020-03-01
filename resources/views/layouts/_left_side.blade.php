<div class="lg:w-1/4 mx-2 sm:hidden lg:block">
    <div class="fixed">
        {{-- <a href="#group-modal" rel="modal:open" class="button-primary open-group-modal">Create Group</a> --}}
        <ul class="left-side-ul">
            <li>
                <a class="font-medium mt-4 mb-4" href="">@lang('site.friends') 
                    @if (count(auth()->user()->friends))
                        <small>{{ count(auth()->user()->friends) }}</small>
                    @endif
                </a>
            </li>

            <li class="font-medium mt-4 mb-4">
                <div>
                    <a href="/groups">@lang('site.groups') 
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

            <li class="font-medium mt-4 mb-4">
                <a href="">@lang('site.pages') 
                    {{-- @if (count(auth()->user()->pages)) --}}
                        {{-- <small>100</small> --}}
                    {{-- @endif --}}
                </a>
            </li>

            <li class="font-medium mt-4 mb-4"><a href="">@lang('site.settings')</a></li>
        </ul>

        @include('layouts._footer')
    </div>
</div>