<input type="hidden" name="title" value="have-question-module">
<div class="form-group">
    <label>Sub heading*</label>
 @if (isset($area['hqsubhead']))
    <input type="text" name="hqsubhead"  class="form-control" value="{{ $area['hqsubhead'] }}">
 @else
    <input type="text" name="hqsubhead" class="form-control">
 @endif  
    <span class="text-danger error-text hqsubhead_error"></span>
 </div>
 <div class="form-group">
    <label>Section heading*</label>
 @if (isset($area['hqhead']))
    <input type="text" name="hqhead"  class="form-control" value="{{ $area['hqhead'] }}" required>
 @else
    <input type="text" name="hqhead" class="form-control" required>
 @endif  
    <span class="text-danger error-text hqhead_error"></span>
 </div>
 <div class="form-group">
    <label>Description*</label>
 @if (isset($area['hqdesc']))
    <textarea type="text" name="hqdesc" class="form-control" required>{{ $area['hqdesc'] }}</textarea>
 @else
    <textarea type="text" name="hqdesc" class="form-control" required></textarea>
 @endif
    <span class="text-danger error-text hqdesc_error"></span>
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
       @if (isset($area['hqbtnlbl']))
          <input type="text" name="hqbtnlbl" value="{{$area['hqbtnlbl']}}" class="form-control">
       @else
          <input type="text" name="hqbtnlbl" class="form-control">
       @endif   
          <span class="text-danger error-text hqbtnlbl_error"></span>
    </div>
    <div class="form-group">
       <label>Button Link</label>
       @if (isset($area['hqbtnlink']))
          <input type="text" name="hqbtnlink" value="{{$area['hqbtnlink']}}" class="form-control" required>
       @else
          <input type="text" name="hqbtnlink" value="" class="form-control">
       @endif
          <span class="text-danger error-text hqbtnlink_error"></span>
    </div>
</div>
 </div>

 <style>
 .show-button-details { border: 1px solid #cccccc; padding: 10px; border-radius: 5px;}
 </style>

<script>
   $( document ).on( 'change', '.manage_status', function() {
      $('input[name="sourcebtnstatus"]:checked').val() == 1 ? $( document ).find( '.show-button-details' ).show() : $( document ).find( '.show-button-details' ).hide();
   });
   $( document ).ready( function() {
      $('input[name="sourcebtnstatus"]:checked').val() == 1 ? $( document ).find( '.show-button-details' ).show() : $( document ).find( '.show-button-details' ).hide();
   });
            
</script>
