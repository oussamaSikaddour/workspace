

@props(['name', 'label', 'html_id'])
<div class="textarea__group">
    <textarea

      class="textarea "
      id="{{ $html_id }}"
      wire:model="{{$name }}"
      rows="4"
      cols="100"
      maxlength="3000"
      placeholder="{{ $label }}"
    >
    </textarea>
    <label for="{{ $html_id }}" class="textarea__label">{{ $label }} </label>
    @error($name)
    <div class="input__error">
      {{ $message }}
    </div>
  @enderror
  </div>



