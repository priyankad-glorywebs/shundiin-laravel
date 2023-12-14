<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta http-equiv="Cache-control" content="public">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Page Title -->
    @php 
        $generalSetting = get_general_settings();
        $siteLogo       = '';
        $siteficon      = '';
        $siteTitle      = '';
        if(!empty($generalSetting)){
            if(isset($generalSetting['gs_ficon'])){
                $siteURL         = $generalSetting['gs_site_url'];
                $siteURL         = $siteURL ? $siteURL : '';
                
                $siteLogo        = $generalSetting['gs_sitelogo'];
                $siteLogo        = $siteLogo ? $siteLogo : '';

                $siteficon       = $generalSetting['gs_ficon'];
                $siteficon       = $siteficon ? $siteficon : 'frontend-assets/images/favicon.png';

                $siteTitle       = $generalSetting['gs_sitetitle'];
                $siteTitle       = $siteTitle ? $siteTitle : '';
               
                $sitePhone       = $generalSetting['gs_phone'];
                $sitePhone       = $sitePhone ? $sitePhone : '';
                
                $siteEmail       = $generalSetting['gs_email'];
                $siteEmail       = $siteEmail ? $siteEmail : '';
                /* SOCIAL LINKS*/
                $siteFblink      = $generalSetting['gs_fblink'];
                $siteFblink      = $siteFblink ? $siteFblink : '';
                $siteInstalink   = $generalSetting['gs_instalink'];
                $siteInstalink   = $siteInstalink ? $siteInstalink : '';
                $sitegmlink      = $generalSetting['gs_gmaplink'];
                $sitegmlink      = $sitegmlink ? $sitegmlink : '';
                $siteaddress      = $generalSetting['gs_addressinfo'];
                $siteaddress      = $siteaddress ? $siteaddress : '';
                // $siteTlink       = $generalSetting['gs_tlink'];
                // $siteTlink       = $siteTlink ? $siteTlink : '';
                // $siteYlink       = $generalSetting['gs_ylink'];
                // $siteYlink       = $siteYlink ? $siteYlink : '';
                
                $siteCopyright   = $generalSetting['gs_copyinfo'];
                $siteCopyright   = $siteCopyright ? $siteCopyright : '';
            }
        }
        @endphp
    @php 
    $pageId = 0;
    $meta_title         = null;
    $meta_description   = null;
    $pageSlug           = null;
    if(isset($postData)){
        $pageId = $postData['postId'];
        if(isset($postData['pageData'])){
            if(isset($postData['pageData'][0])){
                $meta_title         = $postData['pageData'][0]->meta_title;
                $meta_description   = $postData['pageData'][0]->meta_description;
                $pageSlug           = $postData['pageData'][0]->slug;
            }
        }
    }
    @endphp
    @if(isset($postData))
        @if(isset($meta_title))
        <title>{{$meta_title}} - {{$siteTitle}}</title>
        @else
        <title>{{$postData['postTitle']}} - {{$siteTitle}}</title>
        @endif
    @else
        <title>404 page - {{$siteTitle}}</title>
    @endif
    <!-- Meta Description & Keywords -->
    <meta name="description" content="{{$meta_description}}">
    {{-- <meta name="keywords" content="Tax Sale, tax liens, tax deeds, real estate, Tax Lien Certificates, Tax Foreclosures, Tax Sale Training, Foreclosures, Tax Sale Lists"> --}}
    <!-- Favicon -->
    <link rel="icon" href="{{ asset($siteficon) }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- OWL Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <!-- Bootstrep CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend-assets/css/headerfooter.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend-assets/css/style.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"/>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.3.2/css/lightgallery.css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    {{-- <link type="text/css" rel="stylesheet" href="{{asset('plugins/lightgallery/css/lightgallery-bundle.css')}}" /> --}}
    <link rel="stylesheet" href="https://fh-kit.com/buttons/v2/?orange=d4762d" type="text/css" media="screen">
