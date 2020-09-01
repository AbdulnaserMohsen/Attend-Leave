@extends('layouts.admin_layout')
@section('admin_css')
	
	<link href="{{ asset('css/jquery.listtopie.css') }}" rel="stylesheet">
@endsection

@section('main_admin')

                  <!--==========================
				      Services Section
				    ============================-->
				    <section id="services" >
				      	<div class="container" id="page_container">
					        <div class="section-header">
					          <h2>{{ __('admin.statistics') }}</h2>
					        </div>
					        
						        @foreach($statistics_of_users as $stat_user)
						        <div class="clearfix"></div>
						        <div class=" pb-10">
						        	<div class="title">
							          <h2>{{$stat_user['name']}}</h2>
							        </div>
							        <div class="col-md-12" >
							        	<div class="col-md-3">
							        		<div class="card text-white bg-danger mb-3 text-center" style="max-width: 18rem;">
											  <div class="card-header">{{ __('admin.absense') }}</div>
											  <div class="card-body">
											    <h5 class="card-title js-number-counter">{{$stat_user['absence_counter']}}</h5>
											  </div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="card text-white bg-success mb-3 text-center" style="max-width: 18rem;">
											  <div class="card-header">{{ __('admin.attend&leave') }}</div>
											  <div class="card-body">
											    <h5 class="card-title js-number-counter">{{$stat_user['attend_leave_counter']}}</h5>
											  </div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="card text-white bg-primary mb-3 text-center" style="max-width: 18rem;">
											  <div class="card-header">{{ __('admin.other_attend') }}</div>
											  <div class="card-body">
											  	@if(isset($stat_user['other_attend']))
												  	@foreach($stat_user['other_attend'] as $key => $value)
												    	<h5 class="card-title ">{{$key}} :<span class="js-number-counter">{{$value}}</span></h5>	
												    @endforeach
											    @endif
											  </div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="card text-white bg-info mb-3 text-center" style="max-width: 18rem;">
											  <div class="card-header">{{ __('admin.other_leave') }}</div>
											  <div class="card-body">
											  	@if(isset($stat_user['other_leave']))
												  	@foreach($stat_user['other_leave'] as $key => $value)
												    	<h5 class="card-title ">{{$key}} :<span class="js-number-counter">{{$value}}</span></h5>
												    @endforeach
											    @endif
											    
											  </div>
											</div>
										</div>
							        	
							        </div>
							        <div class="col-md-11">
							        	<div class="row">
							        		<div class="col-md-6 " class="chart-container" >
							        			<canvas class="doughnut" id="doughnut{{$loop->iteration}}" width="50" height="30"></canvas>
							        		</div>
							        		<div class="col-md-6">
							        			<canvas class="bar" id="bar{{$loop->iteration}}" width="50" height="30"></canvas>
							        		</div>
							        	</div>
							        </div>
						        </div>

						        <div class="table-responsive col-md-11 " id="table_section">

						        	<div id="mytable_wrapper" class="dataTables_wrapper no-footer">
						        		<div class="dataTables_length" >
						        			<label>{{ __('admin.lenght') }}
						        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url="{{route('statictics',['year'=>$year,'month'=>$month ,'worker_paginate'=> Cache::get('worker_paginate') ,'table_paginate'=> ':length' ] )}}">
						        					<option @if($stat_user['ordinary']->perPage() == 10) selected disabled @endif value="10">10</option>
						        					<option @if($stat_user['ordinary']->perPage() == 25) selected disabled @endif value="25">25</option>
						        					<option @if($stat_user['ordinary']->perPage() == 31) selected disabled @endif value="31">31</option>
						        					@if(!in_array($stat_user['ordinary']->perPage(),[10,25,31]) )
						        					<option selected disabled value="{{$stat_user['ordinary']->perPage()}}">{{$stat_user['ordinary']->perPage()}}</option>
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
							                   <th>{{ __('admin.date') }}</th>
							                   <th>{{ __('all.attend') }}</th>
							                   <th>{{ __('all.leave') }}</th>
							                
							                </thead>
											    
										    <tbody>
										    	@foreach($stat_user['ordinary'] as $ord)
											    <tr class="content-center">
												    <td><input type="checkbox" class="checkthis" data-id="{{$ord->id}}" /></td>
												    <td>{{$loop->iteration+(($stat_user['ordinary']->currentPage()-1)*$stat_user['ordinary']->perPage())}} </td>
												    <td>{{$ord->calendar->date}}</td>
												    @if(app()->getLocale()=="ar")
												    	<td>{{$ord->status_attend->name_ar}}</td>
												    @else
												    	<td>{{$ord->status_attend->name_en}}</td>
												    @endif

												    @if(app()->getLocale()=="ar")
												    	<td>{{$ord->status_leave->name_ar}}</td>
												    @else
												    	<td>{{$ord->status_leave->name_en}}</td>
												    @endif
												</tr>
												@endforeach
											        
											</tbody>
									        
										</table>

										<div class="col-md-12 container">
											<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#table_section" data-contanier="#mytable_wrapper"> 
												{{ $stat_user['ordinary']->appends(['page' => $workers->currentPage(), 'table' => $stat_user['ordinary']->currentPage()])->links() }}
											</div>
										</div>	
									</div>
									<div class="clearfix"></div>
								</div>
						        @endforeach
						    
						    @if(Route::current()->getName() == 'statictics')
						    <div class="col-md-10 d-flex justify-content-center pageint2"  data-section="#services" data-contanier="#page_container"> 
								{{ $workers->links() }} 
							</div>
							@endif

					        
				      	</div>
				    </section>
				    <!-- #services -->

		
		
@endsection

@section('admin_js')

<script src="{{ asset('js/table.js') }}"></script>
<script src="{{ asset('js/Chart.js') }}"></script>
<script>

	$(document).on('click','.pageint2 .pagination a', function(event)
	{
		event.preventDefault();

		var page = $(this).attr('href');
		window.location.href = page;
	});

		

		var labels = ["{{ __('admin.absense') }}","{{ __('admin.attend&leave') }}"];
		var statistics = {!! json_encode($statistics_of_users) !!};
		//console.log(statistics);
		
		
   		var absense = "{{ __('admin.absense') }}";
   		if($('html').attr('lang') == "ar")
   			var attend_leave = "الحضور والانصراف";
   		else
   			var attend_leave = "Attend & Leave ";

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
<script src="{{ asset('js/chart drawing.js') }}"></script>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.5.1/snap.svg-min.js"></script>
<script src="{{ asset('js/jquery.listtopie.js') }}"></script>

<script>
	/*Example5*/
	$('.rowtest4').listtopie({
		  size:'auto',
		  useMenu:true,
		  strokeWidth:3,
		  speedDraw:150,
		  hoverEvent:false,
		  sectorRotate:true,
		  hoverBorderColor:'#6fe7dd',
		  hoverWidth:2,
		  textSize:'16',
		  marginCenter:35,
		  listVal:false,
		  listValMouseOver: false,
		  infoText:true,
		  setValues:true,
		  backColorOpacity: '0.5',
		  hoverSectorColor:true,
		  usePercent:false,
		  textSize:'12'
	});

	$('.rowtest4').on('afterChange', function(event, listtopie){
		  var idSector = listtopie.currentChangeSector;
		  $( ".menu_title" ).css('display','none');
		  $('.rowtest4').listtopie('hoverGoTo',idSector);
		  $("#m" + idSector).fadeIn("slow");
	});

	/*example5*/

</script>
	
@endsection

