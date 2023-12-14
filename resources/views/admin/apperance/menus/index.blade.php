@extends('layouts.master')
@section('title') {{$pageDetails['title']}} @endsection
@section('content')
<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">Menus</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                  <li class="breadcrumb-item active">Menus</li>
                  <li class="breadcrumb-item active">Navigation Menus</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->

   <section class="content">
      <div class="row" id="main-row">
		<div class="col-12">
			
			
		<div class="card card-outline card-primary">
			<div class="card-header">
				<div class="content">
					@if(session()->has('success'))
						<div class="alert alert-success alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							{{session('success')}}
						</div>
					@endif
					@if(session()->has('error'))
						<div class="alert alert-danger alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							{{session('error')}}
						</div>
					@endif
					@if(count($menus) > 0)		
					Select a menu to edit: 	
					<form action="{{URL::TO('admin/manage-menus')}}" class="form-inline">
					   <select name="id" class="form-control">
						  @foreach($menus as $menu)
						  @if($desiredMenu != '')
						  <option value="{{$menu->id}}" @if($menu->id == $desiredMenu->id) selected @endif>{{$menu->title}}</option>
						  @else
						  <option value="{{$menu->id}}">{{$menu->title}}</option>
						  @endif
						  @endforeach
					   </select>
					   <button class="btn btn-sm btn-default btn-menu-select">Select</button>
					</form>
					or
					@endif 
					<a href="{{url('admin/manage-menus?id=new')}}">Create a new menu</a>.	
				 </div>
			</div>	
		<div class="card-body">
			<div class="row">
         <div class="col-sm-4 cat-form @if(count($menus) == 0) disabled @endif">
            <h3><span>Add Menu Items</span></h3>
            <div class="card-body">
               <div id="accordion">
                  <div class="card card-primary" id="menu-items">
                     <div class="card-header">
                        <h4 class="card-title w-100">
                           <a class="d-block w-100" href="#categories-list" data-toggle="collapse">Categories <span class="fas fa-caret-down float-right"></span></a>
                        </h4>
                     </div>
                     <div id="categories-list" class="collapse show" data-parent="#accordion" >
                        <div class="card-body">
                           <div class="item-list-body">
                              @foreach($categories as $cat)
                              <p><input type="checkbox" name="select-category[]" value="{{$cat->id}}"> {{$cat->title}}</p>
                              @endforeach
                           </div>
                           <div class="item-list-footer">
                              <label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-categories"> Select All</label>
                              <button type="button" class="float-right btn btn-default btn-sm" id="add-categories">Add to Menu</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card card-primary" id="menu-items">
                     <div class="card-header">
                        <h4 class="card-title w-100">
                           <a class="d-block w-100" href="#posts-list" data-toggle="collapse">Posts <span class="fas fa-caret-down float-right"></span></a>
                        </h4>
                     </div>
                     <div id="posts-list" class="collapse" data-parent="#accordion" >
                        <div class="card-body">
                           <div class="item-list-body">
                              @foreach($posts as $post)
                              <p><input type="checkbox" name="select-post[]" value="{{$post->id}}"> {{$post->title}}</p>
                              @endforeach
                           </div>
                           <div class="item-list-footer">
                              <label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-posts"> Select All</label>
                              <button type="button" id="add-posts" class="float-right btn btn-default btn-sm">Add to Menu</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card card-primary" id="menu-items">
                     <div class="card-header">
                        <h4 class="card-title w-100">
                           <a class="d-block w-100" href="#custom-links" data-toggle="collapse">Custom Links <span class="fas fa-caret-down float-right"></span></a>
                        </h4>
                     </div>
                     <div id="custom-links" class="collapse" data-parent="#accordion" >
                        <div class="card-body">
                           <div class="item-list-body">
                              <div class="form-group">
                                 <label>URL</label>
                                 <input type="url" id="url" class="form-control" placeholder="https://">
                              </div>
                              <div class="form-group">
                                 <label>Link Text</label>
                                 <input type="text" id="linktext" class="form-control" placeholder="">
                              </div>
                           </div>
                           <div class="item-list-footer">
                              <button type="button" class="float-right btn btn-default btn-sm" id="add-custom-link">Add to Menu</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-sm-8 cat-view">
            <h3><span>Menu Structure</span></h3>
            @if($desiredMenu == '')
            <h5>Create New Menu</h5>
            <form method="post" action="{{url('admin/create-menu')}}">
               {{csrf_field()}}
               <div class="row">
                  <div class="col-sm-12">
                     <label>Name</label>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">							
                        <input type="text" name="title" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-sm-6 text-right">
                     <button class="btn btn-sm btn-primary">Create Menu</button>
                  </div>
               </div>
            </form>
         @else
            <div id="menu-content">
               <div id="result"></div>
               <div style="min-height: 240px;">
                  <p>Select categories, pages or add custom links to menus.</p>
                  @if($desiredMenu != '')
                  <ul class="menu ui-sortable" id="menuitems">
                     @if(!empty($menuitems))
                     @foreach($menuitems as $key=>$item)
                     <li data-id="{{$item->id}}">
                        <span class="menu-item-bar"><i class="fa fa-arrows"></i> @if(empty($item->name)) {{$item->title}} @else {{$item->name}} @endif <a href="#collapse{{$item->id}}" class="float-right" data-toggle="collapse"><i class="fas fa-caret-down"></i></a></span>
                        <div class="collapse" id="collapse{{$item->id}}">
                           <div class="input-box">
                              <form method="post" action="{{url('admin/update-menuitem')}}/{{$item->id}}">
                                 {{csrf_field()}}
                                 <div class="form-group">
                                    <label>Link Name</label>
                                    <input type="text" name="name" value="@if(empty($item->name)) {{$item->title}} @else {{$item->name}} @endif" class="form-control">
                                 </div>
                                 @if($item->type == 'custom')
                                 <div class="form-group">
                                    <label>URL</label>
                                    <input type="text" name="slug" value="{{$item->slug}}" class="form-control">
                                 </div>
                                 <div class="form-group">
                                    <input type="checkbox" name="target" value="_blank" @if($item->target == '_blank') checked @endif> Open in a new tab
                                 </div>
                                 @endif
                                 <div class="form-group">
                                    <button class="btn btn-sm btn-primary">Save</button>
                                    <a href="{{url('admin/delete-menuitem')}}/{{$item->id}}/{{$key}}" class="btn btn-sm btn-danger">Delete</a>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <ul>
                           @if(isset($item->children))
                           @foreach($item->children as $m)
                           @foreach($m as $in=>$data)
                           <li data-id="{{$data->id}}" class="menu-item">
                              <span class="menu-item-bar"><i class="fa fa-arrows"></i> @if(empty($data->name)) {{$data->title}} @else {{$data->name}} @endif <a href="#collapse{{$data->id}}" class="float-right" data-toggle="collapse"><i class="fas fa-caret-down"></i></a></span>
                              <div class="collapse" id="collapse{{$data->id}}">
                                 <div class="input-box">
                                    <form method="post" action="{{url('admin/update-menuitem')}}/{{$data->id}}">
                                       {{csrf_field()}}
                                       <div class="form-group">
                                          <label>Link Name</label>
                                          <input type="text" name="name" value="@if(empty($data->name)) {{$data->title}} @else {{$data->name}} @endif" class="form-control">
                                       </div>
                                       @if($data->type == 'custom')
                                       <div class="form-group">
                                          <label>URL</label>
                                          <input type="text" name="slug" value="{{$data->slug}}" class="form-control">
                                       </div>
                                       <div class="form-group">
                                          <input type="checkbox" name="target" value="_blank" @if($data->target == '_blank') checked @endif> Open in a new tab
                                       </div>
                                       @endif
                                       <div class="form-group">
                                          <button class="btn btn-sm btn-primary">Save</button>
                                          <a href="{{url('admin/delete-menuitem')}}/{{$data->id}}/{{$key}}/{{$in}}" class="btn btn-sm btn-danger">Delete</a>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <ul></ul>
                           </li>
                           @endforeach
                           @endforeach	
                           @endif	
                        </ul>
                     </li>
                     @endforeach
                     @endif
                  </ul>
                  @endif	
               </div>
               @if($desiredMenu != '')
               <div class="form-group menulocation">
                  <label><b>Menu Location</b></label>
                  <p><label><input type="radio" name="location" value="1" @if($desiredMenu->location == 1) checked="checked" @endif> Header</label></p>
                  <p><label><input type="radio" name="location" value="2" @if($desiredMenu->location == 2) checked="checked" @endif> Main Navigation</label></p>
               </div>
			   <div class="row align-items-center">
				<div class="col-sm-6">
					<div class="delete-menu"><a href="{{url('admin/delete-menu')}}/{{$desiredMenu->id}}">Delete Menu</a></div>
					 </div>
				<div class="col-sm-6">
               <div class="text-right">
                  <button class="btn btn-sm btn-primary" id="saveMenu">Save Menu</button>
               </div>
				</div>
				
			   </div>  
			   @endif										
            </div>
            @endif	
         </div>
			</div>
		</div>
		</div>
		</div>
      </div>
   </section>
