@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Verify Your Email Address</h1>
                                    </div>

                                    <div class="mb-4 text-sm text-gray-600">
                                        @if (session('registered'))
                                            Thanks for signing up! Before getting started, could you verify your email
                                            address by clicking on the link we just emailed to you?
                                        @else
                                            Please verify your email address by clicking on the link we just sent to you.
                                        @endif
                                        If you didn't receive the email, we will gladly send you another.
                                    </div>

                                    @if (session('status') == 'verification-link-sent')
                                        <div class="alert alert-success mb-4" role="alert">
                                            A new verification link has been sent to the email address you provided during
                                            registration.
                                        </div>
                                    @endif

                                    <div class="mt-4">
                                        <form method="POST" action="{{ route('verification.send') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Resend Verification Email
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                                            @csrf
                                            <button type="submit" class="btn btn-link btn-block text-sm text-gray-600">
                                                Log Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
