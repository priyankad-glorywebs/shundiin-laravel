@php 
$folderName = NUll;
$CurrentFolderPath = '';
if($entities['page_id'] != NUll){
    $CurrentFolderPath = $entities['CurrentFolderPath'];
    foreach($entities['FoldersItems'] as $fvals){
        $folderName = $fvals->name;
    }
}
@endphp
<div class="card card-outline card-primary">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.js"></script>
    <div class="card-header">
        <h3 class="card-title float-none float-sm-left mb-3">Media Manager</h3>
        <div class="btn-group float-right">
            <div class="mr-2">
                <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#upload-modal"><i
                        class="fas fa-cloud-upload-alt nav-icon"></i> Upload</a>
            </div>
            <div class="mr-0">
                <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                    data-target="#add-folder-modal"><i class="fa fa-plus"></i> Add Folder</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="jquery-message"></div>
        <div class="row">
            <div class="col-md-9" id="media-container">
                <div class="list-media">
                    <ul class="media-list">
                        <!-- START FOLDER LOOP -->
                        <div class="folder-data-view"
                        @if(isset($_REQUEST['page']) == true)
                            @if($_REQUEST['page'] > 1 )
                            style="display:none";
                            @endif
                        @endif
                        >
                        @foreach ($entities['FoldersItems'] as $item)
                            @if ($entities['page_id'] != $item->id)
                                <li class="media-item" title="{{ $item->name }}">
                                    <a href="{{ route('admin.media.folder', [$item->id]) }}" class="media-item-info"
                                        data-id="{{ $item->id }}">
                                        @php
                                            $arr = $item->toArray();
                                            $arr['url'] = $item->path;
                                            $arr['updated'] = adLte_date_format($item->updated_at);
                                            $arr['size'] = format_size_units($item->size);
                                            $arr['is_file'] = 1;
                                        @endphp
                                        <textarea class="d-none item-info">@json($arr)</textarea>
                                        <div class="attachment-preview">
                                            <div class="thumbnail">
                                                <div class="centered">
                                                    @if ($item->path)
                                                        <img src="{{ URL::asset('storage/photos/' . $item->path) }}"
                                                            alt="{{ $item->name }}">
                                                    @else
                                                        @if ($item->type == 'image')
                                                            <img class="lazyload"
                                                                src="{{ URL::asset('folder.png') }}"
                                                                data-src="{{ URL::asset('folder.png') }}"
                                                                alt="{{ $item->name }}">
                                                        @else
                                                            <img class="lazyload"
                                                                src="{{ URL::asset('folder.png') }}"
                                                                data-src="{{ URL::asset('folder.png') }}"
                                                                alt="{{ $item->name }}">
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media-name">
                                            <span>{{ $item->name }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </div>    
                        <!-- END FOLDER LOOP -->
                        @foreach ($entities['FilesItems'] as $item)
                            <li class="media-item" title="{{ $item->name }}">
                                <a href="javascript:void(0)" class="media-item-info media-file-item"
                                    data-id="{{ $item->id }}">
                                    @php
                                        $arr = $item->toArray();
                                        $arr['url'] = $item->path;
                                        $arr['updated'] = adLte_date_format($item->updated_at);
                                        $arr['size'] = format_size_units($item->size);
                                        $arr['is_file'] = 1;
                                    @endphp
                                    <textarea class="d-none item-info">@json($arr)</textarea>
                                    <div class="attachment-preview">
                                        <div class="thumbnail">
                                            <div class="centered">
                                                @if ($item->path)
                                                    @if ($item->extension == 'png' ||
                                                        $item->extension == 'webp' ||
                                                        $item->extension == 'jpeg' ||
                                                        $item->extension == 'svg' ||
                                                        $item->extension == 'jpg')
                                                        <img src="{{ URL::asset('storage/photos/' . $item->path) }}"
                                                            alt="{{ $item->name }}">
                                                            @elseif($item->extension == 'pdf')
                                                            <img class="lazyload"
                                                                src="{{ URL::asset('pdf.png') }}"
                                                                data-src="{{ URL::asset('pdf.png') }}"
                                                                alt="{{ $item->name }}">
                                                            @elseif($item->extension == 'xls')
                                                            <img class="lazyload"
                                                                src="{{ URL::asset('xls.png') }}"
                                                                data-src="{{ URL::asset('xls.png') }}"
                                                                alt="{{ $item->name }}">
                                                            @elseif($item->extension == 'csv')
                                                            <img class="lazyload"
                                                                src="{{ URL::asset('csv.png') }}"
                                                                data-src="{{ URL::asset('csv.png') }}"
                                                                alt="{{ $item->name }}">
                                                            @elseif($item->extension == 'doc')
                                                            <img class="lazyload"
                                                                src="{{ URL::asset('doc.png') }}"
                                                                data-src="{{ URL::asset('doc.png') }}"
                                                                alt="{{ $item->name }}">
                                                        @endif
                                                @else
                                                    @if ($item->type == 'image')
                                                        <img class="lazyload"
                                                            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                            data-src="{{ URL::asset('storage/photos/' . $item->path) }}"
                                                            alt="{{ $item->name }}">
                                                    @else
                                                        <img class="lazyload"
                                                            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                            data-src="{{ URL::asset('storage/photos/' . $item->path) }}"
                                                            alt="{{ $item->name }}">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-name">
                                        <span>{{ $item->name }}</span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="pagination">
                    {{ $entities['FilesItems']->links() }}
                </div> 
                <div class="mt-3">

                </div>
            </div>

            <div class="col-md-3" id="preview-file">
                <div class="preview">
                    <i class="fas fas fa-photo-video nav-icon"></i>
                </div>
                <p class="text-center">Click file to view info.</p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal fade" id="add-folder-modal" tabindex="-1" aria-labelledby="add-folder-modal-label"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.media.add-folder') }}" method="post" class="form-ajax"
                    data-success="add_folder_success">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add-folder-modal-label"> Add Folder</h5><button type="button"
                                class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group"><label class="col-form-label" for="name">Folder name </label>
                                <input type="text" name="name" class="form-control " id="name"
                                    value="" autocomplete="off" placeholder="">
                            </div> <input type="hidden" name="folder_id" value="{{ $entities['page_id'] }}"><input
                                type="hidden" name="type" value="">
                            
                                @if($entities['page_id'] != NUll)
                                <input type="hidden" name="working_dir" id="working_dir"
                                    value="{{$CurrentFolderPath}}">
                                @else
                                <input type="hidden" name="working_dir" id="working_dir"
                                    value="">
                                @endif

                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                data-dismiss="modal"><i class="fa fa-times"></i> Close</button> <button
                                type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Folder</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="upload-modal" tabindex="-1" aria-labelledby="upload-modal-label"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="upload-modal-label">
                            Upload File(s)
                        </h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="upload" role="tabpanel"
                                aria-labelledby="upload-tab">
                                <form action="{{ URL::to('/') . '/admin/file-manager/upload' }}" role="form"
                                    id="uploadForm" name="uploadForm" method="post" class="dropzone"
                                    enctype="multipart/form-data">
                                    <div class="form-group" id="attachment">
                                        <div class="controls text-center">
                                            <div class="input-group w-100"><a
                                                    class="btn btn-primary w-100 text-white dz-clickable"
                                                    id="upload-button">Choose File(s)</a></div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="folder_id" value="{{ $entities['page_id'] }}">
                                        @if($entities['page_id'] != NUll)
                                        <input type="hidden" name="working_dir" id="working_dir"
                                            value="{{$CurrentFolderPath}}">
                                        @else
                                        <input type="hidden" name="working_dir" id="working_dir"
                                            value="">
                                        @endif
                                        <input type="hidden" name="type"
                                        id="type" value="image"> <input type="hidden" name="_token"
                                        value="{{ csrf_token() }}">
                                    <div class="dz-default dz-message"><span>Or drop files here to upload</span></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal"><i class="fa fa-times"></i> Close </button></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    @php
        $mimeTypes = ['application/xls','text/csv','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword','application/xls','image/webp','application/pdf','application/octet-stream', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/svg+xml', 'application/pdf', 'text/xml', 'video/mp4', 'audio/mp3'];
    @endphp
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {

            new Dropzone("#uploadForm", {
                paramName: "upload",
                uploadMultiple: false,
                parallelUploads: 5,
                timeout: 0,
                clickable: '#upload-button',
                dictDefaultMessage: "",
                maxFilesize: 3,
                maxFiles: 5,
                chunking: true,
                chunkSize: 1048576,
                init: function() {
                    this.on('success', function(file, response) {
                        console.log(response);
                        // var dataArray = [response];
                        if (response.url) {
                            fileStoreData(file);
                        } else if(response.error){
                            let alretDiv =
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert"><span>'+ response.error.message +'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                            $("#uploadForm").prepend(alretDiv);
                        } else {
                            let alretDiv =
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert"><span>A file with this name already exists</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                            $("#uploadForm").prepend(alretDiv);
                            //window.location = "";
                        }

                        if (response == 'OK') {
                            window.location = "";
                        } else {
                            //this.defaultOptions.error(file, response.join('\n'));
                        }
                    });
                },
                headers: {
                    'Authorization': "Bearer {{ csrf_token() }}"
                },
                acceptedFiles: "{{ implode(',', $mimeTypes) }}",
            });

            function fileStoreData(file) {
                /*START AJAX*/
                let folder_id = jQuery("#myTabContent #uploadForm input[name=folder_id]").val();
                let working_dir = jQuery("#myTabContent #uploadForm input[name=working_dir]").val();
                let fileinfo = file.upload;
                let fileType = file.type;
                let fileSize = file.size;
                let fileURL = file.dataURL;
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.media.store_file') }}",
                    data: {
                        'folder_id'     : folder_id,
                        'working_dir'   : working_dir,
                        'fileinfo'      : fileinfo,
                        'fileType'      : fileType,
                        'fileSize'      : fileSize,
                        'fileURL'       : fileURL,
                        "_token"        : "{{ csrf_token() }}",
                    }
                }).done(function(data) {
                    window.location = "";
                    
                    // if (data.status === false) {
                    //     show_message(data);
                    //     return false;
                    // }

                    return false;
                }).fail(function(data) {
                    // show_message(data);
                    return false;
                });
                /*END AJAX*/
            }

            const mediaContainer = $('#media-container');
            mediaContainer.on('click', '.media-file-item', function() {
                let temp = document.getElementById('media-detail-template').innerHTML;
                let info = JSON.parse($(this).find('.item-info').val());

                info.name = htmlspecialchars(info.name);
                temp = replace_template(temp, info);
                $('#preview-file').html(temp);
            });
            /* Delete Files */
            function confirm_message(question, callback, title = 'Are you sure?', type = 'warning') {
                Swal.fire({
                    title: title,
                    text: question,
                    icon: 'warning',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'Cancel!',
                }).then((result) => {
                    callback(result.value);
                });
            }
            function toggle_global_loading(status, timeout = 300) {
                if (status) {
                    $("#admin-overlay").fadeIn(300);
                } else {
                    setTimeout(function(){
                        $("#admin-overlay").fadeOut(300);
                    }, timeout);
                }
            }
            $('#preview-file').on('click', '.delete-file', function () {
                let id = $(this).data('id');
                let is_file = $(this).data('is_file');
                let name = $(this).data('name');
                let token = "{{ csrf_token() }}";

                confirm_message('Are you sure you want to delete the selected items?',
                    function (value) {
                        if (!value) {
                            return false;
                        }
                        toggle_global_loading(true);
                        ajaxRequest(
                           " {{route('admin.media.destroy')}}",
                            {
                                id      : id,
                                is_file : is_file,
                                '_token': token
                            },
                            {
                                method: 'DELETE',
                                callback: function (response) {
                                    toggle_global_loading(false);
                                    show_message(response);
                                    setTimeout(
                                        function () {
                                            window.location = "";
                                        },
                                        500
                                    );
                                },
                                failCallback: function (response) {
                                    toggle_global_loading(false);
                                    show_message(response);
                                }
                            }
                        );
                    }
                );

                function ajaxRequest(url, data = null, options = {}) {
                let jqxhr = $.ajax({
                    type: options.method || 'POST',
                    url: url,
                    dataType: options.dataType || 'json',
                    data: data,
                    cache: false,
                    async: typeof options.async !== 'undefined' ? options.async : true,
                });

                jqxhr.done(function(response) {
                    if (options.callback || false) {
                        options.callback(response);
                    }
                });

                jqxhr.fail(function(response) {
                    if (options.failCallback || false) {
                        options.failCallback(response);
                    }
                });

                return jqxhr.responseJSON;
            }
            });
        });

        function add_folder_success(form) {
            window.location = "";
        }

        function replace_template(template, data) {
            return template.replace(
                /{(\w*)}/g,
                function(m, key) {
                    return data.hasOwnProperty(key) ? data[key] : "";
                }
            );
        }
    </script>
