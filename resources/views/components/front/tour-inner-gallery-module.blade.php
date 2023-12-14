@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
    // dd($moduleData['document'][0]);
@endphp 
@if ($moduleStatus == true && $moduleData != null)

<section class="tour-detail-section">
    <div class="container">
        <div class="row cautionary-row mb-4">
            <div class="col-12 col-lg-8">
                <h2>{{$moduleData['sechead']}}</h2>

                <div id="gallery" class="row">

                    @for ($i = 0; $i < count($moduleData['document']); $i++)
                        @if ($i === 0)
                            <div class="col-md-6 px-1 left-image-box">
                                <a href="{{('public/storage/photos/'.$moduleData['document'][$i])}}" data-fancybox="gallery" data-caption="{{$moduleData['document'][$i]}}">
                                    <img src="{{asset('storage/photos/'.$moduleData['document'][$i])}}" alt="{{$moduleData['document'][$i]}}">
                                </a>
                            </div>
                        @elseif ($i === 1)
                            <div class="col-md-6 px-1 right-image-box">
                                <a href="{{('public/storage/photos/'.$moduleData['document'][$i])}}" data-fancybox="gallery" data-caption="{{$moduleData['document'][$i]}}">
                                    <img src="{{asset('storage/photos/'.$moduleData['document'][$i])}}" alt="{{$moduleData['document'][$i]}}">
                                </a>
                        @elseif ($i > 1)
                            <a href="{{('public/storage/photos/'.$moduleData['document'][$i])}}" data-fancybox="gallery" data-caption="{{$moduleData['document'][$i]}}">
                                <img src="{{asset('storage/photos/'.$moduleData['document'][$i])}}" alt="{{$moduleData['document'][$i]}}">
                            </a>
                        @elseif ($i === count($moduleData['document']))
                                <a href="{{('public/storage/photos/'.$moduleData['document'][$i])}}" data-fancybox="gallery" data-caption="{{$moduleData['document'][$i]}}">
                                    <img src="{{asset('storage/photos/'.$moduleData['document'][$i])}}" alt="{{$moduleData['document'][$i]}}">
                                </a>
                            </div>
                        @endif
                    @endfor

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .left-image-box a{
        width: 100%;
        height: 390px;
    }
    .left-image-box img{
        max-width: 390px;
        max-height: 390px;
        width: 100%;
        height: 100%;
    }
    .right-image-box {
        max-height: 384px;
    }
    .right-image-box a{
        max-width: 45%;
        /* float: left; */
        margin: 0px 4px 8px 0px;
    }
    .right-image-box img{
       width: 180px;
       height: 190px;
       max-height: 190px;
       max-width: 100%;
    }
</style>

@endif