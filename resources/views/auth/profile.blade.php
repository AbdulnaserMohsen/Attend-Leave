@extends('layouts.all')

@section('headerCss')
 

  <link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
  
@endsection


@section('content')

<section class="container" id="services">
  <div class="" id="container">
    
    <div class="" >
      
      <div class="user_forms-signup">
        <div class="section-header ">
          <h2>{{ __('all.profile') }}</h2>
        </div>
        <form id="update_form" class="forms_form validate-form" data-url="{{route('update_profile')}}" data-section="#services" data-contanier="#container" data-page="">
          @csrf
          <fieldset class="forms_fieldset">

            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('loginRegister.valid_name_ar') }} @enderror">
              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_ar') }}:</span>
              <input type="text" placeholder="{{ __('loginRegister.place_name_ar') }}" class="forms_field-input" name="name_ar" value="{{$user->name_ar}}" required autocomplete="name_ar" />
            </div>
            
            <div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('loginRegister.valid_name_en') }} @enderror">
              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_en') }}:</span>
              <input type="text" placeholder="{{ __('loginRegister.place_name_en') }}" class="forms_field-input" name="name_en" value="{{$user->name_en}}" required autocomplete="name_en" />
            </div>

            <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_job') }} @enderror" >
              <div class="select">
                <select name="slct" id="slct">
                  <option selected disabled  >{{ __('loginRegister.choose_job') }}</option>
                  @foreach($jobs as $job)
                    @if(app()->getLocale()=="ar" )
                      <option @if($user->job_id==$job->id ) selected @endif value="{{$job->id}}">{{$job->job_ar}}</option>
                    @else
                      <option @if($user->job_id==$job->id ) selected @endif value="{{$job->id}}">{{$job->job_en}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="forms_field validate-input @error('user_name_register') has-invalid alert-validate @enderror" data-validate="@error('user_name_register'){{ $message }} @else{{ __('loginRegister.valid_user_name') }} @enderror">
              <span><i class="fa fa-envelope-o"></i> {{ __('loginRegister.user_name') }}:</span>
              <input type="text" placeholder="{{ __('loginRegister.place_user_name') }}" class="forms_field-input" name="user_name" value="{{$user->user_name}}" required autocomplete="user_name" />
            </div>
            
           

          </fieldset>
           
            <div class="row">
              
              <div class="col-md-6">
                <div class="forms_buttons container justify-content-start">
                  <input type="button" value="{{ __('loginRegister.change_password') }}" class="forms_buttons-action" onclick="location.href='{{ route('change_password') }}'">
                </div>
              </div>

              <div class="col-md-6">
                <div class="forms_buttons container justify-content-end ">
                  <button class="forms_buttons-action" type="submit">
                    {{ __('admin.save') }} <i class="fa fa-check-circle" aria-hidden="true"></i>
                  </button> 
                </div>
              </div>

            </div>
            
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('footerJs')

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('js/loginRegister.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>

@endsection