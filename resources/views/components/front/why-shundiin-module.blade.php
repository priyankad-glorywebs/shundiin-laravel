@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
    // dd(request()->path());
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="why-tour" style="{{request()->path() !== "/" ? 'background:#f5f5f5' : ''}}">
    <div class="container">
      <div class="row">
        <h2 class="mb-4">{{$moduleData['wshead']}}</h2>
        <div class="why-our-tour owl-carousel owl-theme">

        @foreach ($moduleData['services'] as $service)

        <div class="item travel-item">
          <div class="travel-head mb-4">
            <div class="details">
              <div class="image">
                <img src="{{asset('storage/photos/'.$service['tourImageName'])}}" alt="Travel" style="opacity: 1;" width="90" height="100">
              </div>
              <div class="content">
                <h3 class="travel-title">{{$service['servname']??''}}</h3>
                <p class="travel-desc">{{$service['servdesc']??''}}</p>
              </div>
            </div>
            <span>{{$loop->index + 1}}</span>
          </div>
        </div>

        @endforeach

       </div>
      </div>
    </div>
  </section>
@endif