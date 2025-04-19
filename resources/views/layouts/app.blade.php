<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('vendor/cloud-sass/assets/images/favicon.png') }}">
    <!-- Page Title  -->
    <title>@yield('title', 'Laravel')</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('vendor/cloud-sass/assets/css/dashlite.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('vendor/cloud-sass/assets/css/theme.css') }}">

    @laravelViewsStyles

    @stack('styles')

</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">

            @include('cloud-sass::partials.sidebar')

            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon"
                                    data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="{{ asset('vendor/cloud-sass/assets/images/logo.png') }}"
                                        srcset="{{ asset('vendor/cloud-sass/assets/images/logo2x.png') }} 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="{{ asset('vendor/cloud-sass/assets/images/logo-dark.png') }}"
                                        srcset="{{ asset('vendor/cloud-sass/assets/images/logo-dark2x.png') }} 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-news d-none d-xl-block">
                                <div class="nk-news-list">
                                    <a class="nk-news-item" href="#">
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-card-view"></em>
                                        </div>
                                        <div class="nk-news-text">
                                            <p>Latest News Hear <span> for Details</span></p>
                                            <em class="icon ni ni-external"></em>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- .nk-header-news -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-name dropdown-indicator">{{ Auth::user()->name }}</div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <span><img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="avatar"></span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text">{{  Auth::user()->name }}</span>
                                                        <span class="sub-text">{{  Auth::user()->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="#" id="logout_button"><em
                                                                class="icon ni ni-signout"></em><span>Sign
                                                                out</span></a></li>
                                                        <form method="POST" action="{{ route('logout') }}" id="logout_form">
                                                            @csrf
                                                        </form>
                                                </ul>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->
                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->

                @yield('content')

                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; {{ date('Y') }} Hansoft Tchnologies
                            </div>
                            <div class="nk-footer-links">
                                <ul class="nav nav-sm">
                                    <li class="nav-item">
                                        <a href="https://hansofttechnologies.com" class="nav-link">
                                            <span class="ms-1">Hansoft Technologies Private Ltd</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->

    <!-- JavaScript -->
    @laravelViewsScripts

    <script src="{{ asset('vendor/cloud-sass/assets/js/bundle.js') }}"></script>
    <script src="{{ asset('vendor/cloud-sass/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('vendor/cloud-sass/assets/js/charts/gd-default.js') }}"></script>
    <script src="{{ asset('vendor/cloud-sass/assets/js/custom.js') }}"></script>

    <script>
        $('#logout_button').on('click', function (e) {
            e.preventDefault();
            $('#logout_form').trigger('submit');
        })
    </script>

    @yield('scripts')

    @stack('scripts')

</body>

</html>
