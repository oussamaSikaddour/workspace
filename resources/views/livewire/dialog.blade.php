@php
$dialogQuestion = [
    "user" => function ($attribute) {
        return __('dialogs.delete.user', ['attribute' => $attribute]);
    },
    "classroom" => function ($attribute) {
        return __('dialogs.delete.classroom', ['attribute' => $attribute]);
    },
    "days-off" => function ($attribute) {
        return __('dialogs.delete.days-off', ['attribute' => $attribute]);
    },
    "product" => function ($attribute) {
        return __('dialogs.delete.product', ['attribute' => $attribute]);
    },
    "ourQuality" => function ($attribute) {
        return __('dialogs.delete.ourQuality', ['attribute' => $attribute]);
    },
    "training" => function ($attribute) {
        return __('dialogs.delete.training', ['attribute' => $attribute]);
    },



];
@endphp

<div role="dialog"
    aria-labelledby="dialog_box"
    class="box"
    x-bind:class="{ 'open': {{ $isOpen ? 'true' : 'false' }} }"
    id="box">
    <h3 id="dialog_box" class="sr-only">help about the box</h3>
    <div class="box__header">
        <h3>{{ __($question) }}</h3>
    </div>
    <div class="box__body">
        @if (count($details) === 2 && array_key_exists($details[0], $dialogQuestion))
            {{ $dialogQuestion[$details[0]]($details[1]) }}
        @else
            {{ '' }}
        @endif
    </div>
    <div class="box__footer">
        <button class="button box__closer" wire:click="closeDialog">Non</button>
        <button class="button button--primary" wire:click="confirmAction">Oui</button>
    </div>
</div>

@script
    <script>
        document.addEventListener('dialog-will-be-close', function(event) {
            @this.closeDialog();
        });
        $wire.on("user-chose-yes",()=>{
            @this.closeDialog();

            const closeDialogBoxEvent = new CustomEvent('close-dialog-box');
         document.dispatchEvent(closeDialogBoxEvent);
        })
    </script>
@endscript
