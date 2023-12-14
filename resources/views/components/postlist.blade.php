<div class="card card-outline card-primary">
    <div class="card-header">
        {{-- <h3 class="card-title float-none float-sm-left mb-3">Pages</h3> --}}
        <a href="{{ route($entities['add_route']) }}">
            <div class="btn btn-primary float-sm-right">
                <i class="far fas fa-plus fa-lg mr-2"></i> Add new
            </div>
        </a>
        @if(isset($entities['name']))
            @if($entities['name'] == 'events')
            <div class="clipboard">
                <input onclick="copy()" class="copy-input" value="[upcoming-event number=6]" id="copyClipboard" readonly="readonly">
                <button class="copy-btn" id="copyButton" onclick="copy(94)"><i class="far fa-copy"></i></button>
            </div>
            @endif   
        @endif
    </div>
    <div class="card-body">
        <div id="jquery-message"></div>
        <div class="row">
            <div class="col-md-2">
                <form method="post" class="form-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="dropdown d-inline-block mb-2 mr-2">
                        <button type="button" class="btn btn-primary dropdown-toggle bulk-actions-button"
                            data-toggle="dropdown" aria-expanded="false" disabled>Bulk Actions</button>
                        <div class="dropdown-menu bulk-actions-actions" role="menu" style="">
                            <a class="dropdown-item select-action action-publish " href="javascript:void(0)"
                                data-action="publish">Publish</a>
                            <a class="dropdown-item select-action action-private " href="javascript:void(0)"
                                data-action="private">Private</a>
                            <a class="dropdown-item select-action action-draft " href="javascript:void(0)"
                                data-action="draft">Draft</a>
                            <a class="dropdown-item select-action action-trash " href="javascript:void(0)"
                                data-action="trash">Trash</a>
                            <a class="dropdown-item select-action action-delete  text-danger " href="javascript:void(0)"
                                data-action="delete">Delete</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-10">
                <form method="get" class="seachbox-status float-right" id="form-search">
                    <select id="selectedpostType" class="js-select2 text-left">
                        <option value="all_status">All Status</option>
                        <option value="publish">Publish</option>
                        <option value="private">Private</option>
                        <option value="draft">Draft</option>
                        <option value="trash">Trash</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="post-table-responsive">
            <div class="clearfix"></div>
            <div class="table-overflow">
                <table id="postdatatable" class="table table-bordered table-striped display responsive nowrap">
                    <thead>
                        <tr>
                            <th width="4%" class="checkbox-info"><input type="checkbox" id="checkedAll"></th>
                            <th width="5%">Lock/Unlock</th>
                            <th width="76%">Title</th>
                            <th width="10%">Created At</th>
                            <th width="10%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- /.card-body -->
    <script>
        $(function() {
            var dataTable = $('#postdatatable').DataTable({
                processing: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                serverSide: true,
                info: true,
                responsive: true,
                language: {
                    emptyTable: "No {{$entities['title']}} Found"
                },
                ajax: {
                    url: "{{ route($entities['list_route']) }}",
                    data: function(data) {
                        data.filterPostType = $('#selectedpostType').val();
                    }
                },
                order: [
                    [3, "desc"]
                ],
                columns: [
                    {
                        data: "id",
                        name: "id",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return '<input type="checkbox" name="btSelectItem" class="singleCheckbox" data-id="' +
                            data + '" value="' + data + '">';
                        }
                    },
                    {
                        sTitle: "L/U",
                        data: "id",
                        name: "id",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var checked = 'unchecked';
                            if(row.lockunlockstatus == 0){
                                var checked = 'checked';
                            }else{
                                var checked = 'unchecked';
                            }
                            return '<div class="box post-lock-unlock"><input type="checkbox" id="lock'+row.id+'" name="checkbox" data-id="'+row.id+'" '+checked+'/><label for="lock'+row.id+'"><i></i></label></div>';
                        }
                    },
                    {
                        sTitle: "Title",
                        data: "title",
                        name: "title",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {

                            var postSlug = row.slug;
                            
                            if(row.type == 'services'){
                                var postSlug = '\services/' + postSlug;
                            }else if(row.type == 'events'){
                                var postSlug = '\events/' + postSlug;
                            }

                            var str = "";
                            str += '<div class="">';
                            str += '<div class="float-left">';
                            str += '<div class="">';
                            str += '<span class="mr-2 text-bold">' + row.title + '</span>';
                            str += '</div>';
                            str +=
                                '<div class="text-muted text-sm"><ul class="list-inline mb-0 list-actions mt-2 ">  <li class="list-inline-item"><a href="{{ route('home') }}/admin/post-type/{{$entities['name']}}/' +
                                row.id + '/edit" class="jw-table-row  " data-id="' + row.id +
                                '">Edit</a></li>  <li class="list-inline-item"><a href="javascript:void(0)" class="text-danger delete_record" data-id="' +
                                row.id +
                                '" data-action="delete">Delete</a></li>  <li class="list-inline-item"><a href="{{ route('home') }}/' +
                                    postSlug+ '" target="_blank" class="jw-table-row  " data-id="' +
                                row.id + '">View</a></li> <li class="list-inline-item"><a href="javascript:void(0)" class="jw-table-row  clone-post" data-id="' +
                                row.id + '">Clone</a></li></ul></div>';
                            str += '</div>';
                            str += '</div>';
                            return str;
                        }
                    },
                    {
                        sTitle: "Created At",
                        data: "display_created_at",
                        name: "created_at",
                        orderable: true,
                        searchable: true
                    },
                    {
                        sTitle: "Status",
                        data: "status",
                        name: "status",
                        orderable: true,
                        searchable: true,
                    }
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex) {
                    return nRow;
                },
                fnDrawCallback: function(oSettings) {
                    $('.delete_record').on('click', function(e) {
                        let delId = $(this).attr("data-id");
                        let url = '{{ route('home') }}/admin/post-type/{{$entities['name']}}/' + delId + '/del';
                        self.confirmDelete(delId, url, dataTable);
                    });

                    jQuery('#postdatatable .post-lock-unlock input').click(function(){
                        toggle_global_loading(true);
                        let lockUnlockId = $(this).data("id");
                        if(lockUnlockId.length != 0){
                            var lockUnloack = 'yes';
                            if(jQuery(this).is(':checked')){
                                var lockUnloack = 'yes';
                            }else{
                                var lockUnloack = 'no';
                            }
                            $.ajax({
                                type: 'POST',
                                url: "{{route('post-lock-unlock')}}",
                                data: {
                                    'id' : lockUnlockId,
                                    'status': lockUnloack,
                                    "_token" : "{{ csrf_token() }}",
                                }
                            }).done(function(data) {
                                toggle_global_loading(false);
                                //window.location = "";
                                return false;
                            }).fail(function(data) {
                                return false;
                            });
                        }
                    });
                    /* dublicate post */
                    jQuery('#postdatatable .list-inline-item .clone-post').click(function(){
                        toggle_global_loading(true);
                        let postId = $(this).data("id");
                        if(postId.length != 0){
                            $.ajax({
                                type: 'POST',
                                url: "{{route('post-clone')}}",
                                data: {
                                    'id' : postId,
                                    "_token" : "{{ csrf_token() }}",
                                }
                            }).done(function(data) {
                                toggle_global_loading(false);
                                window.location = "";
                                return false;
                            }).fail(function(data) {
                                return false;
                            });
                        }
                    });
                },
                fnInitComplete: function(oSettings, json) {},
                createdRow: function(row, data, dataIndex) {}
            });

            /* START BULK ACTION AJAX */
            jQuery(document).find('#checkedAll').on('click', function() {
                let bulkActionButton = $('.bulk-actions-button');
                if ($(this).is(':checked')) {
                    bulkActionButton.prop('disabled', false);
                    $(".singleCheckbox").prop('checked', true);
                } else {
                    bulkActionButton.prop('disabled', true);
                    $(".singleCheckbox").prop('checked', false);
                }
            });

            $('#postdatatable').on('click', 'tbody input.singleCheckbox', function() {
                let bulkActionButton = $('.bulk-actions-button');
                if ($(this).is(':checked')) {
                    bulkActionButton.prop('disabled', false);
                } else {
                    bulkActionButton.prop('disabled', true);
                }
            });

            let bulkActionButton = $('.bulk-actions-button');
            $('.bulk-actions-actions').on('click', '.select-action', function() {
                let btn = bulkActionButton;
                let text = btn.html();
                let action = $(this).data('action');
                let form = $(this).closest('form');
                let token = form.find('input[name=_token]').val();
                let ids = $("#postdatatable tbody input[name=btSelectItem]:checked").map(function() {
                    return $(this).val();
                }).get();
                bulkActionButton.dropdown('toggle');

                if (!ids || !action) {
                    return false;
                }

                if (action == 'delete') {
                    confirm_message('Are you sure you want to delete the selected items?', function(result) {
                        if (!result) {
                            return false;
                        }

                        btn.html('Please wait...');
                        btn.prop("disabled", true);

                        ajaxRequest("{{route($entities['bulk_action_route'])}}", {
                            'ids': ids,
                            'action': action,
                            '_token': token
                        }, {
                            callback: function(response) {
                                btn.prop("disabled", false);
                                btn.html(text);

                                if (response.status === true) {
                                    show_message(response);
                                    setTimeout(function () {
                                        $('#jquery-message').html('');
                                    }, 1000);

                                    if (response.data.window_redirect) {
                                        window.location = response.data.window_redirect;
                                        return false;
                                    }

                                    if (response.data.redirect) {
                                        setTimeout(function() {
                                            window.location = response.data
                                                .redirect;
                                        }, 1000);
                                        return false;
                                    }

                                    dataTable.draw();
                                    return false;
                                } else {
                                    show_message(response);
                                    return false;
                                }
                            }
                        });
                    });
                } else {
                    btn.html('Please wait...');
                    btn.prop("disabled", true);

                    ajaxRequest("{{route($entities['bulk_action_route'])}}", {
                        'ids': ids,
                        'action': action,
                        '_token': token
                    }, {
                        callback: function(response) {
                            if (response.status === true) {
                                setTimeout(function () {
                                    $('#jquery-message').html('');
                                }, 2000);
                                show_message(response);
                                $('#checkedAll').prop('checked', false); // Unchecks it

                                if (response.data.window_redirect) {
                                    window.location = response.data.window_redirect;
                                    return false;
                                }

                                if (response.data.redirect) {
                                    setTimeout(function() {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                if (response.data.window_redirect) {
                                    setTimeout(function() {
                                        window.location = response.data
                                            .window_redirect;
                                    }, 1000);
                                    return false;
                                }

                                btn.prop("disabled", false);
                                btn.html(text);

                                dataTable.draw();
                                return false;
                            } else {
                                show_message(response);
                                return false;
                            }
                        }
                    });
                    
                }
                return false;
            });
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
            /* END BULK ACTION AJAX */
            $(".js-select2").select2();
            // Dropdown FilterBy User Type
            $("#postdatatable_filter.dataTables_filter").append($("#selectedpostType"));
            $("#selectedpostType").change(function(event) {
                // console.log(event.target.value);
                dataTable.draw();
            });
        });
        function copy(id=null) {
            let copyText = document.getElementById("copyClipboard");
            let copySuccess = document.getElementById("copied-success");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            copyText.select();
            document.execCommand("copy");
            copySuccess.style.opacity = "1";
            setTimeout(function() {
                copySuccess.style.opacity = "0"
            }, 500);
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
    </script>
</div>
<!-- /.card -->
