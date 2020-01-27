<div class="lg:w-1/4 mx-2 sm:hidden lg:block">
    <div class="text-gray-500 ml-12 fixed">
        <a href="#group-modal" rel="modal:open" class="button-primary open-group-modal">Create Group</a>
        <ul>
            <li><a class="font-medium mt-4 mb-4" href="">friends <span>({{ count(auth()->user()->friends) }})</span></a></li>
            <li class="font-medium mt-4 mb-4">
                <div>
                    <a href="/groups">Groups <span>({{ count(auth()->user()->groups) }})</span></a>
                </div>
                <div>
                    @for($i = 0; $i < (count(auth()->user()->groups) < 3 ? count(auth()->user()->groups) : 3); ++$i)
                        <div>
                            <a class="ml-4 text-primary" href="">{{ auth()->user()->groups->toArray()[$i]['name'] }}</a>
                        </div>
                    @endfor
                </div>
            </li>
            <li class="font-medium mt-4 mb-4"><a href="">Pages (0)</a></li>
            <li class="font-medium mt-4 mb-4"><a href="">Sittings</a></li>
        </ul>

        @include('layouts.footer')
    </div>
</div>