@extends('layouts.admin_layout')

@section('admin_css')
  	<link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
@endsection


@section('main_admin')


           				


		<div id="page_section">
           <div class="page-content" id="page_container">
           	
				<section class="" id="add_section">
					
					<div class="" >
				        <h2 class="forms_title">{{ __('admin.jobs') }}</h2>
				        <form class="forms_form validate-form" id="job_form_add"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('add_job')}}" data-page="?page={{$jobs->currentPage()}}" >
				          @csrf
				          
				          <fieldset class="forms_fieldset">
				            <div class="forms_field validate-input @error('job_en') has-invalid alert-validate @enderror" data-validate="@error('job_en'){{ $message }} @else{{ __('admin.valid_job_en') }} @enderror" >
				              <span> {{ __('admin.job_en') }}:</span>
				              <input  type="text" placeholder="{{ __('admin.place_job_en') }}" class="forms_field-input2" name="job_en" value="{{ old('job_en') }}" required autocomplete="job_en" />
				            </div>

							<div class="forms_field validate-input @error('job_ar') has-invalid alert-validate @enderror" data-validate="@error('job_ar'){{ $message }} @else{{ __('admin.valid_job_ar') }} @enderror" >
				              <span> {{ __('admin.job_ar') }}:</span>
				              <input  type="text" placeholder="{{ __('admin.place_job_ar') }}" class="forms_field-input2" name="job_ar" value="{{ old('job_ar') }}" required autocomplete="job_ar" />
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
		        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url='{{ route("jobs", ":length") }}'>
		        					<option @if($jobs->perPage() == 10) selected disabled @endif value="10">10</option>
		        					<option @if($jobs->perPage() == 25) selected disabled @endif value="25">25</option>
		        					<option @if($jobs->perPage() == 50) selected disabled @endif value="50">50</option>
		        					<option @if($jobs->perPage() == 100) selected disabled @endif value="100">100</option>
		        					@if(!in_array($jobs->perPage(),[10,25,50,100]) )
		        					<option selected disabled value="{{$jobs->perPage()}}">{{$jobs->perPage()}}</option>
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
			                   <th>{{ __('admin.job_en') }}</th>
			                   <th>{{ __('admin.job_ar') }}</th>
			                   <th>{{ __('admin.edit') }}</th>
			                   <th>{{ __('admin.delete') }}</th>
			                
			                </thead>
							    
						    <tbody>
						    	@foreach($jobs as $job)
							    <tr class="content-center">
								    <td><input type="checkbox" class="checkthis" data-id="{{$job->id}}" /></td>
								    <td>{{$loop->iteration+(($jobs->currentPage()-1)*$jobs->perPage())}} </td>
								    <td>{{$job->job_ar}}</td>
								    <td>{{$job->job_en}}</td>
								    <td>
								    	<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit_{{$loop->iteration}}" ><span class="glyphicon glyphicon-pencil"></span> {{ __('admin.edit') }}</button>
								    </td>
								    @php($page=$jobs->currentPage())
									@if($jobs->count()==1)
										@if($jobs->currentPage() != 1)
											@php($page =$jobs->currentPage()-1)
										@endif
									@endif
								    <td>
								    	<button class="btn btn-danger btn-xs" name="delete" data-section="#page_section" data-contanier="#page_container" data-url="{{route('delete_job',$job->id)}}" data-page="?page={{$page}}"><span class="glyphicon glyphicon-trash"></span> {{ __('admin.delete') }}</button>
								    </td>
								</tr>
								@endforeach
							        
							</tbody>
					        
						</table>

						<div class="col-md-12 container">
							<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#page_section" data-contanier="#page_container"> 
								{{ $jobs->links() }} 
							</div>

							<div class="col-md-2 ">
								<button class="btn btn-danger btn-xs" id="delete_all" data-section="#page_section" data-contanier="#page_container"  data-page="?page={{$jobs->currentPage()}}" data-url="{{route('delete_all_jobs',':ids')}}" data-count="{{$jobs->count()}}">
									<span class="glyphicon glyphicon-trash"></span>
									{{ __('admin.delete_all') }}
								</button>
							</div>
						</div>
						
						
					</div>

					
					<div class="clearfix"></div>
					
			                
			    </div>


			    @foreach($jobs as $job)
				<div class="modal" id="edit_{{$loop->iteration}}"   >
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove" ></span></button>
					      	</div>
					      	
						    <form class="forms_form validate-form" id="job_form_update_{{$loop->iteration}}"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('update_job',$job->id)}}" data-page="?page={{$jobs->currentPage()}}">
						    @csrf
					      		<div class="modal-body">
					      	   
						          <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.job') }}</h2>
						          <fieldset class="forms_fieldset">
						            <div class="forms_field validate-input @error('job_en') has-invalid alert-validate @enderror" data-validate="@error('job_en'){{ $message }} @else{{ __('admin.valid_job_en') }} @enderror" >
						              <span> {{ __('admin.job_en') }}:</span>
						              <input  type="text" placeholder="{{ __('admin.place_job_en') }}" class="forms_field-input2" name="job_en" value="{{$job->job_en}}" required autocomplete="job_en" />
						            </div>

									<div class="forms_field validate-input @error('job_ar') has-invalid alert-validate @enderror" data-validate="@error('job_ar'){{ $message }} @else{{ __('admin.valid_job_ar') }} @enderror" >
						              <span> {{ __('admin.job_ar') }}:</span>
						              <input  type="text" placeholder="{{ __('admin.place_job_ar') }}" class="forms_field-input2" name="job_ar" value="{{$job->job_ar}}" required autocomplete="job_ar" />
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

