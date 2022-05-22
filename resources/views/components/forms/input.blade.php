@props(['type' => 'text', 'name', 'label', 'old' => "", 'required' => false])

<div class="mb-3">
    <label class="form-label{{ $required ? ' required' : '' }}" for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" class="form-control @error($name) is-invalid is-invalid-lite @enderror"
        name="{{ $name }}" value="{{ $old }}" spellcheck="false" />
    @error($name)
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>