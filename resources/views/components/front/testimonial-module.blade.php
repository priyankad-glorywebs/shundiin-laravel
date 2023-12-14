@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="review-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-12">
                <div class="testimonial-slider owl-carousel owl-theme owl-loaded owl-drag">

                @foreach ($moduleData['testimonials'] as $testimonial)
                        
                    <div class="item testimonial-item">
                        <div class="testimonials-wrp">
                            <h2 class="testimonials-main-title">{{$moduleData['tshead']}}</h2>
                        </div>
                        <div class="testimonial-head mb-3 d-flex justify-content-between">
                            <div class="details d-flex align-items-center">
                                <div class="image mr-3">
                                    <img src="{{asset('storage/photos/'.$testimonial['tourImageName'])}}" width="70px" height="70px" alt="Client Testimonial">
                                </div>
                                <div class="rating">
                                    <ul class="star d-flex mb-2">
                                        @if (isset($testimonial['tsstar']) && $testimonial['tsstar'] !== '')
                                            @for ($i = 0; $i < $testimonial['tsstar']; $i++)
                                                <li><img src="{{asset('storage/photos/thumbs/star.png')}}" width="20px" height="19px" alt="Star"></li>
                                            @endfor
                                        @endif
                                    </ul>
                                    <h3 class="testimonial-name">{{$testimonial['tstitle']??''}}</h3>
                                </div>
                            </div>
                            <div class="social-icons">
                                <ul class="socials-all">
                                    <li class="facebook">
                                    <a href="https://www.tripadvisor.com/Attraction_Review-g60834-d25244355-Reviews-Shun_diin_Canyon_Tours-Page_Arizona.html" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="Facebook">
                                        <img src="{{asset('storage/photos/thumbs/tour-trip.png')}}" width="51px" height="51px" alt="Social Icons">
                                    </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p>"{{$testimonial['tsdesc']??''}}"</p>
                    </div>
                @endforeach

                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-12 text-right">
                <img src="{{asset('frontend-assets/images/testimonial-img.jpg')}}" alt="testimonial" class="img-fluid">
              </div>
        </div>
    </div>
</section>
@endif