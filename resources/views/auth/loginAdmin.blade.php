<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8" />
        <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

        <!-- Site favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendors/images/favicon-32x32.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendors/images/favicon-16x16.png') }}" />

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}" />

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258" crossorigin="anonymous"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());

            gtag("config", "G-GBZ3SGGX85");
        </script>
        <!-- Google Tag Manager -->
        <script>
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != "dataLayer" ? "&l=" + l : "";
                j.async = true;
                j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
        </script>
        <!-- End Google Tag Manager -->
        <style>
            .logo-container {
                display: flex;
                align-items: center;
            }

            .light-logo {
                margin-right: 10px;
                height: 50px;
                width: 50px;
            }

            .agency-text {
                font-size: 16px;
                font-weight: bold;
                color: #ffffff;
            }
        </style>
    </head>
    <body class="login-page">
        <div class="login-header box-shadow">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="logo-container">
                    <img src="{{ asset('vendors/images/photos1.png') }}" alt="Logo" class="light-logo" />
                    <span class="agency-text">Agence Immobilière</span>
                </div>
                <div class="login-menu">
                    <ul>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-7">
                        <img src="{{ asset('vendors/images/register-page-img.png') }}" alt="" />
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="login-box bg-white box-shadow border-radius-10">
                            @if (Session::has('error'))
                                <div class="alert alert-danger mt-1">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success mt-1">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="login-title">
                                <h2 class="text-center text-primary">Login To Administrator</h2>
                            </div>
                            <form action="{{ route('admin.login') }}" method="POST">
                                @csrf
                                <div class="select-role">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn active">
                                            <input type="radio" name="options" id="admin" />
                                            <div class="icon">
                                                <img src="{{ asset('vendors/images/banner-img.png') }}" class="svg" alt="" />
                                            </div>
                                            <span>I'm</span>
                                            Manager
                                        </label>
                                        <label class="btn">
                                            <input type="radio" name="options" id="user" />
                                            <div class="icon">
                                                <img src="{{ asset('vendors/images/chat-img2.jpg') }}" class="svg" alt="" />
                                            </div>
                                            <span>I'm</span>
                                            Employee
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group custom">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="admin@gmail.com" value="admin@gmail.com" />
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                    </div>
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger mt-1">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="input-group custom">
                                    <input type="password" name="pwd" class="form-control form-control-lg" placeholder="admin123" value="admin123"/>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                    </div>
                                    @if ($errors->has('pwd'))
                                        <div class="alert alert-danger mt-1">
                                            {{ $errors->first('pwd') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="row pb-30">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                            <label class="custom-control-label" for="customCheck1">Remember</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="forgot-password">
                                            <a href="forgot-password.html">Forgot Password</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-0">
                                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Login">
                                        </div>
                                        <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                                            OR
                                        </div>
                                        <div class="input-group mb-0">
                                            <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('register') }}">Register To Create Account</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- welcome modal start -->
        {{-- <div class="welcome-modal">
            <button class="welcome-modal-close">
                <i class="bi bi-x-lg"></i>
            </button>
            <iframe
                class="w-100 border-0"
                src="https://embed.lottiefiles.com/animation/31548"
            ></iframe>
            <div class="text-center">
                <h3 class="h5 weight-500 text-center mb-2">
                    Open source
                    <span role="img" aria-label="gratitude">❤️</span>
                </h3>
                <div class="pb-2">
                    <a
                        class="github-button"
                        href="https://github.com/dropways/deskapp"
                        data-color-scheme="no-preference: dark; light: light; dark: light;"
                        data-icon="octicon-star"
                        data-size="large"
                        data-show-count="true"
                        aria-label="Star dropways/deskapp dashboard on GitHub"
                    >Star</a>
                </div>
                <a
                    class="btn btn-outline-primary btn-sm"
                    href="https://github.com/dropways/deskapp"
                    role="button"
                >View Source</a>
            </div>
        </div> --}}
        <!-- welcome modal end -->
        <!-- js -->
        <script src="{{ asset('vendors/scripts/core.js') }}"></script>
        <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
        <script src="{{ asset('vendors/scripts/process.js') }}"></script>
        <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
    </body>
</html>
