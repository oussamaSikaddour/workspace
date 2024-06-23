@props(['model','htmlId','value','label'=>'','type'=>""])


<div class="radio__button" {{ $attributes }}>

    <input type="radio" id="{{ $htmlId }}"
    @if($type="forTable")
    wire:model.live="{{ $model }}"
    @endif
    wire:model="{{$model}}"
    value="{{ $value }}"/>
 <label for="{{ $htmlId }}"  role="radio" tabindex="0">{{ $label }}</label>
</div>


