<div class="card card-outline card-primary">
    <form action="{{ route($entities['actionRoute'], ['id' => $entities['post_id']]) }}" method="post" class="form-ajax"
        novalidate="novalidate">

        <input type="hidden" name="post_types" value="{{ $entities['post_types'] }}" />
        <?php echo csrf_field(); ?>
        <div class="card-header">
            <h3 class="card-title float-none float-sm-left mb-3">{{ $entities['main_title'] }}</h3>
            <div class="btn-group float-sm-right">
                <button type="submit" class="btn btn-success px-5"><i class="fa fa-edit"></i> Update
                </button>
                <button type="button" class="btn btn-warning cancel-button px-3"><i class="fa fa-refresh"></i> Reset
                </button>
            </div>
        </div>
       {{-- {{dd($entities->post_types)}} --}}
        <div class="card-body">
            <div class="row">
                <div id="jquery-message" style="width: 100%"></div>
                <div class="col-md-6">
                    <div class="edit-taxonomy">
                        <form method="post" action="{{ route('posts.create.categories') }}" class="form-ajax"
                            data-success="reload_data" id="form-add" novalidate="novalidate">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label class="col-form-label" for="name">Name <abbr>*</abbr>
                                </label>
                                <input type="text" name="name" class="form-control " id="name" value="{{ $entities['pageInfo']->name }}"
                                    autocomplete="off" placeholder="" required="">
                            </div>
                            <div class="form-group ">
                                <label class="col-form-label" for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ $entities['pageInfo']->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="tags-explodes[]" value="{{ $entities['post_id'] }}"/>
                                <label class="col-form-label" for="parent_id">Parent</label>
                                <select name="parent_id" id="parent_id"
                                    class="form-control load-taxonomies select2-hidden-accessible"
                                    data-post-type="{{ $entities['post_types'] }}" data-taxonomy="{{ $entities['taxonomy'] }}" data-placeholder="Parent"
                                    data-select2-id="parent_id" tabindex="-1" aria-hidden="true"
                                    data-explodes="{{ $entities['post_id'] }}">
                                    
                                    @if($entities['pageInfo'])
                                        @if($entities['pageInfo']->parent_id)
                                            <option value="{{ $entities['pageInfo']->parent_id }}" selected>{{ $entities['pageInfo']->parent_name }}</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                            <input type="hidden" name="post_type" value="{{ $entities['post_types'] }}">
                            <input type="hidden" name="taxonomy" value="{{ $entities['taxonomy'] }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /.card -->
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
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
                        return {
                            search: $.trim(params.term),
                            page: params.page,
                            explodes: [explodes],
                            post_type: postType,
                            taxonomy: taxonomy
                        };
                    }
                }
            });
        });
    </script>
</div>
