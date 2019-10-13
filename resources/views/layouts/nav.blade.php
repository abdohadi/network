<nav id="nav" class="bg-white shadow py-2 fixed w-full z-10 {{ isset($nav_visiblity) ? $nav_visiblity : '' }}">
    <div class="container flex justify-between m-auto flex-center items-center">
        <a class="text-xl" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul>
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="ml-4">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li>
                        <ul class="flex items-center">
                            <li>
                                <a class="mx-3 flex text-gray-600 font-medium" href="/">Home</a>    
                            </li>

                            {{-- Friend requests icon --}}
                            <li id="show-friend-requests" class="mx-3 text-2xl cursor-pointer" title="Friend Requests">
                                <i id="show-friend-requests" class="fa fa-users text-gray-700"></i>
                            </li>

                            {{-- Friend requests menue --}}
                            <div id="friend-requests-dropdown" class="absolute bg-white border p-4 shadow-2xl w-2/6 z-10 hidden" style="right:187px;height:600px">
                                <h4 class="mb-3 text-gray-500">Friend Requests</h4>
                                <ul>
                                    @forelse(auth()->user()->receivedFriendRequests as $user)
                                        <li class="flex items-center justify-between mb-4" id="friend-request">
                                            <div class="flex items-center">
                                                <a href="{{ $user->path() }}">
                                                    <img src="{{ gravatar($user->email) }}" class="rounded-full w-10 mr-2">
                                                </a> 
                                                <a href="{{ $user->path() }}">
                                                    <span>{{ $user->name }}</span>
                                                </a>
                                            </div>
                                            <div>
                                                <button 
                                                    data-user-id="{{ $user->id }}" 
                                                    id="accept_friend_request" 
                                                    class="button-outline-secondary ml-auto"
                                                >Accept</button>
                                                <button 
                                                    data-user-id="{{ $user->id }}" 
                                                    id="delete_friend_request" 
                                                    class="button-outline-primary ml-auto"
                                                >Delete</button>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-sm ml-6">No Friend Requests</li>
                                    @endforelse
                                </ul>

                                <h4 class="mb-3 text-gray-500 mt-8">Make New Friends</h4>
                                <ul>
                                    @forelse(peopleYouMayKnow() as $user)
                                        @include('users.people_you_may_know')
                                    @empty
                                        <div class="text-sm ml-6">No users yet</div>
                                    @endforelse
                                </ul>
                            </div>

                            <li class="mx-3 text-2xl cursor-pointer" title="Notifications">
                                <i class="fa fa-bell text-gray-700"></i>
                            </li>

                            <li class="mx-3 text-2xl cursor-pointer" title="Notifications">
                                <i class="fa fa-comment text-gray-700"></i>
                            </li>

                            <li class="mx-3">
                                <a href="{{ auth()->user()->path() }}" class="flex items-center cursor-pointer">
                                    <span class="text-sm text-gray-800">{{ Auth::user()->name }}</span>
                                    <img src="{{ gravatar(auth()->user()->email) }}" class="rounded-full w-8 ml-2 h-8 text-sm"> 
                                </a>
                            </li>

                            <li class="mx-3 flex text-gray-600">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>