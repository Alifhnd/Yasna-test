<!DOCTYPE html>
<html lang="fa">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>{{ getSetting('site_title') }}</title>

    <!-- Bootstrap css -->
    {!! Html::style(Module::asset('yasna:libs/bootstrap/css/bootstrap.min.css')) !!}
    {!! Html::style(Module::asset('yasna:libs/bootstrap/css/bootstrap.rtl.min.css')) !!}

    <!-- Fonts -->
    {!! Html::style(Module::asset('yasna:css/fontiran.css')) !!}
    {!! Html::style(Module::asset('yasna:libs/fontawesome/css/font-awesome.min.css')) !!}
    

    <!-- Custom styles -->
    {!! Html::style(Module::asset('yasna:css/login-style.min.css')) !!}
    

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- Site Wrapper -->
<div class="wrapper">
    <section class="login">
        <div class="bg-particles" id="bg-particles">

        </div>
        <h1>
            <a href="#">
                {{--<img src="public/assets/images/logo.svg" alt="logo">--}}
                {{ getSetting('site_title') }}
            </a>
        </h1>
        <div class="inner-container">
            <div class="login-box">
                <div class="login-box-container">
                    <div class="login-tabs-container">
                        <ul class="login-tabs js-tabs-control">
                            <li class="login-tabs__tab center active" data-target="login">
                                <a href="{{ v0() }}">ورود</a>
                            </li>
                            {{--<li class="login-tabs__tab" data-target="register">
                                <a href="/register">عضویت</a>
                            </li>--}}
                        </ul>
                        <div class="login-tabs-underline"></div>
                    </div>
                </div>
                <div class="login-content">
                    <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                        <!-- Email -->
                        <div class="form-input {{ $errors->has('email') ? ' has-error form-input--error' : '' }}">
                            <input type="email" class="english" id="email" name="email" value="" autocomplete="off" required>
                            <label for="email" class="form-input-label">آدرس ایمیل</label>
                            <div class="form-input-underline"></div>
                            {{--@if ($errors->has('email'))
                            <label for="email" class="form-input-massage">{{ $errors->first('email') }}</label>
                            @endif--}}
                        </div>
                        <!-- Password -->
                        <div class="form-input {{ $errors->has('email') ? ' has-error form-input--error' : '' }}">
                            <input type="password" class="english" id="password" name="password" value="" autocomplete="off" required>
                            <label for="password" class="form-input-label">رمز عبور</label>
                            <div class="form-input-underline"></div>
                            <span class="password-toggle js-toggle-visibility" data-passinput="password">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </span>
                        </div>
                        @if ($errors->has('password'))
                            <div class="form-alert text-danger">{{ $errors->first('password') }}</div>
                        @elseif($errors->has('email'))
                            <div class="form-alert text-danger">{{ $errors->first('email') }}</div>
                        @endif
                        @if (!env('APP_DEBUG'))
                            <div class="form-input">
                                {!! app('captcha')->render(getLocale()); !!}
                            </div>
                        @endif
                        <div class="form-submit">
                            <button class="btn secondary" type="submit" {{--name="submit"--}}>ورود</button>
                            <div class="checkbox remember-info">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> مرا به خاطر بسپار
                                </label>
                            </div>
                        </div>
                    </form>
                    <div class="pass-recovery">
                        <a href="{{ route('password.request') }}">رمز عبور را فراموش کرده‌اید؟</a>
                    </div>
                </div>
                {{--<div class="register-content">
                    <!-- Register form -->
                    <form action="/register">
                        <!-- Email -->
                        <div class="form-input">
                            <input type="email" class="english" id="reg-email" name="email" value="" autocomplete="off" required>
                            <label for="reg-email" class="form-input-label">آدرس ایمیل</label>
                            <div class="form-input-underline"></div>
                            <label for="reg-email" class="form-input-massage">ایمیل خود را وارد کنید.</label>
                        </div>
                        <!-- Password -->
                        <div class="form-input">
                            <input type="password" class="english" id="reg-password" name="password" value="" autocomplete="off" required>
                            <label for="reg-password" class="form-input-label">رمز عبور</label>
                            <div class="form-input-underline"></div>
                            <button class="password-toggle js-toggle-visibility" data-passinput="reg-password">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <div class="pwd-container" id="pwd-container">
                                <div class="pw-progress">
                                </div>
                                <span class="pw-verdict"></span>
                            </div>
                        </div>
                        <!-- Name -->
                        <div class="form-input">
                            <input type="text" class="" id="reg-name" name="email" value="" autocomplete="off" required>
                            <label for="reg-name" class="form-input-label">نام</label>
                            <div class="form-input-underline"></div>
                            <label for="reg-name" class="form-input-massage">نام خود را وارد کنید.</label>
                        </div>
                        <!-- Last Name -->
                        <div class="form-input">
                            <input type="text" class="" id="reg-lastname" name="email" value="" autocomplete="off" required>
                            <label for="reg-lastname" class="form-input-label">نام خانوادگی</label>
                            <div class="form-input-underline"></div>
                            <label for="reg-lastname" class="form-input-massage">نام خانوادگی خود را وارد کنید.</label>
                        </div>
                        <!-- Mobile Phone -->
                        <div class="form-input">
                            <input type="number" class="english" id="reg-mobile" name="email" value="" autocomplete="off" required>
                            <label for="reg-mobile" class="form-input-label">شماره موبایل</label>
                            <div class="form-input-underline"></div>
                            <label for="reg-mobile" class="form-input-massage">شماره موبایل خود را وارد کنید.</label>
                        </div>
                        <!-- National id card number -->
                        <div class="form-input">
                            <input type="number" class="english" id="reg-idnumber" name="email" value="" autocomplete="off" required>
                            <label for="reg-idnumber" class="form-input-label">کد ملی</label>
                            <div class="form-input-underline"></div>
                            <label for="reg-idnumber" class="form-input-massage">کد ملی خود را وارد کنید.</label>
                        </div>

                        <div class="form-alert text-danger">
                            <span>اطلاعات وارد شده نامعتبر می باشد.</span>
                        </div>
                        <div class="form-submit">
                            <button class="btn secondary" type="submit" name="submit">ثبت نام</button>
                        </div>
                    </form>
                </div>--}}
            </div>
        </div>
    </section>
</div>
<!-- !END Site Wrapper -->

<!-- End-body Scripts -->
<!-- Modernizer -->
{{--{!! Html::script(Module::asset('yasna:libs/modernizr/modernizr.custom.js')) !!}--}}

<!-- jQuery -->
{!! Html::script(Module::asset('yasna:libs/jquery/jquery.min.js')) !!}

<!-- Bootstrap js -->
{!! Html::script(Module::asset('yasna:libs/bootstrap/js/bootstrap.min.js')) !!}

<!-- pwstrength.bootstrap -->
{{--{!! Html::script(Module::asset('yasna:libs/pwstrength.bootstrap/dist/pwstrength-bootstrap.min.js')) !!}--}}


<!-- Particles.js -->
{!! Html::script(Module::asset('yasna:libs/particles/particles.min.js')) !!}
{!! Html::script(Module::asset('yasna:libs/particles/app.js')) !!}


<!-- Custom js -->
{!! Html::script(Module::asset('yasna:js/login-form.js')) !!}

<!-- !END End-body Scripts -->
</body>
</html>