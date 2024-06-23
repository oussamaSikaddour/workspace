@props(['name', 'htmlId', 'label', 'data', 'type' => '', 'showError' => false, "toTranslate" => null])


@php

    $constantsList = [
        "specialty" => function ($option)  {
            return app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$option];
        }
    ];

@endphp

<div class="select__group">
    <div>
        <label for="{{ $htmlId }}">{{ $label }} :</label>
        <div class="select">
            <select
                id="{{ $htmlId }}"
                @if ($type == 'filter')
                    wire:model.live="{{ $name }}"
                @else
                    wire:model="{{ $name }}"
                @endif
            >
                @if(array_key_exists($toTranslate, $constantsList))

                    @foreach ($data as $value => $option)
                        <option value="{{ $value }}">{{ $constantsList[$toTranslate]($option) }}</option>
                    @endforeach
                @else
                    @foreach ($data as $value => $option)
                        <option value="{{ $value }}">{{ $option }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    @if ($showError)
        @error($name)
            <div class="input__error">{{ $message }}</div>
        @enderror
    @endif
</div>
