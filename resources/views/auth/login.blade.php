@php
    $configData = Helper::applClasses();
@endphp
@extends('admin/layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-cover">
        <div class="auth-inner row m-0">
            <!-- Left Text-->
            <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    <div>
                        {{-- Vision --}}
                        @if ($about->vision)
                            <div class="item mb-1 ">
                                <h3 class="badge rounded-pill badge-light-primary" style="font-size: 2rem;">{{ __('locale.vision') }}</h3>
                                <div id="vision" class="mx-2">
                                </div>
                            </div>
                        @endif
                        {{-- Message --}}
                        @if ($about->message)
                            <div class="item mb-1 ">
                                <h3 class="badge rounded-pill badge-light-primary" style="font-size: 2rem;">{{ __('locale.message') }}</h3>
                                <div id="message" class="mx-2">
                                </div>
                            </div>
                        @endif
                        {{-- Mission --}}
                        @if ($about->mission)
                            <div class="item mb-1 ">
                                <h3 class="badge rounded-pill badge-light-primary" style="font-size: 2rem;">{{ __('locale.mission') }}</h3>
                                <div id="mission" class="mx-2">
                                </div>
                            </div>
                        @endif
                        {{-- Objectives --}}
                        @if ($about->objectives)
                            <div class="item mb-1 ">
                                <h3 class="badge rounded-pill badge-light-primary" style="font-size: 2rem;">{{ __('locale.objectives') }}</h3>
                                <div id="objectives" class="mx-2">
                                </div>
                            </div>
                        @endif
                        {{-- Responsibilities --}}
                        @if ($about->responsibilities)
                            <div class="item mb-1 ">
                                <h3 class="badge rounded-pill badge-light-primary" style="font-size: 2rem;">{{ __('locale.responsibilities') }}</h3>
                                <div id="responsibilities" class="mx-2">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /Left Text-->

            <!-- Login-->
            <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                    <div class="text-center">
                        <img src="{{asset(getSystemSetting('APP_LOGO'))}}" class="mw-100" alt="Company logo">
                    </div>
                    <h2 class="card-title fw-bold mb-1">{{ __('locale.LoginWelcome', ['name' => getSystemSetting('APP_NAME')]) }}</h2>
                    <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-1">
                            <label class="form-label" for="login-email">{{ __('locale.Username') }}</label>
                            <input class="form-control @error('username') is-invalid @enderror" id="login-email" type="text" name="username" placeholder="Username" aria-describedby="username" autofocus="" tabindex="1"/>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">Password</label>

                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2"/>
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <div class="form-check">
                                <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3"/>
                                <label class="form-check-label" for="remember-me"> Remember Me</label>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" tabindex="4">Sign in</button>
                    </form>
                    <p class="text-center mt-2">
                    <span class="float-md-start d-block d-md-inline-block mt-25">{{ __('locale.COPYRIGHT') }} &copy;
                        <script>
                            document.write(new Date().getFullYear())

                        </script><a class="ms-25" href="{{ getSystemSetting('APP_AUTHOR_WEBSITE', 'https://www.pksaudi.com/') }}" target="_blank">
                            {{ session()->get('locale') == 'ar' ? getSystemSetting('APP_AUTHOR_ABBR_AR', 'Cyber Mode') : getSystemSetting('APP_AUTHOR_ABBR_EN', 'Cyber Mode') }}
                        </a>,
                        <span class="d-none d-sm-inline-block">{{ __('locale.All rights Reserved') }}</span>
                    </span>
                    </p>
                </div>
            </div>
            <!-- /Login-->
        </div>
    </div>
    <div id="quill-content" class="d-none"></div>

@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/pages/auth-login.js')) }}"></script>
    <script>
        const aboutData = @json($about)
            , quill = new Quill('#quill-content', {
            theme: 'bubble'
        });

        quill.setContents(JSON.parse(aboutData.vision));
        $('#vision').html(quill.root.innerHTML)

        quill.setContents(JSON.parse(aboutData.message));
        $('#message').html(quill.root.innerHTML)

        quill.setContents(JSON.parse(aboutData.mission));
        $('#mission').html(quill.root.innerHTML)

        quill.setContents(JSON.parse(aboutData.objectives));
        $('#objectives').html(quill.root.innerHTML)

        quill.setContents(JSON.parse(aboutData.responsibilities));
        $('#responsibilities').html(quill.root.innerHTML)

    </script>
    <script>
        $('form').on('submit', function () {
            $(this).find('button:submit').addClass('disabled');
        })
    </script>
@endsection
