@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
    <section class="tour-detail-section">
        <div class="container">
            <div class="row ltinerary-row mb-4">
                <div class="col-12 col-lg-8">
                    <h2>{{$moduleData['sechead']}}</h2>
                    <div class="ltinerary-box">
                        <h3 class="mt-3">{{$moduleData['secsubhead']}}</h3>
                        {!!html_entity_decode($moduleData['secdesc'])!!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif