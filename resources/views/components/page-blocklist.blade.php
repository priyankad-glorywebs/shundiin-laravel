<div class="page-block-content">
    @php
        $moduleArr = array(
            'testimonial-module'        =>  'Testimonial Section',
            'faq-module'                =>  'FAQ Section',
            'contact-us-module'         =>  'Contact Section',
            'banner-module' =>  'Banner Module',
            "about-img-left-module" =>  "About Shun'diin Tour Image Left Section",
            "about-img-right-module" =>  "About Shun'diin Tour Image Right Section",
            "discover-tour-slider-module" =>  "Discover Tours Slider Section",
            "have-question-module" => "Have Questions Section",
            "why-shundiin-module" => "Why Shun'Diin Section",
            "experience-shundiin-tour-module" => "Experience Shun'Diin Tour Section",
            "contact-form-module" => "Contact Form Section",
            "image-slider-module" => "Image Slider Section",
            "gallery-module" => "Gallery Section",
            "what-expect-lower-antelope-module" => "What To Expect From Lower Antelope Section",
            "things-to-know-module" => "Things To Know Section",
            "tour-overview-module" => "Tour Overview Section",
            "tour-inner-gallery-module" => "Tour Inner Gallery Section",
        );
    @endphp
    @php
        // $moduleArr = App\Models\Module::get()->toArray();
        // dd($blockData);
        // dd($moduleArr);
        
    @endphp
    <div id="page-block-builder-nestable-{{ $entities['idContent'] }}" class="dd jw-widget-builder">
        <ol class="dd-list">
            @if(!empty($blockData))
                @php 
                $blockDataInfo = json_decode($blockData, true);
                @endphp
                @foreach ($blockDataInfo as $bkey => $block)
                    @if( $block != 'default')
                        @foreach ($block['content'] as $bkey => $blockVal)
                            @component('components.page_block_item', [
                                'data' => $entities,
                                'key' => $bkey,
                                'block' => $moduleArr[$blockVal['block']],
                                'valueKey' => $blockVal['block'],
                                'contentKey' => 'content',
                                'ShortcodeValue' => $blockVal['shortcode'],
                            ])
                            @endcomponent
                        @endforeach
                    @else
                    {{-- <div class="dd-empty"></div> --}}
                    @endif
                @endforeach
            @endif
        </ol>
        @if(empty($blockData))
        <div class="dd-empty"></div>
        @endif
    </div>
    

    <div class="widget-button w-100 text-center">
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton-{{ $entities['idContent'] }}"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans('Add Block') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{$entities['idContent'] }}">
                {{-- {{dd($moduleArr)}} --}}
                 @foreach($moduleArr as $bkey => $b)
                    <a
                        href="javascript:void(0)"
                        class="dropdown-item add-block-data"
                        data-block="{{ $bkey }}"
                        data-key="{{ $entities['idContent'] }}"
                        data-content_key="{{ 'content' }}"
                    >{{ $b }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@foreach($moduleArr as $bkey => $block)
    <template id="block-{{ $bkey }}-template">
        @component('components.page_block_item', [
            'data' => $entities,
            'key' => '{marker}',
            'block' => $block,
            'valueKey' => $bkey,
            'contentKey' => '{content_key}',
            'ShortcodeValue' => '',
        ])
        @endcomponent
    </template>
@endforeach