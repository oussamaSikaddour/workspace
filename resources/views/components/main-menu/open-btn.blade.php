@props(['html_id'])


<button
    :id="$html_id"
    {{ $attributes->merge(['class'=>"button rounded menu__btn"]) }}
    aria-haspopup="true"
    aria-expanded="false"
    aria-controls="mainMenu"
>
    <span>
        <i class="fa-solid fa-gear"></i>
    </span>
</button>
