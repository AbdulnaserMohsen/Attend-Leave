@extends(Route::current()->getName() == 'statictics' ? 'layouts.admin_layout' : 'layouts.all' )
@section(Route::current()->getName() == 'statictics' ? 'admin_css' : 'headerCss')

	@if(Route::current()->getName() != 'statictics')
		@if(app()->getLocale()=="en" )
	      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	   @else
	      <link 
	        rel="stylesheet"
	        href="https://cdn.rtlcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
	        integrity="sha384-cSfiDrYfMj9eYCidq//oGXEkMc0vuTxHXizrMOFAaPsLt1zoCUVnSsURN+nef1lj"
	        crossorigin="anonymous">
	   @endif
		<link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css')}}">
	@endif

@endsection

@section(Route::current()->getName() == 'statictics' ? 'main_admin' : 'content')

                  <!--==========================
				      Services Section
				    ============================-->
				    <section id="services" >
				      	<div class="container " id="page_container">

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
						        				@if(Route::current()->getName() == 'statictics')
						        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url="{{route('statictics',['year'=>$year,'month'=>$month ,'worker_paginate'=> Cache::get('worker_paginate') ,'table_paginate'=> ':length' ] )}}">
						        				@else
						        				<select id="mytable_length" name="mytable_length" aria-controls="mytable" class="classic" data-url="{{route('user_statictics',['year'=>$year,'month'=>$month ,'table_paginate'=> ':length' ] )}}">
						        				@endif
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
											@if(Route::current()->getName() == 'statictics')
												<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#table_section" data-contanier="#mytable_wrapper"> 
												{{ $stat_user['ordinary']->appends(['page' => $workers->currentPage(), 'table' => $stat_user['ordinary']->currentPage()])->links() }}
											</div>
											@else
												<div class="col-md-10 d-flex justify-content-center pageint"  data-section="#table_section" data-contanier="#mytable_wrapper"> 
												{{ $stat_user['ordinary']->links() }}
											</div>
											@endif
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

@section(Route::current()->getName() == 'statictics' ? 'admin_js' : 'footerJs')

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
	
	</script>
<script src="{{ asset('js/chart drawing.js') }}"></script>




@endsection

