@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: url('./assets/img/bg-login.jpg');
        background-size: cover;
    }

    .card-login {
        opacity: 85%;
        margin-top: 50%;
    }
</style>
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card card-login">
                <div class="card-header text-center">
                    <img src="{{'assets/img/bs.png'}}" alt="" width="20%">
                    <h6>Aplikasi Kehadiran BSKP</h6>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col">
                                <div class="text-center">
                                    <input placeholder="Your Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            

                            <div class="col">
                                <input placeholder="Your Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col">
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Login') }}
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
