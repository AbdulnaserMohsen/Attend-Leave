@extends('layouts.admin_layout')

@section('admin_css')
  	<link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">


  	<link href="{{ asset('css/fm.selectator.jquery.css') }}" rel="stylesheet">

  	<style>
		select { width: 90%; }
	</style>

@endsection


@section('main_admin')


           				


		<div id="page_section">
           <div class="page-content" id="page_container">
		
				<section class="" id="add_section">
					
					<div class="" >
				        <h2 class="forms_title">{{ __('admin.user_statuses') }} </h2>
				        <form class="forms_form validate-form" id="user_status_form_add"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('add_user_status')}}" data-page="?page={{$user_statuses->currentPage()}}" >
				          @csrf
				          
				          <fieldset class="forms_fieldset">
				            
				            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('loginRegister.valid_name_ar') }} @enderror">
				              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_ar') }}:</span>
				              <input type="text" placeholder="{{ __('loginRegister.place_name_ar') }}" class="forms_field-input bigger" name="name_ar" value="{{ old('name_ar') }}" required autocomplete="name_ar" autofocus />
				            </div>
				            
				            <div class="forms_field validate-input @error('valid_name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('loginRegister.valid_name_en') }} @enderror">
				              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_en') }}:</span>
				              <input type="text" placeholder="{{ __('loginRegister.place_name_en') }}" class="forms_field-input bigger" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en" />
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
		        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url='{{ route("user_statuses", ":length") }}'>
		        					<option @if($user_statuses->perPage() == 10) selected disabled @endif value="10">10</option>
		        					<option @if($user_statuses->perPage() == 25) selected disabled @endif value="25">25</option>
		        					<option @if($user_statuses->perPage() == 50) selected disabled @endif value="50">50</option>
		        					<option @if($user_statuses->perPage() == 100) selected disabled @endif value="100">100</option>
		        					@if(!in_array($user_statuses->perPage(),[10,25,50,100]) )
		        					<option selected disabled value="{{$user_statuses->perPage()}}">{{$user_statuses->perPage()}}</option>
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
			                   <th>{{ __('admin.edit') }}</th>
			                   <th>{{ __('admin.delete') }}</th>
			                
			                </thead>
							    
						    <tbody>
						    	@foreach($user_statuses as $user_status)
							    <tr class="content-center">
								    <td><input type="checkbox" class="checkthis" data-id="{{$user_status->id}}" /></td>
								    <td>{{$loop->iteration+(($user_statuses->currentPage()-1)*$user_statuses->perPage())}} </td>
								    <td>{{$user_status->name_ar}}</td>
								    <td>{{$user_status->name_en}}</td>
								    <td>
								    	<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit_{{$loop->iteration}}" ><span class="glyphicon glyphicon-pencil"></span> {{ __('admin.edit') }}</button>
								    </td>
								    @php($page=$user_statuses->currentPage())
									@if($user_statuses->count()==1)
										@if($user_statuses->currentPage() != 1)
											@php($page =$user_statuses->currentPage()-1)
										@endif
									@endif
								    <td>
								    	<button class="btn btn-danger btn-xs" name="delete" data-section="#page_section" data-contanier="#page_container" data-url="{{route('delete_user_status',$user_status->id)}}" data-page="?page={{$page}}"><span class="glyphicon glyphicon-trash"></span> {{ __('admin.delete') }}</button>
								    </td>
								</tr>
								@endforeach
							        
							</tbody>
					        
						</table>

						<div class="col-md-12 container">
							<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#page_section" data-contanier="#page_container"> 
								{{ $user_statuses->links() }} 
							</div>
							
							<div class="col-md-2 ">
								<button class="btn btn-danger btn-xs" id="delete_all" data-section="#page_section" data-contanier="#page_container"  data-page="?page={{$user_statuses->currentPage()}}" data-url="{{route('delete_all_user_statuses',':ids')}}" data-count="{{$user_statuses->count()}}">
									<span class="glyphicon glyphicon-trash"></span>
									{{ __('admin.delete_all') }}
								</button>
							</div>
						</div>
						
						
					</div>

					
					<div class="clearfix"></div>
					
			                
			    </div>


			    @foreach($user_statuses as $user_status)
				<div class="modal" id="edit_{{$loop->iteration}}"   >
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove" ></span></button>
					      	</div>
					      	
					      	
						    <form class="forms_form validate-form" id="user_status_form_update_{{$loop->iteration}}"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('update_user_status',$user_status->id)}}" data-page="?page={{$user_statuses->currentPage()}}">
						    @csrf
					      		<div class="modal-body">
					      	   
						          <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.user_status') }}</h2>
						          <fieldset class="forms_fieldset">
						            
						            <div class="forms_field validate-input @error('name_ar') has-invalid alert-validate @enderror" data-validate="@error('name_ar'){{ $message }} @else{{ __('loginRegister.valid_name_ar') }} @enderror">
						              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_ar') }}:</span>
						              <input type="text" placeholder="{{ __('loginRegister.place_name_ar') }}" class="forms_field-input bigger" name="name_ar" value="{{$user_status->name_ar}}" autocomplete="name_ar" autofocus />
						            </div>
						            
						            <div class="forms_field validate-input @error('name_en') has-invalid alert-validate @enderror" data-validate="@error('name_en'){{ $message }} @else{{ __('loginRegister.valid_name_en') }} @enderror">
						              <span><i class="fa fa-address-book-o"></i> {{ __('loginRegister.name_en') }}:</span>
						              <input type="text" placeholder="{{ __('loginRegister.place_name_en') }}" class="forms_field-input bigger" name="name_en" value="{{$user_status->name_en}}" autocomplete="name_en" />
						            </div>
						          </fieldset>
				      			</div>
				          
					          	<div class="modal-footer ">
					        		<button type="submit" class="forms_buttons-action"  style="width: 100%;" >{{ __('admin.update') }} <i class="fa fa-check-circle"></i></button>
					      		</div>
				      		</form>
				      		
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
	
	<script src="https://code.jquery.com/jquery.min.js"></script>
	<script src="{{ asset('js/fm.selectator.jquery.js') }}"></script>
	<script src="{{ asset('js/multiple selector.js') }}"></script>

	
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

