@extends('layouts.app')

@section('content')
    <section class="py-3 main-back-color">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('panel.f_confirm_password') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 ">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="h5 text-uppercase mb-3">{{ __('panel.f_confirm_password') }}</h2>
                {{ __('panel.f_please_confirm_your_password_before_continuing') }}
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="row mb-3">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password" class="col-md-4 col-form-label ">{{ __('panel.f_password') }}</label>
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('panel.f_confirm_password') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('panel.f_forgot_password') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
