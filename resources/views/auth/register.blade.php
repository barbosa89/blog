@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center vh-100">
        <div class="d-flex flex-column justify-content-center align-items-center p-5">
            <div class="card w-50 p-3 border-0 shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3 px-4">
                            <label for="name" class="col-form-label ps-0">{{ __('Name') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3 px-4">
                            <label for="email" class="col-form-label ps-0">{{ __('Email Address') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3 px-4">
                            <label for="password" class="col-form-label ps-0">{{ __('Password') }}</label>

                            <input id="password" type="password" class="form-control my-2 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3 px-4">
                            <label for="password-confirm" class="col-form-label ps-0">{{ __('Confirm Password') }}</label>

                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="row mb-0 px-3">
                            <div class="col-12 text-end px-2">
                                <a class="btn btn-link text-dark" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
