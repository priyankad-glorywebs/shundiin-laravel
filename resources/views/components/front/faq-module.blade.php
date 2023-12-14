@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="tour-detail-section faq-section">
    <div class="container">
        <div class="row faqs-row mb-4">
            <div class="col-12 col-lg-8">
                <div class="faqs-box">
                    <h2>{{$moduleData['faqheading']}}</h2>
                    <div class="accordion" id="accordionExample">

                    @foreach ($moduleData['faqmodule'] as $faq)

                        <div class="accordion-item">
                            <button class="accordion-button {{$loop->index+1 == 1 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->index+1}}" aria-expanded="{{$loop->index+1 == 1 ? 'true' : 'false'}}" aria-controls="collapse{{$loop->index+1}}">{{$faq['q1']?$faq['q1']:'Question?'}}</button>
                            <div id="collapse{{$loop->index+1}}" class="accordion-collapse overview-box collapse {{$loop->index+1 == 1 ? 'show' : ''}}" aria-labelledby="heading{{$loop->index+1}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!!html_entity_decode($faq['a1'])!!}
                                </div>
                            </div>
                        </div>

                    @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif