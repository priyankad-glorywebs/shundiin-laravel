@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
    $generalSetting = get_general_settings();
    $gs_phone       = '';
    if(!empty($generalSetting)){
        if(isset($generalSetting['gs_phone'])){
            $gs_phone       = $generalSetting['gs_phone'];
        }
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="calltoaction">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h5>{{$moduleData['hqsubhead']}}</h5>
                <h2>{{$moduleData['hqhead']}}</h2>
                <h5 class="mb-3">Call us at : {{$gs_phone}}. {{$moduleData['hqdesc']}}</h5>
                <div class="cta-seperator">
                    <span> OR </span>
                </div>
                @if (isset($moduleData['sourcebtnstatus']) && $moduleData['sourcebtnstatus'] == '1' && isset($moduleData['hqbtnlbl']))  
                <div class="grd-btn position-relative d-inline-block">
                    <a href="{{$moduleData['hqbtnlink']??'#'}}" class="btn btn-primary">{{$moduleData['hqbtnlbl']??''}}</a>
                </div>
                @endif
            </div>
        </div>
    </div>
  </section>
@endif