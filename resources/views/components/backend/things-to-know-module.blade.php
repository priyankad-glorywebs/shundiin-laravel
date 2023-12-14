<input type="hidden" name="title" value="things-to-know-module">
<div class="form-group">
   <label>Heading*</label>
   @if (isset($area['sechead'])) 
      <input type="text" name="sechead" value="{{$area['sechead']}}" class="form-control" required>
   @else
      <input type="text" name="sechead" value="" class="form-control" required>
    @endif
      <span class="text-danger error-text sechead_error"></span>
</div>
<div class="form-group">
   <label>Sub Heading*</label>
   @if (isset($area['secsubhead'])) 
      <input type="text" name="secsubhead" value="{{$area['secsubhead']}}" class="form-control" required>
   @else
      <input type="text" name="secsubhead" value="" class="form-control" required>
    @endif
      <span class="text-danger error-text secsubhead_error"></span>
</div>
<div class="form-group">
    <label>Content In Box*</label>
    @if (isset($area['secdesc']))
       <textarea name="secdesc" class="tinymce-editor form-control" required>{{$area['secdesc']}}</textarea>
    @else
       <textarea name="secdesc"  class="tinymce-editor form-control" required></textarea>
    @endif
       <span class="text-danger error-text secdesc_error"></span>
 </div>