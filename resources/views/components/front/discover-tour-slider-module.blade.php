@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="discover">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2>{{$moduleData['dthead']}}</h2>
        </div>
        <div class="col-6"></div>
        <div class="discover-tour">
          <!-- <div class="{{request()->path() === "tours" ? 'row' : 'tour-slider-wrap owl-carousel owl-theme'}}"> -->
            <div class="row">
        @foreach ($moduleData['tours'] as $tour)
            
            <!-- <div class="{{request()->path() === "tours" ? 'col-12 col-md-6 col-xl-4 my-2 p-2' : 'item'}}"> -->
              <div class="col-12 col-md-6 col-xl-4 my-2 p-2">
              <div class="card">
                <div class="card-img">
                  <img src="{{asset('storage/photos/'.$tour['tourImageName'])}}" alt="{{$tour['tourImageName']}}" class="img-fluid">
                </div>
                <div class="card-body">
                  <h3>{{$tour['tourname']??''}}</h3>
                  <p>{{$tour['tourdesc']??''}}</p>
                  <div class="tour-meta">
                    <div class="tour-price">${{$tour['tourprice']??''}}<span class="person-wrp">/Per {{$tour['tourperson'] === 'one' ? '' : $tour['tourperson']}} Person</span></div>
                    <div class="tour-book-btn"><a href="{{$tour['tourbtnlink']??''}}" class="booking-btn">{{$tour['tourbtnlbl'] ? $tour['tourbtnlbl'] : 'BOOK THIS TOUR'}}</a></div>
                  </div>
                </div>
              </div>
            </div>

        @endforeach
          </div>
        </div>
      </div>
    </div>
</section>
@endif