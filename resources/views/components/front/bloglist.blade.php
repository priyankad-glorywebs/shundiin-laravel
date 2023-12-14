@php
$data  = getallPost();

@endphp

{{--@foreach($data as $key => $value)

@endforeach--}}

<style>
    .bloglist .blog-category h3 a {
    font-family: Poppins,sans-serif;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 2px;
    padding: 2px 15px;
    border: 1px solid #C86724;
    color: #C86724;
    transition: all 0.5s ease;
    }
    .bloglist .uabb-read-more-text a {
    font-family: Poppins,sans-serif;
    font-weight: 400;
    font-size: 15px;
    line-height: 24px;
    text-align: left;
    text-transform: capitalize;
    color: #C86724;
}
.bloglist .fl-post-grid-post:hover .blog-category .uabb-read-more-text a:after {
    background: #C86724;
    color: #fff;
    border: 1px solid #C86724;
}
    </style>

<style>
    .fl-node-jf5x1gi2nbo3 {
        width: 65.28%;
    }
    .fl-col {
    float: left;
    min-height: 1px;
}
.fl-builder-content *, .fl-builder-content *:before, .fl-builder-content *:after{
    box-sizing: border-box;
}
.fl-node-jrkegyq08zhl>.fl-col-content{
    padding-right: 25px;
    padding-bottom: 20px;
    padding-left: 25px;
}
.fl-node-jrkegyq08zhl>.fl-col-content {
    margin-right: 25px;
    margin-left: 35px;
}
.fl-node-jrkegyq08zhl>.fl-col-content {
    margin-right: 25px;
    margin-left: 35px;
}
.fl-node-jrkegyq08zhl>.fl-col-content {
    background-color: #fafafa;
    border-style: solid;
    border-width: 0;
    background-clip: border-box;
    border-color: #f6f6f6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
}
.fl-col-content {
    padding-top: 0;
    padding-right: 0;
    padding-bottom: 0;
    padding-left: 0;
}

element.style {
}
.fl-node-jrkegyq08zhl>.fl-col-content {
    padding-right: 25px;
    padding-bottom: 20px;
    padding-left: 25px;
}
.fl-node-jrkegyq08zhl>.fl-col-content {
    margin-right: 25px;
    margin-left: 35px;
}
.fl-node-jrkegyq08zhl>.fl-col-content {
    background-color: #fafafa;
    border-style: solid;
    border-width: 0;
    background-clip: border-box;
    border-color: #f6f6f6;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
}
.fl-col-content {
    padding-top: 0;
    padding-right: 0;
    padding-bottom: 0;
    padding-left: 0;
}
.fl-col-content {
    margin-top: 0;
    margin-right: 0;
    margin-bottom: 0;
    margin-left: 0;
}
.categories_namelists .widget.widget_categories li a {
    font-family: Poppins,sans-serif;
    font-weight: 400;
    font-size: 18px;
    line-height: 42px;
    color: #262626;
    margin-left: 15px;
}


.categories_namelists .widget.widget_categories li a {
    font-family: Poppins,sans-serif;
    font-weight: 400;
    font-size: 18px;
    line-height: 42px;
    color: #262626;
    margin-left: 15px;
}
a:hover, a:focus {
    color: #2b7bb9;
}
a:hover, a:focus {
    color: #23527c;
    text-decoration: underline;
}
a:active, a:hover {
    outline: 0;
}
.fl-builder-content *, .fl-builder-content *:before, .fl-builder-content *:after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
a {
    color: #2b7bb9;
}
a {
    color: #337ab7;
    text-decoration: none;
}
a {
    background-color: transparent;
}

.categories_namelists .fl-widget ul li {
    list-style-type: circle;
    display: list-item;
    font-size: 20px !important;
    color: #C86724 !important;
    margin-left: 10px;
}

</style>