</div>
<div id="serialize_output">@if($desiredMenu){{$desiredMenu->content}}@endif</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://johnny.github.io/jquery-sortable/js/jquery-sortable.js"></script> 
<script>
   jQuery(document).ready(function ($){
     $('#select-all-categories').click(function(event) {   
   	if(this.checked) {
   	  $('#categories-list :checkbox').each(function() {
   		this.checked = true;                        
   	  });
   	}else{
   	  $('#categories-list :checkbox').each(function() {
   		this.checked = false;                        
   	  });
   	}
     });
   });
</script>
<script>
   jQuery(document).ready(function ($){
    $('#select-all-posts').click(function(event) {   
   if(this.checked) {
     $('#posts-list :checkbox').each(function() {
   	this.checked = true;                        
     });
   }else{
     $('#posts-list :checkbox').each(function() {
   	this.checked = false;                        
     });
   }
    });
   });
</script>
@if($desiredMenu)
<script>
   jQuery(document).ready(function ($) {
   $('#add-categories').click(function(){
     var menuid = <?=$desiredMenu->id?>;
     var n = $('input[name="select-category[]"]:checked').length;
     var array = $('input[name="select-category[]"]:checked');
     var ids = [];
     for(i=0;i<n;i++){
       ids[i] =  array.eq(i).val();
     }
     if(ids.length == 0){
   	return false;
     }
     $.ajax({
   	type:"get",
   	data: {menuid:menuid,ids:ids},
   	url: "{{url('admin/add-categories-to-menu')}}",				
   	success:function(res){				
         location.reload(false);
   	}
     })
   })
   $('#add-posts').click(function(){
     var menuid = <?=$desiredMenu->id?>;
     var n = $('input[name="select-post[]"]:checked').length;
     var array = $('input[name="select-post[]"]:checked');
     var ids = [];
     for(i=0;i<n;i++){
   	ids[i] =  array.eq(i).val();
     }
     if(ids.length == 0){
   	return false;
     }
     $.ajax({
   	type:"get",
   	data: {menuid:menuid,ids:ids},
   	url: "{{url('admin/add-post-to-menu')}}",				
   	success:function(res){
     	  location.reload();
   	}
     })
   })
   $("#add-custom-link").click(function(){
     var menuid = <?=$desiredMenu->id?>;
     var url = $('#url').val();
     var link = $('#linktext').val();
     if(url.length > 0 && link.length > 0){
   	$.ajax({
   	  type:"get",
   	  data: {menuid:menuid,url:url,link:link},
   	  url: "{{url('admin/add-custom-link')}}",				
   	  success:function(res){
   	    location.reload();
   	  }
   	})
     }
   })
   
   // var  group = $("#menuitems").serialize();
   // console.log(group);
   var group = $("#menuitems").sortable({
      // alert('hii');
     group: 'serialization',
     onDrop: function ($item, container, _super) {
       var data = group.sortable("serialize").get();	  
      // alert(data);  
       var jsonString = JSON.stringify(data, null, '');
     //  alert(jsonString)
       $('#serialize_output').text(jsonString);
     	  _super($item, container);
     }
   });
   $("#saveMenu").click(function(){
     var menuid = <?=$desiredMenu->id?>;
     
     var location = $('input[name="location"]:checked').val();
     
     var newText = $("#serialize_output").text();
     
     //var data = JSON.parse($("#serialize_output").text());	
     var data = JSON.parse(newText);	

     alert(data);
     $.ajax({
       type:"get",
   	data: {menuid:menuid,data:data,location:location},
   	url: "{{url('admin/update-menu')}}",				
   	success:function(res){
   	   window.location.reload();
   	}
     })	
   });
   });
