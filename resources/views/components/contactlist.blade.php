<div class="card card-outline card-primary">
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Created At</th>
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
                emptyTable: "No {{ $entities['title'] }} Found"
            },
            ajax: {
                url: "{{ route($entities['list_route']) }}",
                data: function(data) {
                    // console.log(data);
                    data.filterPostType = $('#selectedpostType').val();
                }
            },
            order: [
                [5, "desc"]
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
                    sTitle: "Name",
                    data: "fullname",
                    name: "name",
                    orderable: true,
                    searchable: true,
                    // render: function(data, type, row, meta) {
                    //     var str = "";
                    //     str += '<div class="">';
                    //     str += '<div class="">';
                    //     str += '<div class="text-bold">';
                    //     str += data
                    //     str += '</div>';
                    //     str +=
                    //         '<div class="text-muted text-sm"><ul class="list-inline mb-0 list-actions mt-2 "> <li class="list-inline-item"><a href="javascript:void(0)" class="text-danger delete_record" data-id="' +
                    //         row.id +
                    //         '" data-action="delete">Delete</a></li> <li class="list-inline-item"><a href="javascript:void(0)" class="clone-module" data-id="' +
                    //         row.id + '">View</a></li> </ul></div>';
                    //     str += '</div>';
                    //     str += '</div>';
                    //     return str;
                    //     }
                },
                {
                    sTitle: "Email",
                    data: "email",
                    name: "email",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row, meta) {
                        var str = "";
                        str += '<div class="">';
                        str += '<div class="">';
                        str += '<div class="text-bold">';
                        str += data
                        str += '</div>';
                        str +=
                            '<div class="text-muted text-sm"><ul class="list-inline mb-0 list-actions mt-2 "> <li class="list-inline-item"><a href="javascript:void(0)" class="text-danger delete_record" data-id="' +
                            row.id +
                            '" data-action="delete">Delete</a></li>';
                            // <li class="list-inline-item"><a href="javascript:void(0)" class="clone-module" data-id="' +
                            // row.id + '">View</a></li> </ul></div>';
                        str += '</div>';
                        str += '</div>';
                        return str;
                        }
                        
                        
                },
                {
                    sTitle: "Phone",
                    data: "phone",
                    name: "phone",
                    orderable: true,
                    searchable: true,
                },
                {
                    sTitle: "Message",
                    data: "message",
                    name: "message",
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row, meta) {
                        if(data.length > 100){
                            var small = data.slice(0, 50);
                            var str = '';
                            str += '<div class="small-data">'+small+'...<a href="javascript:void(0)" class="show-more">Show more</a></div>';
                            str += '<div style="display:none;" class="big-data">'+data+'<a href="javascript:void(0)" class="show-less">Show less</a></div>';
                            return str;
                        } else {
                            return data;
                        }
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
                $('.show-more').on('click', function(){
                    console.log('show more');
                    $('.small-data').hide();
                    $('.big-data').fadeIn('slow');
                });
                $('.show-less').click(function(){
                    $('.big-data').hide();
                    $('.small-data').fadeIn('slow');
                });
            },
            fnInitComplete: function(oSettings, json) {},
            createdRow: function(row, data, dataIndex) {}
        });

        $('#postdatatable thead > tr> th:nth-child(1)').css({'max-width': '10px' })
        $('#postdatatable thead > tr> th:nth-child(2)').css({'max-width': '90px' })
        $('#postdatatable thead > tr> th:nth-child(3)').css({'max-width': '90px' })
        $('#postdatatable thead > tr> th:nth-child(4)').css({'max-width': '100px' })
        $('#postdatatable thead > tr> th:nth-child(5)').css({'min-width': '170px' })
        $('#postdatatable thead > tr> th:nth-child(6)').css({'max-width': '80px' })

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

                        ajaxRequest("{{ route('post-type.bulk-action-contacts') }}", {
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

                    ajaxRequest("{{ route('post-type.bulk-action-contacts') }}", {
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
    #postdatatable {
        max-width: 100% !important;
    }
    #postdatatable td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: break-spaces;
    }
    /* #postdatatable thead > tr> th:nth-child(5) {
        min-width: 150px;
    } */
</style>