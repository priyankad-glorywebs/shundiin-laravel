<input type="hidden" name="title" value="discover-tour-slider-module">
<div class="form-group">
    <label>Section heading*</label>
 @if (isset($area['dthead']))
    <input type="text" name="dthead"  class="form-control" value="{{ $area['dthead'] }}" required>
 @else
    <input type="text" name="dthead" class="form-control" required>
    <span class="text-danger error-text dthead_error"></span>
 @endif  
 </div>

 <div class="repeater-default" data-limit="10">
    <div data-repeater-list="tours">
       @if (isset($area['tours']))
          @foreach($area['tours'] as $key => $value)
             <div data-repeater-item="" class="data-repeater-item drophere">
               <div class=" draghere card collapsed-card">
                  <div class="card-header border-bottom-0 d-flex justify-content-md-between align-items-center" data-card-widget="collapse" aria-expanded="false" role='button'>
                     <div class="p-0 col-10">
                        <p class="h4 mb-0 pb-0">Tour <span class="increament-number"></span></p>
                     </div>
                  </div>
                  <div class="card-body pt-1">
                     <div class="form-group">
                        <label>Tour Name*</label>
                        <input type="text" name="tourname" value="{{ $value['tourname'] }}" class="form-control" required>
                        <span class="text-danger error-text tourname_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Tour Description*</label>
                        <textarea type="text" name="tourdesc" class="form-control" required>{{ $value['tourdesc'] }}</textarea>
                        <span class="text-danger error-text tourdesc_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Tour Price*</label>
                        <input type="number" name="tourprice" value="{{ $value['tourprice'] }}" class="form-control" required>
                        <span class="text-danger error-text tourprice_error"></span>
                     </div>
                     <div class="form-group">
                        <label>Per ? person</label>
                        <input type="text" name="tourperson" value="{{ isset($value['tourperson']) ? $value['tourperson'] : '' }}" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Button Label</label>
                        <input type="text" name="tourbtnlbl" value="{{ isset($value['tourbtnlbl']) ? $value['tourbtnlbl'] : '' }}" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Button Link</label>
                        <input type="text" name="tourbtnlink" value="{{ isset($value['tourbtnlink']) ? $value['tourbtnlink'] : '' }}" class="form-control">
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
               </div>
             </div>
          @endforeach
       @else
          <div data-repeater-item="" class="drophere">
            <div class="draghere card collapsed-card">
               <div class="card-header border-bottom-0 d-flex justify-content-md-between align-items-center" data-card-widget="collapse" aria-expanded="false" role='button'>
                  <div class="p-0 col-10">
                     <p class="h4 mb-0 pb-0">Destination <span class="increament-number"></span></p>
                  </div>
               </div>
               <div class="card-body pt-1">
                  <div class="form-group">
                     <label>Tour Name*</label>
                     <input type="text" name="tourname" class="form-control" required>
                     <span class="text-danger error-text tourname_error"></span>
                  </div>
                  <div class="form-group">
                     <label>Tour Description*</label>
                     <textarea type="text" name="tourdesc" class="form-control" required></textarea>
                     <span class="text-danger error-text tourdesc_error"></span>
                  </div>
                  <div class="form-group">
                     <label>Tour Price*</label>
                     <input type="number" name="tourprice" class="form-control" required>
                     <span class="text-danger error-text tourprice_error"></span>
                  </div>
                  <div class="form-group">
                     <label>Per ? person</label>
                     <input type="text" name="tourperson" class="form-control">
                  </div>
                  <div class="form-group">
                     <label>Button Label</label>
                     <input type="text" name="tourbtnlbl" class="form-control">
                  </div>
                  <div class="form-group">
                     <label>Button Link</label>
                     <input type="text" name="tourbtnlink" class="form-control">
                  </div>
                  
                  <div class="form-group" id="imageUploadForm" enctype="multipart/form-data">
                     <label>Upload Image</label>
                     <input type="file" id="uploadImage" class="uploadImage" name="tourimage" accept="image/*" style="display: none">
                     <input type="text" name="tourImageName" class="form-control tourImageName" style="display: none">
                     <div class="dropbox">
                        <h5 class="text-secondary ">Upload or drag and drop file here</h5>
                     </div>
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
