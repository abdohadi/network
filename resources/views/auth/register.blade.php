@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-20 ml-auto w-1/2" style="padding:50px 0;">
                <div>
                    <div class="card-header"><h3 class="text-2xl text-center mb-8">{{ __('Register') }}</h3></div>

                    <div class="card-body w-3/4 m-auto">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input 
                                        id="name" 
                                        type="text" 
                                        class="w-full py-2 px-2 border rounded mt-2 @error('name') is-invalid border border-red-300 @enderror" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        required 
                                        autocomplete="name" 
                                        autofocus>

                                    @error('name')
                                        <span class="invalid-feedback text-red-600" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

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
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        class="w-full py-2 px-2 border rounded mt-2 form-control @error('password') is-invalid border border-red-300 @enderror" 
                                        name="password" 
                                        required >

                                    @error('password')
                                        <span class="invalid-feedback text-red-600" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input 
                                        id="password-confirm" 
                                        type="password" 
                                        class="w-full py-2 px-2 border rounded mt-2 form-control @error('password-confirm') is-invalid border border-red-300 @enderror" 
                                        name="password_confirmation" 
                                        required >

                                    @error('password-confirm')
                                        <span class="invalid-feedback text-red-600" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="button-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
