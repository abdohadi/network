<div class="lg:w-1/4 mx-2 sm:hidden lg:block">
    <div class="text-gray-500 ml-12 font-medium fixed">
        <a href="#group-modal" rel="modal:open" class="button-primary open-group-modal">Create Group</a>
        <ul>
            <li><a href="">friends</a></li>
            <li><a href="/groups">Groups <span>{{ count(auth()->user()->groups) }}</span></a></li>
            <li><a href="">Pages</a></li>
            <li><a href="">Sittings</a></li>
        </ul>

        @include('layouts.footer')
    </div>
</div>