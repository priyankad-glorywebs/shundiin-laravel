<div class="card card-outline card-primary">
    <div class="card-header">
        {{-- <h3 class="card-title float-none float-sm-left mb-3">Pages</h3> --}}
        <a href="{{ URL::TO('/admin/post-type/modules?module=banner-module') }}">
            <div class="btn btn-primary float-sm-right">
                <i class="far fas fa-plus fa-lg mr-2"></i> Add new
            </div>
        </a>
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
                            <a class="dropdown-item select-action action-delete  text-danger " href="javascript:void(0)"
                                data-action="delete">Delete</a>
                        </div>
                    </div>
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
                            <th class="checkbox-info"><input type="checkbox" id="checkedAll"></th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Shortcode</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="copied-success" class="copied">
            <span>Copied!</span>
        </div>
    </div>
    <!-- /.card-body -->
    <script>
        
        /* copy text */
        function copy(id=null) {
            let copyText = document.getElementById("copyClipboard"+id);
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
        /* */
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
                    emptyTable: "No {{ $entities['title'] }} Found"
                },
                ajax: {
                    url: "{{ route($entities['list_route']) }}",
                    data: function(data) {
                        data.filterPostType = $('#selectedpostType').val();
                    }
                },
                order: [
                    [4, "desc"]
                ],
                columns: [{
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
                        sTitle: "Title",
                        data: "title",
                        name: "title",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        sTitle: "Header Content",
                        data: "content",
                        name: "content",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            const parser = new DOMParser();
                            const decodedData = parser.parseFromString(`<!doctype html><body>${data}`, 'text/html').body.textContent;

                            // Parse the JSON data
                            const jsonData = JSON.parse(decodedData);
                            var dataArray = Object.values(jsonData)

                            // console.log(dataArray);
                            if(Array.isArray(dataArray[0]) && dataArray[0] !== null){
                                dataArray = dataArray[0];
                            }
                            if(typeof dataArray[0] === 'object' && dataArray[0] !== null){
                                var dataObject = Object.values(dataArray[0]);
                                dataArray = dataObject;
                            }
                            return dataArray[0];
                        }
                    },
                    {
                        sTitle: "Shortcode",
                        data: "title",
                        name: "title",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {

                            var str = "";
                            str += '<div class="">';
                            str += '<div class="">';
                            str += '<div class="">';
                            str +=
                                '<span class="mr-2 text-bold"><div class="clipboard"><input onclick="copy(' + row.id +
                                ')" class="copy-input" value="[' +
                                row.title + ' id=' + row.id +
                                ']" id="copyClipboard' + row.id +
                                '" readonly="readonly"><button class="copy-btn" id="copyButton" onclick="copy(' + row.id +
                                ')"><i class="far fa-copy"></i></button></div></span>';
                            str += '</div>';
                            str +=
                                '<div class="text-muted text-sm"><ul class="list-inline mb-0 list-actions mt-2 ">  <li class="list-inline-item"><a href="{{ route('home') }}/admin/post-type/{{ $entities['name'] }}/' +
                                row.id + '/edit" class="jw-table-row  " data-id="' + row.id +
                                '">Edit</a></li>  <li class="list-inline-item"><a href="javascript:void(0)" class="text-danger delete_record" data-id="' +
                                row.id +
                                '" data-action="delete">Delete</a></li> <li class="list-inline-item"><a href="javascript:void(0)" class="clone-module" data-id="' +
                                row.id + '">Clone</a></li> </ul></div>';
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
                        searchable: true,
                    }
                    //},
                    // {
                    //     sTitle: "Status",
                    //     data: "status",
                    //     name: "status",
                    //     orderable: true,
                    //     searchable: true,
                    // }
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex) {
                    return nRow;
                },
                fnDrawCallback: function(oSettings) {
                    $('.delete_record').on('click', function(e) {
                        let delId = $(this).attr("data-id");
                        let url = '{{ route('home') }}/admin/post-type/{{ $entities['name'] }}/' + delId + '/del';
                        self.confirmDelete(delId, url, dataTable);
                    });
                    $('.clone-module').on('click', function(){
                        console.log('module clone called');
                        toggle_global_loading(true);
                        let postId = $(this).data("id");
                        if(postId.length != 0){
                            $.ajax({
                                type: 'POST',
                                url: "{{route('module-clone')}}",
                                data: {
                                    'id' : postId,
                                    "_token" : "{{ csrf_token() }}",
                                }
                            }).done(function(response) {
                                toggle_global_loading(false);
                                show_message(response);
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

            $('#postdatatable thead > tr> th:nth-child(1)').css({'max-width': '10px' })
            $('#postdatatable thead > tr> th:nth-child(2)').css({'max-width': '90px' })
            $('#postdatatable thead > tr> th:nth-child(3)').css({'max-width': '120px' })
            $('#postdatatable thead > tr> th:nth-child(4)').css({'max-width': '100px' })
            $('#postdatatable thead > tr> th:nth-child(5)').css({'max-width': '80px' })

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
                    confirm_message('Are you sure you want to delete the selected items?', function(
                    result) {
                        if (!result) {
                            return false;
                        }

                        btn.html('Please wait...');
                        btn.prop("disabled", true);

                        ajaxRequest("{{ route('post-type.bulk-action-modules') }}", {
                            'ids': ids,
                            'action': action,
                            '_token': token
                        }, {
                            callback: function(response) {
                                btn.prop("disabled", false);
                                btn.html(text);

                                if (response.status === true) {
                                    show_message(response);
                                    setTimeout(function() {
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

                    ajaxRequest("{{ route('post-type.bulk-action-modules') }}", {
                        'ids': ids,
                        'action': action,
                        '_token': token
                    }, {
                        callback: function(response) {
                            if (response.status === true) {
                                setTimeout(function() {
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
    </script>
    <style>
        /* #postdatatable thead > tr> th:nth-child(2), */
        #postdatatable {
            max-width: 100% !important;
        }
        #postdatatable thead > tr> th:nth-child(2) {
            max-width: 100px;
        }
        #postdatatable thead > tr> th:nth-child(3) {
            max-width: 100px;
        }
        #postdatatable thead > tr> th:nth-child(4) {
            min-width: 150px;
        }
        #postdatatable td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: break-spaces;
        }
        .clipboard {
            position: relative;
        }

        /* You just need to get this field */
        .copy-input {
            max-width: 275px;
            width: 100%;
            cursor: pointer;
            background-color: #eaeaeb;
            border: none;
            color: #6c6c6c;
            font-size: 14px;
            border-radius: 5px;
            padding: 15px 45px 15px 15px;
            font-family: 'Montserrat', sans-serif;
        }

        .copy-input:focus {
            outline: none;
        }

        .copy-btn {
            width: 40px;
            background-color: #eaeaeb;
            font-size: 18px;
            padding: 6px 9px;
            border-radius: 5px;
            border: none;
            color: #6c6c6c;
            margin-left: -50px;
            transition: all .4s;
        }

        .copy-btn:hover {
            transform: scale(1.3);
            color: #1a1a1a;
            cursor: pointer;
        }

        .copy-btn:focus {
            outline: none;
        }

        .copied {
            font-family: 'Montserrat', sans-serif;
            width: 100px;
            opacity: 0;
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            margin: auto;
            color: #000;
            padding: 15px 15px;
            background-color: #fff;
            border-radius: 5px;
            transition: .4s opacity;
        }
        i.far.fa-copy {
            color: #007bff;
        }
    </style>
</div>
<!-- /.card -->
