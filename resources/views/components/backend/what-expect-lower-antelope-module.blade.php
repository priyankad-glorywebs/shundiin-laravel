<input type="hidden" name="title" value="what-expect-lower-antelope-module">
<div class="form-group"> 
   <label>Heading</label>
   @if (isset($area['sechead'])) 
      <input type="text" name="sechead" value="{{ $area['sechead'] }}" class="form-control" required>
   @else
      <input type="text" name="sechead" class="form-control" required>
   @endif
      <span class="text-danger error-text sechead_error"></span>
</div>
<div class="form-group">
    <label>Description</label>
    @if (isset($area['secdesc']))
       <textarea name="secdesc" class="tinymce-editor form-control" required>{{$area['secdesc']}}</textarea>
    @else
       <textarea name="secdesc"  class="tinymce-editor form-control" required></textarea>
    @endif
       <span class="text-danger error-text secdesc_error"></span>
 </div>
