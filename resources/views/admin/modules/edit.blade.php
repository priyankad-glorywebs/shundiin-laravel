@extends('layouts.master')
@section('title') {{$moduleDetail['title']}} @endsection
@section('content')
@include('layouts.admin.functions')
@include('layouts.admin.flash-message')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">{{ $moduleDetail['title'] }}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                  <li class="breadcrumb-item active">{{ $moduleDetail['main_title'] }}</li>
                  <li class="breadcrumb-item active">{{ $moduleDetail['main_title'] }} list</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   @foreach($moduleDetails as $value)
   <section class="content">
   <div class="row">
      <div class="col-12">
         <div class="card card-outline card-primary">
            <form method="post" action="{{ url('/admin/post-type/update-modules',  $value->id) }}" class="faq-form" enctype="multipart/form-data">
               @csrf 
            <div class="card-header">
               <div class="btn-group float-sm-right">
                  <button type="submit" class="btn btn-success px-5"><i class="fa fa-edit"></i>Update</button>
                  <button type="button" class="btn btn-warning cancel-button px-3"><i class="fa fa-refresh"></i> Reset
                  </button>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div id="jquery-message" style="width: 100%"></div>
                  <div class="col-md-9">
                     <div class="card ">
                        <div class="card-header">
                           <div id="success-msg" class="alert alert-success" style="display:none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>
                           <div id="error-msg" class="alert alert-danger" style="display:none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>
                           <div class="d-flex flex-column justify-content-center">
                              <h5 class="mb-0">
                                 @php $modulename = $value->title; 
                                 $jsonobj = $value->content;
                                 //@dd($jsonobj);
                                 $area = json_decode($jsonobj, true);
                                 // $moduleid = $value->id;  
                                 @endphp
                                 {{-- @php $names = str_replace('_', ' ', $modulename) @endphp
                                 {{$names}} --}}
                                 @if(isset($modulename))
                                 @if($modulename == 'faq-module') FAQ
                                 @elseif($modulename == 'testimonial-module') Testimonial Module
                                 @elseif($modulename == 'contact-us-module') Contact Section
                                 @elseif($modulename == 'banner-module') Banner Module
                                 @elseif($modulename == 'about-img-left-module') About Shun'diin Tour Image Left
                                 @elseif($modulename == 'about-img-right-module') About Shun'diin Tour Image Right
                                 @elseif($modulename == 'discover-tour-slider-module') Discover Tour Slider
                                 @elseif($modulename == 'have-question-module') Have Questions Section
                                 @elseif($modulename == 'why-shundiin-module') Why Shun’Diin Section
                                 @elseif($modulename == 'experience-shundiin-tour-module') Experience Shun’Diin Tour Section
                                 @elseif($modulename == 'contact-form-module') Contact Form Section
                                 @elseif($modulename == 'image-slider-module') Image Slider Section
                                 @elseif($modulename == 'gallery-module') Gallery Section
                                 @elseif($modulename == 'what-expect-lower-antelope-module') What To Expect From Lower Antelope Section
                                 @elseif($modulename == 'things-to-know-module') Things To Know Section
                                 @elseif($modulename == 'tour-overview-module') Tour Overview Section
                                 @elseif($modulename == 'tour-inner-gallery-module') Tour Inner Gallery Section
                                 @endif
                                 @endif
                              </h5>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="row mb-2">
                                <div class="col-md-12">
                                <!-- START EDITOR -->
                                    @component('components.backend.'.$modulename, ['area' => $area])
                                    @endcomponent
                                <!-- END EDITOR -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
</div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"></script>
<script src="{{ asset('plugins/tinymce/tinymce.min.js?v=v3.2.10') }}" id="core-tinymce"></script>
<script type="text/javascript">
   tinymce.init({
   selector: 'textarea.tinymce-editor',
   height: 300,
   menubar: true,
   plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table paste code help wordcount', 'image'
   ],
   toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | help',
   content_css: '//www.tiny.cloud/css/codepen.min.css'
   });