</div>
<template id="media-detail-template">
    <div class="box-image {extension}-bg">
        <img src="{{ URL::asset('storage/photos/') . '/' }}{url}" alt="" class="preview-image">
    </div>

    <div class="mt-2 mb-3 float-left">
        <a href="{{ URL::asset('storage/photos/') . '/' }}{url}" class="btn btn-success mr-2"
            download="">{{ trans('Download') }}</a>
        <a href="javascript:void(0)" class="delete-file btn btn-danger" data-id="{id}" data-is_file="{is_file}"
            data-name="{name}">{{ trans('Delete') }}</a>
    </div>

    <form action="" method="post" class="form-ajax">
        @method('put')
        <input type="hidden" name="is_file" value="{is_file}">
        <table class="table">
            <tbody>
                <tr>
                    <td>{{ trans('Path') }}</td>
                    <td><input type="text" name="url" class="form-control " id="a8btbd-url"
                            value="{{ URL::asset('storage/photos/') . '/' }}{url}" autocomplete="off"
                            placeholder="" disabled=""></td>
                </tr>

                <tr>
                    <td>{{ trans('Name') }}</td>
                    <td>{name}</td>
                </tr>

                <tr>
                    <td>{{ trans('Extension') }}</td>
                    <td>{extension}</td>
                </tr>

                <tr>
                    <td>{{ trans('Size') }}</td>
                    <td>{size}</td>
                </tr>
                <tr>
                    <td>{{ trans('Last update') }}</td>
                    <td>{updated}</td>
                </tr>
            </tbody>
        </table>
    </form>

</template>
<style>
    .xls-bg{
        background-image: url(/xls.png);
        background-size: contain;
        background-repeat: no-repeat;
    }
    .pdf-bg{
        background-image: url(/pdf.png);
        background-size: contain;
        background-repeat: no-repeat;
    }
    .csv-bg{
        background-image: url(/csv.png);
        background-size: contain;
        background-repeat: no-repeat;
    }
    .doc-bg{
        background-image: url(/doc.png);
        background-size: contain;
        background-repeat: no-repeat;
    }
</style>    
<!-- /.card -->
