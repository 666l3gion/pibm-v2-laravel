@props(['type' => 'text', 'name', 'label', 'old', 'required' => false])

<div class="mb-3">
    <label class="form-label{{ $required ? ' required' : '' }}" for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" class="form-control" name="{{ $name }}" value="{{ $old }}">
    @error($name)
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>