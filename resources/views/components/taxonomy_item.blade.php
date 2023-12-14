<li class="m-1" id="item-category-{{ $item->id }}">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="categories[]" class="custom-control-input" id="categories-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $checked ?? [])) checked  @endif>
        <label class="custom-control-label" for="categories-{{ $item->id }}">{{ $item->name }}</label>
    </div>
    <ul class="ml-3 p-0">
        @foreach($item->children as $child)
            @component('components.taxonomy_item', [
                'taxonomy' => 'categories',
                'item' => $child,
                'value' => $value,
                'checked' => $checked,
            ])
            @endcomponent
        @endforeach
    </ul>
</li>



