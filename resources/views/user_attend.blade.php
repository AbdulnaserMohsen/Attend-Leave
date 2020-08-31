@extends('layouts.all')


@section('headerCss')
    <link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
    <link href="{{ asset('css/TimeCircles.css') }}" rel="stylesheet">
@endsection


@section('content')
  
  <main id="main">

    <section id="services">
      <div class="container">
        

        <div class="row">

          
          <div class="col-md-12">
            <div class="section-header ">
              <h2>{{ __('all.attend') }}</h2>
            </div>

            @if($user_attend_leave->attend_user_status_id != 3)
              <div class="col-md-8 offset-md-2" >
                @if(app()->getLocale()=="ar" )
                  <h2 class=" text-center" style="color:#32CD32";>{{ __('all.saved_as') }} {{$user_attend_leave->status_attend->name_ar}} <i class="fa fa-check-circle-o"></i></h2>
                @else
                  <h2 class=" text-center" style="color:#32CD32";>{{ __('all.saved_as') }} {{$user_attend_leave->status_attend->name_en}} <i class="fa fa-check-circle-o"></i></h2>
                @endif
              </div>

            @else
            <div class="col-md-8 offset-md-2" >
              @if($attend_timer > 0 )
                <h2 class="forms_title text-center">{{ __('all.attend_time') }} </h2>
                <div class="timer" data-timer="{{$attend_timer}}" ></div>
              @elseif($attend_timer < 0)
                <h2 class="forms_title text-center">{{ __('all.attend_time_finished') }}</h2>
                <p class="text-center">{{ __('all.attend_from', ['attend_from' => date('g:i A', strtotime($attend_leave_setting->attend_time_from))  , 'attend_to' => date('g:i A', strtotime($attend_leave_setting->attend_time_to)) ]) }}</p>
                @if($attend_leave_setting->enable_after_attend)
                  <p class="text-center">{{ __('all.enable_attend') }}</p>
                @endif
              @else
                <h2 class="forms_title text-center">{{ __('all.attend_time_from') }} {{date('g:i A', strtotime($attend_leave_setting->attend_time_from))}}</h2>
              @endif
              
              @if($attend_timer > 0 || ($attend_leave_setting->enable_after_attend && $attend_timer < 0))
                <form class="forms_form validate-form" id="attend_form" data-section="#main" data-contanier="#services" data-url="{{route('user_attend')}}" data-page="" >
                  @csrf
                  
                  <fieldset class="forms_fieldset  offset-md-3">
                    
                    <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('all.choose_your_status') }} @enderror" >
                      <div class="select">
                        <select name="slct">
                          <option  disabled  >{{ __('all.choose_your_status') }}</option>
                          
                          @foreach($user_statuses as $user_status)
                            @if(app()->getLocale()=="ar" )
                              <option @if($user_status->id==1 ) selected @endif  value="{{$user_status->id}}">{{$user_status->name_ar}}</option>
                            @else
                              <option @if($user_status->id==1 ) selected @endif  value="{{$user_status->id}}">{{$user_status->name_en}}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>

                  </fieldset>

                  <div class="forms_buttons offset-md-5">
                    <button class="forms_buttons-action" type="submit">
                      {{ __('admin.save') }}
                      <i class="fa fa-check-circle"></i>
                    </button>
                    
                  </div>
                </form>
                @endif
              </div>
              @endif

          </div>
          
          <div class="clearfix"></div>

          <div class="col-md-12 " id="about">
            <div class="section-header">
              <h2>{{ __('all.leave') }}</h2>
            </div>

            @if($user_attend_leave->leave_user_status_id != 3)
              <div class="col-md-8 offset-md-2" >
                @if(app()->getLocale()=="ar" )
                  <h2 class=" text-center" style="color:#32CD32";>{{ __('all.saved_as') }} {{$user_attend_leave->status_leave->name_ar}} <i class="fa fa-check-circle-o" ></i></h2>
                @else
                  <h2 class=" text-center" style="color:#32CD32";>{{ __('all.saved_as') }} {{$user_attend_leave->status_leave->name_en}} <i class="fa fa-check-circle-o"></i></h2>
                @endif
              </div>

            @else
            <div class="col-md-8 offset-md-2" >
              @if($leave_timer > 0 )
                <h2 class="forms_title text-center">{{ __('all.leave_time') }} </h2>
                <div class="timer" data-timer="{{$leave_timer}}" ></div>
              @elseif($leave_timer < 0)
                <h2 class="forms_title text-center">{{ __('all.leave_time_finished') }}</h2>
                <p class="text-center">{{ __('all.leave_from', ['leave_from' => date('g:i A', strtotime($attend_leave_setting->leave_time_from))  , 'leave_to' => date('g:i A', strtotime($attend_leave_setting->leave_time_to)) ]) }}</p>
              @else
                <h2 class="forms_title text-center">{{ __('all.leave_time_from') }} {{date('g:i A', strtotime($attend_leave_setting->leave_time_from))}} </h2>
                @if($attend_leave_setting->enable_before_leave)
                  <p class="text-center">{{ __('all.enable_leave') }}</p>
                @endif
              @endif
              @if($leave_timer > 0 || ($attend_leave_setting->enable_before_leave && $leave_timer == 0))
              <form class="forms_form validate-form" id="leave_form"  data-section="#main" data-contanier="#services" data-url="{{route('user_leave')}}" data-page="" >
                @csrf
                
                <fieldset class="forms_fieldset offset-md-3">
                  
                  <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_your_status') }} @enderror" >
                    <div class="select">
                      <select name="slct">
                        <option disabled  >{{ __('all.choose_your_status') }}</option>
                        
                        @foreach($user_statuses as $user_status)
                          @if(app()->getLocale()=="ar" )
                            <option @if($user_status->id==2 ) selected @endif  value="{{$user_status->id}}">{{$user_status->name_ar}}</option>
                          @else
                            <option @if($user_status->id==2 ) selected @endif  value="{{$user_status->id}}">{{$user_status->name_en}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>

                </fieldset>

                <div class="forms_buttons offset-md-5">
                  <button class="forms_buttons-action" type="submit">
                    {{ __('admin.save') }}
                    <i class="fa fa-check-circle"></i>
                  </button>
                  
                </div>
              </form>
              @endif
            </div>
            @endif

          </div>
        </div>
      </div>
    </section><!-- #services -->        
        
        <div class="clearfix"></div>
  </main>


@endsection


@section('footerJs')
  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="{{ asset('js/TimeCircles.js') }}"></script> 
  <script src="{{ asset('js/user_attend.js') }}"></script>

@endsection