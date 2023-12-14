@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)

<section class="my-5">
        <div class="row">
            <div class="slick-gallery p-0 m-0" id="gallery">
            
            @foreach ($moduleData['document'] as $image)

                <a href="{{asset('storage/photos/'.$image)}}" data-fancybox="gallery" data-caption="{{$image}}">
                    <img src="{{asset('storage/photos/'.$image)}}" alt="{{$image}}">
                </a>
                
            @endforeach

            </div>
        </div>
</section>

<style>
    body{
        overflow-x: hidden;
        overflow-y: scroll;
    }
    .slick-gallery {
        max-width: 99%;
    }
    .slick-gallery img {
        padding: 0 10px;
        height: 300px;
        border-radius: 24px;
        object-fit: cover;
    }

    .slick-gallery .slick-next {
        right: 45px;
        z-index: 99;
    }

    .slick-gallery .slick-prev {
        left: 45px;
        z-index: 99;
    }
    /* .lg-outer {
        background: black;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 99999;
    } */
</style>

@endif