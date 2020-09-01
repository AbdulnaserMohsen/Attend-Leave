@extends('layouts.all')
@section('content')

  <main id="main">

    
    <section id="services">
      <div class="container">
        <div class="section-header">
          <h2>{{ __('all.the_vacation') }}</h2>
          @if(app()->getLocale()=="ar" )
            <p>{{ __('all.vaction_day', ['vacation_name' => $newday->day_status->name_ar ]) }}</p>
          @else
            <p>{{ __('all.vaction_day', ['vacation_name' => $newday->day_status->name_en ]) }}</p>
          @endif
        </div>
      </div>
    </section><!-- #services -->



    
  </main>
@endsection

@section('footerJs')

@endsection