@extends('layouts.admin-auth')
<style>
    @media (min-width:767px) {
        .login-card {
            width: 40%;
        }
    }
</style>
@section('content')
<div class="out d-flex justify-content-center align-items-center w-100" style="height: 100vh">
    <div class="card login-card">
        <div class="card-body">

            <div class="text-center mt-4">
                <div class="mb-3">
                    <a href="{{ route('admin.index') }}" class="auth-logo">
                    </a>
                </div>
            </div>

            <h4 class="text-muted text-center font-size-18"><b>تسجيل الدخول</b></h4>

            <div class="p-3">
                <form class="form-horizontal mt-3" action="{{ route('login') }}" method="POST" class="user">
                    @csrf
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <div class="form-group">
                                {{-- <label for="email">Email Address</label> --}}
                                <input type="text" name="email" class="form-control form-control--sm js_email_fe rounded-pill @if ($errors->has('email') || $errors->has('username')) has-error @endif" placeholder="ادخل اسم المستخدم او البريد الالكتروي" value="{{ old('email') }}">
                                @if ($errors->has('email') || $errors->has('username'))
                                <span class="help">{{ $errors->first('email') }}
                                    {{ $errors->first('username') }}</span>
                                @endif
                            </div>

                        </div>
                    </div>


                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="password" name="password" required autocomplete="current-password" class="form-control form-control--sm js_email_fe rounded-pill" placeholder="ادخل كلمة المرور" />

                                @error('password')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-label ms-1" for="remember">تذكرني في المرة المقبلة</label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mb-3 text-center row mt-3 pt-1">
                        <div class="col-12">
                            <button class="btn btn-info w-100 waves-effect waves-light form-control--sm js_email_fe rounded-pill" type="submit">تسجيل الدخول</button>
                        </div>
                    </div>


                </form>
                <div class="form-group mb-0 row mt-2">
                    <div class="col-sm-7 mt-3">
                        <a href="{{ route('admin.forgot_password') }}" class="text-muted"><i class="mdi mdi-lock"></i>
                            نسيت كلمة المرور؟</a>
                    </div>
                </div>
            </div>
            <!-- end -->
        </div>
        <!-- end cardbody -->
    </div>
</div>
@endsection