@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="about">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-12">
        <img src="{{asset('frontend-assets/images/About-image.png')}}" alt="About image">
      </div>
      <div class="col-lg-6 col-12 back-logo">
        <div class="image">
          <h2 class="main-heading-h2">{{$moduleData['abhead']}}</h2>
          <p>{{$moduleData['abdesc']}}</p>
            <div class="grd-btn  position-relative d-inline-block">
              @if (isset($moduleData['sourcebtnstatus']) && $moduleData['sourcebtnstatus'] == '1' && isset($moduleData['sourcelbl']))  
                <a href="{{$moduleData['sourcelink'] ? url($moduleData['sourcelink']) : '#'}}" class="btn btn-primary">{{$moduleData['sourcelbl']}}</a>
              @endif
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif