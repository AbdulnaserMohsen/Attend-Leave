@extends('layouts.all')
@section('content')

  <main id="main">

    <!--==========================
      About Section
    ============================-->
    <section id="about" class="wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 about-img">
            <img src="img/{{$home->image}}" alt="">
          </div>

          <div class="col-lg-6 content">
            @if(app()->getLocale()=="ar" )
              <h2>{{$home->company_name_ar}}</h2>
              <h3>{{$home->description_ar}}</h3>
            @else
              <h2>{{$home->company_name_en}}</h2>
              <h3>{{$home->description_en}}</h3>
            @endif

          </div>
        </div>

      </div>
    </section><!-- #about -->

    <!--==========================
      Services Section
    ============================-->
    <section id="services">
      <div class="container">
        <div class="section-header">
          <h2>{{ __('all.services') }}</h2>
        </div>

        <div class="row">
          @foreach($services as $service)
            <div class="col-lg-6">
              <div class="box wow fadeInLeft">
                <div class="icon">{!! $service->font !!}</div>
                @if(app()->getLocale()=="ar" )
                  <h4 class="title"><a href="">{{$service->service_title_ar}}</a></h4>
                  <p class="description">{{$service->service_description_ar}}</p>
                @else
                  <h4 class="title"><a href="">{{$service->service_title_en}}</a></h4>
                  <p class="description">{{$service->service_description_en}}</p>
                @endif
              </div>
            </div>
          @endforeach

        </div>

      </div>
    </section><!-- #services -->



    
  </main>
@endsection

@section('footerJs')
  
  <script>
    
    jQuery( document ).ready
    (function( $ ) 
    {
      var hash = window.location.hash.substring(1);
      if (hash == "services") 
      {
        $('#link_services').trigger('click');
        //$('#link_services').click();
        //console.log(hash); 
      }
    
    });

  </script>
@endsection