<script src="{{ asset('plugins/tinymce/tinymce.min.js?v=v3.2.10') }}" id="core-tinymce"></script>
<div class="card card-outline card-primary">
    @if ($entities['post_id'] != null)
        <form action="{{ route($entities['actionRoute'], ['id' => $entities['post_id']]) }}" method="post"
            class="form-ajax" novalidate="novalidate">
        @else
            <form action="{{ route($entities['actionRoute']) }}" method="post" class="form-ajax" novalidate="novalidate">
    @endif
    <input type="hidden" name="post_types" value="{{ $entities['post_types'] }}" />
    <?php echo csrf_field(); ?>
    <div class="card-header">
        <div class="btn-group float-sm-right">
            @if ($entities['post_id'] != null)
                @if ($entities['post_id'] != null)
                    <button type="submit" class="btn btn-success px-5"><i class="fa fa-edit"></i> Update
                    </button>
                @endif
            @else
                <button type="submit" class="btn btn-success px-5"><i class="fa fa-save"></i> Save
                </button>
            @endif
            <button type="button" class="btn btn-warning cancel-button px-3"><i class="fa fa-refresh"></i> Reset
            </button>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div id="jquery-message" style="width: 100%"></div>
            <div class="col-md-9">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex flex-column justify-content-center">
                            <h5 class="mb-0">Information</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group"><label class="col-form-label"
                                        for="{{ $entities['idContent'] }}-title">Title
                                        <abbr>*</abbr> </label>
                                    @if ($entities['pageInfo'] != null)
                                        <input type="text" name="title" class="form-control"
                                            id="{{ $entities['idContent'] }}-title"
                                            value="{{ $entities['pageInfo']->title }}" autocomplete="off" placeholder=""
                                            required="">
                                    @else
                                        <input type="text" name="title" class="form-control generate-slug"
                                            id="{{ $entities['idContent'] }}-title" value="" autocomplete="off"
                                            placeholder="" required="">
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{-- <label class="col-form-label" for="{{ $entities['idContent'] }}-slug">Slug</label> --}}
                                    <div class="input-group">
                                        @if ($entities['pageInfo'] != null)
                                            <input type="text" name="slug" class="form-control edit-slug"
                                                id="{{ $entities['idContent'] }}-slug"
                                                value="{{ $entities['pageInfo']->slug }}" autocomplete="off"
                                                data-max-length="150" readonly="" placeholder="Slug">
                                        @else
                                            <input type="text" name="slug" class="form-control "
                                                id="{{ $entities['idContent'] }}-slug" value=""
                                                autocomplete="off" data-max-length="150" readonly=""
                                                placeholder="Slug">
                                        @endif
                                        <div class="input-group-append"><span class="input-group-text"><a
                                                    href="javascript:void(0)" class="slug-edit"><i
                                                        class="fa fa-edit"></i></a></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                             <label class="col-form-label" for="description">Description <abbr>*</abbr></label>
                            <div class="input-group">
                                <textarea name="description" class="form-control myTextarea" id="description-data" required>{{$entities['pageInfo']->description??''}}
                                </textarea>
                            </div>
                        </div> -->
                    
                     
                        <div class="form-group">
                            <label class="col-form-label" for="{{ $entities['idContent'] }}">Content</label>
                            @if (isset($_REQUEST['template']) && $_REQUEST['template'] == 'default')
                                <!-- START TEMPLATE CODE-->
                                @php
                                    $blockData = null;
                                @endphp
                                @if ($entities['pageInfo'] != null)
                                    @if ($entities['pageInfo']->json_metas != null)
                                        @if (str_contains($entities['pageInfo']->json_metas, 'block_content') == true)
                                            @php
                                                $blockData = $entities['pageInfo']->json_metas;
                                            @endphp
                                        @endif
                                    @endif
                                @endif

                                @php 
                                $jsonData   = json_decode($blockData, true);
                                $NewJson    = [];
                                $json_metas = null;
                                if(!empty($jsonData)){
                                    foreach($jsonData as $jsonDataVal){
                                        $NewJson['template'] = 'default';
                                        if($jsonDataVal != 'notemplate'){
                                            $NewJson['block_content']['content'] = $jsonDataVal['content'];
                                        }
                                    }
                                    $json_metas = json_encode($NewJson);
                                }
                                @endphp
                                @component('components.page-blocklist', ['entities' => $entities, 'blockData' => $json_metas])
                                @endcomponent
                                <!-- END TEMPLATE CODE -->
                            @else
                                <!-- start notemplate selected -->
                                    @if(isset($_REQUEST['template']) && $_REQUEST['template'] == 'notemplate')
                                        <textarea class="form-control cms-content-editor" name="content" id="{{ $entities['idContent'] }}" rows="5">
                                            @if ($entities['pageInfo'] != null)
                                                {{ $entities['pageInfo']->content ?? '' }}
                                            @endif
                                        </textarea>
                                    <!-- end notemplate selected -->
                                    @else
                                        <!-- start module data availavle -->	
                                        
                                            @php
                                                $blockData = null;
                                            @endphp
                                            @if ($entities['pageInfo'] != null && $entities['pageInfo']->type == 'pages')
                                            @if ($entities['pageInfo']->templateStatus != null)
                                            @if (str_contains($entities['pageInfo']->templateStatus, 'default') == true &&
                                                            str_contains($entities['pageInfo']->json_metas, 'block_content') == true)
                                                            {{-- {{dd('in')}} --}}
                                                        @php
                                                            $blockData = $entities['pageInfo']->json_metas;
                                                        @endphp

                                                        @php 
                                                        $jsonData = json_decode($blockData, true);
                                                        $NewJson = [];
                                                        if(!empty($jsonData)){
                                                            foreach($jsonData as $jsonDataVal){
                                                                $NewJson['template'] = 'default';
                                                                $NewJson['block_content']['content'] = $jsonData['block_content']['content'];
                                                            }
                                                            $json_metas = json_encode($NewJson);
                                                        }
                                                        @endphp
                                                        @component('components.page-blocklist', ['entities' => $entities, 'blockData' => $json_metas])
                                                        @endcomponent
                                                    @else
                                                        <textarea class="form-control cms-content-editor" name="content" id="{{ $entities['idContent'] }}" rows="5">
                                                            @if ($entities['pageInfo'] != null)
                                                                {{ $entities['pageInfo']->content ?? '' }}
                                                            @endif
                                                        </textarea>
                                                    @endif
                                                @endif
                                                @else
                                                <textarea class="form-control cms-content-editor" name="content" id="{{ $entities['idContent'] }}" rows="5">
                                                    @if ($entities['pageInfo'] != null)
                                                        {{ $entities['pageInfo']->content ?? '' }}
                                                    @endif
                                                </textarea>
                                            @endif
                                        <!-- end module data availavle -->	
                                    @endif
                            @endif
                        </div>
                        <script type="text/javascript">
                            var tabeditor = '{{ request()->query('e', 'editor') }}';
                            loadEditorContent(tabeditor);

                            function loadEditorContent(tab) {
                                if (tab === 'editor') {
                                    tinymce.init({
                                        selector: '#{{ $entities['idContent'] }}',
                                        convert_urls: true,
                                        document_base_url: '{{ url('/storage') }}/',
                                       
                                        urlconverter_callback: function(url, node, on_save, name) {
                                            
                                            //url = url.replace("{{ url('/storage') }}/", '');
                                            return url;
                                        },
                                        height: 400,
                                        plugins: [
                                            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                            "searchreplace wordcount visualblocks visualchars code fullscreen",
                                            "insertdatetime media nonbreaking save table directionality",
                                            "emoticons template paste textpattern"
                                        ],
                                        menu: {
                                            file: {
                                                title: 'File',
                                                items: 'newdocument restoredraft | preview | print '
                                            },
                                            edit: {
                                                title: 'Edit',
                                                items: 'undo redo | cut copy paste | selectall | searchreplace'
                                            },
                                            view: {
                                                title: 'View',
                                                items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen'
                                            },
                                            insert: {
                                                title: 'Insert',
                                                items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime'
                                            },
                                            format: {
                                                title: 'Format',
                                                items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align lineheight | forecolor backcolor | removeformat'
                                            },
                                            tools: {
                                                title: 'Tools',
                                                items: 'spellchecker spellcheckerlanguage | code wordcount'
                                            },
                                            table: {
                                                title: 'Table',
                                                items: 'inserttable | cell row column | tableprops deletetable'
                                            },
                                        },
                                        toolbar: [{
                                                name: 'new',
                                                items: ['newdocument']
                                            },
                                            {
                                                name: 'history',
                                                items: ['undo', 'redo']
                                            },
                                            {
                                                name: 'styles',
                                                items: ['styleselect']
                                            },
                                            {
                                                name: 'formatting',
                                                items: ['bold', 'italic']
                                            },
                                            {
                                                name: 'alignment',
                                                items: ['alignleft', 'aligncenter', 'alignright', 'alignjustify']
                                            },
                                            {
                                                name: 'indentation',
                                                items: ['outdent', 'indent']
                                            },
                                            {
                                                name: 'media',
                                                items: ['link', 'image', 'media']
                                            },
                                            {
                                                name: 'view',
                                                items: ['code', 'preview', 'fullscreen']
                                            }
                                        ],
                                        file_picker_callback: function(callback, value, meta) {
                                            let x = window.innerWidth || document.documentElement.clientWidth || document
                                                .getElementsByTagName('body')[0].clientWidth;
                                            let y = window.innerHeight || document.documentElement.clientHeight || document
                                                .getElementsByTagName('body')[0].clientHeight;
                                            let cmsURL = '{{ route('home') }}/admin/file-manager?editor=' + meta.fieldname;

                                            if (meta.filetype == 'image') {
                                                cmsURL = cmsURL + "&type=image";
                                            } else {
                                                cmsURL = cmsURL + "&type=file";
                                            }

                                            
                                            tinyMCE.activeEditor.windowManager.openUrl({
                                                url: cmsURL,
                                                title: 'Filemanager',
                                                width: x * 0.8,
                                                height: y * 0.8,
                                                resizable: "yes",
                                                close_previous: "no",
                                                onMessage: (api, message) => {
                                                    callback(message.content);
                                                }
                                            });
                                        },
                                        setup: function(ed) {
                                            ed.on('change', function(e) {
                                                let title = $('input[name=title]').val();
                                            //  let desc =$('#discription-data').val();
                                                
                                            let description = tinyMCE.activeEditor.getContent();
                                                if (!$('.review-title').length) {
                                                    return false;
                                                }

                                                $.ajax({
                                                    type: 'POST',
                                                    url: '{{ route('home') }}admin/ajax/SeoContent',
                                                    dataType: 'json',
                                                    data: {
                                                        'title': title,
                                                        'desc':desc,
                                                        'description': description,
                                                        "_token": "{{ csrf_token() }}",
                                                    }
                                                }).done(function(data) {
                                                    if (data.status === false) {
                                                        show_message(data);
                                                        return false;
                                                    }

                                                    if (!$("#meta_title").val()) {
                                                        $(".review-title").text(data.title);
                                                    }

                                                    if (!$("#meta_description").val()) {
                                                        $(".review-description").text(data.description);
                                                    }

                                                    if (!$("#description-data").val()) {
                                                        $("#description-dataos").text(data.desc);
                                                    }

                                                    if (!$("#meta_description").val()) {
                                                        $("#review-description").val(data.description);
                                                    }

                                                    return false;
                                                }).fail(function(data) {
                                                    show_message(data);
                                                    return false;
                                                });
                                            })
                                        }
                                    });
                                } else {
                                    var mixedMode = {
                                        name: "htmlmixed",
                                        scriptTypes: [{
                                                matches: /\/x-handlebars-template|\/x-mustache/i,
                                                mode: null
                                            },
                                            {
                                                matches: /(text|application)\/(x-)?vb(a|script)/i,
                                                mode: "vbscript"
                                            }
                                        ]
                                    };

                                    var editor = CodeMirror.fromTextArea(document.getElementById("{{ $entities['idContent'] }}"), {
                                        mode: mixedMode,
                                        lineNumbers: true,
                                        styleActiveLine: true,
                                        matchBrackets: true,
                                        lineWrapping: true,
                                        extraKeys: {
                                            "Ctrl-Space": "autocomplete"
                                        },
                                    });

                                    editor.setOption("theme", 'default');
                                }
                            }
                        </script>
                    </div>
                </div>

                {{--@if ($entities['post_types'] == 'posts')

                    @php
                        $videoData = [];
                        if (isset($entities['pageInfo']->meta_key)) {
                            if ($entities['pageInfo']->meta_key == 'video_data') {
                                if (isset($entities['pageInfo']->meta_value)) {
                                    $videoData = json_decode($entities['pageInfo']->meta_value, true);
                                }

                            }
                        }
                    @endphp
                    <div class="card mt-3">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h4 class="card-title">Add Video Details</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About heading</label>
                                                @if (isset($value['abhead']))
                                                    <input type="text" name="abhead" class="form-control" value="{{ $value['abhead'] }}" required>
                                                @else
                                                <input type="text" name="abhead" class="form-control" required>
                                                <span class="text-danger error-text abhead_error"></span>
                                             @endif  
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif--}}
               
                @if ($entities['post_types'] == 'events')

                    @php
                        $eventData = [];
                        $eventInfo = [];
                        $eventStartDate = null;
                        $eventEndDate = null;
                        $eventPrice = null;
                        $eventP_off = null;
                        $eventS_Desc = null;
                        $eventRegilbl = null;
                        $eventRegilink = null;
                        $eventlimibl = null;
                        
                        if ($entities['pageInfo'] != null) {
                            $eventInfo = json_decode($entities['pageInfo']->json_metas, true);
                            if (!empty($eventInfo['eventInfo'])) {
                                $eventData = unserialize($eventInfo['eventInfo']);
                                $eventStartDate = !empty($eventData['event_sdate']) ? $eventData['event_sdate'] : '';
                                $eventEndDate = !empty($eventData['event_edate']) ? $eventData['event_edate'] : '';
                                $eventPrice = !empty($eventData['event_price']) ? $eventData['event_price'] : '';
                                $eventP_off = !empty($eventData['event_p_off']) ? $eventData['event_p_off'] : '';
                                $eventS_Desc = !empty($eventData['event_s_desc']) ? $eventData['event_s_desc'] : '';
                                $eventRegilbl = !empty($eventData['event_regilbl']) ? $eventData['event_regilbl'] : '';
                                $eventRegilink = !empty($eventData['event_regilink']) ? $eventData['event_regilink'] : '';
                                $eventlimibl = !empty($eventData['event_limitedlbl']) ? $eventData['event_limitedlbl'] : '';
                            }
                        }
                    @endphp
                    <div class="card mt-3">
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h4 class="card-title">Events Details</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="">Start Date</label>
                                    <div class="input-group date" id="startdatetime" data-target-input="nearest">
                                        <input autocomplete="off" value="{{ $eventStartDate }}" name="event_sdate"
                                            type="text" class="form-control datetimepicker-input"
                                            data-target="#startdatetime" />
                                        <div class="input-group-append" data-target="#startdatetime"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="">End Date</label>
                                    <div class="input-group date" id="enddatetime" data-target-input="nearest">
                                        <input autocomplete="off" value="{{ $eventEndDate }}" name="event_edate"
                                            type="text" class="form-control datetimepicker-input"
                                            data-target="#enddatetime" />
                                        <div class="input-group-append" data-target="#enddatetime"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="">Price</label>
                                    <div class="input-group" id="p-price">
                                        <input value="{{ $eventPrice }}" name="event_price" type="number"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="">% Off</label>
                                    <div class="input-group" id="p-off">
                                        <input value="{{ $eventP_off }}" name="event_p_off" type="number"
                                            class="form-control" min="1" max="100" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="">Short Description</label>
                                    <div class="input-group">
                                        <textarea id="summernote" name="event_s_desc">{{ $eventS_Desc }}</textarea>
                                    </div>
                                </div>
                                <script>
                                    $(function() {
                                        // Summernote
                                        $('#summernote').summernote({
                                            height: 150,
                                            tabsize: 2,
                                            toolbar: [
                                                ['view', ['fullscreen', 'codeview']],
                                                ['style', ['style']],
                                                ['font', ['bold', 'italic', 'underline', 'clear']],
                                                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
                                                    'subscript', 'clear'
                                                ]],
                                                ['fontsize', ['fontsize']],
                                                ['color', ['color']],
                                                ['para', ['ul', 'ol', 'paragraph']],
                                                ['height', ['height']],
                                                ['table', ['table']],
                                                ['insert', ['link', 'hr']],
                                                // ['help', ['help']]
                                            ],
                                        })
                                    })
                                </script>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="">Register Now Button Label</label>
                                    <div class="input-group" id="p-price">
                                        <input value="{{ $eventRegilbl }}" name="event_regilbl" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="">Register Now Button Link</label>
                                    <div class="input-group" id="p-off">
                                        <input value="{{ $eventRegilink }}" name="event_regilink" type="url"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="">Limited Seats Label</label>
                                    <div class="input-group" id="p-price">
                                        <input value="{{ $eventlimibl }}" name="event_limitedlbl" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card mt-3">
                    <div class="card-header row">
                        <div class="col-md-6">
                            <h4 class="card-title">Custom SEO</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:void(0)" class="custom-seo"><i class="fa fa-edit"></i> Custom SEO
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="box-custom-seo box-hidden">
                            <div class="form-group"><label for="meta_title" class="form-label">Title</label>
                                @if ($entities['pageInfo'] != null)
                                    <input type="text" name="meta_title" id="meta_title" class="form-control"
                                        value="{{ $entities['pageInfo']->meta_title }}" autocomplete="off">
                                @else
                                    <input type="text" name="meta_title" id="meta_title" class="form-control"
                                        value="" autocomplete="off">
                                @endif
                            </div>
                            <div class="form-group"><label for="meta_description"
                                    class="form-label">Description</label>
                                @if ($entities['pageInfo'] != null)
                                    <textarea name="meta_description" id="meta_description" class="form-control" rows="4" autocomplete="off">{{ $entities['pageInfo']->meta_description }}</textarea>
                                @else
                                    <textarea name="meta_description" id="meta_description" class="form-control" rows="4" autocomplete="off"></textarea>
                                @endif
                            </div>
                            <hr>
                        </div>
                        <div class="seo-review">
                            <h5>Preview</h5>
                            <div class="review-title">
                                @if ($entities['pageInfo'] != null)
                                    {{ $entities['pageInfo']->title }} @endif
                            </div>
                            <div >
                                @if ($entities['name'] == 'services')
                                    @if ($entities['pageInfo'] != null)
                                        <a href="{{ URL::to('/') }}/{{ $entities['name'] }}/{{ $entities['pageInfo']->slug }}" class="review-url" target="_blank">
                                            {{ URL::to('/') }}/{{ $entities['name'] }}/<span>{{ $entities['pageInfo']->slug }}</span>
                                        </a>
                                    @else
                                        <a href="{{ URL::to('/') }}/{{ $entities['name'] }}/" class="review-url" target="_blank">
                                            {{ URL::to('/') }}/{{ $entities['name'] }}/<span></span>
                                        </a>
                                    @endif
                                @elseif($entities['name'] == 'events')
                                    @if ($entities['pageInfo'] != null)
                                        <a href="{{ URL::to('/') }}/{{ $entities['name'] }}/{{ $entities['pageInfo']->slug }}" class="review-url" target="_blank">
                                            {{ URL::to('/') }}/{{ $entities['name'] }}/<span>{{ $entities['pageInfo']->slug }}</span>
                                        </a>
                                    @else
                                        <a href="{{ URL::to('/') }}/{{ $entities['name'] }}/" class="review-url" target="_blank">
                                            {{ URL::to('/') }}/{{ $entities['name'] }}/<span></span>
                                        </a>
                                    @endif
                                @else
                                    @if ($entities['pageInfo'] != null)
                                        @if ($entities['name'] == 'pages' || $entities['name'] == 'posts')
                                            <a href="{{URL::to('/')}}/{{$entities['pageInfo']->slug}}" class="review-url" target="_blank">
                                                {{ URL::to('/') }}/<span>{{ $entities['pageInfo']->slug }}</span>
                                            </a>
                                        @else
                                            <a href="{{ URL::to('/') }}/{{ $entities['name'] }}/{{ $entities['pageInfo']->slug }}" class="review-url" target="_blank">
                                                {{ URL::to('/') }}/{{ $entities['name'] }}/<span>{{ $entities['pageInfo']->slug }}</span>
                                            </a>
                                        @endif
                                    @else
                                        @if ($entities['name'] == 'pages' || $entities['name'] == 'posts')
                                            <a href="{{ URL::to('/') }}/" class="review-url" target="_blank">
                                                {{ URL::to('/') }}/<span></span>
                                            </a>
                                        @else
                                            <a href="{{ URL::to('/') }}/{{ $entities['name'] }}/" class="review-url" target="_blank">
                                                {{ URL::to('/') }}/{{ $entities['name'] }}/<span></span>
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div class="review-description">
                                @if ($entities['pageInfo'] != null)
                                    {{ $entities['pageInfo']->meta_description }}
                                @endif
                            </div>
                            @if ($entities['pageInfo'] != null)
                                <input type="hidden" id="review-description" name="review_description"
                                    value="{{ $entities['pageInfo']->meta_description }}" />
                            @else
                                <input type="hidden" id="review-description" name="review_description"
                                    value="" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex flex-column justify-content-center">
                            <h5 class="mb-0">Status</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label" for="{{ $entities['idContent'] }}-status">Status</label>
                            @if ($entities['pageInfo'] != null)
                                <select style="width: 100%" name="status" id="{{ $entities['idContent'] }}-status">
                                    <option @if ($entities['pageInfo']->status == 'publish') selected @endif value="publish">
                                        Publish
                                    </option>
                                    <option @if ($entities['pageInfo']->status == 'private') selected @endif value="private">
                                        Private
                                    </option>
                                    <option @if ($entities['pageInfo']->status == 'draft') selected @endif value="draft">Draft
                                    </option>
                                    <option @if ($entities['pageInfo']->status == 'trash') selected @endif value="trash">Trash
                                    </option>
                                </select>
                            @else
                                <select style="width: 100%" name="status" id="{{ $entities['idContent'] }}-status">
                                    <option value="publish">Publish
                                    </option>
                                    <option value="private">Private
                                    </option>
                                    <option value="draft">Draft
                                    </option>
                                    {{-- <option value="trash">Trash
                                    </option> --}}
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($entities['post_types'] == 'pages')
                    <div class="form-group">
                        <label class="col-form-label" for="{{ $entities['idContent'] }}-metatemplate">Template
                        </label>
                        <select name="meta[template]" id="{{ $entities['idContent'] }}-metatemplate">
                            <option value="notemplate">Choose Template</option>
                            <option value="default"
                                @if ($entities['pageInfo'] != null) 
                                    @if ($entities['pageInfo']->json_metas != null)
                                        @if (str_contains($entities['pageInfo']->templateStatus, 'default') == true)
                                            selected="selected"
                                        @endif
                                    @endif
                                @endif
                >Module Template</option>
                </select>
            </div>
            @endif
            <div class="form-group"> <label class="col-form-label">Featured image</label>
                <div class="form-image text-center previewing">
                    @if ($entities['pageInfo'] != null)
                        @if ($entities['pageInfo']->thumbnail)
                            <a href="javascript:void(0)" class="image-clear"><i class="fa fa-times-circle fa-2x"></i>
                            </a>
                        @endif
                    @endif

                    <a href="javascript:void(0)" class="image-clear" style="display: none"><i
                            class="fa fa-times-circle fa-2x"></i>
                    </a>

                    @if ($entities['pageInfo'] != null)
                        <input type="hidden" name="thumbnail" class="input-path"
                            value="{{ $entities['pageInfo']->thumbnail }}">
                    @else
                        <input type="hidden" name="thumbnail" class="input-path" value="">
                    @endif
                    <div class="dropify-preview image-hidden"
                        @if ($entities['pageInfo'] != null) @if ($entities['pageInfo']->thumbnail) style="display: block" @endif
                        @endif
                        >
                        <span class="dropify-render">
                            @if ($entities['pageInfo'] != null)
                                @if ($entities['pageInfo']->thumbnail)
                                    <img src="{{ asset($entities['pageInfo']->thumbnail) }}" alt="pageinfo">
                                @endif
                            @endif
                        </span>
                        <div class="dropify-infos">
                            <div class="dropify-infos-inner">
                                <p class="dropify-filename"><span class="dropify-filename-inner"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="icon-choose"><i class="fas fa-cloud-upload-alt fa-5x"></i>
                        <p>Click here to select file</p>
                    </div>
                </div>
            </div>
            
           
            @if ($entities['post_types'] == 'posts')
                <div class="form-group form-taxonomy card">
                    <div class="card-header">
                        <div class="d-flex flex-column justify-content-center">
                            <h5 class="mb-0">Categories</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <label class="col-form-label w-100">
                            Categories
                            <span>
                                <a href="javascript:void(0)" class="float-right add-new">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            </span>
                        </label>
                        @php
                            // $checked_categories
                            $checkedCat = [];
                            $checkedCats = [];
                            if ($entities['pageInfo'] != null) {
                                if ($entities['pageInfo']->json_taxonomies != null) {
                                    $checked_categories = json_decode($entities['pageInfo']->json_taxonomies, true);
                                    $checkedCats = $checked_categories;
                                    foreach ($checkedCats as $checkedCatsVal) {
                                        $checkedCat[] = $checkedCatsVal['id'];
                                    }
                                }
                            }
                            
                            $items = \App\Models\Taxonomies::with(['children'])
                                ->whereNull('parent_id')
                                ->where('taxonomy', '=', 'categories')
                                ->where('post_type', '=', 'posts')
                                ->get();
                            $value = \App\Models\Taxonomies::where('taxonomy', '=', 'categories')
                                ->pluck('id')
                                ->toArray();
                        @endphp

                        <div class="show-taxonomies taxonomy-categories">
                            <ul class="mt-2 p-0">
                                @foreach ($items as $item)
                                    @component('components.taxonomy_item', [
                                        'taxonomy' => 'categories',
                                        'item' => $item,
                                        'value' => $value,
                                        'checked' => $checkedCat,
                                    ])
                                    @endcomponent
                                @endforeach
                            </ul>
                        </div>

                        <div class="form-add mt-2 form-add-taxonomy box-hidden">
                            <div class="form-group">
                                <label class="col-form-label">Name <abbr>*</abbr></label>
                                <input type="text" class="form-control taxonomy-name" autocomplete="off">
                            </div>
                            <div class="form-group mb-1" data-select2-id="8"><label
                                    class="col-form-label">Parent</label>
                                <select class="form-control load-taxonomies taxonomy-parent"
                                    data-placeholder="--- Add New ---" data-post-type="posts" data-type="posts"
                                    data-taxonomy="categories">
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary mt-2" data-type="posts"
                                data-post_type="posts" data-taxonomy="categories">
                                <i class="fa fa-plus-circle"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
                <!-- START TAGS HERE -->
                <div class="form-group form-taxonomy card">
                    <div class="card-header">
                        <div class="d-flex flex-column justify-content-center">
                            <h5 class="mb-0">Tags</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <label class="col-form-label w-100">
                            Tags
                            <span>
                                <a href="javascript:void(0)" class="float-right add-new">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            </span>
                        </label>

                        <select class="form-control load-taxonomies select-tags" data-placeholder="--- Add New ---"
                            data-post-type="posts" data-type="posts" data-taxonomy="tags"
                            data-explodes="tags-explode">
                        </select>

                        <div class="show-tags mt-2">
                            @php
                                $items = \App\Models\Taxonomies::where('taxonomy', '=', 'tags')->get();
                            @endphp

                            @foreach ($checkedCats as $item)
                                @if ($item['taxonomy'] == 'tags')
                                    @component('components.tag-item', [
                                        'name' => 'tags',
                                        'item' => $item,
                                    ])
                                    @endcomponent
                                @endif
                            @endforeach
                        </div>

                        <div class="form-add mt-2 form-add-taxonomy box-hidden">
                            <div class="form-group mb-1">
                                <label class="col-form-label">Name <abbr>*</abbr></label>
                                <input type="text" class="form-control taxonomy-name" autocomplete="off">
                            </div>
                            <button type="button" class="btn btn-primary mt-2" data-type="posts"
                                data-post_type="posts" data-taxonomy="tags"><i class="fa fa-plus-circle"></i>
                                Add</button>
                        </div>
                    </div>
                </div>
                <!-- END TAGS HERE -->
            @endif


        </div>
    </div>
