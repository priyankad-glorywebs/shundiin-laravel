<div class="card card-outline card-primary">
    <div class="card-body">
        <div id="jquery-message"></div>
        <div class="row">
            <div class="col-md-4">
                <h5>Add new</h5>
                <form method="post" action="{{route('posts.create.categories')}}" class="form-ajax" data-success="reload_data" id="form-add" novalidate="novalidate">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label class="col-form-label" for="name">Name <abbr>*</abbr>
                        </label>
                        <input type="text" name="name" class="form-control " id="name" value="" autocomplete="off" placeholder="" required="">
                    </div>
                    <div class="form-group ">
                        <label class="col-form-label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="parent_id">Parent</label>
                        <select name="parent_id" id="parent_id" class="form-control load-taxonomies select2-hidden-accessible" data-post-type="posts" data-taxonomy="{{$entities['taxonomy']}}" data-placeholder="Parent" data-select2-id="parent_id" tabindex="-1" aria-hidden="true"></select>
                    </div>
                    <input type="hidden" name="post_type" value="posts">
                    <input type="hidden" name="taxonomy" value="{{$entities['taxonomy']}}">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Add {{ucfirst($entities['taxonomy'])}} </button>
                </form>
            </div>
            <div class="col-md-8">
                <div class="tags-bulk-action">
                    <form method="post" class="form-inline float-left">
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
                <div class="clearfix"></div>
                <div class="post-table-responsive">
                    <div class="clearfix"></div>
                    <div class="table-overflow">
                        <table id="categoriesdatatable" class="table table-bordered table-striped display responsive nowrap">
                            <thead>
                                <tr>
                                    <th width="4%" class="checkbox-info"><input type="checkbox" id="checkedAll"></th>
                                    <th width="56%">Title</th>
                                    <th width="10%">Parent</th>
                                    <th width="15%">Total posts</th>
                                    <th width="15%">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <script>
        $(function () {
            var dataTable = $('#categoriesdatatable').DataTable({
                processing: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                serverSide: true,
                info: true,
                responsive: true,
                language: {
                    emptyTable: "No matching records found"
                },
                ajax: {
                    
                },
                order: [
                    [4, 'desc']
                ],
                columns: [{
                        data: "id",
                        name: "id",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return '<input type="checkbox" name="btSelectItem" class="singleCheckbox" data-id="' +
                                    data + '" value="' + data + '">';
                        }
                    },
                    {
                        sTitle: "Name",
                        data: "name",
                        name: "name",
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row, meta) {

                            var str = "";
                            str += '<div class="">';
                            str += '<div class="float-left">';
                            str += '<div class="">';
                            str += '<span class="mr-2 text-bold">' + row.name + '</span>';
                            str += '</div>';
                            str +=
                                    '<div class="text-muted text-sm"><ul class="list-inline mb-0 list-actions mt-2 ">  <li class="list-inline-item"><a href="/shundiin-laravel/admin/taxonomy/posts/{{$entities['name']}}/' +
                            row.id + '/edit" class="jw-table-row  " data-id="' + row.id +
                            '">Edit</a></li>  <li class="list-inline-item"><a href="javascript:void(0)" class="text-danger delete_record" data-id="' +
                                    row.id +
                                    '" data-action="delete">Delete</a></li>  </ul></div>';
                            str += '</div>';
                            str += '</div>';
                            return str;
                        }
                    },
                    {
                        sTitle: "Parent",
                        data: "parent_name",
                        name: "parent_id",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        sTitle: "Total posts",
                        data: "total_post",
                        name: "total_post",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        sTitle: "Created At",
                        data: "display_created_at",
                        name: "created_at",
                        orderable: true,
                        searchable: true
                    },
                ],
                fnRowCallback: function (nRow, aData, iDisplayIndex) {
                    return nRow;
                },
                fnDrawCallback: function (oSettings) {
                    $('.delete_record').on('click', function (e) {
                        let delId = $(this).attr("data-id");
                        let taxonomy = "{{$entities['taxonomy']}}";
                        let url = '{{ route('home') }}/admin/taxonomy/posts/' + delId + '/del/?taxonomy='+taxonomy;
                        self.confirmDelete(delId, url, dataTable);
                    });
                },
                fnInitComplete: function (oSettings, json) {},
                createdRow: function (row, data, dataIndex) {}
            });

            /* START BULK ACTION AJAX */
            jQuery(document).find('#checkedAll').on('click', function () {
                let bulkActionButton = $('.bulk-actions-button');
                if ($(this).is(':checked')) {
                    bulkActionButton.prop('disabled', false);
                    $(".singleCheckbox").prop('checked', true);
                } else {
                    bulkActionButton.prop('disabled', true);
                    $(".singleCheckbox").prop('checked', false);
                }
            });

            $('#categoriesdatatable').on('click', 'tbody input.singleCheckbox', function () {
                let bulkActionButton = $('.bulk-actions-button');
                if ($(this).is(':checked')) {
                    bulkActionButton.prop('disabled', false);
                } else {
                    bulkActionButton.prop('disabled', true);
                }
            });

            let bulkActionButton = $('.bulk-actions-button');
            $('.bulk-actions-actions').on('click', '.select-action', function () {
                let btn = bulkActionButton;
                let text = btn.html();
                let action = $(this).data('action');
                let taxonomy = "{{$entities['taxonomy']}}";
                let form = $(this).closest('form');
                let token = form.find('input[name=_token]').val();
                let ids = $("#categoriesdatatable tbody input[name=btSelectItem]:checked").map(function () {
                    return $(this).val();
                }).get();
                bulkActionButton.dropdown('toggle');

                if (!ids || !action) {
                    return false;
                }

                if (action == 'delete') {
                    confirm_message('Are you sure you want to delete the selected items?', function (result) {
                        if (!result) {
                            return false;
                        }

                        btn.html('Please wait...');
                        btn.prop("disabled", true);

                        ajaxRequest("{{route('tax-bulk-action')}}", {
                            'ids': ids,
                            'action': action,
                            'taxonomy' : taxonomy,
                            '_token': token
                        }, {
                            callback: function (response) {
                                btn.prop("disabled", false);
                                btn.html(text);

                                if (response.status === true) {
                                    show_message(response);
                                    setTimeout(function () {
                                        $('#jquery-message').html('');
                                    }, 2000);
                                     $('#categoriesdatatable #checkedAll').prop('checked', false);

                                    if (response.data.window_redirect) {
                                        window.location = response.data.window_redirect;
                                        return false;
                                    }

                                    if (response.data.redirect) {
                                        setTimeout(function () {
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

                jqxhr.done(function (response) {
                    if (options.callback || false) {
                        options.callback(response);
                    }
                });

                jqxhr.fail(function (response) {
                    if (options.failCallback || false) {
                        options.failCallback(response);
                    }
                });

                return jqxhr.responseJSON;
            }
            /* END BULK ACTION AJAX */
            /* GET CATEGORIES SELECT2 */
            let parent = 'body';
            $(parent +' .load-taxonomies').select2({
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
                    url: "{{route('posts.load-categories')}}",
                    dataType: 'json',
                    data: function (params) {
                        let postType = $(this).data('post-type');
                        let taxonomy = $(this).data('taxonomy');
                        let explodes = $(this).data('explodes');
                        if (explodes) {
                            explodes = $("." + explodes).map(function () {
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
            
            
        });
    </script>
</div>
<!-- /.card -->
