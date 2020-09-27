@extends('layouts.all')

@section('headerCss')
  <!--
    This was created based on the Dribble shot by Deepak Yadav that you can find at https://goo.gl/XRALsw
    I'm @hk95 on GitHub. Feel free to message me anytime.
  -->

  <link href="https://fonts.googleapis.com/css?family=Montserrat:300, 400, 500" rel="stylesheet">

  <link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
  
@endsection


@section('content')
<section class="user">
  <div class="user_options-container">
    <div class="user_options-text">
      <div class="user_options-unregistered">
        <h2 class="user_unregistered-title">{{ __('loginRegister.not_have_ac') }}</h2>
        <p class="user_unregistered-text">{{ __('loginRegister.join_us') }} </p>
        <button name="register_toggle" class="user_unregistered-signup" id="signup-button">{{ __('all.register') }}</button>
      </div>

      <div class="user_options-registered">
        <h2 class="user_registered-title">{{ __('loginRegister.have_ac') }}</h2>
        <p class="user_registered-text">{{ __('loginRegister.go_login') }}</p>
        <button name="login_toggle" class="user_registered-login" id="login-button">{{ __('all.login') }}</button>
      </div>
    </div>
    
    @if(url()->current() == route('register'))
    <div class="user_options-forms bounceLeft" id="user_options-forms">
    @else
    <div class="user_options-forms" id="user_options-forms">
    @endif
      <div class="user_forms-login">
        <h2 class="forms_title">{{ __('all.login') }}</h2>
        <form class="forms_form" method="POST" action="{{ route('login') }}">
          @csrf
          <fieldset class="forms_fieldset">
            <div class="forms_field validate-input @error('user_name') has-invalid alert-validate @enderror" data-validate="@error('user_name'){{ $message }} @else{{ __('loginRegister.valid_user_name') }} @enderror" >
              <span><i class="fa fa-envelope"></i>  {{ __('loginRegister.user_name') }}:</span>
              <input  type="text" placeholder="{{ __('loginRegister.place_user_name') }}" class="forms_field-input" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus />
            </div>

            <div class="forms_field validate-input @error('password') has-invalid alert-validate @enderror" data-validate="@error('password'){{ $message }} @else{{ __('loginRegister.valid_password') }} @enderror">
              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password') }}:</span>
              <input type="password" placeholder="{{ __('loginRegister.password') }}" class="forms_field-input" name="password"  required />
            </div>

          </fieldset>
          <div class="forms_buttons">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('loginRegister.remember') }}
                </label>
            </div>
          </div>
          <div class="forms_buttons justify-content-end">
            <input type="submit" value="{{ __('all.login') }}" class="forms_buttons-action">
          </div>
        </form>
      </div>
      <div class="user_forms-signup">
        <h2 class="forms_title">{{ __('all.register') }}</h2>
        <form id="register_form" class="forms_form validate-form" method="POST"data-url="{{route('register')}}">
          @csrf
          <fieldset class="forms_fieldset">

            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('loginRegister.valid_name_ar') }} @enderror">
              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_ar') }}:</span>
              <input type="text" placeholder="{{ __('loginRegister.place_name_ar') }}" class="forms_field-input" name="name_ar" value="{{ old('name_ar') }}" required autocomplete="name_ar" autofocus />
            </div>
            
            <div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('loginRegister.valid_name_en') }} @enderror">
              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_en') }}:</span>
              <input type="text" placeholder="{{ __('loginRegister.place_name_en') }}" class="forms_field-input" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en" />
            </div>

            <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_job') }} @enderror" >
              <div class="select">
                <select name="slct" id="slct">
                  <option selected disabled  >{{ __('loginRegister.choose_job') }}</option>
                  @foreach($jobs as $job)
                    @if(app()->getLocale()=="ar" )
                      <option value="{{$job->id}}">{{$job->job_ar}}</option>
                    @else
                      <option value="{{$job->id}}">{{$job->job_en}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="forms_field validate-input @error('user_name_register') has-invalid alert-validate @enderror" data-validate="@error('user_name_register'){{ $message }} @else{{ __('loginRegister.valid_user_name') }} @enderror">
              <span><i class="fa fa-envelope-o"></i> {{ __('loginRegister.user_name') }}:</span>
              <input type="text" placeholder="{{ __('loginRegister.place_user_name') }}" class="forms_field-input" name="user_name_register" value="{{ old('user_name_register') }}" required autocomplete="user_name_register" />
            </div>
            
            <div class="forms_field validate-input @error('password_register') has-invalid alert-validate @enderror" data-validate="@error('password_register'){{ $message }} @else{{ __('loginRegister.valid_password') }} @enderror">
              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password') }}:</span>
              <input id="password_register" type="password" placeholder="{{ __('loginRegister.password') }}" class="forms_field-input" name="password_register" required autocomplete="password_register" />
            </div>

            <div class="forms_field validate-input @error('password_confirmation') has-invalid alert-validate @enderror" data-validate="@error('password_confirmation'){{ $message }} @else{{ __('loginRegister.valid_password_confirmation') }} @enderror">
              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password_confirmation') }}:</span>
              <input type="password" placeholder="{{ __('loginRegister.place_password_confirmation') }}" class="forms_field-input" name="password_register_confirmation"  required autocomplete="password_confirmation" />
            </div>

          </fieldset>
          <div class="forms_buttons justify-content-end">
            <input type="submit" value="{{ __('all.register') }}" class="forms_buttons-action">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('footerJs') 
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="{{ asset('js/loginRegister.js') }}"></script>

@if(isset($registered))
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    
    $(document).ready(function() 
    {
      var registered = {!! $registered !!}
      if(registered)
      {
          swal
          ({
            title: "{{ __('registered successfully') }}",
            icon: "success",
            buttons: false,
            timer: 1500,
          });      
      }


    });
  </script>
@endif

@endsection