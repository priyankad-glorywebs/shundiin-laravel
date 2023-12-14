<section class="discover">
                    <div class="container">
                        <div class="row">
                                <div class="col-12">
                                <h2></h2>
                            </div>
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
                                                                    <a href="{{asset($cat['slug'])}}" rel="tag" class="{{$cat['slug']}}">{{$cat['name']}}</a>
                                                                </h3>  
                                                            </div>
                                                            @endforeach
                                                            <h3>{{$value->title}}</h3>
                                                            @php 
                                                            $test =  get_post_description($value->id);
                                                            @endphp
                                                            <p>{{$test[0]['meta_description']}}</p>
                                                            <div class="tour-meta">
                                                            </div>
                                                            <span class="uabb-read-more-text">
                                                            <a href="{{asset($value->slug)}}" title="Learn More">Learn More</a>
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