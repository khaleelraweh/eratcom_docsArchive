@extends('layouts.app')

@section('content')
    <section class="py-3 pref">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('transf.lnk_login') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 ">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="h5 text-uppercase mb-3">{{ __('transf.lnk_login') }}</h2>

                {{-- <form method="POST" action="{{ route('login') }}">

                    @csrf
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="username" class="text-small text-uppercase">{{ __('إسم الحساب') }}</label>
                                <input id="username" type="text"
                                    class="form-control form-control-lg @error('username') is-invalid @enderror"
                                    name="username" placeholder="ادخل اسم الحساب" value="{{ old('username') }}" required
                                    autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="password" class="text-small text-uppercase">{{ __('كلمة المرور') }}</label>
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" placeholder="ادخل كلمة المرور" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6 form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label  text-small text-uppercase" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group d-flex align-item-center justify-content-between flex-wrap">

                                <div class="mb-2">
                                    <button type="submit" class="btn btn-dark">
                                        {{ __('Login') }}
                                    </button>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link  " href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>

                                @if (Route::has('register'))
                                    <a class="btn btn-secondary mb-2 " href="{{ route('register') }}">
                                        {{ __('إنشاء حساب جديد') }}
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                </form> --}}



                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">

                        {{-- <input type="text" name="username" value="{{ old('username') }}" required autocomplete="username"
                            class="form-control form-control--sm js_email_fe rounded-pill"
                            placeholder="ادخل اسم المستخدم" />

                        @error('username')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}

                        {{-- user name or email --}}
                        <div class="form-group mb-5">
                            <label for="modalSigninEmail">
                                {{ __('transf.lbl_username_or_email') }}
                            </label>
                            <input type="text" name="email"
                                class="form-control  @if ($errors->has('email') || $errors->has('username')) has-error @endif"
                                id="modalSigninEmail" placeholder="{{ __('transf.holder_your_name_or_email') }}"
                                value="{{ old('email') }}">
                            @if ($errors->has('email') || $errors->has('username'))
                                <span class="help">{{ $errors->first('email') }}
                                    {{ $errors->first('username') }}</span>
                            @endif
                        </div>

                        <!-- <div class="invalid-feedback">لا يكون الحقل فارغ</div> -->
                    </div>

                    <div class="form-group mb-5">
                        <label for="modalSigninPassword">
                            {{ __('transf.lbl_password') }}
                        </label>
                        <input type="password" name="password" required autocomplete="current-password" class="form-control"
                            id="modalSigninPassword" placeholder="{{ __('transf.holder_stars') }}" />

                        @error('password')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="d-flex align-items-center mb-5 font-size-sm">
                        <div class="form-check">
                            <input class="form-check-input text-gray-800" type="checkbox" id="autoSizingCheck">
                            <label class="form-check-label text-gray-800" for="autoSizingCheck">
                                {{ __('transf.lbl_remember_me') }}
                            </label>
                        </div>

                    </div>

                    <!-- Submit -->
                    <button class="btn btn-block btn-primary" type="submit">
                        {{ __('transf.btn_login') }}
                    </button>

                    <div class="d-flex justify-content-between">
                        <div class="mt-3">
                            @if (Route::has('password.request'))
                                <a class="  " href="{{ route('password.request') }}">
                                    {{ __('transf.lnk_forgot_password') }}
                                </a>
                            @endif
                        </div>

                        <div class="mt-3">
                            @if (Route::has('register'))
                                <h6 class="small-body-subtitle">
                                    {{ __('transf.New user') }}
                                    <a href="{{ route('register') }}"
                                        class="dropdn-link js-dropdn-link js-dropdn-link only-icon custom-color"
                                        data-panel="#dropdnSignUp">
                                        <!-- <i class="icon-user"></i> -->
                                        <span>{{ __('transf.Create a new account') }}</span>
                                    </a>
                                </h6>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
