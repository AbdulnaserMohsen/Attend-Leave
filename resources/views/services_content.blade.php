@extends('layouts.admin_layout')

@section('admin_css')
  	<link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
@endsection


@section('main_admin')


           				


		<div id="page_section">
           <div class="page-content" id="page_container">
           	
				<section class="" id="add_section">
					
					<div class="" >
						<div class="section-header">
				          <h2>{{ __('all.services') }}</h2>
				        </div>

				        <form class="forms_form validate-form" id="service_form_add"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('add_service')}}" data-page="?page=@if($services->isNotEmpty()){{$services->currentPage()}} @endif" >
				          @csrf
				          
				          <fieldset class="forms_fieldset">
				            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('admin.valid_name_ar') }} @enderror" >
				              <span> {{ __('admin.service_ar') }}:</span>
				              <input  type="text" placeholder="{{ __('admin.place_name_ar') }}" class="forms_field-input bigger" name="name_ar" value="{{ old('name_ar') }}" required autocomplete="name_ar" />
				            </div>

							<div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('admin.valid_name_en') }} @enderror" >
				              <span> {{ __('admin.service_en') }}:</span>
				              <input  type="text" placeholder="{{ __('admin.place_name_en') }}" class="forms_field-input bigger" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en" />
				            </div>

				            <div class="forms_field validate-input @error('description_ar') has-invalid alert-validate @enderror" data-validate="@error('description_ar'){{ $message }} @else{{ __('admin.valid_description_ar') }} @enderror">
				              <span><i class="fa fa-pencil"></i> {{ __('admin.description_ar') }}:</span>
				              <textarea placeholder="{{ __('admin.place_description_ar') }}" class="forms_field-input bigger" name="description_ar" required autocomplete="description_ar"></textarea>
				            </div>

				            <div class="forms_field validate-input @error('description_en') has-invalid alert-validate @enderror" data-validate="@error('description_en'){{ $message }} @else{{ __('admin.valid_description_en') }} @enderror">
				              <span><i class="fa fa-pencil"></i> {{ __('admin.description_en') }}:</span>
				              <textarea placeholder="{{ __('admin.place_description_en') }}" class="forms_field-input bigger" name="description_en" required autocomplete="description_en"></textarea>
				            </div>

				            <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_icon') }} @enderror" >
				              <div class="select">
				              	<style>
									select{
										font-family: fontAwesome
									}
								</style>
				                <select name="slct">
				                  <option selected disabled  >{{ __('loginRegister.choose_icon') }}</option>
				                  
				                  @foreach($fonts_list as $font )
				                    @php($val =str_replace('"', '', $font['val']))
				                    <option value="<i class='fa {{$font['fa']}}'></i>">{!!  $val !!}  {{$font['fa']}}</option>
				                    
				                  @endforeach
				                </select>
				              </div>
				            </div>

				          </fieldset>
				          <div class="forms_buttons justify-content-end">
				          	<button class="forms_buttons-action" type="submit">
				          		{{ __('admin.add') }}
				          		<i class="fa fa-plus-circle"></i>
				          	</button>
				            
				          </div>
				        </form>
			    	</div>
				
				</section>
	
				
		        <div class="table-responsive" id="table_section">

		        	<div id="mytable_wrapper" class="dataTables_wrapper no-footer">
		        		<div class="dataTables_length" >
		        			<label>{{ __('admin.lenght') }}
		        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url='{{ route("services", ":length") }}'>
		        					@if($services->isNotEmpty())
			        					<option @if($services->perPage() == 10) selected disabled @endif value="10">10</option>
			        					<option @if($services->perPage() == 25) selected disabled @endif value="25">25</option>
			        					<option @if($services->perPage() == 50) selected disabled @endif value="50">50</option>
			        					<option @if($services->perPage() == 100) selected disabled @endif value="100">100</option>
			        					@if(!in_array($services->perPage(),[10,25,50,100]) )
			        					<option selected disabled value="{{$services->perPage()}}">{{$services->perPage()}}</option>
			        					@endif
			        				@endif
		        				</select>
		        			</label>
		        		</div>

		        		<div  class="dataTables_filter">
		        			<label> {{ __('admin.search') }}
		        				<input id="mytable_filter" type="search" class="" placeholder="" aria-controls="mytable">
		        			</label>
		        		</div>

		                
			            <table id="mytable" class="table table-bordred table-striped" >
			                  
			                <thead>
			                   
			                   <th><input type="checkbox" id="checkall" /></th>
			                   <th>#</th>
			                   <th>{{ __('admin.service_ar') }}</th>
			                   <th>{{ __('admin.service_en') }}</th>
			                   <th>{{ __('admin.description_ar') }}</th>
			                   <th>{{ __('admin.description_en') }}</th>
			                   <th>{{ __('admin.icon') }}</th>
			                   <th>{{ __('admin.edit') }}</th>
			                   <th>{{ __('admin.delete') }}</th>
			                
			                </thead>
							    
						    <tbody>
						    	@if($services->isNotEmpty())
						    	@foreach($services as $service)
							    <tr class="content-center">
								    <td><input type="checkbox" class="checkthis" data-id="{{$service->id}}" /></td>
								    <td>{{$loop->iteration+(($services->currentPage()-1)*$services->perPage())}} </td>
								    <td>{{$service->service_title_ar}}</td>
								    <td>{{$service->service_title_en}}</td>
								    <td>{{$service->service_description_ar}}</td>
								    <td>{{$service->service_description_en}}</td>
								    <td>{!! $service->font !!}</td>
								    <td>
								    	<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit_{{$loop->iteration}}" ><span class="glyphicon glyphicon-pencil"></span> {{ __('admin.edit') }}</button>
								    </td>
								    @php($page=$services->currentPage())
									@if($services->count()==1)
										@if($services->currentPage() != 1)
											@php($page =$services->currentPage()-1)
										@endif
									@endif
								    <td>
								    	<button class="btn btn-danger btn-xs" name="delete" data-section="#page_section" data-contanier="#page_container" data-url="{{route('delete_service' ,['id'=>$service->id,'model'=>'Services'])}}" data-page="?page={{$page}}"><span class="glyphicon glyphicon-trash"></span> {{ __('admin.delete') }}</button>
								    </td>
								</tr>
								@endforeach
								@endif
							        
							</tbody>
					        
						</table>

						<div class="col-md-12 container">
							<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#page_section" data-contanier="#page_container"> 
								@if($services->isNotEmpty()) {{ $services->links() }} @endif 
							</div>

							<div class="col-md-2 ">
								<button class="btn btn-danger btn-xs" id="delete_all" data-section="#page_section" data-contanier="#page_container"  data-page="?page=@if($services->isNotEmpty()){{$services->currentPage()}} @endif" data-url="{{route('delete_all_services',':ids')}}" data-count="{{$services->count()}}">
									<span class="glyphicon glyphicon-trash"></span>
									{{ __('admin.delete_all') }}
								</button>
							</div>
						</div>
						
						
					</div>

					
					<div class="clearfix"></div>
					
			                
			    </div>

			    @if($services->isNotEmpty())
			    @foreach($services as $service)
				<div class="modal" id="edit_{{$loop->iteration}}"   >
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove" ></span></button>
					      	</div>
					      	
						    <form class="forms_form validate-form" id="service_form_update_{{$loop->iteration}}"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('update_service',$service->id)}}" data-page="?page=@if($services->isNotEmpty()){{$services->currentPage()}} @endif">
						    @csrf
					      		<div class="modal-body">
					      	   
						          <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.service') }}</h2>
						          <fieldset class="forms_fieldset">
						             <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('admin.valid_name_ar') }} @enderror" >
						              <span> {{ __('admin.service_ar') }}:</span>
						              <input  type="text" placeholder="{{ __('admin.place_name_ar') }}" class="forms_field-input bigger" name="name_ar" value="{{$service->service_title_ar}}" required autocomplete="name_ar" />
						            </div>

									<div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('admin.valid_name_en') }} @enderror" >
						              <span> {{ __('admin.service_en') }}:</span>
						              <input  type="text" placeholder="{{ __('admin.place_name_en') }}" class="forms_field-input bigger" name="name_en" value="{{$service->service_title_en}}" required autocomplete="name_en" />
						            </div>

						            <div class="forms_field validate-input @error('description_ar') has-invalid alert-validate @enderror" data-validate="@error('description_ar'){{ $message }} @else{{ __('admin.valid_description_ar') }} @enderror">
						              <span><i class="fa fa-pencil"></i> {{ __('admin.description_ar') }}:</span>
						              <textarea placeholder="{{ __('admin.place_description_ar') }}" class="forms_field-input bigger" name="description_ar" required autocomplete="description_ar">{{$service->service_description_ar}}</textarea>
						            </div>

						            <div class="forms_field validate-input @error('description_en') has-invalid alert-validate @enderror" data-validate="@error('description_en'){{ $message }} @else{{ __('admin.valid_description_en') }} @enderror">
						              <span><i class="fa fa-pencil"></i> {{ __('admin.description_en') }}:</span>
						              <textarea placeholder="{{ __('admin.place_description_en') }}" class="forms_field-input bigger" name="description_en" required autocomplete="description_en">{{$service->service_description_en}}</textarea>
						            </div>

						            <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_icon') }} @enderror" >
						              <div class="select">
						              	<style>
											select{
												font-family: fontAwesome
											}
										</style>
						                <select name="slct">
						                  <option  disabled  >{{ __('loginRegister.choose_icon') }}</option>
						                  
						                  @foreach($fonts_list as $font )
						                    @php($val =str_replace('"', '', $font['val']))
						                    @php($fa = $font['fa'])
						                    @php($faii = "<i class='fa ".$fa."'></i>")
						                    <option @if($service->font == $faii) selected @endif  value="{{$faii}}">{!! $val !!}  {{$fa}}</option>
						                    
						                  @endforeach
						                </select>
						              </div>
						            </div>

						          </fieldset>
						        
				      			</div>
				          
					          	<div class="modal-footer ">
					        		<button type="submit" class="forms_buttons-action bigger"  style="width: 100%;" >{{ __('admin.update') }} <i class="fa fa-check-circle"></i></button>
					      		</div>
				      		</form>
				        </div>
				    	<!-- /.modal-content --> 
				  	</div>
				    <!-- /.modal-dialog --> 
				</div>
				@endforeach
				@endif


			</div>
		</div>
			            
			    
			
			    
			    

@endsection		
		

@section('admin_js')
	
	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="{{ asset('js/loginRegister.js') }}"></script>
	
	<script>


   		var updated = "{{ __('admin.updated') }}";
   		var added = "{{ __('admin.added') }}";
   		var select_first = "{{ __('admin.select_first') }}";
   		var delete_question_all = "{{ __('admin.delete_question_all') }}";
   		var delete_hint = "{{ __('admin.delete_hint') }}";
   		var delete_cancel = "{{ __('admin.delete_cancel') }}";
   		var delete_ok = "{{ __('admin.delete_ok') }}";
   		var deleted = "{{ __('admin.deleted') }}";
   		var error_not_deleted = "{{ __('admin.error_not_deleted') }}";
   		var error = "{{ __('admin.error') }}";
   		var call_it = "{{ __('admin.call_it') }}";
   		var data_safed = "{{ __('admin.data_safed') }}";
   		var delete_question = "{{ __('admin.delete_question') }}";
   		var not_authorized_delete = "{{ __('admin.not_authorized_delete') }}";
   		var not_authorized_update = "{{ __('admin.not_authorized_update') }}";
   		
	</script>
	<script src="{{ asset('js/table.js') }}"></script>


	
	
@endsection

