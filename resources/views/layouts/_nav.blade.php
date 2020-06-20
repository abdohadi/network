<nav id="nav" class="bg-white shadow py-2 fixed w-full z-10 {{ isset($nav_visiblity) ? $nav_visiblity : '' }}">
    <div class="container flex justify-between m-auto flex-center items-center px-10">
        <a class="text-xl" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul>
                <!-- Authentication Links -->
                <li>
                    <ul class="flex items-center">
                        <li>
                            <a class="mx-3 flex text-gray-600 font-medium" href="/">@lang('site.home')</a>    
                        </li>

                        {{-- Friend requests icon --}}
                        <li id="show-friend-requests" class="mx-3 text-2xl cursor-pointer" title="Friend Requests">
                            <i id="show-friend-requests" class="fa fa-user-friends text-gray-700"></i>
                        </li>

                        {{-- Friend requests menue --}}
                        <div 
                            id="friend-requests-dropdown" 
                            class="absolute bg-white border p-4 shadow-2xl z-10 hidden md:right-c-187 h-screen sm:h-c-450 inset-0 sm:inset-auto overflow-scroll">
                            <h4 class="mb-3 text-gray-500">@lang('site.friend_requests')</h4>

                            <ul>
                                @forelse(auth()->user()->receivedFriendRequests as $user)
                                    <li class="flex items-center justify-between mb-4" id="friend-request">
                                        <div class="flex items-center">
                                            <a href="{{ route('users.show', $user) }}">
                                                <img src="{{ getProfilePicture($user) }}" class="rounded-full w-10 mr-2">
                                            </a> 

                                            <a href="{{ route('users.show', $user) }}">
                                                <span>{{ $user->name }}</span>
                                            </a>
                                        </div>

                                        <div class="flex">
                                            <div>
                                                {{-- Accept Friend Request Form --}}
                                                @include('users._accept_request_form')
                                            </div>

                                            <div class="ml-1">
                                                {{-- Delete Friend Request Form --}}
                                                @include('users._delete_request_form')
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-sm ml-6">@lang('site.no_friend_requests')</li>
                                @endforelse
                            </ul>

                            <h4 class="mb-3 text-gray-500 mt-8">@lang('site.make_new_friends')</h4>

                            <ul>
                                @forelse(peopleYouMayKnow() as $user)
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
                                    <div class="text-sm ml-6">@lang('site.no_users_yet')</div>
                                @endforelse
                            </ul>
                        </div>

                        <li class="mx-3 text-2xl cursor-pointer" title="Notifications">
                            <i class="fa fa-bell text-gray-700"></i>
                        </li>

                        <li class="mx-3 text-2xl cursor-pointer" title="Notifications">
                            <i class="fab fa-facebook-messenger text-gray-700"></i>
                        </li>

                        <li class="mx-3">
                            <a href="{{ route('users.show', auth()->user()) }}" class="flex items-center cursor-pointer">
                                <span class="text-sm text-gray-800">{{ Auth::user()->name }}</span>
                                <img src="{{ getProfilePicture(auth()->user()) }}" class="rounded-full w-8 ml-2 h-8 text-sm"> 
                            </a>
                        </li>

                        <li class="mx-3 flex text-gray-600">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('site.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>