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
					              <div class="icon"><i class="fa fa-calendar"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter" >{{$attend_leave_history_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('calendar')}}">{{ __('admin.calendar') }}
					              </a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInLeft">
					              <div class="icon"><i class="fa fa-cog"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$setting_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('settings',Cache::get('setting_paginate') )}}">{{ __('admin.setting') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInRight">
					              <div class="icon"><i class="fa fa-calendar-times-o"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$day_status_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('day_statuses',Cache::get('day_status_paginate') )}}">{{ __('admin.day_statuses') }} {{ __('admin.work_vacation') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInRight">
					              <div class="icon"><i class="fa fa-user-times"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">{{$user_status_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('user_statuses',Cache::get('user_status_paginate') )}}">{{ __('admin.user_statuses') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>
       
					        </div>
				      	</div>
				    </section>
				    <!-- #services -->

		
		
@endsection

@section('admin_js')
	
@endsection

