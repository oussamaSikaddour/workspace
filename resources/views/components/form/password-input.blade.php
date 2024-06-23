@props(['html_id','name', 'label'])
<div class="input__item">
<div class="input__group" x-data="{ showPassword: false }">
    <input
    x-bind:type="showPassword ? 'text' : 'password'"
    class="input"
    placeholder="Mot de passe"
    wire:model="{{ $name }}"
    id="{{ $html_id }}"
    />

    <span
    class="input__span"
    x-on:click="showPassword = !showPassword"
       >
    <i x-bind:class="showPassword ? 'form__icon fa-solid fa-eye fa-xl' : 'form__icon fa-solid fa-eye-slash fa-xl'"></i>
   </span>

   <label for="{{ $html_id }}" class="input__label">{{$label}}</label>
</div>
@error($name)
<div class="input__error">
    {{ $message }}
</div>
@enderror
</div>
