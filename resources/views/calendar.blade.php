@extends('layouts.admin_layout')

@section('admin_css')
	<meta name="_token" content="{{ csrf_token() }}"/>

	<link href="{{ asset('css/loginRegister.css') }}" rel="stylesheet">

	<link href="{{ asset('css/evo-calendar.royal-navy.css') }}" rel="stylesheet">
	@if(app()->getLocale()=="en" )
		<link href="{{ asset('css/evo-calendar.css') }}" rel="stylesheet">
	@else
		<link href="{{ asset('css/evo-calendarRTL.css') }}" rel="stylesheet">
	@endif
@endsection


@section('main_admin')


           				


		<div id="page_section">
           <div class="page-content" id="page_container">
				<section class="" >
					

					<div id="calendar"></div>
					


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
				</section>
			</div>
		</div>
		
			    

@endsection		
		

@section('admin_js')
	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script src="{{ asset('js/loginRegister.js') }}"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>


   		var add = "{{ __('admin.add') }}";
   		var remove = "{{ __('admin.delete') }}";
   		var vacation = "{{ __('admin.vacation') }}";

	</script>
	<script src="{{ asset('js/evo-calendar.js') }}"></script>
        <script>
        // initialize your calendar, once the page's DOM is ready
        $(document).ready(function() 
        {
        	var response;
        	$(document).on( "click","#add_vacation", function() 
			{
				if($("#active_date").val() == "")
				{
					console.log("aaaa");
					var now = new Date();
            		var day = ("0" + now.getDate()).slice(-2);
					var month = ("0" + (now.getMonth() + 1)).slice(-2);
					var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
  
            		$("#active_date").val(today);
				}
				
			});
			
			function ajax(type,url,processData,contentType,form,section,link,contanier,callback)
			{
				var result;
				$.ajax
				({
					type: type, //THIS NEEDS TO BE GET
					url: url,
					dataType: 'json',
					data: form,
					async: false, // to make js wait unitl ajax finish
					processData: processData,
    				contentType: contentType,

    				success: function (data) 
					{
						//console.log(data);
						//$(section).load(link +" "+ contanier);
						result = data;
					},
					error:function(data)
					{ 
						//console.log(data);
						//console.log(data.responseJSON);
						//console.log(data.responseJSON.message);
						result = data;
					}
				});
				return result;

			}
			function get_last_section(callback)
			{
				var url = '{{ route("calendar") }}';
				var section = "#page_section";
				var contanier = "#page_container";
				var year = $(".calendar-year p").html();
				var month = $("#month").data('month');
				var datatosend = {year:year, month:month, date:$("#current_date").data('date')};
				
				var type = "GET";
				var processData = true;
				var contentType = false;
				
				var response = ajax(type,url,processData,contentType,datatosend,section,url,contanier);

				return response;
			}

			$(document).on( "click","[name='delete']", function(event) 
			{
				
				var id=$( this ).data("event");
				var url = '{{ route("delete_vacation", ":id") }}';
				url = url.replace(':id', id);
				//console.log(url);
				var processData = true;
				var contentType = false;

				var type = "GET";
				var link = location.href;
				var section = $(this).data('section');
				var contanier = $(this).data("contanier");
				//var form = new FormData();
				var datatosend = {};
				
				swal(
				{
				  title: delete_question_all,
				  text: delete_hint,
				  icon: "warning",
				  buttons:  [delete_cancel, delete_ok],
				  dangerMode: true,
				})
				.then((willDelete) => 
				{
					if (willDelete)
				  	{
						response = ajax(type,url,processData,contentType,datatosend,section,link,contanier);
						//console.log(data);
						if(response.hasOwnProperty("success") && !response.hasOwnProperty("responseJSON"))
						{
							console.log(response);
							$("#calendar").evoCalendar('removeCalendarEvent', id);
							//$("#last_section").load(link +" "+ "#last_container");
							var newresponse = get_last_section();
							$("#last_section").replaceWith(newresponse.html);
							swal(response.success, 
							{
							  icon: "success",
							  buttons: false,
							  timer: 1500,
							});
							
						}
						else if(response.hasOwnProperty("failed"))
						{
							swal(
									response.failed,
								);
						}
						else
						{
							console.log(response);
							swal(
									error,
									response.responseText,
								);
						}

				  	}
				  	else 
				  	{
						swal(data_safed,
						{
							buttons: false,
							timer: 1000,
						});
				  	}
				});
				
				
			});
			
			$(document).on( "submit",".validate-form", function(event) 
			{
				event.preventDefault(); 

				var section = $(this).data('section');
				var contanier = $( this ).data("contanier");
				var url = $(this).data('url');
				var form = '#'+$(this).attr('id');
				var link = location.href.split('?')[0];
				var type = 'POST';
				var processData = false;
				var contentType = false;

				var formData = new FormData($(form)[0]);
				
				response = ajax(type,url,processData,contentType,formData,section,link,contanier);


				if(response.hasOwnProperty("success") && !response.hasOwnProperty("responseJSON") )
				{
					console.log(response);
					if(response.type == 'update')
					{
						$("#calendar").evoCalendar('removeCalendarEvent', response.id);
					}

					$("#calendar").evoCalendar('addCalendarEvent', 
					[{
						id: response.id,
					  	name: response.vacation_name,
					  	date: response.date,
					  	type: "holiday",
					  	everyYear: false,
					}]);

					//$("#last_section").load(link +" "+ "#last_container");
					//$("#last_section").replaceWith(response.html);
					// var newresponse = get_last_section();
					// $("#last_section").replaceWith(newresponse.html);

					swal(response.success, 
					{
					  icon: "success",
					  buttons: false,
					  timer: 1500,
					});
					
					$('.close').trigger('click');
					$('.close').trigger('click');

					var newresponse = get_last_section();
					$("#last_section").replaceWith(newresponse.html);
				}
				else if(response.hasOwnProperty("failed"))
				{
					swal(
							response.failed,
						);
				}
				else
				{
					console.log(response);
					if(typeof response.responseJSON.errors !== 'undefined' )
					{
						$.each(response.responseJSON.errors, function (key, value) 
						{
							console.log(key , value);
							if(key == "slct")//select
							{
								$('[name="' + key + '"]').parent().parent().removeClass("has-valid true-validate");
								
								$('[name="' + key + '"]').parent().parent().attr('data-validate',value);
							
								$('[name="' + key + '"]').parent().parent().addClass("has-invalid alert-validate");
							}
							else
							{
								
								$('[name="' + key + '"]').parent().removeClass("has-valid true-validate");
							
								$('[name="' + key + '"]').parent().attr('data-validate',value);
							
								$('[name="' + key + '"]').parent().addClass("has-invalid alert-validate");
							}

	
						});

					}
					else
					{
						swal(
							error,
							response.responseText,
						);
						$('.close').trigger('click');
						$('.close').trigger('click');	
					}
				}

			});


			$(document).on( "click",".icon-button[data-year-val='prev'] , .icon-button[data-year-val='next']", function(event)
			{
				// var year= $(".calendar-year p").html();
				// var url = '{{ route("change_year", ":year") }}';
				// url$("#current_date").data('date') = url.replace(':year', year);

				var url = '{{ route("calendar") }}';
				
				var link = location.href;
				var section = "#page_section";
				var contanier = "#page_container";

				
				var year = $(".calendar-year p").html();
				var month = $("#month").data('month');
				//console.log(month);
				var datatosend = {year:year ,month:month ,date:$("#current_date").data('date')};
				//console.log(datatosend);

				var type = "GET";
				var processData = true;
				var contentType = false;
				
				var response = ajax(type,url,processData,contentType,datatosend,section,link,contanier);
				if(response.hasOwnProperty("success") )
				{
					console.log(response,response.daily_event);
					$("#calendar").evoCalendar('destroy');
		            $("#last_section").replaceWith(response.html);
		            evocalendar();

				}
				else
				{
					console.log("error",response);
					
					//window.location.replace(url);
					//$(section).load(url +" "+ contanier);
					//$("#calendar").evoCalendar('destroy');
					//evocalendar();
					//$("html").replaceWith(data);
				}

			});

			$(document).on( "click",".month", function(event)
			{
				//console.log($(this).data('month-val')+1);
				$("#month").data('month',$(this).data('month-val')+1);

				var url = '{{ route("calendar") }}';
				var link = location.href;
				var section = "#page_section";
				var contanier = "#page_container";

				var year = $("#year").data('year');
				var month = $("#month").data('month');
				console.log(month);
				var datatosend = { year:year,month:month ,date:$("#current_date").data('date')};
				
				var type = "GET";
				var processData = true;
				var contentType = false;
				
				var response = ajax(type,url,processData,contentType,datatosend,section,link,contanier);
				if(response.hasOwnProperty("success") )
				{
					console.log(response,response.daily_event);
					$("#calendar").evoCalendar('destroy');
		            $("#last_section").replaceWith(response.html);
		            evocalendar();

				}
				else
				{
					console.log("error",response);
				}

			});
			
			$(document).on( "click",".work", function(event)
			{
				//console.log($(this).data("url"));
				window.location.href = $(this).data("url");
			});

			
			
			function evocalendar()
			{
				//var vacations = {!! json_encode($daily_event) !!};
				var vacations = $("#vacations").data('vacations');
				console.log(vacations);

				
				$('#calendar').evoCalendar
	            ({
	            	theme:'Royal Navy',
	            	format:'mm/dd/yyyy',
	            	titleFormat:'MM yyyy',
	            	eventHeaderFormat:'d MM  yyyy',
	            	todayHighlight:true,
	            	firstDayOfWeek: 6,// Saturday
	            	weekends:{!! json_encode($weekends) !!}, //me //friday

	            	language:$('html').attr('lang'),
	
	            	calendarEvents: vacations,

	            })
	            .on('selectDate', function() 
	            {
	            	var active_date = $("#calendar").evoCalendar('getActiveDate');
	            	$("#current_date").data('date',active_date);
	            	//console.log(active_date);
	            	
	            	var now = new Date(active_date);
	            	var day = ("0" + now.getDate()).slice(-2);
					var month = ("0" + (now.getMonth() + 1)).slice(-2);
					var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	  
	            	//var today = new Date(active_date).toISOString().substr(0, 10);
	            	//console.log(today);
	            	$("#active_date").val(today);
				})
				.on('selectEvent', function() 
				{
					console.log("ffd");

				});
				var current_date = $("#current_date").data('date');
				$("#calendar").evoCalendar('selectDate', current_date);
				console.log(current_date);

				var year = $("#year").data('year');
				$("#calendar").evoCalendar('selectYear', year);
				console.log(year);

				var month = $("#month").data('month')-1;
				$("#calendar").evoCalendar('selectMonth', month);
				console.log(month);
				
			}
			evocalendar();
			/*$(document).ajaxComplete(function()
			{
				//console.log("aa");
				evocalendar();
				//$("#current_date").data('date',response.current_date);

			});*/


        });
        </script>

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

@endsection

