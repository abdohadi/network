<nav class="bg-white shadow py-4">
    <div class="container flex justify-between m-auto flex-center items-center">
        <a class="text-xl" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="flex text-gray-600">
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
                    <li class="flex items-center">
                        <div class="mr-6" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>

                        <div class="flex items-center">
                            <a class="text-sm">{{ Auth::user()->name }}</a>
                            <img src="{{ gravatar($post->user->email) }}" class="rounded-full w-8 ml-2 h-8 text-sm"> 
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>