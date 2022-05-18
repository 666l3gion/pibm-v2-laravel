@props(['type' => 'text', 'name', 'label', 'required' => false, 'placeholder'])

<div class="mb-3">
    <label class="form-label{{ $required ? ' required' : '' }}">{{ $label }}</label>
    <select type="text" class="form-select @error($name) is-invalid is-invalid-lite @enderror" name="{{ $name }}"
        placeholder="{{ $placeholder }}" id="{{ $name }}" value="">
        {{ $slot }}
    </select>
    @error($name)
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

@pushOnce('scripts')
<script src="{{ asset('tabler/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}"></script>
@endPushOnce

@push('scripts')
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
        let el;
        window.TomSelect && (new TomSelect(el = document.getElementById("{{ $name }}"), {
            copyClassesToDropdown: false,
            dropdownClass: 'dropdown-menu',
            optionClass: 'dropdown-item',
            controlInput: '<input>',
            render: {
                item: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });
    // @formatter:on
</script>
@endpush