</script>
@endif		
<style>
	#menu-content ul {list-style: none;}
   .placeholder{margin: 5px 0;padding: 0;min-height: 40px;border: 1px dashed #b6bcbf;box-sizing: border-box;-moz-box-sizing: border-box}
	#menu-content ul#menuitems {padding-left: 0;}
	.menulocation p {margin: 0;}
	.delete-menu a {color: #b32d2e; text-decoration: underline;}
	#accordion #menu-items label { margin-bottom: 0;}
	#accordion #menu-items p {margin-bottom: 2px;}
	div#menu-items:last-child .item-list-body {overflow-y: unset;}
   .item-list,.info-box{background: #fff;padding: 10px;}
   .item-list-body{max-height: 300px;overflow-y: scroll;}
   .panel-body p{margin-bottom: 5px;}
   .info-box{margin-bottom: 15px;}
   .item-list-footer{padding-top: 10px;}
   .panel-heading a{display: block;}
   .form-inline{display: inline;}
   .form-inline select{padding: 4px 10px;}
   .btn-menu-select{padding: 4px 10px}
   .disabled{pointer-events: none; opacity: 0.7;}
   .menu-item-bar{background: #eee;padding: 10px 10px;border:1px solid #d7d7d7;margin-bottom: 5px; width: 75%; cursor: move;display: block;}
   #serialize_output{display: block;}
   .menulocation label{font-weight: normal;display: block;}
   body.dragging, body.dragging * {cursor: move !important;}
   .dragged {position: absolute;z-index: 1;}
   ol.example li.placeholder {position: relative;}
   ol.example li.placeholder:before {position: absolute;}
   #menuitem{list-style: none;}
   #menuitem ul{list-style: none;}
   .input-box{width:75%;background:#fff;padding: 10px;box-sizing: border-box;margin-bottom: 5px; border: 1px solid #eee;}
   .input-box .form-control{width: 50%}
</style>
@stop