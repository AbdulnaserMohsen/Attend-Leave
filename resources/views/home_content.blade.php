@extends('layouts.admin_layout')

@section('admin_css')
  	<link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
@endsection


@section('main_admin')


           				


		<div id="page_section">
           <div class="page-content" id="page_container">
		
				<section class="" id="add_section">
					
					<div class="" >
						<div class="section-header ">
				          <h2>{{ __('all.home') }}</h2>
				        </div>
				        <form id="update_form" class="forms_form validate-form" data-url="{{route('update_home',1)}}" data-section="#services" data-contanier="#container" data-page="">
				          @csrf
				          <fieldset class="forms_fieldset">

				            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('loginRegister.valid_name_ar') }} @enderror">
				              <span><i class="fa fa-pencil"></i> {{ __('admin.compnay_name_ar') }}:</span>
				              <input type="text" placeholder="{{ __('admin.place_compnay_name_ar') }}" class="forms_field-input bigger" name="name_ar" value="{{$home->company_name_ar}} " required autocomplete="name_ar" />
				            </div>
				            
				            <div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('loginRegister.valid_name_en') }} @enderror">
				              <span><i class="fa fa-pencil"></i> {{ __('admin.company_name_en') }}:</span>
				              <input type="text" placeholder="{{ __('admin.place_compnay_name_en') }}" class="forms_field-input bigger" name="name_en" value="{{$home->company_name_en}}" required autocomplete="name_en" />
				            </div>

				            <div class="forms_field validate-input @error('description_ar') has-invalid alert-validate @enderror" data-validate="@error('description_ar'){{ $message }} @else{{ __('admin.valid_description_ar') }} @enderror">
				              <span><i class="fa fa-pencil"></i> {{ __('admin.description_ar') }}:</span>
				              <textarea placeholder="{{ __('admin.place_description_ar') }}" class="forms_field-input bigger" name="description_ar" required autocomplete="description_ar">{{$home->description_ar}}</textarea>
				            </div>

				            <div class="forms_field validate-input @error('description_en') has-invalid alert-validate @enderror" data-validate="@error('description_en'){{ $message }} @else{{ __('admin.valid_description_en') }} @enderror">
				              <span><i class="fa fa-pencil"></i> {{ __('admin.description_en') }}:</span>
				              <textarea placeholder="{{ __('admin.place_description_en') }}" class="forms_field-input bigger" name="description_en" required autocomplete="description_en">{{$home->description_en}}</textarea>
				            </div>

				            <div class="forms_field validate-input @error('logo') has-invalid alert-validate @enderror" data-validate="@error('logo'){{ $message }} @else{{ __('admin.valid_logo') }} @enderror">
				              <span><i class="fa fa-pencil"></i> {{ __('admin.logo') }}:</span>
				              <input type="file"  class="forms_field-input bigger"  accept="image/*" name="image" id="file"  onchange="loadFile(event)" value="{{$home->image}}" >
				              <img id="output" width="200" src="{{ asset('img/'.$home->image) }}" />
				            </div>

				          </fieldset>
				           
				            <div class="row">
				            
				              
				                <div class="forms_buttons container justify-content-end ">
				                  <button class="forms_buttons-action" type="submit">
				                    {{ __('admin.save') }} <i class="fa fa-check-circle" aria-hidden="true"></i>
				                  </button> 
				                </div>
				              
				            </div>
				            
				        </form>
			    	</div>
				
				</section>

			</div>
		</div>
			            
			    
			
			    
			    

@endsection		
		

@section('admin_js')
	
	

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="{{ asset('js/loginRegister.js') }}"></script>
	
	<script>


   		var saved = "{{ __('admin.saved') }}";
   		
	</script>
	<script src="{{ asset('js/ajax.js') }}"></script>

	<script>
		var loadFile = function(event) {
		  var image = document.getElementById('output');
		  image.src = URL.createObjectURL(event.target.files[0]);
		};
	</script>


	
	
@endsection

