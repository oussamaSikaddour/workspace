@php
$guestMessageLabel =  strtoupper($message["name"])." ".__('forms.message.message')." :";

@endphp

<div class="form__container">
    <form class="form" wire:submit="handleSubmit">
        <div class="column center">
            <x-form.textarea
            name="guestMessage"
            :label="$guestMessageLabel"
            html_id="lc-m-m"
            />
        </div>
        <div class="column">
            <livewire:tiny-mce-text-area htmlId="rM-m" contentUpdatedEvent="set-message-content" wire:key="rM-m" :content="$messageContent" />
        </div>
        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-loading />
            </div>
            <button type="submit" class="button button--primary rounded">
                <i class='fa-solid fa-reply'></i>
            </button>
        </div>
    </form>
</div>

@script
<script>
$wire.on('form-submitted',()=>{
const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
 document.dispatchEvent(clearFormErrorsOnFocusEvent);
})
</script>
@endscript
