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
                        <img src="{{ URL::asset('assets/img/media/login.png') }}"
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
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex"> <a href="{{ url('/' . ($page = 'index')) }}"><img
                                                src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                                                class="sign-favicon ht-40" alt="logo"></a>
                                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Ad<span>el</span>xpress</h1>
                                    </div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>مرحبا مجددا !</h2>
                                            <h5 class="font-weight-semibold mb-4">الرجاء تسجيل الدخول من اجل المتابعة</h5>
                                            <form action="{{ route('login') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="email">إسم المستخدم او البريد الإلكتروني</label>

                                                    <input
                                                        class="form-control  @if ($errors->has('email') || $errors->has('username')) has-error @endif"
                                                        name="email" id="email" value="{{ old('email') }}"
                                                        placeholder="ادخل اسم المستخدم او البريد الالكتروي" type="text">
                                                    @if ($errors->has('email') || $errors->has('username'))
                                                        <span class="help">{{ $errors->first('email') }}
                                                            {{ $errors->first('username') }}</span>
                                                    @endif

                                                </div>

                                                <div class="form-group">
                                                    <label>كلمة المرور</label>
                                                    <input class="form-control" name="password" required
                                                        autocomplete="current-password" placeholder="ادخل كلمة المرور"
                                                        type="password">
                                                    @error('password')
                                                        <span class="invalid-feedback text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-main-primary btn-block" type="submit">تسجيل
                                                    الدخول</button>


                                            </form>
                                            <div class="main-signin-footer mt-5">
                                                <p><a href="{{ route('admin.forgot_password') }}"> نسيت كلمة المرور؟</a>
                                                </p>
                                            </div>
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
