<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{-- Stylesheets --}}
    @include('layouts.assets.css.fontawesome')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @include('layouts.assets.css.overlayscrollbar')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    @stack('page_css')

    <style>
        .sub-active {
            background-color: #007bff !important;
            color: #fff !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    {{-- <img src="{{ asset('image/logo.png') }}"
                         class="user-image img-circle elevation-2" alt="User Image"> --}}
                         @if(Auth::user()->user_type != null)
                            @if(Auth::user()->user_type == 1)    
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Admin)</span>
                            @else

                                @if(Auth::user()->user_type == 2)    
                                    <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Factory Head)</span>
                                @else

                                
                                    @if(Auth::user()->user_type == 3)    
                                        <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Supervisor)</span>
                                    @else

                                        @if(Auth::user()->user_type == 4)    
                                            <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Department Head)</span>
                                        @else

                                            @if(Auth::user()->user_type == 5)    
                                                <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Employee)</span>
                                            @else
                                                
                                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                                
                                            @endif
                                            

                                        @endif
                                        

                                    @endif
                                    

                                @endif
                                

                            @endif

                         @else
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                         @endif
                   
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{ asset('image/logo.png') }}"
                             class="img-circle elevation-2"
                             alt="User Image">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.5
        </div>
        <strong>Copyright &copy; 2022 Lockhood.</strong> All rights reserved.
    </footer>
</div>

{{-- Javascripts --}}
@include('layouts.assets.js.jquery')
@include('layouts.assets.js.popper')
<script src="{{ asset('js/app.js') }}"></script>
@include('layouts.assets.js.momentjs')
@include('layouts.assets.js.overlayscrollbar')
@include('components.reuse-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

@stack('page_scripts')
</body>
</html>
