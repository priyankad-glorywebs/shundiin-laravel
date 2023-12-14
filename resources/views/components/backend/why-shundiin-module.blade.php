<input type="hidden" name="title" value="why-shundiin-module">
<div class="form-group">
    <label>Section heading*</label>
 @if (isset($area['wshead']))
    <input type="text" name="wshead"  class="form-control" value="{{ $area['wshead'] }}" required>
 @else
    <input type="text" name="wshead" class="form-control" required>
 @endif  
    <span class="text-danger error-text wshead_error"></span>
 </div>

 <div class="repeater-default" data-limit="10">
    <div data-repeater-list="services">
       @if (isset($area['services']))
          @foreach($area['services'] as $key => $value)
             <div data-repeater-item="" class="data-repeater-item" class="main">
                <div class="form-group">
                   <label>Service Name*</label>
                   <input type="text" name="servname" value="{{ $value['servname'] }}" class="form-control" required>
                   <span class="text-danger error-text servname_error"></span>
                </div>
                <div class="form-group">
                   <label>Description*</label>
                   <textarea type="text" name="servdesc" class="form-control" required>{{ $value['servdesc'] }}</textarea>
                   <span class="text-danger error-text servdesc_error"></span>
                </div>
                
                <div class="form-group" id="imageUploadForm" enctype="multipart/form-data">
                  <label>Upload Image</label>
                  <input type="file" id="uploadImage" class="uploadImage" name="tourimage" accept="image/*" style="display: none">
                  <input type="text" name="tourImageName" class="form-control tourImageName" style="display: none" value="{{$value['tourImageName']}}">
                  <div class="dropbox" style="background-image: url('{{asset('storage/photos/'.$value['tourImageName'])}}')">
                      <h5 class="text-secondary">Upload or drag and drop file here</h5>
                  </div>
               </div>
                
                <div class="form-group col-12">
                   <span data-repeater-delete="" class="btn btn-danger btn-sm">
                   <span class="glyphicon glyphicon-remove"></span> Delete
                   </span>
                </div>
             </div>
          @endforeach
       @else
          <div data-repeater-item="" class="main">
            <div class="form-group">
                <label>Service Name*</label>
                <input type="text" name="servname" class="form-control" required>
                <span class="text-danger error-text servname_error"></span>
             </div>
             <div class="form-group">
                <label>Description*</label>
                <textarea type="text" name="servdesc" class="form-control" required></textarea>
                <span class="text-danger error-text servdesc_error"></span>
             </div>
            <div class="form-group" id="imageUploadForm" enctype="multipart/form-data">
                <label>Upload Image</label>
                <input type="file" id="uploadImage" class="uploadImage" name="tourimage" accept="image/*" style="display: none">
                <input type="text" name="tourImageName" class="form-control tourImageName" style="display: none">
                <div class="dropbox">
                    <h5 class="text-secondary">Upload or drag and drop file here</h5>
                </div>
            </div>
            <div class="form-group col-12">
                <span data-repeater-delete="" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove"></span> Delete
                </span>
             </div>
                    {{-- </div> --}}
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

 <style>
    .dropbox {
        border: 1px dashed rgb(153, 153, 153);
        display: flex;
        padding: 50px;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        background-repeat: no-repeat;
    }
 </style>
