@extends('layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets/img/media/forgot.png') }}"
                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="mb-5 d-flex"> <a href="{{ url('/' . ($page = 'index')) }}"><img
                                            src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                                            class="sign-favicon ht-40" alt="logo"></a>
                                    <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Ad<span>el</span>xpress</h1>

                                </div>
                                <div class="main-card-signin d-md-flex bg-white">
                                    <div class="wd-100p">
                                        <div class="main-signin-header">
                                            <h2>إعادة تعيين كلمة المرور!</h2>
                                            <h4>الرجاء إدخل بريدك الإلكتروني</h4>

                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    <button aria-label="Close" class="close" data-dismiss="alert"
                                                        type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <div class="d-none">{{ session('status') }}</div>

                                                    <strong>ملاحظة !</strong>
                                                    {{ __('panel.f_we_have_sent_you_a_reset_link_to_your_email') }}
                                                </div>
                                            @else
                                                <div class="alert alert-info" role="alert">
                                                    <button aria-label="Close" class="close" data-dismiss="alert"
                                                        type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <strong>ملاحظة !</strong>
                                                    ادخل <strong> بريدك الإلكتروني </strong> , وسيتم ارسالت التعليمات الى
                                                    البريد الإلكتروني
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="email">البريد الإلكتروني</label>
                                                    <input type="email" name="email" id="email" class="form-control"
                                                        name="email" value="{{ old('email') }}"
                                                        placeholder="ادخل بريدك الإلكتروني" autocomplete="email"
                                                        autocapitalize="none">>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                                <button class="btn btn-main-primary btn-block" type="submit"
                                                    name="submit">
                                                    {{ __('panel.f_send_reset_link') }}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="main-signup-footer mg-t-20">
                                            <p>
                                                تذكرت بيانات حسابي العودة الى
                                                <a href="{{ route('admin.login') }}"> واجهة تسجيل الدخول </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
@endsection
@section('js')
@endsection