</div>
</form>
<!-- /.card -->
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {

        //Date and time picker
        $('#startdatetime').datetimepicker({
            icons: {
                timePicker: true,
                time: 'far fa-clock',
                format: 'MM/DD/YYYY hh:mm A'
            }
        });
        //Date and time picker
        $('#enddatetime').datetimepicker({
            icons: {
                timePicker: true,
                time: 'far fa-clock',
                format: 'MM/DD/YYYY hh:mm A'
            }
        });


        $('.form-taxonomy').on('click', '.add-new', function() {
            let formAdd = $(this).closest('.form-taxonomy').find('.form-add');
            if (formAdd.is(':visible')) {
                formAdd.hide('slow');
                $(this).children().removeClass('fa-minus').addClass('fa-plus');
            } else {
                $(this).children().removeClass('fa-plus').addClass('fa-minus');
                formAdd.show('slow');
            }
        });

        $('#{{ $entities['idContent'] }}-status').select2({
            allowClear: false,
            dropdownAutoWidth: !$(this).data('width'),
            width: $(this).data('width') || '100%',
            placeholder: function(params) {
                return {
                    id: null,
                    text: params.placeholder,
                }
            }
        });
        $('#{{ $entities['idContent'] }}-metatemplate').select2({
            allowClear: false,
            dropdownAutoWidth: !$(this).data('width'),
            width: $(this).data('width') || '100%',
            placeholder: function(params) {
                return {
                    id: null,
                    text: params.placeholder,
                }
            }
        });
        /* tags */
        let parent = 'body';
        $(parent + ' .load-taxonomies').select2({
            allowClear: true,
            dropdownAutoWidth: !$(this).data('width'),
            width: $(this).data('width') || '100%',
            placeholder: function(params) {
                return {
                    id: null,
                    text: params.placeholder,
                }
            },
            ajax: {
                method: 'GET',
                url: "{{ route('posts.load-categories') }}",
                dataType: 'json',
                data: function(params) {
                    let postType = $(this).data('post-type');
                    let taxonomy = $(this).data('taxonomy');
                    let explodes = $(this).data('explodes');
                    if (explodes) {
                        explodes = $("." + explodes).map(function() {
                            return $(this).val();
                        }).get();
                    }

                    return {
                        search: $.trim(params.term),
                        page: params.page,
                        explodes: explodes,
                        post_type: postType,
                        taxonomy: taxonomy
                    };
                }
            }
        });
        $('body').on('change', '.select-tags', function() {
            let item = $(this);
            let id = item.val();
            let taxonomy = item.data('taxonomy');
            let type = item.data('type');

            $.ajax({
                type: 'GET',
                url: '{{ route('home') }}/admin/taxonomy/' + type + '/' + taxonomy +
                    '/component-item',
                dataType: 'json',
                data: {
                    'id': id
                }
            }).done(function(response) {
                if (response.status === false) {
                    show_message(response);
                    return false;
                }

                item.closest('.form-taxonomy')
                    .find('.show-tags')
                    .append(response.data.html);

                item.val(null).trigger('change.select2');

                return false;
            }).fail(function(response) {
                show_message(response);
                return false;
            });
        });
        $(document).on('click', '.remove-tag-item', function() {
            $(this).closest('.tag').remove();
        });

        /* Add tags and categorie */
        $(document).on('click', '.form-add-taxonomy button', function() {
            let btn = $(this);
            let taxForm = btn.closest('.form-add');
            let name = taxForm.find('.taxonomy-name').val();
            let parent = taxForm.find('.taxonomy-parent').val();
            let type = btn.data('type');
            let taxonomy = btn.data('taxonomy');
            let postType = btn.data('post_type');
            let icon = btn.find('i').attr('class');

            btn.find('i').attr('class', 'fa fa-spinner fa-spin');
            btn.prop("disabled", true);

            $.ajax({
                type: 'POST',
                url: '{{ route('home') }}/admin/post-taxonomy/posts/taxonomy/' + taxonomy,
                dataType: 'json',
                data: {
                    name: name,
                    parent_id: parent,
                    post_type: postType,
                    taxonomy: taxonomy,
                    "_token": "{{ csrf_token() }}",
                }
            }).done(function(response) {
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);

                if (response.status === false) {
                    show_message(response);
                    setTimeout(function() {
                        $("#jquery-message").html('');
                    }, 2000);
                    return false;
                }

                let addForm = btn.closest('.form-taxonomy').find('.show-tags');
                if (addForm.length) {
                    addForm.append(response.data.html);
                } else {
                    let res = response.data.info;
                    let htmlItem = `<li class="m-1" id="item-category-${res.id}">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="${res.taxonomy}[]" class="custom-control-input" id="${res.taxonomy}-${res.id}" value="${res.id}" checked>
                            <label class="custom-control-label" for="${res.taxonomy}-${res.id}">${res.name}</label>
                        </div>
                    </li>`;

                    if (parent) {
                        addForm = btn.closest('.form-taxonomy').find(
                            '.show-taxonomies ul #item-category-' + res.parent_id +
                            ' ul:first');
                        if (addForm.length) {
                            addForm.append(htmlItem);
                        } else {
                            htmlItem = '<ul class="mt-2 p-0">' + htmlItem + '</ul>';
                            btn.closest('.form-taxonomy').find(
                                    '.show-taxonomies ul #item-category-' + res.parent_id)
                                .append(htmlItem);
                        }
                    } else {
                        btn.closest('.form-taxonomy')
                            .find('.show-taxonomies ul:first')
                            .append(htmlItem);
                    }
                }

                taxForm.find('.taxonomy-name').val('');
                if (parent) {
                    taxForm.find('.taxonomy-parent').val(null).trigger('change.select2');
                }
                return false;
            }).fail(function(response) {
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);
                show_message(response);
                return false;
            });
        });
    });
</script>
</div>
