<input type="hidden" name="title" value="faq-module">
<div class="form-group"> 
   <label>Heading</label>
   @if (isset($area['faqheading'])) 
      <input type="text" name="faqheading" value="{{ $area['faqheading'] }}" class="form-control" required>
   @else
      <input type="text" name="faqheading" class="form-control">
      <span class="text-danger error-text faqheading_error"></span>
   @endif
</div>
<div class="repeater-default">
   <div data-repeater-list="faqmodule">
      @if (isset($area['faqmodule'])) 
         @foreach($area['faqmodule'] as $key => $value)
         <div data-repeater-item="" class="data-repeater-item">
            <div class="form-group">
               <label>Question*</label>
                  <input type="text" name="q1" value="{{ $value['q1'] }}" class="form-control" required>
                  <span class="text-danger error-text q1_error"></span>
            </div>
            <div class="form-group">
               <label>Answer*</label>
                  <textarea name="a1" class="tinymce-editor form-control" required>{{$value['a1']}}</textarea>
                  <span class="text-danger error-text a1_error"></span>
            </div>
            <div class="form-group col-12">
               <span data-repeater-delete="" class="btn btn-danger btn-sm">
               <span class="glyphicon glyphicon-remove"></span> Delete
               </span>
            </div>
         </div>
         @endforeach
      @else
         <div data-repeater-item="" class="data-repeater-item">
            <div class="form-group">
               <label>Question*</label>
                  <input type="text" name="q1" class="form-control" required>
                  <span class="text-danger error-text q1_error"></span>
            </div>
            <div class="form-group">
               <label>Answer*</label>
                  <textarea name="a1" class="tinymce-editor form-control" required></textarea>
                  <span class="text-danger error-text a1_error"></span>
            </div>
            <div class="form-group col-12">
               <span data-repeater-delete="" class="btn btn-danger btn-sm">
               <span class="glyphicon glyphicon-remove"></span> Delete
               </span>
            </div>
         </div>
      @endif
      </div>
      <div class="form-group">
         <div class="col-sm-offset-1 col-sm-11">
            <span data-repeater-create="" class="btn btn-info btn-md add-repeater">
            <span class="glyphicon glyphicon-plus"></span> Add
            </span>
         </div>
      </div>  
</div>