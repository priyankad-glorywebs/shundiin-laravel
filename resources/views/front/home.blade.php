@extends('layouts.front-master')
 @section('content')
    @php
        $pageId = null;
        $pageTitle = null;
        $postIsBlockOrNot = null;
        $postContent = null;
        $postImage = null;
        if (isset($postData)) {
            
            $pageId = $postData['pageData'][0]->id;
            $pageTitle = $postData['pageData'][0]->title;
            $postIsBlockOrNot = $postData['pageData'][0]->json_metas;
            $postIsBlockOrNotStatus = $postData['pageData'][0]->templateStatus;
            $postContent = $postData['pageData'][0]->content;
            $postImage = $postData['pageData'][0]->thumbnail;
            $postImage = !empty($postImage) ? $postImage : null;
        }
     

        $Content = str_replace('&amp;', '', $postContent);
       

        // if (!empty($postContent)) {
        //     $Content = str_replace('&amp;', '', $postContent);
        //     $doc = new DOMDocument();
        //     $doc->loadHTML(html_entity_decode($Content, ENT_HTML5));
        //     $tags = $doc->getElementsByTagName('img');
        //     foreach ($tags as $tag) {
        //         $old_src = $tag->getAttribute('src');
        //         $new_src_url = 'storage/' . $old_src;
        //         $tag->setAttribute('src', $new_src_url);
        //         $tag->setAttribute('data-src', $old_src);
        //     }
        //     $postContent = $doc->saveHTML();
         //}
        $generalSetting = get_general_settings();
        $siteURL = '';
        if (!empty($generalSetting)) {
            if (isset($generalSetting['gs_ficon'])) {
                $siteURL = $generalSetting['gs_site_url'];
                $siteURL = $siteURL ? $siteURL : '';
            }
        }
    @endphp

    @if (str_contains($postIsBlockOrNotStatus, 'default') == true)
        @if ($pageTitle != 'Home' && $pageTitle != $siteURL && $pageTitle != 'homepage')
            <section class="faq-section contact-us">
                <div class="container">
                    <div class="row">
                        
                        {{-- <div class="col-12">
                            <div class="breadcrumb justify-content-between align-items-center">
                                <div class="breadcrumb-title">{{ ucfirst($pageTitle) }}</div>
                                <div class="breadcrumb-path">
                                    <ul class="d-flex align-items-center">
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li>{{ ucfirst($pageTitle) }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </section>
        @endif
        <!-- START BLOCK MODULE -->
        @php
            $postBlockData = json_decode($postIsBlockOrNot, true);
            $blockArr = $postBlockData['block_content']['content'];
            $i = 0;
        @endphp
        @while ($i < count($blockArr))
            @component('components.front.' . $blockArr[$i]['block'], [
              
                'data' => $blockArr[$i],
            ])
            @endcomponent

            @php
                $i++;
            @endphp
        @endwhile
        <!-- END BLOCK MODULE -->
    @else
        {{-- <section class="faq-section contact-us">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb justify-content-between align-items-center">
                            <div class="breadcrumb-title">{{ ucfirst($pageTitle) }}</div>
                            <div class="breadcrumb-path">
                                <ul class="d-flex align-items-center">
                                    @if ($pageTitle != 'Home' && $pageTitle != 'home' && $pageTitle != 'homepage')
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li>{{ ucfirst($pageTitle) }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 p-0">
                        <div class="content-wrp">
                            @if ($postImage != null)
                                <div class="feature-img">
                                    <img src="{{ $postImage }}" alt="" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
    <section class="blog-detail-sec">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12 order-2 order-lg-1">
                        <div class="blog-detail-wrap">
                            {!! html_entity_decode($postContent) !!}
                        </div>
                    </div>
                    {{--<div class="col-12 col-lg-4 order-1 order-lg-2">
                        <div class="blog-detail-sidebar">
                            
                        </div>                        
                    </div>--}}
                </div>
            </div>
        </section>


    @endif
@endsection
