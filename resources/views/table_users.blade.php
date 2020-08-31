@extends('layouts.admin_layout')

@section('admin_css')
  	<link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
@endsection


@section('main_admin')


           				


		<div id="page_section">
           <div class="page-content" id="page_container">
		
				<section class="" id="add_section">
					
					<div class="" >
				        <h2 class="forms_title">{{ __('admin.users') }}</h2>
				        <form class="forms_form validate-form" id="user_form_add"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('register')}}" data-page="?page={{$users->currentPage()}}" >
				          @csrf
				          
				          <fieldset class="forms_fieldset">
				            
				            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('loginRegister.valid_name_ar') }} @enderror">
				              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_ar') }}:</span>
				              <input type="text" placeholder="{{ __('loginRegister.place_name_ar') }}" class="forms_field-input bigger" name="name_ar" value="{{ old('name_ar') }}" required autocomplete="name_ar" autofocus />
				            </div>
				            
				            <div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('loginRegister.valid_name_en') }} @enderror">
				              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_en') }}:</span>
				              <input type="text" placeholder="{{ __('loginRegister.place_name_en') }}" class="forms_field-input bigger" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en" />
				            </div>

				            <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_job') }} @enderror" >
				              <div class="select">
				                <select name="slct">
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
				              <input type="text" placeholder="{{ __('loginRegister.place_user_name') }}" class="forms_field-input bigger" name="user_name_register" value="{{ old('user_name_register') }}" required autocomplete="user_name_register" />
				            </div>
				            
				            <div class="forms_field validate-input @error('password_register') has-invalid alert-validate @enderror" data-validate="@error('password_register'){{ $message }} @else{{ __('loginRegister.valid_password') }} @enderror">
				              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password') }}:</span>
				              <input type="password" placeholder="{{ __('loginRegister.password') }}" class="forms_field-input bigger" name="password_register" required autocomplete="password_register" />
				            </div>

				            <div class="forms_field validate-input @error('password_confirmation') has-invalid alert-validate @enderror" data-validate="@error('password_confirmation'){{ $message }} @else{{ __('loginRegister.valid_password_confirmation') }} @enderror">
				              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password_confirmation') }}:</span>
				              <input type="password" placeholder="{{ __('loginRegister.place_password_confirmation') }}" class="forms_field-input bigger" name="password_register_confirmation"  required autocomplete="password_confirmation" />
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
		        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url='{{ route("users", ":length") }}'>
		        					<option @if($users->perPage() == 10) selected disabled @endif value="10">10</option>
		        					<option @if($users->perPage() == 25) selected disabled @endif value="25">25</option>
		        					<option @if($users->perPage() == 50) selected disabled @endif value="50">50</option>
		        					<option @if($users->perPage() == 100) selected disabled @endif value="100">100</option>
		        					@if(!in_array($users->perPage(),[10,25,50,100]) )
		        					<option selected disabled value="{{$users->perPage()}}">{{$users->perPage()}}</option>
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
			                   <th>{{ __('loginRegister.name_ar') }}</th>
			                   <th>{{ __('loginRegister.name_en') }}</th>
			                   <th>{{ __('admin.job') }}</th>
			                   <th>{{ __('loginRegister.user_name') }}</th>
			                   <th>{{ __('admin.edit') }}</th>
			                   <th>{{ __('admin.delete') }}</th>
			                   <th>{{ __('admin.acc_status') }}</th>
			                
			                </thead>
							    
						    <tbody>
						    	@foreach($users as $user)
							    <tr class="content-center">
								    <td><input type="checkbox" class="checkthis" data-id="{{$user->id}}" /></td>
								    <td>{{$loop->iteration+(($users->currentPage()-1)*$users->perPage())}} </td>
								    <td>{{$user->name_ar}}</td>
								    <td>{{$user->name_en}}</td>
								    @if(app()->getLocale()=="ar" )
								    	<td>{{$user->job->job_ar}}</td>
								    @else
								    	<td>{{$user->job->job_en}}</td>
								    @endif
								    <td>{{$user->user_name}}</td>
								    <td>
								    	<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit_{{$loop->iteration}}" ><span class="glyphicon glyphicon-pencil"></span> {{ __('admin.edit') }}</button>
								    </td>
								    @php($page=$users->currentPage())
									@if($users->count()==1)
										@if($users->currentPage() != 1)
											@php($page =$users->currentPage()-1)
										@endif
									@endif
								    <td>
								    	<button class="btn btn-danger btn-xs" name="delete" data-section="#page_section" data-contanier="#page_container" data-url="{{route('delete_user',$user->id)}}" data-page="?page={{$page}}"><span class="glyphicon glyphicon-trash"></span> {{ __('admin.delete') }}</button>
								    </td>
								    <td>
								    	<div class="onoffswitch">
										    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch{{$loop->iteration}}" tabindex="0" data-section="#page_section" data-contanier="#page_container"data-page="?page={{$users->currentPage()}}" 
										    @if($user->disable_account == 0) 
										    	data-url="{{route('disable_account',$user->id)}}" 
										    	checked
										    @else
										    	data-url="{{route('enable_account',$user->id)}}"
										    @endif>
										    <label class="onoffswitch-label" for="myonoffswitch{{$loop->iteration}}">
										        <span class="onoffswitch-inner" data-on="{{ __('admin.enable') }}" data-off="{{ __('admin.disable') }}" ></span>
										        <span class="onoffswitch-switch"></span>
										    </label>
										</div>
								    </td>
								</tr>
								@endforeach
							        
							</tbody>
					        
						</table>

						<div class="col-md-12 container">
							<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#page_section" data-contanier="#page_container"> 
								{{ $users->links() }} 
							</div>
							
							<div class="col-md-2 ">
								<button class="btn btn-danger btn-xs" id="delete_all" data-section="#page_section" data-contanier="#page_container"  data-page="?page={{$users->currentPage()}}" data-url="{{route('delete_all_users',':ids')}}" data-count="{{$users->count()}}">
									<span class="glyphicon glyphicon-trash"></span>
									{{ __('admin.delete_all') }}
								</button>
							</div>
						</div>
						
						
					</div>

					
					<div class="clearfix"></div>
					
			                
			    </div>


			    @foreach($users as $user)
				<div class="modal" id="edit_{{$loop->iteration}}"   >
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove" ></span></button>
					      	</div>
					      	
					      	@if($user->reset_pass == 1 || Auth()->user()->type == 3)
						    <form class="forms_form validate-form" id="user_form_update_{{$loop->iteration}}"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('update_user',$user->id)}}" data-page="?page={{$users->currentPage()}}">
						    @csrf
					      		<div class="modal-body">
					      	   
						          <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.user') }}</h2>
						          <fieldset class="forms_fieldset">
						            
						            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('loginRegister.valid_name_ar') }} @enderror">
						              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_ar') }}:</span>
						              <input type="text" placeholder="{{ __('loginRegister.place_name_ar') }}" class="forms_field-input bigger" name="name_ar" value="{{$user->name_ar}}" autocomplete="name_ar" autofocus />
						            </div>
						            
						            <div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('loginRegister.valid_name_en') }} @enderror">
						              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_en') }}:</span>
						              <input type="text" placeholder="{{ __('loginRegister.place_name_en') }}" class="forms_field-input bigger" name="name_en" value="{{$user->name_en}}" autocomplete="name_en" />
						            </div>

						            <div class="forms_field validate-input @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_job') }} @enderror" >
						              <div class="select">
						                <select name="slct" >
						                  <option selected disabled  >{{ __('loginRegister.choose_job') }}</option>
						                  
						                  @foreach($jobs as $job)
						                    @if(app()->getLocale()=="ar" )
						                      <option @if($user->job_id == $job->id) selected @endif value="{{$job->id}}">{{$job->job_ar}}</option>
						                    @else
						                      <option @if($user->job_id == $job->id) selected @endif value="{{$job->id}}">{{$job->job_en}}</option>
						                    @endif
						                  @endforeach
						                </select>
						              </div>
						            </div>

						            <div class="forms_field validate-input @error('user_name_register') has-invalid alert-validate @enderror" data-validate="@error('user_name_register'){{ $message }} @else{{ __('loginRegister.valid_user_name') }} @enderror">
						              <span><i class="fa fa-envelope-o"></i> {{ __('loginRegister.user_name') }}:</span>
						              <input type="text" placeholder="{{ __('loginRegister.place_user_name') }}" class="forms_field-input bigger" name="user_name_register" value="{{$user->user_name}}" autocomplete="user_name_register" />
						            </div>
				            		
				            		<div class="forms_field validate-input @error('password_register') has-invalid alert-validate @enderror" data-validate="@error('password_register'){{ $message }} @else{{ __('loginRegister.valid_password') }} @enderror">
						              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password') }}:</span>
						              <input  type="password" placeholder="{{ __('loginRegister.password') }}" class="forms_field-input bigger" name="password_register" required autocomplete="password_register" />
						            </div>

						            <div class="forms_field validate-input @error('password_confirmation') has-invalid alert-validate @enderror" data-validate="@error('password_confirmation'){{ $message }} @else{{ __('loginRegister.valid_password_confirmation') }} @enderror">
						              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password_confirmation') }}:</span>
						              <input type="password" placeholder="{{ __('loginRegister.place_password_confirmation') }}" class="forms_field-input bigger" name="password_register_confirmation"  required autocomplete="password_confirmation" />
						            </div>
				           
						          </fieldset>
						        
				      			</div>
				          
					          	<div class="modal-footer ">
					        		<button type="submit" class="forms_buttons-action"  style="width: 100%;" >{{ __('admin.update') }} <i class="fa fa-check-circle"></i></button>
					      		</div>
				      		</form>
				      		@else
				      		<form class="forms_form validate-form" id="user_form_update_{{$loop->iteration}}"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('update_user',$user->id)}}" data-page="?page={{$users->currentPage()}}">
						    @csrf
					      		<div class="modal-body">
					      	   
						          <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.user') }}</h2>
						          <fieldset class="forms_fieldset">
						            <div class="forms_field validate-input @error('password_register') has-invalid alert-validate @enderror" data-validate="@error('password_register'){{ $message }} @else{{ __('loginRegister.valid_password') }} @enderror">
						              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password') }}:</span>
						              <input type="password" placeholder="{{ __('loginRegister.password') }}" class="forms_field-input bigger" name="password_register" required autocomplete="password_register" />
						            </div>

						            <div class="forms_field validate-input @error('password_confirmation') has-invalid alert-validate @enderror" data-validate="@error('password_confirmation'){{ $message }} @else{{ __('loginRegister.valid_password_confirmation') }} @enderror">
						              <span><i class="fa fa-lock"></i> {{ __('loginRegister.password_confirmation') }}:</span>
						              <input type="password" placeholder="{{ __('loginRegister.place_password_confirmation') }}" class="forms_field-input bigger" name="password_register_confirmation"  required autocomplete="password_confirmation" />
						            </div>						    
				           
						          </fieldset>
						        
				      			</div>
				          
					          	<div class="modal-footer ">
					        		<button type="submit" class="forms_buttons-action"  style="width: 100%;" >{{ __('admin.update') }} <i class="fa fa-check-circle"></i></button>
					      		</div>
				      		</form>
				      		@endif
				        </div>
				    	<!-- /.modal-content --> 
				  	</div>
				    <!-- /.modal-dialog --> 
				</div>
				@endforeach


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

