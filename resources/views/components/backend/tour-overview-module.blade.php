<input type="hidden" name="title" value="tour-overview-module">
<div class="form-group">
   <label>Tour Name*</label>
   @if (isset($area['tourname'])) 
      <input type="text" name="tourname" value="{{$area['tourname']}}" class="form-control" required>
   @else
      <input type="text" name="tourname" value="" class="form-control" required>
    @endif
      <span class="text-danger error-text tourname_error"></span>
</div>
<div class="form-group">
   <label>Time(like 1 hour and 30 minutes)*</label>
   @if (isset($area['tourtime'])) 
      <input type="text" name="tourtime" value="{{$area['tourtime']}}" class="form-control" required>
   @else
      <input type="text" name="tourtime" value="" class="form-control" required>
    @endif
      <span class="text-danger error-text tourtime_error"></span>
</div>
<div class="form-group">
    <label>Scale Of Tour*</label>
    <select class="form-control" name="tourscale" required>
      <option value="Easy" {{isset($area['tourscale'])==='Easy'?'selected':''}}>Easy</option>
      <option value="Moderate" {{isset($area['tourscale'])==='Moderate'?'selected':''}}>Moderate</option>
      <option value="Hard" {{isset($area['tourscale'])==='Hard'?'selected':''}}>Hard</option>
    </select>
    <span class="text-danger error-text tourscale_error"></span>
  </div>
 <div class="form-group">
    <label>Button Link</label>
    @if (isset($area['btnlink']))
        <input type="text" name="btnlink"  class="form-control" value="{{ isset($area['btnlink']) ? $area['btnlink'] : '' }}">
    @else
        <input type="text" name="btnlink" class="form-control">
    @endif
 </div>
<div class="form-group">
   <label>Section Heading*</label>
   @if (isset($area['sechead'])) 
      <input type="text" name="sechead" value="{{$area['sechead']}}" class="form-control" required>
   @else
      <input type="text" name="sechead" value="" class="form-control" required>
    @endif
      <span class="text-danger error-text sechead_error"></span>
</div>
<div class="form-group">
    <label>Description*</label>
    @if (isset($area['secdesc']))
       <textarea name="secdesc" class="tinymce-editor form-control" required>{{$area['secdesc']}}</textarea>
    @else
       <textarea name="secdesc"  class="tinymce-editor form-control" required></textarea>
    @endif
       <span class="text-danger error-text secdesc_error"></span>
 </div>