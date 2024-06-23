@props(['model', 'label', "multiple"=>false])
<div class="upload__group">
    <button class="button">{{ $label }}</button>
    <input
    type="file"
     wire:model="{{ $model }}"
     @if($multiple)
       multiple
     @endIf
    />
    @error($model)
    <div class="input__error">
      {{ $message }}
    </div>
  @enderror
  </div>
