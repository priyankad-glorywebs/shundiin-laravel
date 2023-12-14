@php
	$url = request()->path();
	$separated = preg_split("#/#", $url); 
	$separated = str_replace('-', ' ', $separated[0]);	
@endphp
<section class="tour-breadcrub breadcrub-section" >
    <div class="container">
      	<div class="row">
      		<nav aria-label="breadcrumb ">
        		<ol class="breadcrumb p-0 m-0 border-bottom">
					<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>

				{{-- @foreach ($separated as $item) --}}
					<li class="breadcrumb-item active">{{ucfirst($separated)}}</li>
					
				{{-- @endforeach --}}	

						
        		</ol>
      		</nav>
			 
    	</div>
		<div class="row">
		@if($url == "blog")
		@component('components.front.bloglist')
        @endcomponent
		@endif	
		</div>
    </div>
  </section>


