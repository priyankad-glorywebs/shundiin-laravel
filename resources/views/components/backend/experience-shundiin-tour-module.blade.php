<input type="hidden" name="title" value="experience-shundiin-tour-module">
<div class="form-group">
    <label>Section heading*</label>
 @if (isset($area['eshead']))
    <input type="text" name="eshead"  class="form-control" value="{{ $area['eshead'] }}" required>
 @else
    <input type="text" name="eshead" class="form-control" required>
    <span class="text-danger error-text eshead_error"></span>
 @endif  
</div>
<div class="form-group">
    <label>Video Link*</label>
 @if (isset($area['eslink']))
    <input type="text" name="eslink"  class="form-control" value="{{ $area['eslink'] }}" required>
 @else
    <input type="text" name="eslink" class="form-control" required>
    <span class="text-danger error-text eslink_error"></span>
 @endif  
</div>
<div class="form-group">
    <label>Video Width</label>
 @if (isset($area['eswidth']))
    <input type="text" name="eswidth"  class="form-control" value="{{ $area['eswidth'] }}" required>
 @else
    <input type="text" name="eswidth" class="form-control" required>
    <span class="text-danger error-text eswidth_error"></span>
 @endif  
</div>
<div class="form-group">
    <label>Video Height</label>
 @if (isset($area['esheight']))
    <input type="text" name="esheight"  class="form-control" value="{{ $area['esheight'] }}" required>
 @else
    <input type="text" name="esheight" class="form-control" required>
    <span class="text-danger error-text esheight_error"></span>
 @endif  
</div>