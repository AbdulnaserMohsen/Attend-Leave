<!DOCTYPE html>
<html @if(app()->getLocale()=="en" )lang="en" dir="ltr" @else lang="ar" dir="rtl" @endif>
<head>
  <meta charset="utf-8">
  <title>{{ __('all.title') }}</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="{{ asset('img/'.$home->image) }}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  

  <!-- Libraries CSS Files -->
  <link href="{{ asset('lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  @if(app()->getLocale()=="en" )
  <!-- Bootstrap CSS File -->
  <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
  @else
    <!-- Bootstrap CSS File -->
    <link href="{{ asset('lib/bootstrap/css/bootstrapRTL.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate/animateRTL.min.css') }}" rel="stylesheet">
  @endif
  <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  <link href="{{ asset('css/ArabicFonts.css') }}" rel="stylesheet">
  <link href="{{ asset('css/developer.css') }}" rel="stylesheet">

  <!-- =======================================================
    Theme Name: Reveal
    Theme URL: https://bootstrapmade.com/reveal-bootstrap-corporate-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
  @yield('headerCss')
</head>

<body id="body">

  <!--==========================
    Top Bar
  ============================-->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info  float-left">
        
      </div>
      <div class="social-links float-right">
        @if(app()->getLocale()=="en" )
        <a href="{{ url('lang/ar') }}" class="twitter"><i class="fa fa-language"></i> {{ __('all.language') }} </a>
        @else
        <a href="{{ url('lang/en') }}" class="twitter"><i class="fa fa-language"></i> {{ __('all.language') }} </a>
        @endif
      </div>
    </div>
  </section>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo"  class="float-left"  >
        <!-- <h1><a href="#body" class="scrollto">Reve<span>al</span></a></h1> -->
        <!-- Uncomment below if you prefer to use an image logo -->
        @if(url()->current() == route('index'))
         <a href="#body"><img src="{{ asset('img/'.$home->image) }}" alt="" title="" /></a>
        @else
          <a href="{{ route('index') }}"><img src="{{ asset('img/'.$home->image) }}" alt="" title="" /></a>
        @endif
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li @if(url()->current() == route('index')) class="menu-active" @endif>
            @if(url()->current() == route('index'))  
              <a href="#about">{{ __('all.home') }} <i class="fa fa-home"></i></a>
            @else
              <a href="{{ route('index') }}">{{ __('all.home') }} <i class="fa fa-home"></i></a>
            @endif
          </li>

          <li>
            @if(url()->current() == route('index'))  
              <a id="link_services" href="#services">{{ __('all.services') }} <i class="fa fa-file-text-o"></i></a>
            @else
              <a  href="{{ route('index') }}#services">{{ __('all.services') }} <i class="fa fa-file-text-o"></i></a>
            @endif
          </li>
          
          @if(!Auth::check())
            @if(url()->current() == route('login') || url()->current() == route('register'))
              <li @if(url()->current() == route('login')) class="menu-active" @endif><a name="login_toggle" href="#">{{ __('all.login') }} <i class="fa fa-sign-in"></i></a></li>
            @else
              <li @if(url()->current() == route('login')) class="menu-active" @endif><a href="{{ route('login') }}">{{ __('all.login') }} <i class="fa fa-sign-in"></i></a></li>
            @endif

            @if(url()->current() == route('login') || url()->current() == route('register'))
              <li @if(url()->current() == route('register')) class="menu-active" @endif><a name="register_toggle" href="#">{{ __('all.register') }} <i class="fa fa-user-plus"></i></a></li>
            @else
              <li @if(url()->current() == route('register')) class="menu-active" @endif><a href="{{ route('register') }}">{{ __('all.register') }} <i class="fa fa-user-plus"></i></a></li>
            @endif
          @else
            <li @if(url()->current() == route('home')) class="menu-active" @endif ><a href="{{ route('home') }}">{{ __('admin.attend&leave') }} {{ __('admin.today') }} <i class="fa fa-calendar-check-o"></i></a></li>

            <li ><a href="{{ route('user_year_months_statistics',\Carbon\Carbon::now()->year) }}">{{ __('all.your_statistics') }} <i class="fa fa-bar-chart"></i></a></li>
            @if(Auth::user()->type>0)
              
              @if(url()->current() == route('index') || url()->current() == route('home') || url()->current() == route('profile') || Request::is('user_statictics/*') || Request::is('user_year_months_statistics/*') || url()->current() == route('change_password') )
                <li ><a href="{{ route('admin') }}">{{ __('all.admin') }} <i class="fa fa-cog"></i></a></li>
              @else
                <li ><a href="{{ route('index') }}">{{ __('all.user') }} <i class="fa fa-user-o"></i></a></li>
              @endif
            @endif
            
            <li class="menu-has-children"><a href=""><i class="fa fa-user"></i> 
              @if(app()->getLocale()=="en" )
                {{Auth::user()->name_en}} </a>
              @else
                {{Auth::user()->name_ar}} </a>
              @endif
              <ul>
                <li><a href="{{ route('profile') }}">{{ __('all.profile') }} <i class="fa fa-id-card-o"></i></a></li>
                <li>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('all.logout') }} 
                    <i class="fa fa-sign-out"></i>
                  </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                </li>
              </ul>
            </li>
          @endif

        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->