</script>
<script>
   jQuery(document).ready(function($) {   
       $("#opt_level").on('change', function() {          
         document.location.href =  "?module=" + $("#opt_level").val();
       });   
       var repeater = $('.repeater-default').repeater({
         isFirstItemUndeletable: true,
        // initval: 1,
        initEmpty: false,
                defaultValues: {
                    'code': ''
                },
      show: function () {
      $(this).closest('.data-repeater-item').find('.imgsrc').attr('src', '');
            $(this).closest('.data-repeater-item').find('.dropify-preview ,.image-clear').attr("style", "display:none");
            $(this).show();
         var limitcount = $(this).parents(".repeater-default").data("limit");
         //alert(limitcount);
         var itemcount = $(this).parents(".repeater-default").find("div[data-repeater-item]").length;

         if (limitcount) {
            if (itemcount <= limitcount) {
                  $(this).slideDown();
                  $('.dropbox').last().css('background-image', '');
            } else {
                  $(this).remove();
            }
         } else {
            $(this).slideDown();
            $('.dropbox').last().css('background-image', '');
         }

         if($('textarea.tinymce-editor')[0]){
            //  console.log('called');
               initTinyEditor();
         }
         
         if($('.drophere')[0]){
               countnumbers();
         }

         if (itemcount >= limitcount) {
            $(".repeater-default span[data-repeater-create]").hide("slow");
         }
      },
      hide: function (deleteElement) {
         var limitcount = $(this).parents(".repeater-default").data("limit");
         var itemcount = $(this).parents(".repeater-default").find("div[data-repeater-item]").length;

         if (confirm('Are you sure you want to delete this element?')) {
            $(this).slideUp(deleteElement);
         }

         if (itemcount <= limitcount) {
            $(".repeater-default span[data-repeater-create]").show("slow");
         }
      },
   });

       var current_input;

       function display(input) {
         if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                  $('#unique-element').children('.dropbox').css({'background-image': 'url('+ event.target.result +')', 'background-size': 'auto 100px', 'background-position': 'center center'});
                   var formData = new FormData();
                    formData.append('tourimage', input.files[0], input.files[0].name);
                    uploadImage(formData);
                  }
                  reader.readAsDataURL(input.files[0]);
               }
            }

         $(document).on('click', '.dropbox', function() {
            // console.log('Clicked');
            $(document).find('#unique-element').attr('id', '');
            $(this).parent('.form-group').attr('id', 'unique-element');
            // console.log($(this).siblings('.uploadImage').html());
            $(this).siblings('.uploadImage').click();
            $(this).siblings('.uploadImage').on('change', function(e){
               display(this);
            });
         });

         function uploadImage(formData){
            $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': "{{ csrf_token() }}"
                 }
             });
             
             // var formData = new formData();
             $.ajax({
                 type: 'POST',
                 url: "{{ route('uploads') }}",
                 data: formData,
                 contentType: false,
                 processData: false,
             }).done(function(data) {
                  if(response.name){
                     $('#unique-element .tourImageName').val(response.name);
                  } else {
                     $('#unique-element .tourImageName').val('no_image.jpg');
                  }
                  return response.message;
             }).fail(function(data) {
                 // show_message(data);
                 return false;
             });
             /*END AJAX*/
         }
         if($('.draghere')[0]){
               makeDraggable(); 
         }
      
         if($('.drophere')[0]){
               $('.drophere').droppable({
               hoverClass: 'hoverClass',
               drop: function(event, ui) {
               var $from = $(ui.draggable),
                  $fromParent = $from.parent(),
                  $to = $(this).children(),
                  $toParent = $(this);
      
               window.endPos = $to.offset();
      
               swap($from, $from.offset(), window.endPos, 0);
               swap($to, window.endPos, window.startPos, 1000, function() {
                  $toParent.html($from.css({position: 'relative', left: '', top: '', 'z-index': ''}));
                  $fromParent.html($to.css({position: 'relative', left: '', top: '', 'z-index': ''}));
                  makeDraggable();
               });
               // countnumbers();
               }
         });
         }
      
         function makeDraggable() {
               $('.draghere').draggable({
               zIndex: 99999,
               revert: 'invalid',
               start: function(event, ui) {
                  window.startPos = $(this).offset();
               }
               });
               countnumbers();
         }
      
         function swap($el, fromPos, toPos, duration, callback) {
               $el.css('position', 'absolute')
               .css(fromPos)
               .animate(toPos, duration, function() {
                  if (callback) callback();
               });
               countnumbers();
         }

         function countnumbers(){
               // console.log('called');
               $('.drophere').each(function(){
                  $(this).find('.increament-number').html($(this).index() + 1);
               });
         }
   });             
</script>

{{-- <script>
var editorContent = tinyMCE.get('textarea.tinymce-editor').getContent();
if (editorContent == '')
{
    alert("add data");
}
else
{
    alert("data found");
}
</script> --}}

<script>
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });
   
   $(function() {
      /* UPDATE ADMIN PERSONAL INFO */
      $('.faq-form').on('submit', function(e) {
         e.preventDefault();
         $.ajax({
               url: $(this).attr('action'),
               method: $(this).attr('method'),
               data: new FormData(this),
               processData: false,
               dataType: 'json',
               contentType: false,
               beforeSend: function() {
               //  $(document).find('span.error-text').text('');
               },
               success: function(data) {
                  if(data.status == 1) {
                     //  $("#success").show();
                     $('#success-msg').text(data.msg).show();
                     setTimeout(function() { $("#success-msg").hide(); }, 5000);
                     window.location = '{{ route('admin.modules') }}';
                  }
                  else{
                     $("#error-msg").text(data.msg).show();
                     setTimeout(function() { $("#error-msg").hide(); }, 5000);
                  }
               }
         });
      });
   });
  
</script>
<style>
   .faq-form .repeater-default { border: 1px solid #ced4da; padding: 10px; border-radius: 5px; margin-bottom: 20px;}
</style>
</div>
<!-- END EDITOR -->
</div>
<!-- /.card-body -->
</div>
</div>
@endsection
@endforeach