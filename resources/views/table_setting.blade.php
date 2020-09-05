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
				          <h2>{{ __('admin.setting') }}</h2>
				        </div>
				        
				        <form class="forms_form validate-form" id="setting_form_add"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('add_setting')}}" data-page="?page={{$settings->currentPage()}}" >
				          @csrf
				          
				          <fieldset class="forms_fieldset">

				          	<div class="col-md-4 forms_field " >
				              <span> {{ __('admin.enable_attend_after') }}:</span>
					            <div class="onoffswitch">
								    <input type="checkbox" name="enable_attend" class="onoffswitch-checkbox" id="myonoffswitch_attend" tabindex="0" >
								    <label class="onoffswitch-label" for="myonoffswitch_attend">
								        <span class="onoffswitch-inner" data-on="{{ __('admin.enable') }}" data-off="{{ __('admin.disable') }}" ></span>
								        <span class="onoffswitch-switch"></span>
								    </label>
								</div>
				            </div>

				            <div class="col-md-4 forms_field" dir="ltr">
				            	<span> {{ __('admin.attend_from') }}:</span>
				            	<div class="input-group ">
						      		<input type="time" name="attend_from" class="form-control time forms_field-input more-bigger" value="06:00">
						    	</div>
				            </div>

				            <div class="col-md-4 forms_field" dir="ltr">
				            	<span> {{ __('admin.attend_to') }}:</span>
				            	<div class="input-group ">
						      		<input type="time" name="attend_to" class="form-control time forms_field-input more-bigger" value="09:00">
						    	</div>
				            </div>

				            <div class="clearfix"></div>

				            <div class="col-md-4 forms_field " >
				              <span> {{ __('admin.enable_leave_before') }}:</span>
					            <div class="onoffswitch">
								    <input type="checkbox" name="enable_leave" class="onoffswitch-checkbox" id="myonoffswitch_leave" tabindex="0" >
								    <label class="onoffswitch-label" for="myonoffswitch_leave">
								        <span class="onoffswitch-inner" data-on="{{ __('admin.enable') }}" data-off="{{ __('admin.disable') }}" ></span>
								        <span class="onoffswitch-switch"></span>
								    </label>
								</div>
							</div>
				            

				            <div class="col-md-4 forms_field "  dir="ltr">
				            	<span> {{ __('admin.leave_from') }}:</span>
				            	<div class="input-group ">
						      		<input type="time" name="leave_from" class="form-control time forms_field-input more-bigger " value="12:30">
						    	</div>
				            </div>

				            <div class="col-md-4 forms_field " dir="ltr">
				           		<span> {{ __('admin.leave_to') }}:</span>
				            	<div class="input-group ">
						      		<input type="time" name="leave_to" class="form-control time forms_field-input more-bigger" value="16:00">
						    	</div>
				            </div>

				          </fieldset>

				          <div class="forms_buttons pull-right">
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
		        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url='{{ route("settings", ":length") }}'>
		        					<option @if($settings->perPage() == 10) selected disabled @endif value="10">10</option>
		        					<option @if($settings->perPage() == 25) selected disabled @endif value="25">25</option>
		        					<option @if($settings->perPage() == 50) selected disabled @endif value="50">50</option>
		        					<option @if($settings->perPage() == 100) selected disabled @endif value="100">100</option>
		        					@if(!in_array($settings->perPage(),[10,25,50,100]) )
		        					<option selected disabled value="{{$settings->perPage()}}">{{$settings->perPage()}}</option>
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
			                   <th>{{ __('admin.attend_from') }}</th>
			                   <th>{{ __('admin.attend_to') }}</th>
			                   <th>{{ __('admin.enable_attend_after') }}</th>
			                   <th>{{ __('admin.leave_from') }}</th>
			                   <th>{{ __('admin.leave_to') }}</th>
			                   <th>{{ __('admin.enable_leave_before') }}</th>
			                   <th>{{ __('admin.date') }}</th>
			                   <th>{{ __('admin.delete') }}</th>
			                
			                </thead>
							    
						    <tbody>
						    	@foreach($settings as $setting)
							    <tr class="content-center">
								    <td><input type="checkbox" class="checkthis" data-id="{{$setting->id}}" /></td>
								    <td>{{$loop->iteration+(($settings->currentPage()-1)*$settings->perPage())}} </td>
								    <td>{{$setting->attend_time_from}}</td>
								    <td>{{$setting->attend_time_to}}</td>
								    <td>
								    	<div class="onoffswitch">
										    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch_attend{{$loop->iteration}}" tabindex="0" data-section="#page_section" data-contanier="#page_container"data-page="?page={{$settings->currentPage()}}" 
										    @if($setting->enable_after_attend == 1) 
										    	data-url="{{route('disable_attend',$setting->id)}}" 
										    	checked
										    @else
										    	data-url="{{route('enable_attend',$setting->id)}}"
										    @endif>
										    <label class="onoffswitch-label" for="myonoffswitch_attend{{$loop->iteration}}">
										        <span class="onoffswitch-inner" data-on="{{ __('admin.enable') }}" data-off="{{ __('admin.disable') }}" ></span>
										        <span class="onoffswitch-switch"></span>
										    </label>
										</div>
								    </td>

								    <td>{{$setting->leave_time_from}}</td>
								    <td>{{$setting->leave_time_to}}</td>
								    <td>
								    	<div class="onoffswitch">
										    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch_leave{{$loop->iteration}}" tabindex="0" data-section="#page_section" data-contanier="#page_container"data-page="?page={{$settings->currentPage()}}" 
										    @if($setting->enable_before_leave == 1) 
										    	data-url="{{route('disable_leave',$setting->id)}}" 
										    	checked
										    @else
										    	data-url="{{route('enable_leave',$setting->id)}}"
										    @endif>
										    <label class="onoffswitch-label" for="myonoffswitch_leave{{$loop->iteration}}">
										        <span class="onoffswitch-inner" data-on="{{ __('admin.enable') }}" data-off="{{ __('admin.disable') }}" ></span>
										        <span class="onoffswitch-switch"></span>
										    </label>
										</div>
								    </td>
								    <td>{{$setting->created_at}}</td>
								    @php($page=$settings->currentPage())
									@if($settings->count()==1)
										@if($settings->currentPage() != 1)
											@php($page =$settings->currentPage()-1)
										@endif
									@endif
								    <td>
								    	<button class="btn btn-danger btn-xs" name="delete" data-section="#page_section" data-contanier="#page_container" data-url="{{route('delete_setting',$setting->id)}}" data-page="?page={{$page}}"><span class="glyphicon glyphicon-trash"></span> {{ __('admin.delete') }}</button>
								    </td>
								</tr>
								@endforeach
							        
							</tbody>
					        
						</table>

						<div class="col-md-12 container">
							<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#page_section" data-contanier="#page_container"> 
								{{ $settings->links() }} 
							</div>

							<div class="col-md-2 ">
								<button class="btn btn-danger btn-xs" id="delete_all" data-section="#page_section" data-contanier="#page_container"  data-page="?page={{$page}}" data-url="{{route('delete_all_settings',':ids')}}" data-count="{{$settings->count()}}">
									<span class="glyphicon glyphicon-trash"></span>
									{{ __('admin.delete_all') }}
								</button>
							</div>
						</div>
						
						
					</div>

					
					<div class="clearfix"></div>
					
			                
			    </div>


			</div>
		</div>
			            
			    
			
			    
			    

@endsection		
		

@section('admin_js')
	
	

	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="{{ asset('js/loginRegister.js') }}"></script>
	
  	<script src="{{ asset('js/jquery-clock-timepicker.js') }}"></script>
  	<script src="{{ asset('js/time1.js') }}"></script>

        

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