<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="fl-col fl-node-jrkegyq08zhl fl-col-small fl-col-small-custom-width" data-node="jrkegyq08zhl">

   
        <div class="fl-col fl-col-small" data-node="jrkegyq08zhl">
        <div class="fl-col-content fl-node-content">
            <!-- Your loop for posts goes here -->
            <div id="postsContainer">
                <section class="discover" >
                    <div class="container">
                        <div class="row">
                              
                                <h2>BLOG SHUN'DIIN CANYON TOURS</h2>
                            <div class="col-6"></div>
                            <div class="discover-tour">
                                    <div class="row">
                                        @foreach($data as $key => $value)
                                            <div class="col-12 col-md-6 col-xl-4 my-2 p-2">
                                                <div class="card bloglist">
                                                    <div class="card-img">
                                                        <img src="{{asset($value->thumbnail)}}" alt="" class="img-fluid">
                                                    </div>
                                                    <div class="card-body">
                                                            @foreach($value->json_taxonomies as $cat) 
                                                            <div class="blog-category">  
                                                                <h3 class="uabb-post-meta uabb-blog-post-section">
                                                                    <a  rel="tag" class="{{$cat['slug']}}">{{$cat['name']}}</a>
                                                                </h3>  
                                                            </div>
                                                            @endforeach
                                                            <h3><a style="color:black;" href="{{$value->slug}}">{{$value->title}}</a></h3>
                                                            @php 
                                                            $test =  get_post_description($value->id);
                                                            @endphp
                                                            <p>{{$test[0]['meta_description']}}</p>
                                                            <div class="tour-meta">
                                                            </div>
                                                            <span class="uabb-read-more-text">
                                                            <a href="{{$value->slug}}" title="Learn More">Learn More</a>
                                                            <!-- <a href="{{--route('details',$value->id)--}}" title="Learn More">Learn More</a> -->
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                               </div>
                                {{-- $data->links() --}}
                        </div> 
                    </div>
                </section>
                </div>
              
                <!-- end -->
            </div>
           
        </div>
     

        <!-- Right Content (Categories) -->
        <section class="discover">
                        <div class="container">
                            <div class="row">
                    <div class="fl-col fl-col-small" data-node="ja23oscnhmy1">
                        <div class="">
                            <div class="fl-widget">
                                <!-- Your categories widget goes here -->
                                <div class="fl-col fl-node-jrkegyq08zhl fl-col-small fl-col-small-custom-width" data-node="jrkegyq08zhl">
                                    {{--<div class="fl-col-content fl-node-content"><div class="fl-module fl-module-widget fl-node-aud985yn2hv0 categories_namelists" data-node="aud985yn2hv0">
                                        <div class="fl-module-content fl-node-content">
                                            <div class="fl-widget">
                                                <div class="widget widget_search"><h2 class="widgettitle">Search</h2>
                                                    <form aria-label="Search" method="get" role="search" action="https://www.antelopelowercanyon.com/" title="Type and press Enter to search.">
                                                        <input aria-label="Search" type="search" class="fl-search-input form-control" name="s" placeholder="Search" value="" onfocus="if (this.value === 'Search') { this.value = ''; }" onblur="if (this.value === '') this.value='Search';">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}
                                        {{--<div class="fl-module fl-module-widget fl-node-ja23oscnhmy1 categories_namelists" data-node="ja23oscnhmy1">
                                            <div class="fl-module-content fl-node-content">
                                                <div class="fl-widget">
                                                    <div class="widget widget_categories"><h2 class="widgettitle">Categories</h2>
                                                        <ul>
                                                            @php
                                                            $categoryList = getpostCategory();
                                                            @endphp
                                                            @foreach($categoryList as $key => $cat_list)
                                                            <li class="cat-item cat-item-1 categorydata" id="{{$cat_list->slug}}"><a>{{$cat_list->name}}</a>
                                                            </li>
                                                            @endforeach
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>--}}
                                    </div>
                                </div>
                                <!-- end -->
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </section>
    

    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

<script>
// $(document).ready(function () {
//     $(document).on("click", '.categorydata', function () {
//         let categorySlug = $(this).attr('id');
//         $.ajax({
//             url: '{{--route("categoryslug")--}}', 
//             type: 'post', 
//             data: { categorySlug: categorySlug,   _token: $('meta[name="csrf-token"]').attr('content'),
//        },
//             success: function (data) {
//                     $('.discover').html('');
//                     $('#postsContainer').html('');
//                 console.log(data);
//                 $('#TEST').html(data.html)
//             },
//             error: function (error) {
//                 console.error('AJAX request error:', error);
//             }
//         });
//     });
// });

 
</script>
