@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
    $tour_data = get_tours_data($moduleData['tourname']);
    if(isset($moduleData['btnlink']) && $moduleData['btnlink'] !== ''){
        $btnlink = str_replace(' ', '-', $moduleData['btnlink']);
    } else {
        $btnlink = str_replace(' ','-',strtolower($moduleData['tourname']));  
    }
    $generalSetting = get_general_settings();
    $gs_phone       = '';
    $gs_email       = '';
    if(!empty($generalSetting)){
      if(isset($generalSetting['gs_phone'])){
          $gs_phone       = $generalSetting['gs_phone'];
      }
      if(isset($generalSetting['gs_email'])){
          $gs_email       = $generalSetting['gs_email'];
      }
    }
    // dd($moduleData);
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="tour-detail-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="tour-detail-leftcontent">
                    <div class="row overview-row mb-4">
                        <div class="col-12">
                            <div class="detail-icon-sec">
                                <div class="content-container">
                                    <div class="icon-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><g><path d="M50,17.8c-17.7,0-32.2,14.4-32.2,32.2c0,17.7,14.4,32.2,32.2,32.2c17.7,0,32.2-14.4,32.2-32.2C82.2,32.3,67.7,17.8,50,17.8 z M50,80.1c-16.6,0-30.1-13.5-30.1-30.1c0-16.6,13.5-30.1,30.1-30.1c16.6,0,30.1,13.5,30.1,30.1C80.1,66.6,66.6,80.1,50,80.1z"></path><rect x="47.9" y="71.6" width="4.2" height="4.2"></rect><rect x="47.9" y="24.2" width="4.2" height="4.2"></rect><rect x="71.6" y="47.9" width="4.2" height="4.2"></rect><rect x="24.2" y="47.9" width="4.2" height="4.2"></rect><polygon points="69.5,35 51.1,47.9 48.9,47.9 35,37.7 33.8,39.4 47.9,49.8 47.9,52.1 52.1,52.1 52.1,49.8 70.7,36.7 	"> </polygon> </g> </svg>
                                    </div>
                                    <p class="text-container">{{$moduleData['tourtime']}}</p>
                                </div>
                                <div class="content-container">
                                    <div class="icon-container"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"> <g> <path d="M50,29.7c-21,0-38.1,17.1-38.1,38.1V69h27v-1.2c0-6.1,5-11,11.1-11c2.6,0,5,0.9,6.9,2.5l-6.3,6.3c-0.2-0.1-0.4-0.1-0.6-0.1 c-1.4,0-2.5,1.1-2.5,2.5c0,1.4,1.1,2.5,2.5,2.5c1.4,0,2.5-1.1,2.5-2.5c0-0.2-0.1-0.4-0.1-0.6l6.3-6.3c1.5,1.9,2.5,4.3,2.5,6.9V69 h27v-1.2C88.1,46.8,71,29.7,50,29.7z M63.5,66.6c-0.3-2.8-1.4-5.3-3.1-7.4L72.6,47l-1.7-1.7L58.6,57.5c-2.3-2-5.3-3.2-8.6-3.2 c-7,0-12.8,5.4-13.5,12.3H14.4C15.1,47.5,30.8,32.2,50,32.2c19.2,0,34.9,15.3,35.6,34.4H63.5z"> </path> <rect x="48.8" y="37.1" width="2.5" height="12.3"></rect> <rect x="31.4" y="44.3" trans="" width="2.5" height="12.3"></rect> </g> </svg>
                                    </div>
                                    <p class="text-container">{{$moduleData['tourscale']}}</p>
                                </div>
                            </div>
                            <div class="overview-box">
                                <h2>{{$moduleData['sechead']}}</h2>
                                {!!html_entity_decode($moduleData['secdesc'])!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-5">
                <div class="button-box">
                    <div class="price">${{$tour_data['tourprice']??''}} <span>/Per {{$tour_data['tourperson'] === 'one' ? '' : $tour_data['tourperson']}} Person</span></div>
                    <button type="button" class="tour-inner-booking"><a href="{{isset($btnlink) ? url($btnlink) : '#'}}" class="text-white">Book This Tour</a></button>
                    <h3 class="title">Have Questions?</h3>
                    <p class="box-paragraph first-pg"> Call us at : <a href="tel:{{$gs_phone??''}}">{{ $gs_phone??''}}.</a></p>
                    <p class="box-paragraph">We’re open 7 days a week, check our <span>office hours.</span></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif