@extends('layouts.all')
@section('headerCss')
   @if(app()->getLocale()=="en" )
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   @else
      <link 
        rel="stylesheet"
        href="https://cdn.rtlcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-cSfiDrYfMj9eYCidq//oGXEkMc0vuTxHXizrMOFAaPsLt1zoCUVnSsURN+nef1lj"
        crossorigin="anonymous">
   @endif

   <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css')}}">
   @yield('admin_css')
@endsection

@section('content')

      <div class="navbar ">
         
      </div>
   
   <div id="wrapper">
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
         <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
            <li >
               <a href="#"  id="menu-toggle-2" ><span class="fa-stack fa-lg pull-left"><i class="fa fa-bars  fa-stack-1x "></i></span>{{ __('admin.hide') }} </a>
            </li>
            <li @if(url()->current() == route('admin')) class="active" @endif>
               <a href="{{ route('admin') }}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span>{{ __('admin.dashboard') }} </a>
            </li>
            
            <li>
               <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-calendar fa-stack-1x "></i></span>{{ __('admin.attend&leave') }}</a>
               <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                  <li><a href="{{route('day',['date'=>\Carbon\Carbon::now()->format('Y-m-d'),'paginate'=>Cache::get('attend_today_paginate') ])}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-calendar-check-o fa-stack-1x "></i></span>{{ __('admin.today') }}</a></li>
                  <li><a href="{{route('calendar')}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-calendar fa-stack-1x "></i></span>{{ __('admin.calendar') }}</a></li>
                  <li><a href="{{route('settings',Cache::get('user_paginate') )}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-cog fa-stack-1x "></i></span>{{ __('admin.setting') }}</a></li>
                  <li><a href="{{route('day_statuses',Cache::get('day_status_paginate') )}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-calendar-o fa-stack-1x "></i></span>{{ __('admin.day_statuses') }}</a></li>
                  <li><a href="{{route('user_statuses',Cache::get('user_status_paginate') )}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user-times fa-stack-1x "></i></span>{{ __('admin.user_statuses') }}</a></li>
               </ul>
            </li>

            <li @if(url()->current() == route('users',Cache::get('user_paginate') )) class="active" @endif>
               <a href="{{route('users',Cache::get('user_paginate') )}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-users fa-stack-1x "></i></span>{{ __('admin.users') }}</a>
            </li>
            
            <li @if(url()->current() == route('jobs',Cache::get('job_paginate') )) class="active" @endif>
               <a href="{{route('jobs',Cache::get('job_paginate') )}}"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-shopping-bag fa-stack-1x "></i></span>{{ __('admin.jobs') }}</a>
            </li>

            <li >
               <a href=""><span class="fa-stack fa-lg pull-left"><i class="fa fa-cogs fa-stack-1x "></i></span>{{ __('admin.admins') }}</a>
            </li>
            <li >
               <a href=""><span class="fa-stack fa-lg pull-left"><i class="fa fa-eye fa-stack-1x "></i></span>{{ __('admin.monitors') }}</a>
            </li>
            @if(Auth::user()->type == 3)
            <li >
               <a href=""><span class="fa-stack fa-lg pull-left"><i class="fa fa-magic fa-stack-1x "></i></span>{{ __('admin.super_admins') }}</a>
            </li>
            @endif
            <li>
               <a href="{{route('year_month_statistics',\Carbon\Carbon::now()->year)}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-bar-chart fa-stack-1x "></i></span>{{ __('admin.statistics') }}</a>
            </li>
           
         </ul>
      </div>
      <!-- /#sidebar-wrapper -->
      <!-- Page Content -->

      <div id="page-content-wrapper">
         <div class="container-fluid xyz">
            <div class="row">
               <div class="col-lg-12">

                           
                  @yield('main_admin')

               </div>
            </div>
         </div>
      </div>
      <!-- /#page-content-wrapper -->
   </div>
   <!-- /#wrapper -->
   <!-- jQuery -->

      
      
@endsection

@section('footerJs')
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   <script src="{{ asset('js/admin.js')}}"></script>
   @yield('admin_js')
  
   
@endsection

