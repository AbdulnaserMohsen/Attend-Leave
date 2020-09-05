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
					          <h2>{{ __('admin.content') }}</h2>
					        </div>

					        <div class="row">

					          <div class="col-lg-6">
					            <div class="box wow fadeInLeft">
					              <div class="icon"><i class="fa fa-home"></i></div>
					              <h4 class="title counter">
					              	<span class="js-number-counter">1</span>
					              </h4>
					              <h4 class="title"><a href="{{route('home_content')}}">{{ __('all.home') }}</a></h4>
					              <p class="description"></p>
					            </div>
					          </div>

					          <div class="col-lg-6">
					            <div class="box wow fadeInRight">
					              <div class="icon">
					              	<i class="fa fa-file-text-o"></i></i>
					              </div>
					              
					              <h4 class="title counter">
					              	<span class="js-number-counter" >{{$service_count}}</span>
					              </h4>
					              <h4 class="title"><a href="{{route('services',Cache::get('services_paginate') )}}">{{ __('all.services') }}</a></h4>
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

