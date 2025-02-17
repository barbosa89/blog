@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center vh-100">
        <div class="d-flex flex-column justify-content-center align-items-center p-5">
            <span class="mb-3">{{ __('Please confirm your password before continuing.') }}</span>
            <div class="card w-50 p-3 border-0 shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3 px-4">
                            <label for="password" class="col-form-label ps-0">{{ __('Password') }}</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-0 px-3">
                            <div class="col-12 text-end px-2">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-dark" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
