<li class="dd-item" id="dd-item-{{ $key }}" data-label="{{ $block }}">
    <div class="dd-handle">
        @if(!empty($block))
        <span>{{ $block }}</span>
        @endif
        <div class="dd-nodrag">
            <div class="block-action-button">
                <a href="javascript:void(0)"
                   class="show-form-block"
                >
                    <i class="fa fa-edit"></i> {{ trans('Edit') }}
                </a>

                <a href="javascript:void(0)"
                   class="remove-form-block text-danger"
                >
                    <i class="fa fa-trash"></i> {{ trans('Delete') }}
                </a>
            </div>
        </div>
    </div>

    <div class="form-block-edit dd-nodrag box-hidden" id="page-block-{{ $key }}">       
        <div class="form-group">
            @php
            $value =  $ShortcodeValue ?  $ShortcodeValue : '';
            @endphp

            <label class="col-form-label" for="IfHlWehHIs-title">Enter Shortcode</label>
            <input type="text" name="blocks[{{ $contentKey }}][{{ $key }}][{{ $valueKey }}]" class="form-control" id="{{ $contentKey }}-title" value="{{$value}}" autocomplete="off" placeholder="[please enter {{ strtolower($block) }} shortcode/]">
        </div>
    </div>
</li>