@extends('layouts.app')

@section('content')
    <section class="py-5 pref">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('panel.f_insure_user_email') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">

                </div>
            </div>
        </div>
    </section>

    <section class="py-5 ">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="h5 text-uppercase mb-3">{{ __('panel.f_insure_user_email') }}</h2>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert"
                        style="margin-bottom: 5px ; background-color:rgba(200 , 100 , 100,0.3) ; border-radius: 10px">
                        {{ __('panel.f_we_sent_link_insurent_to_your_email') }}
                    </div>
                @endif
                {{ __('panel.f_before_start_check_email_to_continue') }}
                <br>
                {{ __('panel.f_if_you_didnt_receive_an_email') }},

                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 px-1 py-1 m-0 align-baseline" style="border-radius: 5px">
                        {{ __('panel.f_click_here_to_get_another') }}
                    </button>.
                </form>
            </div>
        </div>
    </section>
@endsection
