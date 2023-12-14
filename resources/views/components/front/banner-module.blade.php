@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="{{request()->path() !== "/" ? 'about-bannar-section' : 'bannar-section'}}">
  <div class="container d-flex flex-column justify-content-center">
    <div class="row">
      <div class="col-12 text-center">
        <h1>{{$moduleData['bnhead']}}</h1>
        @if (isset($moduleData['bnsubhead']) && $moduleData['bnsubhead'] !== '')  
          <h5>{{$moduleData['bnsubhead']}}</h5>
        @endif
        @if (isset($moduleData['sourcebtnstatus']) && $moduleData['sourcebtnstatus'] == '1' && isset($moduleData['sourcelbl']))  
          <div class="grd-btn  position-relative d-inline-block">
            <a href="{{$moduleData['sourcelink'] ? url($moduleData['sourcelink']) : '#'}}" class="btn btn-primary">{{Str::upper($moduleData['sourcelbl'])}}</a>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif

@if (request()->path() !== "/")
  @include('components.front.breadcrumb')
@endif