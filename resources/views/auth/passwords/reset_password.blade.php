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

<div class="container">
  <div class="page-content" >
    <div class="clearfix"></div> 
    <section class="" >
          
      <div class="" >
        <div class="section-header ">
          <h2>{{ __('loginRegister.change_password') }}</h2>
        </div>
        <form class="forms_form validate-form" method="post" action="{{route('update_password')}}">
        @csrf
                
          <fieldset class="forms_fieldset">
            
            <div class="forms_field validate-input @error('current_password') has-invalid alert-validate @enderror" data-validate="@error('current_password'){{ $message }} @else{{ __('loginRegister.valid_current_password') }} @enderror">
              <span><i class="fa fa-lock"></i> {{ __('loginRegister.current_password') }}:</span>
              <input type="password" placeholder="{{ __('loginRegister.current_password') }}" class="forms_field-input bigger" name="current_password" required />
            </div>
      
                  
            <div class="forms_field validate-input @error('new_password') has-invalid alert-validate @enderror" data-validate="@error('new_password'){{ $message }} @else{{ __('loginRegister.valid_password') }} @enderror">
              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password') }}:</span>
              <input type="password" placeholder="{{ __('loginRegister.password') }}" class="forms_field-input bigger" name="new_password" required />
            </div>

            <div class="forms_field validate-input @error('new_password_confirmation') has-invalid alert-validate @enderror" data-validate="@error('new_password_confirmation'){{ $message }} @else{{ __('loginRegister.valid_password_confirmation') }} @enderror">
              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password_confirmation') }}:</span>
              <input type="password" placeholder="{{ __('loginRegister.place_password_confirmation') }}" class="forms_field-input bigger" name="new_password_confirmation"  required />
            </div>

          </fieldset>

          <div class="forms_buttons justify-content-end">
            <button class="forms_buttons-action" type="submit">
              {{ __('admin.update') }}
              <i class="fa fa-check-circle"></i>
            </button>
          </div>

        </form>
      </div>
    </section>
    
    <div class="clearfix "></div>          
  </div>
</div>


@endsection

@section('footerJs') 
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="{{ asset('js/loginRegister.js') }}"></script>

@endsection