</head>

<body class="page-id-{{$pageId}} {{$pageSlug}}" 
    {{-- oncontextmenu="return false;" --}}
    >
        <!-- adminbar -->
        @include('common.adminbar')
        <!-- End of adminbar -->
        
        <!-- Topbar -->
        @include('common.front-header')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        @yield('content')
        <!-- /.container-fluid -->

        <!-- Footer -->
        @include('common.front-footer')
        <!-- End of Footer -->
    
        <div class="scrolltop-wrap">
            <a id="to-top" href="javascript:void(0);" role="button" aria-label="Scroll to top">
                <svg height="48" viewBox="0 0 48 48" width="48" height="48px" xmlns="http://www.w3.org/2000/svg">
                    <path id="scrolltop-bg" d="M0 0h48v48h-48z"></path>
                    <path id="scrolltop-arrow" d="M14.83 30.83l9.17-9.17 9.17 9.17 2.83-2.83-12-12-12 12z"></path>
                </svg>
            </a>
        </div>

        <style>
            html {
                scroll-behavior: smooth;
            }

            body {
                position: relative;
            }
            .scrolltop-wrap {
                box-sizing: border-box;
                position: absolute;
                top: 12rem;
                right: 2rem;
                bottom: 0;
                pointer-events: none;
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                z-index: 1111;
            }

            .scrolltop-wrap a {
                position: fixed;
                position: sticky;
                top: -5rem;
                width: 2.5rem;
                height: 2.5rem;
                margin-bottom: -5rem;
                transform: translateY(100vh);
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                display: inline-block;
                text-decoration: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                pointer-events: all;
                outline: none;
                overflow: hidden;
            }

            .scrolltop-wrap a svg {
                display: block;
                border-radius: 20%;
                width: 100%;
                height: 100%;
            }

            svg:not(:root) {
                overflow: hidden;
            }

            .scrolltop-wrap #scrolltop-bg {
                /* fill: #07225d; */
                fill: #c8662956;
            }

            .scrolltop-wrap:hover #scrolltop-bg {
                /* fill: #07225d; */
                fill: #c86629;
            }

            .scrolltop-wrap a svg path {
                transition: all 0.1s;
            }

            .scrolltop-wrap a #scrolltop-arrow {
                transform: scale(0.66);
                transform-origin: center;
            }

            .scrolltop-wrap #scrolltop-arrow {
                fill: white;
            }

            .scrolltop-wrap a svg path {
                transition: all 0.1s;
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Owl Carousel JS -->
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> --}}

        <!-- Main jquery JS -->
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> --}}
        <!-- Bootstrap JS -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
        <!-- Owl Carousel JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <!-- Custom JS -->
        {{-- <script src="{{ asset('frontend-assets/js/custom.js') }}"></script> --}}
        <!-- Touch Start jQuery -->

        <script>
            jQuery(document).ready(function ($) {

                jQuery('.tour-slider-wrap').owlCarousel({
                    autoPlay: false,
                    items:4,
                    loop:false,
                    mouseDrag  : false,
                    // margin:30,
                    // autoWidth:true,
                    dots:false,
                    nav:true,
                    navText : ["<img src='{{asset('/frontend-assets/images/travel-arrow-left.svg')}}' alt='Arrow'>", "<img src='{{asset('/frontend-assets/images/travel-arrow-right.svg')}}' alt='Arrow'>"],
                    margin: 10,
                    responsive: {
                        0: {
                            items: 1,
                            autoWidth:false,
                        },
                        600: {
                            items: 2,
                            autoWidth:false,
                        },
                        1000: {
                            items: 3,
                            autoWidth:false,
                        }
                    }
                });
                // travel Slider
                $('.why-our-tour').owlCarousel({
                    autoPlay: false,
                    items:4,
                    loop:false,
                    margin:30,
                    mouseDrag  : false,
                    autoWidth:true,
                    dots:false,
                    nav:true,
                    navText: ["<img src='{{asset('/frontend-assets/images/travel-arrow-left.svg')}}' alt='Arrow'>", "<img src='{{asset('/frontend-assets/images/travel-arrow-right.svg')}}' alt='Arrow'>"],
                    responsive:{
                        0:{
                            items:1,
                            autoWidth:false,  
                        },
                        768:{
                            items:3,
                            autoWidth:true,  
                        },
                    }
                }); 
                $('.testimonial-slider').owlCarousel({
                    autoPlay: false,
                    items:1,
                    loop:true,
                    margin:30,
                    autoWidth:false,
                    dots:false,
                    nav:true,
                    navText: ["<img src='{{asset('/frontend-assets/images/slider-left.svg')}}' width='41px' height='41px' alt='Arrow'>", "<img src='{{asset('/frontend-assets/images/slider-right.svg')}}' width='41px' height='41px' alt='Arrow'>"],
                    responsive:{
                        0:{
                            items:1,
                            autoWidth:false,  
                        },
                        768:{
                            items:1,
                            autoWidth:false,  
                        },
                    }
                });

                if(window.location.href == '{{url("/")}}/'){
                    $('.home').addClass('active');
                }

                $('.navbar .nav-item .nav-link').each(function(){
                    if($(this).attr('href') == window.location.href){
                        $(this).addClass('active');
                    }
                })
            });
        </script>

        @include('layouts.front.font-functions')
        <script>
            jQuery(document).ready(function($) {
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 100) {
                        $('#to-top').fadeIn();
                    } else {
                        $('#to-top').fadeOut();
                    }
                });
                $('#to-top').click(function() {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 600);
                    return false;
                });
            });
            jQuery.event.special.touchstart = {
                setup: function(_, ns, handle) {
                    this.addEventListener("touchstart", handle, {
                        passive: !ns.includes("noPreventDefault")
                    });
                }
            };
        </script>

        {{-- <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script> --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.3.2/js/lightgallery.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
        
        <script src="https://fareharbor.com/embeds/api/v1/?autolightframe=yes"></script>

        <script>
            $(document).ready(function(){
                
                $('.slick-gallery').slick({
                    centerMode: true,
                    centerPadding: '0px',
                    variableWidth: true,
                    slidesToShow: 5,
                    slidesToScroll : 1,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    dots: false,
                    infinite : true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '0px',
                                slidesToShow: 3
                            }
                        }, {
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '0px',
                                slidesToShow: 2
                            }
                        }, {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '0px',
                                slidesToShow: 1
                            }
                        }
                    ]
                });

                $('[data-fancybox="gallery"]').fancybox({
                    buttons: [
                        "zoom",
                        "share",
                        "slideShow",
                        "fullScreen",
                        "download",
                        "thumbs",
                        "close"
                    ],
                    animationEffect: "fade",
                    transitionEffect: "slide",
                    loop: true
                    // Add more options as per your requirements
                });

            });
        </script>

<script>
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    
    $(function() {
       /* UPDATE ADMIN PERSONAL INFO */
       $('#contact-form-control').on('submit', function(e) {
          // console.log('formdata ', new FormData(this));
          e.preventDefault();
          $.ajax({
                url: '{{route("post-type.create-contacts")}}',
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                  $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                            //alert(prefix);
                        });
                    } else {
                        $('#contact-form-control')[0].reset();
                        
                    }
                   if(data.status == 1) {
                      //  $("#success").show();
                      $('#success-msg').text(data.msg).show();
                      setTimeout(function() { $("#success-msg").hide(); }, 5000);
                   }
                   else{
                      // $("#error-msg").text(data.msg).show();
                      // setTimeout(function() { $("#error-msg").hide(); }, 5000);
                   }
                }
          });
       });
    });
  </script>
</body>
</html>
