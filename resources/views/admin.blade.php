@extends('layouts.admin_layout')
@section('admin_css')
	

@endsection

@section('main_admin')

                  <!--==========================
				      Services Section
				    ============================-->
				    <section id="services">
				      	<div class="">
					        <div class="section-header">
					          <h2>{{ __('admin.dashboard') }}</h2>
					        </div>

					        <div class="row">

					          <div class="col-lg-6">
					            <div class="box wow fadeInLeft">
					              <div class="icon"><i class="fa fa-users"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$users_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('users',Cache::get('user_paginate') )}}">{{ __('admin.users') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInRight">
					              <div class="icon">
					              	<i class="fa fa-shopping-bag"></i></i>
					              </div>
					              
					              <h4 class="title counter">
					              	<span class="js-number-counter" >{{$jobs_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('jobs',Cache::get('job_paginate'))}}">{{ __('admin.jobs') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInLeft" data-wow-delay="0.2s">
					              <div class="icon"><i class="fa fa-calendar"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter" >6</span>
					              </h4>
					              <h4 class="title"><a href="{{route('attend_leave')}}">{{ __('admin.attend&leave') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInRight" data-wow-delay="0.2s">
					              <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$today_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('day',['date'=>\Carbon\Carbon::now()->format('Y-m-d'),'paginate'=>Cache::get('attend_today_paginate') ])}}">{{ __('admin.attend&leave') }} {{ __('admin.today') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInLeft" data-wow-delay="0.2s">
					              <div class="icon"><i class="fa fa-bar-chart"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">5</span>
					              </h4>
					              <h4 class="title"><a href="{{route('year_month_statistics',\Carbon\Carbon::now()->year)}}">{{ __('admin.statistics') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          @if(Auth::user()->type == 3)
					          
					          <div class="col-lg-6">
					            <div class="box wow fadeInRight" data-wow-delay="0.2s">
					              <div class="icon"><i class="fa fa-eye"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$monitors_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('monitors',Cache::get('monitor_paginate') )}}">{{ __('admin.monitors') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>
					          
					          <div class="col-lg-6">
					            <div class="box wow fadeInLeft" data-wow-delay="0.2s">
					              <div class="icon"><i class="fa fa-cogs"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$admins_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('admins',Cache::get('admin_paginate') )}}">{{ __('admin.admins') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInRight" data-wow-delay="0.2s">
					              <div class="icon"><i class="fa fa-magic"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$super_admins_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('super_admins',Cache::get('super_admin_paginate') )}}">{{ __('admin.super_admins') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>
					          @endif


					        </div>
				      	</div>
				    </section>
				    <!-- #services -->

		
		
@endsection

@section('admin_js')
	
@endsection

