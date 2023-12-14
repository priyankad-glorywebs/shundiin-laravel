<input type="hidden" name="title" value="contact-us-module">
<div class="form-group">
    <label>Section heading*</label>
 @if (isset($area['cfhead']))
    <input type="text" name="cfhead"  class="form-control" value="{{ $area['cfhead'] }}" required>
 @else
    <input type="text" name="cfhead" class="form-control" required>
    <span class="text-danger error-text cfhead_error"></span>
 @endif  
 </div>
<div class="form-group">
    <label>Section Description</label>
 @if (isset($area['cfdesc']))
    <input type="text" name="cfdesc"  class="form-control" value="{{ $area['cfdesc'] }}">
 @else
    <input type="text" name="cfdesc" class="form-control">
    <span class="text-danger error-text cfdesc_error"></span>
 @endif  
 </div>
<div class="form-group">
    <label>Address Embed Link</label>
 @if (isset($area['cfaddlink']))
    <input type="text" name="cfaddlink"  class="form-control" value="{{ $area['cfaddlink'] }}" required>
 @else
    <input type="text" name="cfaddlink" class="form-control" required>
    <span class="text-danger error-text cfaddlink_error"></span>
 @endif  
 </div>
 <div class="form-group">
    <label>Button Label</label>
 @if (isset($area['cfbtnlbl']))
    <input type="text" name="cfbtnlbl"  class="form-control" value="{{ $area['cfbtnlbl'] }}" required>
 @else
    <input type="text" name="cfbtnlbl" class="form-control">
 @endif
 </div>
 <div class="form-group">
    <label>Button Link</label>
 @if (isset($area['cfbtnlink']))
    <input type="text" name="cfbtnlink"  class="form-control" value="{{ $area['cfbtnlink'] }}">
 @else
    <input type="text" name="cfbtnlink" class="form-control">
 @endif
 </div>

 <label>Input Fields</label>
 <div class="repeater-default" data-limit="10">
    <div data-repeater-list="inputs">
       @if (isset($area['inputs']))
          @foreach($area['inputs'] as $key => $value)
          {{-- {{dd(gettype($value['fieldrequired'][0]))}} --}}
          <div data-repeater-item="" class="data-repeater-item drophere">
            <div class=" draghere card collapsed-card">
               <div class="card-header border-bottom-0 d-flex justify-content-md-between align-items-center" data-card-widget="collapse" aria-expanded="false" role='button'>
                  <div class="p-0 col-10">
                     <p class="h4 mb-0 pb-0">Input <span class="increament-number"></span></p>
                  </div>
               </div>
               <div class="card-body pt-1">
                  <div class="form-group">
                     <label>Field Type*</label>
                     <select class="form-control" name="fieldtype" required>
                        <option value="text" {{$value['fieldtype']==='text'?'selected':''}}>Text</option>
                        <option value="email" {{$value['fieldtype']==='email'?'selected':''}}>Email</option>
                        <option value="number" {{$value['fieldtype']==='number'?'selected':''}}>Number</option>
                        <option value="password" {{$value['fieldtype']==='password'?'selected':''}}>Password</option>
                        <option value="textarea" {{$value['fieldtype']==='textarea'?'selected':''}}>Textarea</option>
                     </select>
                     <span class="text-danger error-text fieldtype_error"></span>
                     </div>
                  {{-- <div class="form-group">
                     <label>Field Type*</label>
                     <input type="text" name="fieldtype" value="{{ $value['fieldtype'] }}" class="form-control" required>
                     <span class="text-danger error-text fieldtype_error"></span>
                  </div> --}}
                  <div class="form-group">
                     <label>Field Title*</label>
                     <input type="text" name="fieldtitle" value="{{ $value['fieldtitle'] }}" class="form-control" required>
                     <span class="text-danger error-text fieldtitle_error"></span>
                  </div>
                  <div class="form-group">
                     <label>Field Name*</label>
                     <input type="text" name="fieldname" value="{{ $value['fieldname'] }}" class="form-control" required>
                     <span class="text-danger error-text fieldname_error"></span>
                  </div>
                  <div class="form-group">
                     <label>Field Placeholder</label>
                     <input type="text" name="fieldplaceholder" value="{{ $value['fieldplaceholder'] }}" class="form-control">
                     <span class="text-danger error-text fieldplaceholder_error"></span>
                  </div>
                  <div class="form-group">
                     <label>
                        <input type="checkbox" name="fieldrequired" {{isset($value['fieldrequired']) && $value['fieldrequired'][0] == 'on' ? 'checked' : ''}}>
                        Required
                        </label>
                  </div>

                  
                  <div class="form-group col-12">
                     <span data-repeater-delete="" class="btn btn-danger btn-sm">
                     <span class="glyphicon glyphicon-remove"></span> Delete
                     </span>
                  </div>
               </div>
            </div>
          </div>
         @endforeach
       @else
       <div data-repeater-item="" class="drophere">
         <div class="draghere card collapsed-card">
            <div class="card-header border-bottom-0 d-flex justify-content-md-between align-items-center" data-card-widget="collapse" aria-expanded="false" role='button'>
               <div class="p-0 col-10">
                  <p class="h4 mb-0 pb-0">Input <span class="increament-number"></span></p>
               </div>
            </div>
            <div class="card-body pt-1">
               <div class="form-group">
                  <label>Field Type*</label>
                  <select class="form-control" name="fieldtype" required>
                     <option value="text" selected>Text</option>
                     <option value="email">Email</option>
                     <option value="number">Number</option>
                     <option value="password">Password</option>
                     <option value="textarea">Textarea</option>
                  </select>
                  <span class="text-danger error-text fieldtype_error"></span>
               </div>
               <div class="form-group">
                  <label>Field Title*</label>
                  <input type="text" name="fieldtitle" class="form-control" required>
                  <span class="text-danger error-text fieldtitle_error"></span>
               </div>
               <div class="form-group">
                  <label>Field Name*</label>
                  <input type="text" name="fieldname" class="form-control" required>
                  <span class="text-danger error-text fieldname_error"></span>
               </div>
               <div class="form-group">
                  <label>Field Placeholder</label>
                  <input type="text" name="fieldplaceholder" class="form-control">
                  <span class="text-danger error-text fieldplaceholder_error"></span>
               </div>
               <div class="form-group">
                  <label>
                     <input type="checkbox" name="fieldrequired">
                        Required
                  </label>
               </div>
               
               <div class="form-group col-12">
                  <span data-repeater-delete="" class="btn btn-danger btn-sm">
                  <span class="glyphicon glyphicon-remove"></span> Delete
                  </span>
               </div>
            </div>
          </div>
       </div>
       @endif
    </div>
    <div class="form-group">
       <div class="col-sm-offset-1 col-sm-11">
          <span data-repeater-create="" class="btn btn-info btn-md add-repeater">
          <span class="glyphicon glyphicon-plus" id="add-content"></span> Add
          </span>
       </div>
    </div>
 </div>

 <script>
   $(document).ready(function(){
      // $(document).ready(function() {
      //    $('input[type=checkbox]').change(function() {
      //       var checkboxValue = $(this).is(':checked');
      //       $(this).prop('value', checkboxValue);
      //       console.log(checkboxValue); // Outputs true or false
      //    });
      // });
      // $('input[type=checkbox]').each(function(){
      //    $(this).prop('value', false);
      //    $(this).change(function(){
      //       if ($(this).is(':checked')) {
      //           $(this).prop('value', true);
      //       } else {
      //           $(this).prop('value', false);
      //       }
      //       // cb = $(this);
      //       // console.log(cb);
      //       // cb.val(cb.prop('checked'));
      //    });
      // });
   });
 </script>