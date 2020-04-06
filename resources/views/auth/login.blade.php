@extends('layouts.app', ['nav_visiblity' => 'hidden'])

@section('content')
    <div class="login-register-parent flex">
        <div class="w-3/5 text-center text-gray-600 hello-there mt-20 text-4xl px-10 italic font-bold" style="text-shadow: rgba(148, 46, 46, 0.75) 1px -7px 4px;color: #a19191;"></div>
        {{-- <div class="w-3/5 text-center">
            <h1 class="text-center text-4xl font-bold mt-20 mr-20" style="color: rgba(133, 143, 158, 0.98);">Join our network and have fun</h1>
            <ul class="text-3xl font-bold mt-16 mr-20" style="color:rgba(133, 143, 158, 0.98)"> 
                <li class="mb-6">Share your posts with your friends</li>
                <li class="mb-6">Enjoy chating with other people</li>
                <li>Make new friends</li>
            </ul>

            <ul class="mt-10 text-primary text-lg mr-20" style="color:rgba(133, 143, 158, 0.98)">
                <li class="mb-2">High level of security and privacy</li>
                <li>We will never share your data</li>
            </ul>
        </div> --}}

        <div class="login-register w-2/5">
            {{-- Register card --}}
            <div class="card register-card" data-request="{{ old('register-request') ? 'register-request' : '' }}">
                <div class="card-header"><h3 class="text-2xl text-center mb-8">{{ __('site.register') }}</h3></div>

                <div class="card-body w-3/4 m-auto">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('site.name') }}</label>

                            <div class="col-md-6">
                                <input 
                                    id="name" 
                                    type="text" 
                                    class="w-full py-2 px-2 border rounded mt-2 {{ $errors->register->has('name') ? 'is-invalid border border-red-300' : '' }}" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    autocomplete="name" 
                                    autofocus>

                                @if($errors->register->has('name'))
                                    <span class="invalid-feedback text-red-600" role="alert">
                                        {{ $errors->register->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('site.email_address') }}</label>

                            <div class="col-md-6">
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="w-full py-2 px-2 border rounded mt-2 {{ $errors->register->has('email') ? 'is-invalid border border-red-300' : '' }}" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email" 
                                    autofocus>

                                @if($errors->register->has('email'))
                                    <span class="invalid-feedback text-red-600" role="alert">
                                        {{ $errors->register->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('site.password') }}</label>

                            <div class="col-md-6">
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="w-full py-2 px-2 border rounded mt-2 form-control {{ $errors->register->has('password') ? 'is-invalid border border-red-300' : '' }}" 
                                    name="password" 
                                    required >

                                @if($errors->register->has('password'))
                                    <span class="invalid-feedback text-red-600" role="alert">
                                        {{ $errors->register->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('site.confirm_password') }}</label>

                            <div class="col-md-6">
                                <input 
                                    id="password-confirm" 
                                    type="password" 
                                    class="w-full py-2 px-2 border rounded mt-2 form-control {{ $errors->register->has('password-confirm') ? 'is-invalid border border-red-300' : '' }}" 
                                    name="password_confirmation" 
                                    required >

                                @if($errors->register->has('password-confirm'))
                                    <span class="invalid-feedback text-red-600" role="alert">
                                        {{ $errors->register->first('password-confirm') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="register-request" value="register-request">

                        <div>
                            <div class="justify-between flex items-center">
                                <button type="submit" class="button-primary">
                                    {{ __('site.register') }}
                                </button>

                                <span class="have-account ml-auto text-primary cursor-pointer">{{ __('site.already_have_account') }}</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Login card --}}
            <div class="card login-card">
                <div><h3 class="text-2xl text-center mb-8">{{ __('site.login') }}</h3></div>

                <div class="card-body w-3/4 m-auto">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('site.email_address') }}</label>

                            <div class="col-md-6">
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="w-full py-2 px-2 border rounded mt-2 @error('email') is-invalid border border-red-300 @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email" 
                                    autofocus>

                                @error('email')
                                    <span class="invalid-feedback text-red-600" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('site.password') }}</label>

                            <div class="col-md-6">
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="w-full py-2 px-2 border rounded mt-2 form-control @error('password') is-invalid border border-red-300 @enderror" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback text-red-600" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="mb-6">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('site.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="flex justify-between items-center">
                                <button type="submit" class="button-primary">
                                    {{ __('site.login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-primary" href="{{ route('password.request') }}">
                                        {{ __('site.forgot_password') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="text-center">
                    <button class="button-outline-secondary create-account-button mt-10 px-10" style="padding:.4rem 2rem;">{{ __('site.create_new_account') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')

    <footer class="py-8 text-center mt-20 relative b-0" style="background-color:#f1f1f1;">
        Abdelrahman &copy 2019
    </footer>

@endsection