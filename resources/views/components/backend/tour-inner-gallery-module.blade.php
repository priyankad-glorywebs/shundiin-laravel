<input type="hidden" name="title" value="tour-inner-gallery-module">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

<div class="form-group">
    <label>Section Heading*</label>
    @if (isset($area['sechead'])) 
       <input type="text" name="sechead" value="{{$area['sechead']}}" class="form-control" required>
    @else
       <input type="text" name="sechead" value="" class="form-control" required>
     @endif
       <span class="text-danger error-text sechead_error"></span>
 </div>
       
{{-- <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
    @csrf --}}
    <div class="form-group">
        <label for="document">Documents</label>
        <div class="needsclick dropzone" id="document-dropzone">
        </div>
    </div>
    {{-- </div> --}}
{{-- </form> --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>

function getImageSizeFromBase64(base64Data) {
  var byteString = atob(base64Data);
  var fileSizeInBytes = byteString.length;

  // Calculate size in KB or MB
  var fileSizeInKB = fileSizeInBytes / 1024;
  return fileSizeInKB * 1000;
}

  var uploadedDocumentMap = {}
  Dropzone.options.documentDropzone = {
    url: "{{ route('uploads') }}",
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    acceptedFiles: "image/*",
    paramName: "file",
    previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-image"><img data-dz-thumbnail /></div><div class="dz-details"><div class="dz-size"><span data-dz-size></span></div><div class="dz-filename"><span data-dz-name></span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-error-message"><span data-dz-errormessage></span></div><div class="dz-success-mark"><span>✔</span></div><div class="dz-error-mark"><span>✘</span></div></div>',

    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
      uploadedDocumentMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.name !== 'undefined') {
        name = file.name;
      } else {
        name = uploadedDocumentMap[file.name];
      }
      $('.multi-img-form').find('input[name="document[]"][value="' + name + '"]').remove()
    },
    init: function () {
  var myDropzone = this; // Store a reference to the Dropzone instance

  @if(isset($area) && $area['document'])
    var send_data = {!! json_encode($area['document']) !!};
    console.log({!! json_encode($area['document']) !!});
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      }
    });
    $.ajax({
      url: "{{route('getfiledata')}}",
      method: 'POST',
      data: {data: send_data},
      success: function(data) {
        console.log(data);
        for (var i in data) {
          var file = data[i];

          // Create a new file object with the necessary properties
          var newFile = { name: i, size: getImageSizeFromBase64(file) };

          // Manually create the preview element
          // var previewElement = Dropzone.createElement(
          //   Dropzone.options.documentDropzone.previewTemplate
          // );

          // // Add the 'dz-complete' class to the preview element
          // previewElement.classList.add('dz-complete');

          // // Append the preview element to the Dropzone
          // myDropzone.previewsContainer.appendChild(previewElement);

          // // Set the thumbnail image source
          // var img = previewElement.querySelector('img[data-dz-thumbnail]');
          // img.setAttribute('src', 'data:image/png;base64,' + file); // Assuming the file is a PNG image

          // Call the addedfile event to let Dropzone know about the new file
          myDropzone.emit('addedfile', newFile);

          // Call the thumbnail event to generate the thumbnail
          myDropzone.emit('thumbnail', newFile, 'data:image/png;base64,' + file);

          // Call the complete event to mark the file as complete
          myDropzone.emit('complete', newFile);

          // Add the file to Dropzone's internal data structure
          myDropzone.files.push(newFile);

          // Update the hidden input field with the file name
          $('form').append('<input type="hidden" name="document[]" value="' + i + '">');
        }
      }
    });
  @endif
}

  }
</script>