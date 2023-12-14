<input type="hidden" name="title" value="banner-module">
<div class="form-group">
    <label>Banner heading*</label>
 @if (isset($area['bnhead']))
    <input type="text" name="bnhead"  class="form-control" value="{{ $area['bnhead'] }}" required>
 @else
    <input type="text" name="bnhead" class="form-control" required>
    <span class="text-danger error-text bnhead_error"></span>
 @endif  
 </div>
<div class="form-group">
    <label>Banner sub heading</label>
 @if (isset($area['bnsubhead']))
    <input type="text" name="bnsubhead"  class="form-control" value="{{ $area['bnsubhead'] }}">
 @else
    <input type="text" name="bnsubhead" class="form-control">
    <span class="text-danger error-text bnsubhead_error"></span>
 @endif  
 </div>

 <div class="form-group">
    <label>Button to visible : </label>
<label for="are_you_in" class="label-wrap radio radioyes ml-0">Yes 
    @if(isset($area['sourcebtnstatus'])) 
        <input type="radio" class="manage_status" id="are_you_in" name="sourcebtnstatus" value="1" {{ $area['sourcebtnstatus'] == 1 ? 'checked' : '' }} /> 
    @else 
        <input type="radio" class="manage_status" id="are_you_in" name="sourcebtnstatus" value="1" checked /> 
    @endif 
        <span class="checkmark">
            <i class="fa fa-square-o" aria-hidden="true"></i>
        </span>
</label>

<label for="are_you_out" class="label-wrap radio radiono">No 
    @if(isset($area['sourcebtnstatus']))
        <input type="radio" class="manage_status" id="are_you_out" name="sourcebtnstatus" value="0" {{ $area['sourcebtnstatus'] == 0 ? 'checked' : '' }} /> 
    @else 
        <input type="radio" class="manage_status" id="are_you_out" name="sourcebtnstatus" value="0" /> 
    @endif 
    <span class="checkmark">
    <i class="fa fa-square-o" aria-hidden="true"></i>
  </span>
</label>


<div class="show-button-details">
    <div class="form-group">
       <label>Button label</label>
       @if (isset($area['sourcelbl']))
          <input type="text" name="sourcelbl" value="{{$area['sourcelbl']}}" class="form-control">
       @else
          <input type="text" name="sourcelbl" class="form-control">
          <span class="text-danger error-text sourcelbl_error"></span>
       @endif   
    </div>
    <div class="form-group">
       <label>Button Link</label>
       @if (isset($area['sourcelink']))
          <input type="text" name="sourcelink" value="{{$area['sourcelink']}}" class="form-control" required>
       @else
          <input type="text" name="sourcelink" value="" class="form-control">
          <span class="text-danger error-text sourcelink_error"></span>
       @endif
    </div>
</div>
 </div>

<script>
    $( document ).on( 'change', '.manage_status', function() {
        $('input[name="sourcebtnstatus"]:checked').val() == 1 ? $( document ).find( '.show-button-details' ).show() : $( document ).find( '.show-button-details' ).hide();
    });
    $( document ).ready( function() {
        $('input[name="sourcebtnstatus"]:checked').val() == 1 ? $( document ).find( '.show-button-details' ).show() : $( document ).find( '.show-button-details' ).hide();
    });
                
    </script>
    <style>
    .show-button-details { border: 1px solid #cccccc; padding: 10px; border-radius: 5px;}
    </style>