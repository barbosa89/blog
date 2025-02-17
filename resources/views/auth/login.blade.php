@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center vh-100">
        <div class="d-flex flex-column justify-content-center align-items-center p-5">
            <h1 class="mb-3">{{ trans('page.welcome') }}</h1>
            <div class="card w-50 p-3 border-0 shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @honeypot

                        <div class="row mb-3 px-4">
                            <label for="email" class="col-form-label ps-0">{{ __('Email Address') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3 px-4">
                            <label for="password" class="col-form-label ps-0">{{ __('Password') }}</label>

                            <input id="password" type="password" class="form-control my-2 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3 px-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="row mb-3 px-3">
                            <div class="col-12 text-end px-2">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-dark" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-50 d-flex justify-content-end mt-4">
                <a href="/">{{ trans('page.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
