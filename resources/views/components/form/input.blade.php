@props(['name', 'label', 'type', 'html_id',"role"=>"", 'min'=>"", 'max'=>""])

<div class="input__item">
<div class="input__group">
    <input
    type="{{ $type }}"
    class="input"
    placeholder="{{ $label }}"
    id="{{ $html_id }}"
    @if ($role === 'filter')
    wire:model.live.debounce.300ms="{{ $name }}"
    {{-- x-on:input.debounce.300ms="$dispatch('set-search-value', {searchValue: $event.target.value })" --}}
    @else
        wire:model="{{$name }}"
    @endif
    @if($min!=="")
    min="{{ $min }}"
    @endif
    @if($max!=="")
    max="{{ $max }}"
    @endif
    />
    <label for="{{ $html_id }}" class="input__label">{{ $label }}</label>
  </div>
  @error($name)
  <div class="input__error">
    {{ $message }}
  </div>
@enderror
</div>
