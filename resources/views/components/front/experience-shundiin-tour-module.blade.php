@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp
@if ($moduleStatus == true && $moduleData != null)
<div class="layout">
    <section class="video-section" style="height: 246px;">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="banner-content text-center">
              <h1 class="banner-main-title">{{$moduleData['eshead']}}</h1>
              <div class="video-inner">
                <div class=" module">
                  <div class="mwembed">
                    <div class="iframe-video">
                      <iframe width="{{$moduleData['eswidth']?$moduleData['eswidth']:'100%'}}" height="{{$moduleData['esheight']}}" src="{{$moduleData['eslink']??''}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="video-box-section"></section>
  </div>
@endif