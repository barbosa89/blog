@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center vh-100">
        <div class="d-flex flex-column justify-content-center align-items-center p-5">
            <span class="mb-3">{{ __('Verify Your Email Address') }}</span>
            <div class="card w-50 p-3 border-0 shadow">
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
