@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="tour-bannar-section">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
    
    @foreach ($moduleData['sliders'] as $slider)
        
        <div class="carousel-item {{$loop->index == 0 ? 'active' : ''}}" data-bs-interval="{{($loop->index+1) * 2000}}">
            <img src="{{asset('storage/photos/'.$slider['tourImageName'])}}" class="d-block w-100" alt="...">
            <div class="carousel-heading">
                <h1>{{$slider['imghead']}}</h1>
            </div>
        </div>

    @endforeach

      </div>
      <button class="carousel-btn carousel-control-prev" type="button" data-bs-target="#carouselExample"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-btn carousel-control-next" type="button" data-bs-target="#carouselExample"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
@endif

@include('components.front.breadcrumb')