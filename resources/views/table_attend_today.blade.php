@extends('layouts.admin_layout')

@section('admin_css')
  	<link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">
@endsection


@section('main_admin')


           				


		<div id="page_section">
           <div class="page-content" id="page_container">
				<div class="section-header">
		          <h2>{{ __('admin.attend&leave') }} @if( \Carbon\Carbon::now()->format('Y-m-d') == $date->date ) {{ __('admin.today') }} @endif {{$date->date}} </h2>
		        </div>
		        
		        <div >
		        	<form class="forms_form " id="date_form"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('day',['date'=>':date','paginate'=>Cache::get('attend_today_paginate') ])}}" data-page="?page={{$attend_leaves->currentPage()}}">
				    @csrf
			      		<fieldset class="forms_fieldset">
				           
				           <div class="forms_field validate-input @error('date') has-invalid alert-validate @enderror" data-validate="@error('date'){{ $message }} @else{{ __('loginRegister.valid_date') }} @enderror">
				              <span><i class="fa fa-calendar-times-o"></i> {{ __('loginRegister.date') }}:</span>
				              <input id="activate_date" type="date" placeholder="{{ __('loginRegister.place_date') }}" class="forms_field-input bigger" name="date" value="{{$date->date}}" required  />
				            </div>
				       	</fieldset>
				       	
				       	<div class="forms_buttons justify-content-end">
				          	<button class="forms_buttons-action" type="submit">
				          		{{ __('admin.change') }}
				          		<i class="fa fa-refresh"></i>
				          	</button>
				            
				          </div>
		      		</form>			      		
		        </div>

		        <div class="table-responsive" id="table_section">

		        	<div id="mytable_wrapper" class="dataTables_wrapper no-footer">
		        		<div class="dataTables_length" >
		        			<label>{{ __('admin.lenght') }}
		        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url="{{route('day',['date'=>\Carbon\Carbon::now()->format('Y-m-d'),'paginate'=>':length' ])}}" >
		        					<option @if($attend_leaves->perPage() == 10) selected disabled @endif value="10">10</option>
		        					<option @if($attend_leaves->perPage() == 25) selected disabled @endif value="25">25</option>
		        					<option @if($attend_leaves->perPage() == 50) selected disabled @endif value="50">50</option>
		        					<option @if($attend_leaves->perPage() == 100) selected disabled @endif value="100">100</option>
		        					@if(!in_array($attend_leaves->perPage(),[10,25,50,100]) )
		        					<option selected disabled value="{{$attend_leaves->perPage()}}">{{$attend_leaves->perPage()}}</option>
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
			                   <th>{{ __('admin.name') }}</th>
			                   <th>{{ __('all.attend') }}</th>
			                   <th>{{ __('admin.attend_time') }}</th>
			                   <th>{{ __('admin.attend_hint') }}</th>
			                   
			                   @if(Auth::user()->type == 3)
				                   <th>{{ __('admin.attend_by_user') }}</th>
				                   <th>{{ __('admin.attend_by_admin') }}</th>
			                   @endif

			                   <th>{{ __('all.leave') }}</th>
			                   <th>{{ __('admin.leave_time') }}</th>
			                   <th>{{ __('admin.leave_hint') }}</th>

			                   @if(Auth::user()->type == 3)
				                   <th>{{ __('admin.leave_by_user') }}</th>
				                   <th>{{ __('admin.leave_by_admin') }}</th>
				               @endif

			                   <th>{{ __('admin.edit') }}</th>
			                
			                </thead>
							    
						    <tbody>
						    	@if(isset($attend_leaves))
						    	@foreach($attend_leaves as $attend_leave)
							    <tr class="content-center">
								    <td><input type="checkbox" class="checkthis" data-id="{{$attend_leave->id}}" /></td>
								    <td>{{$loop->iteration+(($attend_leaves->currentPage()-1)*$attend_leaves->perPage())}} </td>
								    @if(app()->getLocale()=="ar" )
								    	<td>{{$attend_leave->user->name_ar}}</td>
								    @else
								    	<td>{{$attend_leave->user->name_en}}</td>
								    @endif
								    @if(app()->getLocale()=="ar" )
								    	<td>{{$attend_leave->status_attend->name_ar}}</td>
								    @else
								    	<td>{{$attend_leave->status_attend->name_en}}</td>
								    @endif
								    <td> @if(isset($attend_leave->attend_time)) {{date('g:i A', strtotime($attend_leave->attend_time))}} @endif</td>
								    <td> @if(isset($attend_leave->attend_hint)) {{ __('admin.attend_after') }} {{$attend_leave->attend_hint}} @endif</td>
								    
								    @if(Auth::user()->type == 3)
									    <td> 
									    	@if(isset($attend_leave->attend_by_user))
									    		{{date('g:i A', strtotime($attend_leave->attend_by_user))}} 
									    	@endif
										</td>
										<td> 
									    	@if(isset($attend_leave->attend_by_admin))
									    		{{date('g:i A', strtotime($attend_leave->attend_by_admin))}} 
									    	@endif
										</td>
								    @endif

								    @if(app()->getLocale()=="ar" )
								    	<td>{{$attend_leave->status_leave->name_ar}}</td>
								    @else
								    	<td>{{$attend_leave->status_leave->name_en}}</td>
								    @endif

								    <td> @if(isset($attend_leave->leave_time)) {{date('g:i A', strtotime($attend_leave->leave_time))}} @endif</td>
								    <td> @if(isset($attend_leave->leave_hint)) {{ __('admin.leave_before') }} {{$attend_leave->leave_hint}} @endif</td>

								    @if(Auth::user()->type == 3)
								    	<td> 
									    	@if(isset($attend_leave->leave_by_user))
									    		{{date('g:i A', strtotime($attend_leave->leave_by_user))}} 
									    	@endif
										</td>
										<td> 
									    	@if(isset($attend_leave->leave_by_admin))
									    		{{date('g:i A', strtotime($attend_leave->leave_by_admin))}} 
									    	@endif
										</td>
								    @endif
								    <td>
								    	<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit_{{$loop->iteration}}" ><span class="glyphicon glyphicon-pencil"></span> {{ __('admin.edit') }}</button>
								    </td>
								    
								</tr>
								@endforeach
							        
							</tbody>
					        
						</table>

						
						
						
					</div>

					
					<div class="clearfix"></div>
					        
			    </div>

			   	@foreach($attend_leaves as $attend_leave)
				<div class="modal" id="edit_{{$loop->iteration}}"   >
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove" ></span></button>
					      	</div>
					      	
						    <form class="forms_form validate-form" id="attend_leave_form_update_{{$loop->iteration}}"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('update_attend_leave',$attend_leave->id)}}" data-page="?page={{$attend_leaves->currentPage()}}">
						    @csrf
					      		<div class="modal-body">
					      	   
						          <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.attend_leave_status') }}</h2>
						          <fieldset class="forms_fieldset">
						            
						            <div class="forms_field validate-input @error('slct_attend') has-invalid alert-validate @enderror" data-validate="@error('slct_attend'){{ $message }} @else{{ __('admin.choose_attend_status') }} @enderror" >
						              <div class="select">
						                <select name="slct_attend">
						                  <option selected disabled  >{{ __('admin.choose_attend_status') }}</option>
						                  
						                  @foreach($user_statuses as $user_status)
						                    @if(app()->getLocale()=="ar" )
						                      <option value="{{$user_status->id}}">{{$user_status->name_ar}}</option>
						                    @else
						                      <option value="{{$user_status->id}}">{{$user_status->name_en}}</option>
						                    @endif
						                  @endforeach
						                </select>
						              </div>
						            </div>

						            <div class="forms_field validate-input @error('slct_leave') has-invalid alert-validate @enderror" data-validate="@error('slct_leave'){{ $message }} @else{{ __('admin.choose_leave_status') }} @enderror" >
						              <div class="select">
						                <select name="slct_leave">
						                  <option selected disabled  >{{ __('admin.choose_leave_status') }}</option>
						                  
						                  @foreach($user_statuses as $user_status)
						                    @if(app()->getLocale()=="ar" )
						                      <option value="{{$user_status->id}}">{{$user_status->name_ar}}</option>
						                    @else
						                      <option value="{{$user_status->id}}">{{$user_status->name_en}}</option>
						                    @endif
						                  @endforeach
						                </select>
						              </div>
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
				@endif

			</div>
		</div>
			            
			    
			
			    
			    

@endsection		
		

@section('admin_js')
	
	

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="{{ asset('js/loginRegister.js') }}"></script>
	
	<script>
		var updated = "{{ __('admin.updated') }}";
	</script>
	<script src="{{ asset('js/table.js') }}"></script>

	<script>

		$(document).ready(function() 
		{
			$(document).on( "submit","#date_form", function(event) 
			{
				event.preventDefault(); 
				var date = $("#activate_date").val();
				//console.log(length);
				var url = $(this).data('url');
				url = url.replace(':date', date);
				//console.log(url);
				window.location.href = url;

			});
		});

	</script>


	
	
@endsection

