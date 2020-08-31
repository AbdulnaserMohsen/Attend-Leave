	<div id="last_section">
		<div class="" id="last_container">
			<div class="modal" id="modal-event">
			    <div class="modal-dialog">
				    <div class="modal-content">
				        <div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove" ></span></button>
				      	</div>
				      	
				      	<form class="forms_form validate-form" id="vacation_form"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('add_vacation')}}" data-page="">
					    @csrf
				      		<div class="modal-body">
				      	   		
				      	   	  <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.work_vacation') }}</h2>
					          <h4 class="" ></h4>
					          <fieldset class="forms_fieldset">
					           
					           <div class="forms_field validate-input @error('date') has-invalid alert-validate @enderror" data-validate="@error('date'){{ $message }} @else{{ __('loginRegister.valid_date') }} @enderror">
					              <span><i class="fa fa-calendar-times-o"></i> {{ __('loginRegister.date') }}:</span>
					              <input id="active_date" type="date" placeholder="{{ __('loginRegister.place_date') }}" class="forms_field-input bigger" name="date" value="" required readonly="true" />
					            </div>

					           <div class="forms_field validate-input bigger @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_vacation') }} @enderror" >
					              <div class="select">
					                <select name="slct">
					                  <option selected disabled  >{{ __('loginRegister.choose') }} {{ __('admin.work_vacation') }}</option>
					                
					                @foreach($daystatuses as $daystatus)
					                    @if(app()->getLocale()=="ar" )
					                      <option value="{{$daystatus->id}}">{{$daystatus->name_ar}}</option>
					                    @else
					                      <option value="{{$daystatus->id}}">{{$daystatus->name_en}}</option>
					                    @endif
				                  	@endforeach
					                    
					                </select>
					              </div>
					            </div>
					            <input type="hidden"  name="type" value="add">
					            
					          </fieldset>
					        
			      			</div>
			          
				          	<div class="modal-footer ">
				        		<button type="submit" class="forms_buttons-action"  style="width: 100%;" >{{ __('admin.save') }} <i class="fa fa-check-circle"></i></button>
				      		</div>
			      		</form>
			      		
			        </div>
			    	<!-- /.modal-content --> 
			  	</div>
			    <!-- /.modal-dialog --> 
			</div>
			<div class="" id="change_vacations">
				@foreach($events as $event)
				<div class="modal" id="modal-event{{$event->id}}"   >
				    <div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" ><span class="glyphicon glyphicon-remove" ></span></button>
					      	</div>
					      	
					      	<form class="forms_form validate-form" id="vacation_form{{$event->id}}"  data-section="#page_section" data-contanier="#page_container" data-url="{{route('add_vacation',$event->id)}}" data-page="">
						    @csrf
					      		<div class="modal-body">
					      	   		
					      	   	  <h2 class="forms_title">{{ __('admin.edit') }} {{ __('admin.work_vacation') }}</h2>
						          <h4 class="" ></h4>
						          <fieldset class="forms_fieldset">
						           
						           <div class="forms_field validate-input @error('date') has-invalid alert-validate @enderror" data-validate="@error('date'){{ $message }} @else{{ __('loginRegister.valid_date') }} @enderror">
						              <span><i class="fa fa-calendar-times-o"></i> {{ __('loginRegister.date') }}:</span>
						              <input type="date" placeholder="{{ __('loginRegister.place_date') }}" class="forms_field-input bigger" name="date" value="{{$event->date}}" required readonly="true" />
						            </div>

						           <div class="forms_field validate-input bigger @error('slct') has-invalid alert-validate @enderror" data-validate="@error('slct'){{ $message }} @else{{ __('loginRegister.choose_vacation') }} @enderror" >
						              <div class="select">
						                <select name="slct">
						                  <option disabled  >{{ __('loginRegister.choose') }} {{ __('admin.work_vacation') }}</option>
						                
						                @foreach($daystatuses as $daystatus)
						                    @if(app()->getLocale()=="ar" )
						                      <option @if($event->day_status_id == $daystatus->id) selected @endif value="{{$daystatus->id}}">{{$daystatus->name_ar}}</option>
						                    @else
						                      <option @if($event->day_status_id == $daystatus->id) selected @endif value="{{$daystatus->id}}">{{$daystatus->name_en}}</option>
						                    @endif
					                  	@endforeach
						                    
						                </select>
						              </div>
						            </div>

						            <input type="hidden"  name="type" value="update">

						            
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

			<div id="vacations" style="display: none;" data-vacations="{{json_encode($daily_event)}}"></div>
			
			<div id="year" style="display: none;" data-year="{{$year}}"></div>

			<div id="month" style="display: none;" data-month="{{$month}}"></div>
			
			<div id="current_date" style="display: none;" data-date="{{$current_date}}"></div>
			
		</div>
	</div>
